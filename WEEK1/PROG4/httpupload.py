import socket
import argparse
import os
import mimetypes

def get_args():
    parser = argparse.ArgumentParser(description='Upload file đến server.')
    parser.add_argument('--url', required=True, help='URL của server')
    parser.add_argument('--user', required=True, help='Tên đăng nhập')
    parser.add_argument('--password', required=True, help='Mật khẩu')
    parser.add_argument('--local-file', required=True, help='Đường dẫn tệp cần upload')
    args = parser.parse_args()
    return args.url, args.user, args.password, args.local_file

def check_login(host, port,  user, password):
    login_request = (
        f"POST / HTTP/1.1\r\n"
        f"Host: {host}{port}\r\n"
        f"Content-Type: application/x-www-form-urlencoded\r\n"
        f"Content-Length: {len(user) + len(password) + 15}\r\n"
        f"Connection: close\r\n\r\n"
        f"user={user}&password={password}"
    ).encode()
    
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.connect((host, port))
    s.sendall(login_request)
    response = receive_response(s)
    s.close()
    
    if b"Redirecting..." in response:
        for line in response.split(b"\r\n"):
            if line.lower().startswith(b"set-cookie:"):
                session = line.split(b": ")[1].decode().strip()
                return session
    return None

def prepare_request(host, port, path, user, password, file_path, session):
    boundary = "----WebKitFormBoundary7MA4YWxkTrZu0gW"
    filename = os.path.basename(file_path)
    content_type = mimetypes.guess_type(file_path)[0] or 'application/octet-stream'
    
    with open(file_path, 'rb') as f:
        file_data = f.read()
    
    body = (
        f"--{boundary}\r\n"
        f"Content-Disposition: form-data; name=\"user\"\r\n\r\n{user}\r\n"
        f"--{boundary}\r\n"
        f"Content-Disposition: form-data; name=\"password\"\r\n\r\n{password}\r\n"
        f"--{boundary}\r\n"
        f"Content-Disposition: form-data; name=\"file\"; filename=\"{filename}\"\r\n"
        f"Content-Type: {content_type}\r\n\r\n"
    ).encode() + file_data + f"\r\n--{boundary}--\r\n".encode()
    
    headers = (
        f"POST /{path} HTTP/1.1\r\n"
        f"Host: {host}:{port}\r\n"
        f"Content-Type: multipart/form-data; boundary={boundary}\r\n"
        f"Content-Length: {len(body)}\r\n"
        f"Cookie: {session}\r\n"
        f"Connection: close\r\n\r\n"
    ).encode() + body
    
    return headers

def receive_response(s: socket.socket):
    response = b""
    while True:
        data = s.recv(1024)
        if not data:
            break
        response += data
    return response

def parse_response(response: bytes, url: str):
    if "Tệp đã được tải lên thành công" in response.decode():
        uploaded_file_path = response.split(b"/images/")[1].split()[0].decode()
        print(f"Tệp đã được tải lên thành công: {url}/images/{uploaded_file_path}")
    else:
        print("Upload failed")

if __name__ == "__main__":
    url, user, password, local_file = get_args()
    components = url.split('/')
    HOST = components[2].split(':')[0]
    PORT = int(components[2].split(':')[1])
    PATH = components[3]
    
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.connect((HOST, PORT))

    session = check_login(HOST, PORT, user, password)
    if not session:
        print("Login failed")
        exit(1)

    request = prepare_request(HOST, PORT, PATH, user, password, local_file, session)
    s.sendall(request)
    
    response = receive_response(s)
    parse_response(response, url)
    
    s.close()
