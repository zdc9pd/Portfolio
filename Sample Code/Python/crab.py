#!/usr/bin/python

import sys
import time
import datetime

import gspread

import Adafruit_BBIO.ADC as ADC
import Adafruit_DHT

DHT_TYPE = Adafruit_DHT.AM2302

DHT_PIN  = 'P8_11'

FREQUENCY_SECONDS      = 900

humidity, temp = Adafruit_DHT.read(DHT_TYPE, DHT_PIN)
if humidity is None or temp is None:
                time.sleep(2)
                continue

        print 'Temperature: {0:0.1f} F'.format((((temp*9)/5)+32))
        print 'Humidity:    {0:0.1f} %'.format(humidity)

print'\n'

ADC.setup()
soil_moisture = ADC.read("P9_36")
soil_moisture = ADC.read("P9_36")

if 1 > soil_moisture > .8 :
    print 'Low Soil Moisture: '
    print soil_moisture

elif .8> soil_moisture > .5 :
    print 'Medium Soil Moisture: '
    print soil_moisture
else :
    print 'High Soil Moisture: '
    print soil_moisture 
	
print '\n'	
time.sleep(FREQUENCY_SECONDS)	