import socket
import argparse

def get_url_from_args():
    parser = argparse.ArgumentParser(description='Download file từ URL.')
    parser.add_argument('--url', required=True, help='URL trang web')
    parser.add_argument('--remote-file', required=True, help='Đường dẫn file cần tải')
    args = parser.parse_args()
    return args.url, args.remote_file

def prepare_request(host: str, port:str, path: str):
    return f"GET {path} HTTP/1.1\r\nHost: {host}:{port}\r\nConnection: close\r\n\r\n"

def receive_response(s: socket.socket):
    response = b""
    while True:
        data = s.recv(1024)
        if not data:
            break
        response += data
    return response

def parse_response(response: bytes):
    header, _, body = response.partition(b"\r\n\r\n")
    if b"404 Not Found" in header:
        print("Không tồn tại file ảnh")
        return
    
    for line in header.split(b"\r\n"):
        if line.lower().startswith(b"content-length:"):
            size = int(line.split(b": ")[1])
            print(f"Kích thước file ảnh: {size} bytes")
            return
    
    print("Không thể xác định kích thước file")

if __name__ == "__main__":
    url, remote_file = get_url_from_args()
    components = url.split('/')
    HOST = components[2].split(':')[0]
    PORT = int(components[2].split(':')[1])
    PATH = components[3]

    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.connect((HOST, PORT))

    request = prepare_request(HOST, PORT, remote_file)
    s.sendall(request.encode())
    
    response = receive_response(s)
    parse_response(response)
    
    s.close()