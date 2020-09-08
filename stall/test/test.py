import serial
import socket
import sys

COM_PORT = 'COM6'
BAUD_RATES = '115200'
ser = serial.Serial(COM_PORT, BAUD_RATES)

IP = '0.0.0.0'
PORT = 20080
sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
server_address = (IP, PORT)
sock.bind(server_address)
sock.listen(1)

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
            ser.write(data)
    except KeyboardInterrupt:
        print('bye')
        break
    except Exception as e:
        print(e)
        pass
