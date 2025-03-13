import socket
import argparse
from bs4 import BeautifulSoup

def get_url_from_args():
    parser = argparse.ArgumentParser(description='Lấy URL từ tham số dòng lệnh.')
    parser.add_argument('--url', required=True, help='URL cần lấy')
    parser.add_argument('--user', required=True, help="Username")
    parser.add_argument('--password', required=True, help="Password")
    args = parser.parse_args()
    return args.url, args.user, args.password

def prepareRequest(host, path, user, password):
    return f"POST /{path} HTTP/1.1\r\nHost: {host}\r\nContent-Type: application/x-www-form-urlencoded\r\nContent-Length: {len(user)+len(password)+15}\r\nConnection: keep-alive\r\n\r\nuser={user}&password={password}"

def receiveResponse(s: socket.socket):
    response = b""
    while True:
        data = s.recv(1024)
        if not data:
            break
        response += data
    return response

def handleResponse(response, user):
    lines = response.split("\n")
    status_line = lines[0]
    if "302 FOUND" in status_line:
        for line in lines:
            if line.startswith("Location:") and "/dashboard" in line:
                return f"User {user} đăng nhập thành công"
    return f"User {user} đăng nhập thất bại"


if __name__ == "__main__":
    url, user, password = get_url_from_args()
    components = url.split('/')
    HOST = components[2].split(':')[0]
    PORT = int(components[2].split(':')[1])
    PATH = components[3]
    
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.connect((HOST, PORT))

    request = prepareRequest(HOST, PATH, user, password)
    s.sendall(request.encode())

    res = receiveResponse(s).decode()
    print(handleResponse(res, user))
    s.close()