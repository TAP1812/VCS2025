import socket
import argparse
from bs4 import BeautifulSoup

def get_url_from_args():
    parser = argparse.ArgumentParser(description='Lấy URL từ tham số dòng lệnh.')
    parser.add_argument('--url', required=True, help='URL cần lấy')
    url = parser.parse_args().url
    return url

def prepareRequest(host: str, path: str):
    return f"GET /{path} HTTP/1.1\r\nHost: {host}\r\nConnection: keep-alive\r\n\r\n"

def receiveResponse(s: socket.socket):
    response = b""
    while True:
        data = s.recv(1024)
        if not data:
            break
        response += data
    return response

def handleResponse(html: str):
    soup = BeautifulSoup(html, "html.parser")
    print(f"Title: {soup.title.string}")

if __name__ == "__main__":
    url = get_url_from_args()
    components = url.split('/')
    HOST = components[2].split(':')[0]
    PORT = int(components[2].split(':')[1])
    PATH = components[3]

    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.connect((HOST, PORT))

    request = prepareRequest(HOST, PATH)
    s.sendall(request.encode())

    res = receiveResponse(s)
    handleResponse(res)
    s.close()
    