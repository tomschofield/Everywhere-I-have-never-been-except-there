import serial
import sys
import glob
import requests
import serial.tools.list_ports
import json
import os
import socketio
from colorama import Fore, Back, Style

runLive = True
sio = socketio.Client()

ports = serial.tools.list_ports.comports()

@sio.event
def connect():
    print('connection established')
    sio.emit("news", {'ssid': 'test','lat': '54.9783','lon': '-1.6178'})


@sio.event
def my_message(data):
    print('message received with ', data)
    sio.emit("news", {'ssid': 'test','lat': '54.9783','lon': '-1.6178'})

@sio.event
def disconnect():
    print('disconnected from server')


sio.connect('http://localhost:3001')
# sio.wait()

for port, desc, hwid in sorted(ports):
        print("{}: {} [{}]".format(port, desc, hwid))

if runLive:
    ser = serial.Serial(
            # Serial Port to read the data from
            port='/dev/cu.usbserial-0001',
    
            #Rate at which the information is shared to the communication channel
            baudrate = 115200,
    
            #Applying Parity Checking (none in this case)
            parity=serial.PARITY_NONE,
    
        # Pattern of Bits to be read
            stopbits=serial.STOPBITS_ONE,
        
            # Total number of bits to be read
            bytesize=serial.EIGHTBITS,
    
            # Number of serial commands to accept before timing out
            timeout=1
    )
# Pause the program for 1 second to avoid overworking the serial port
def updateLog(ssid, lat, lon, filename='/Users/ntws2/Desktop/probe_requests/python/data.json'):
    # cwd = os.getcwd()  # Get the current working directory (cwd)
    # files = os.listdir(cwd)  # Get all the files in that directory
    # print("Files in %r: %s" % (cwd, files))
    # JSON data:
    new_data =  '{ "ssid":"'+ssid+'", "lat":"'+str(lat)+'",  "lon":"'+str(lon)+'"}'
    with open(filename,'r+') as file:
          # First we load existing data into a dict.
        file_data = json.load(file)
        # Join new_data with file_data inside emp_details
        file_data["locations"].append(new_data)
        # Sets file's current position at offset.
        file.seek(0)
        # convert back to json.
        json.dump(file_data, file, indent = 4)

def lookupInLog(ssid,filename='/Users/ntws2/Desktop/probe_requests/python/data.json'):
    print("looking up",ssid)
    with open(filename,'r+') as file:
          # First we load existing data into a dict.
        file_data = json.load(file)
        matches = []
        # print(len(file_data["locations"]))
        # Join new_data with file_data inside emp_details
        for location in file_data["locations"]:
            if json.loads(location)['ssid'] == ssid:
                matches.append(json.loads(location))
    return matches

def getAllPoints(filename='/Users/ntws2/Desktop/probe_requests/python/data.json'):
    with open(filename,'r+') as file:
          # First we load existing data into a dict.
        file_data = json.load(file)
        matches = []
        # print(len(file_data["locations"]))
        # Join new_data with file_data inside emp_details
        for location in file_data["locations"]:
            matches.append(json.loads(location))
    return matches
def getNPoints(n,filename='/Users/ntws2/Desktop/probe_requests/python/data.json'):
    with open(filename,'r+') as file:
          # First we load existing data into a dict.
        file_data = json.load(file)
        matches = []
        # print(len(file_data["locations"]))
        # Join new_data with file_data inside emp_details
        i =0
        for location in file_data["locations"]:
            if i<n:
                matches.append(json.loads(location))
            else:
                break
            i+=1
    return matches
def getNPointsExceptSSID(n,ssid, filename='/Users/ntws2/Desktop/probe_requests/python/data.json'):
    with open(filename,'r+') as file:
          # First we load existing data into a dict.
        file_data = json.load(file)
        matches = []
        # print(len(file_data["locations"]))
        # Join new_data with file_data inside emp_details
        i =0
        for location in file_data["locations"]:
            if json.loads(location)['ssid'] != ssid and i<n:
                matches.append(json.loads(location))
            elif i>n:
                break
            i+=1
    return matches

def lookup(ssid):
    print(Fore.RED+"NEW NETWORK NAME FOUND: ",ssid)
    print(Fore.RED+"SEARCHING DATABASE FOR LOCATIONS SEEN ")
    headers = {
        'accept': 'application/json',
    }

    params = {
        'onlymine': 'false',
        'freenet': 'false',
        'paynet': 'false',
        'ssid':ssid,
    }

    response = requests.get('https://api.wigle.net/api/v2/network/search', params=params, headers=headers, auth=('x', 'x'))
    print(response.json())
    for result in response.json()['results']:
        print(Fore.GREEN+result['trilat'],result['trilong'])
        updateLog(ssid,result['trilat'],result['trilong'] )
        sio.emit("news", {'ssid': ssid,'lat': str(result['trilat']),'lon': result['trilong']})

def get_initial_known_ssids(filename='/Users/ntws2/Desktop/probe_requests/python/data.json'):
    
    with open(filename,'r+') as file:
          # First we load existing data into a dict.
        file_data = json.load(file)
        matches = []
        # print(len(file_data["locations"]))
        # Join new_data with file_data inside emp_details
        for location in file_data["locations"]:
            matches.append(json.loads(location)['ssid'])
    return matches

def populateMapWithNPoints(n_points):
    matches = getNPoints(n_points)
    for match in matches:
        sio.emit("news", {'ssid': match['ssid'],'lat': str(match['lat']),'lon': match['lon']})

known_ssids = get_initial_known_ssids();

while 1:
        x=ser.readline()
        if len(x)>1:
            ssid=x.strip().decode('UTF-8')
            
            # sio.emit('news', {'ssid': ssid})
            if not ssid in known_ssids:
                
                known_ssids.append(ssid)
                if( len(ssid)>3 ):
                    
                    lookup(ssid)
            else:
                
                print(Fore.YELLOW+"FOUND KNOWN NETWORK NAME:")
                print(Fore.BLUE+ssid, "\n")
                # matches = lookupInLog(ssid)
                # for match in matches:
                #     sio.emit("news", {'ssid': match['ssid'],'lat': str(match['lat']),'lon': match['lon']})