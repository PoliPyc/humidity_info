import os, sys
import sqlite3, time
import Adafruit_DHT

DHT_SENSOR = Adafruit_DHT.DHT22
DHT_PIN = 4

LOG_FILE = '/home/osmc/humidity/humidity.csv'

def write_header_to_file():
    try:
        f = open(LOG_FILE, 'a+')
    #    if os.stat(LOG_FILE).st_size == 0
        f.write('Date,Time,Temperature,Humidity\r\n')
    except:
        pass

def write_measure_to_file(data):
    print('writing to {}, t:{}, h:{}'.format(LOG_FILE, data['temperature'], data['humidity']))
    with open(LOG_FILE, 'a+') as file:
        file.write('{0},{1},{2:0.1f}*C,{3:0.1f}%\r\n'.format(time.strftime('%m/%d/%y'), time.strftime('%H:%M'), data['temperature'], data['humidity']))
        file.flush()
while True:
    humidity, temperature = Adafruit_DHT.read_retry(DHT_SENSOR, DHT_PIN)
    data = {
            'temperature': temperature,
            'humidity': humidity
    }
    if humidity is not None and temperature is not None:
        write_measure_to_file(data)
    else:
        print("Failed to retrieve data from humidity sensor")

    time.sleep(60)
