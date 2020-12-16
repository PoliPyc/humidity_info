import os, sys
import sqlite3, time
import Adafruit_DHT

DHT_SENSOR = Adafruit_DHT.DHT22
DHT_PIN = 4
WAIT_TIME = 60

LOG_FILE = '/home/osmc/humidity/humidity.csv'
DATABASE_FILE = 'humidity.sqlite3'

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

def write_measure_to_database(data):
    date = time.strftime('%d-%m-%y')
    time_now = time.strftime('%H:%M')
    with sqlite3.connect(DATABASE_FILE) as conn:
        c = conn.cursor()
        c.execute('''CREATE TABLE IF NOT EXISTS measures (
                     measure_id INTERGER PRIMARY KEY,
                     date TEXT NOT NULL,
                     time TEXT NOT NULL,
                     humidity REAL NOT NULL,
                     temperature REAL NOT NULL
                     )''')
        c.execute('INSERT INTO measures VALUES (NULL, {0}, {1}, {2:0.1f}, {3:0.1f})'.format(date, time_now, data['temperature'], data['humidity']))
        conn.commit()

def read_data_from_dht():
    humidity, temperature = Adafruit_DHT.read_retry(DHT_SENSOR, DHT_PIN)
    data = {
            'temperature': temperature,
            'humidity': humidity
    }
    return data

while True:
    data = read_data_from_dht()
    if data['humidity'] is not None and data['temperature'] is not None:
        write_measure_to_file(data)
        write_measure_to_database(data)
    else:
        print("Failed to retrieve data from humidity sensor")

    time.sleep(WAIT_TIME)
