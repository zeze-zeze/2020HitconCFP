import serial
import socket
import sys
import qrcode
import random
import hashlib
import subprocess
import time

IP = '127.0.0.1'
PORT = 20080
sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
server_address = (IP, PORT)
sock.bind(server_address)
sock.listen(1)

COM_PORT = 'COM6'
BAUD_RATES = '9600'
ser = serial.Serial(COM_PORT, BAUD_RATES)
while True:
    try:
        connection, client_address = sock.accept()
        print(client_address)
        data = connection.recv(1000)
        if b'BambooFoxCurrencyManagementKey' in data: 
            data = data.strip().split(b'BambooFoxCurrencyManagementKey')[0] 
        else:
            continue
        print(int(data), data)
        
        data = data.decode() 
        id_ = str(random.randint(1000, 99999))
        s = hashlib.sha1()
        s.update('{id_}|{amount}|BambooFox'.format(id_=id_, amount=data).encode())
        hash_ = s.hexdigest()
        img = qrcode.make('{id_}|{amount}|{sha}'.format(id_=id_, amount=data, sha = hash_))
        img = img.resize((384, 384))
        img.save('qrcode.bmp')
        
        try:
            subprocess.check_output('LCDAssistantCMD.exe qrcode.bmp qrcode', stderr=2, timeout=2)
        except:
            pass
        q = open('qrcode', 'rb').read()
        sended = [i for i in q.split(b'{')[1].split(b'}')[0].replace(b'\n', b'').replace(b'\r', b'').replace(b' ', b'').split(b',')]
        if not sended[-1]:
            sended.pop()
        sended = bytes([int(s[2:], 16) for s in sended])
        sended = b'%s%s%s' % (b'STARTSTART', sended, b'ENDEND')
        
        #if ser.in_waiting == 0:
        #    for i in range(0, len(sended), 32):
        #        ser.write(sended[i: i + 32])
        #        time.sleep(0.001)
        print(sended, len(sended))

        ser.write(sended)
    except KeyboardInterrupt:
        print('bye')
        break
    except Exception as e:
        print(e)
        pass
