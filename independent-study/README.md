# How to send data from Adafruit Feather HUZZAH ESP8266 to Laravel Application


### Arduino Set up and Code
The board that I'm using is the
[Adafruit Feather HUZZAH with ESP8266](https://www.adafruit.com/product/2821), a very popular microcontroller that doesn't cost too much and comes with built in WiFi. 

Download and install the [Arduino IDE](https://www.arduino.cc/en/Main/Software). This software is used to write code and upload it to the board. 

After downloading the IDE, launch the software. Enter `http://arduino.esp8266.com/stable/package_esp8266com_index.json` into _Additional Board Manager URLs_ field in the Arduino IDE preferences.


Next, navigate to **Tools->Board->Board manager**, search for and install the package esp8266 by ESP8266 Community. Under **Tools**, make sure these settings are set appropriately. 

* CPU Frequency is set to 80 Mhz
* Flash Size is set to "4M (3M SPIFFS) 
* Upload speed is set to 115200 baud

Example Arduino code [source](https://github.com/bkolicoski/arduino-laravel-communication):
	
	#include <ESP8266WiFi.h>
	#include <WiFiClient.h> 
	#include <ESP8266WebServer.h>
	#include <ESP8266HTTPClient.h>
	
	const char *ssid = "Arduino";  
	const char *password = "helloworld";
	
	//Web/Server address to read/write from 
	const char *host = "http://e15p3.rsiu01.me/api/user";   //your IP/web server address

	void setup() {
	delay(1000);
	Serial.begin(115200);
	WiFi.mode(WIFI_OFF);        //Prevents reconnection issue (taking too long to connect)
	delay(1000);
	WiFi.mode(WIFI_STA);        //This line hides the viewing of ESP as wifi hotspot
	
	WiFi.begin(ssid, password);     //Connect to your WiFi router
	Serial.println("");
	
	Serial.print("Connecting");
	// Wait for connection
	while (WiFi.status() != WL_CONNECTED) {
		delay(500);
		Serial.print(".");
	}
	
	//If connection successful show IP address in serial monitor
	Serial.println("");
	Serial.print("Connected to ");
	Serial.println(ssid);
	Serial.print("IP address: ");
	Serial.println(WiFi.localIP());  //IP address assigned to your ESP
	}
	
	void loop() {
	//Declare object of class HTTPClient
	HTTPClient http;

	WiFiClient client;

	//Prepare data
	String temperature, humidity, device_id, postData; 
	int tmp_value=random(10, 25);
	int h_value=random(40, 80);
	int dev_id=random(1, 30);
	temperature = String(tmp_value);
	humidity = String(h_value);
	device_id = String(dev_id);
	
	//prepare request
	postData = "temperature=" + temperature  + "&humidity=" + humidity + "&device_id=" + device_id;
	http.begin( host); //HTTP
	http.addHeader("Content-Type", "application/x-www-form-urlencoded");
	int httpCode = http.POST(postData);
	String payload = http.getString();
	
	Serial.println(httpCode);
	Serial.println(payload);
	http.end();
	delay(5000);
	}

### Laravel configuration
Under Api Routes, I defined a route that calls ReadingController@store, which handles data coming from a post request and stores the values in a database. 
	
	<?php

	use Illuminate\Http\Request;

	/*
	|--------------------------------------------------------------------------
	| API Routes
	|--------------------------------------------------------------------------
	|
	| Here is where you can register API routes for your application. These
	| routes are loaded by the RouteServiceProvider within a group which
	| is assigned the "api" middleware group. Enjoy building your API!
	|
	*/

	Route::middleware('auth:api')->get('/user', function (Request $request) {
	    return $request->user();
	});

	Route::post('/', 'ReadingController@store');

ReadingController@store Method:
		
		public function store(Request $request)
		{
			
			# Validate the request data
			# The `$request->validate` method takes an array of data
			# where the keys are form inputs
			# and the values are validation rules to apply to those inputs
			$request->validate([
				'device_id' => 'required',
				'temperature' => 'required',
				'humidity' => 'required'
			
			]);
			
		

			# Note: If validation fails, it will automatically redirect the visitor back to the form page
			# and none of the code that follows will execute.

			# Add the reading to the database
			$newReading = new Reading();
			$newReading->device_id = $request->device_id;
			$newReading->temperature = $request->temperature;
			$newReading->humidity = $request->humidity;
		
			$newReading->save();
		}
	}



		


I had hoped I would get Api with authentication working, but I can't seem to figure it out. So far I looked into the following sources: 

*https://www.toptal.com/laravel/restful-laravel-api-tutorial
*https://laravel.com/docs/7.x/authentication#introduction

mysql> SELECT * FROM readings;
+----+---------------------+---------------------+-------------+----------+-----------+
| id | created_at          | updated_at          | temperature | humidity | device_id |
+----+---------------------+---------------------+-------------+----------+-----------+
|  1 | 2020-04-29 02:48:30 | 2020-04-29 02:48:30 |       24.00 |    52.00 |        26 |
|  2 | 2020-04-29 02:48:35 | 2020-04-29 02:48:35 |       16.00 |    51.00 |        19 |
|  3 | 2020-04-29 02:48:40 | 2020-04-29 02:48:40 |       21.00 |    58.00 |         8 |
|  4 | 2020-04-29 02:48:45 | 2020-04-29 02:48:45 |       22.00 |    56.00 |        21 |
|  5 | 2020-04-29 02:48:50 | 2020-04-29 02:48:50 |       13.00 |    73.00 |         6 |
|  6 | 2020-04-29 02:48:55 | 2020-04-29 02:48:55 |       22.00 |    42.00 |         2 |
|  7 | 2020-04-29 02:49:00 | 2020-04-29 02:49:00 |       11.00 |    78.00 |        20 |
|  8 | 2020-04-29 02:49:05 | 2020-04-29 02:49:05 |       13.00 |    40.00 |        21 |
|  9 | 2020-04-29 02:49:10 | 2020-04-29 02:49:10 |       24.00 |    55.00 |        16 |
| 10 | 2020-04-29 02:49:16 | 2020-04-29 02:49:16 |       11.00 |    46.00 |        13 |
| 11 | 2020-04-29 02:49:21 | 2020-04-29 02:49:21 |       17.00 |    58.00 |        22 |
| 12 | 2020-04-29 02:49:26 | 2020-04-29 02:49:26 |       18.00 |    59.00 |         3 |
| 13 | 2020-04-29 02:49:31 | 2020-04-29 02:49:31 |       12.00 |    70.00 |        24 |
| 14 | 2020-04-29 02:49:36 | 2020-04-29 02:49:36 |       12.00 |    52.00 |         2 |
| 15 | 2020-04-29 02:49:41 | 2020-04-29 02:49:41 |       14.00 |    75.00 |        23 |
| 16 | 2020-04-29 02:49:46 | 2020-04-29 02:49:46 |       10.00 |    70.00 |        18 |
| 17 | 2020-04-29 02:49:51 | 2020-04-29 02:49:51 |       22.00 |    40.00 |         8 |
| 18 | 2020-04-29 02:49:56 | 2020-04-29 02:49:56 |       11.00 |    66.00 |        23 |
| 19 | 2020-04-29 02:50:01 | 2020-04-29 02:50:01 |       23.00 |    71.00 |         8 |
| 20 | 2020-04-29 02:50:06 | 2020-04-29 02:50:06 |       16.00 |    58.00 |        26 |
| 21 | 2020-04-29 02:50:11 | 2020-04-29 02:50:11 |       21.00 |    51.00 |        13 |
| 22 | 2020-04-29 02:50:16 | 2020-04-29 02:50:16 |       11.00 |    52.00 |        19 |
| 23 | 2020-04-29 02:50:22 | 2020-04-29 02:50:22 |       17.00 |    62.00 |        29 |
| 24 | 2020-04-29 02:50:27 | 2020-04-29 02:50:27 |       20.00 |    43.00 |        17 |
| 25 | 2020-04-29 02:50:32 | 2020-04-29 02:50:32 |       23.00 |    50.00 |         9 |
| 26 | 2020-04-29 02:50:37 | 2020-04-29 02:50:37 |       17.00 |    61.00 |         5 |
| 27 | 2020-04-29 02:50:42 | 2020-04-29 02:50:42 |       19.00 |    47.00 |         5 |
| 28 | 2020-04-29 02:50:47 | 2020-04-29 02:50:47 |       14.00 |    76.00 |         2 |
| 29 | 2020-04-29 02:50:52 | 2020-04-29 02:50:52 |       14.00 |    48.00 |        21 |
| 30 | 2020-04-29 02:50:57 | 2020-04-29 02:50:57 |       20.00 |    52.00 |         9 |
| 31 | 2020-04-29 02:51:02 | 2020-04-29 02:51:02 |       18.00 |    60.00 |        25 |
| 32 | 2020-04-29 02:51:07 | 2020-04-29 02:51:07 |       19.00 |    57.00 |        29 |
| 33 | 2020-04-29 02:51:12 | 2020-04-29 02:51:12 |       13.00 |    79.00 |         1 |
| 34 | 2020-04-29 02:51:17 | 2020-04-29 02:51:17 |       16.00 |    43.00 |         1 |
| 35 | 2020-04-29 02:51:23 | 2020-04-29 02:51:23 |       17.00 |    79.00 |         8 |
| 36 | 2020-04-29 02:51:28 | 2020-04-29 02:51:28 |       23.00 |    44.00 |        11 |
| 37 | 2020-04-29 02:51:33 | 2020-04-29 02:51:33 |       12.00 |    45.00 |        25 |
| 38 | 2020-04-29 02:51:38 | 2020-04-29 02:51:38 |       22.00 |    52.00 |        16 |
| 39 | 2020-04-29 02:51:43 | 2020-04-29 02:51:43 |       18.00 |    68.00 |         3 |
| 40 | 2020-04-29 02:51:48 | 2020-04-29 02:51:48 |       24.00 |    44.00 |         4 |
| 41 | 2020-04-29 02:51:53 | 2020-04-29 02:51:53 |       22.00 |    73.00 |        11 |
| 42 | 2020-04-29 02:51:58 | 2020-04-29 02:51:58 |       11.00 |    43.00 |        20 |
| 43 | 2020-04-29 02:52:03 | 2020-04-29 02:52:03 |       13.00 |    52.00 |         1 |
| 44 | 2020-04-29 02:52:08 | 2020-04-29 02:52:08 |       22.00 |    45.00 |        26 |
| 45 | 2020-04-29 02:52:13 | 2020-04-29 02:52:13 |       11.00 |    41.00 |        28 |
| 46 | 2020-04-29 02:52:18 | 2020-04-29 02:52:18 |       23.00 |    58.00 |         1 |
| 47 | 2020-04-29 02:52:23 | 2020-04-29 02:52:23 |       21.00 |    41.00 |        25 |
| 48 | 2020-04-29 02:52:29 | 2020-04-29 02:52:29 |       20.00 |    63.00 |         2 |
| 49 | 2020-04-29 02:52:34 | 2020-04-29 02:52:34 |       23.00 |    48.00 |        11 |
| 50 | 2020-04-29 02:52:39 | 2020-04-29 02:52:39 |       11.00 |    79.00 |        28 |
| 51 | 2020-04-29 02:52:44 | 2020-04-29 02:52:44 |       13.00 |    55.00 |         5 |
| 52 | 2020-04-29 02:52:49 | 2020-04-29 02:52:49 |       11.00 |    54.00 |        18 |
| 53 | 2020-04-29 02:52:54 | 2020-04-29 02:52:54 |       15.00 |    54.00 |        27 |
| 54 | 2020-04-29 02:52:59 | 2020-04-29 02:52:59 |       20.00 |    51.00 |         8 |
| 55 | 2020-04-29 02:53:04 | 2020-04-29 02:53:04 |       14.00 |    60.00 |        27 |
| 56 | 2020-04-29 02:53:09 | 2020-04-29 02:53:09 |       23.00 |    74.00 |         3 |
| 57 | 2020-04-29 02:53:14 | 2020-04-29 02:53:14 |       19.00 |    51.00 |        29 |
| 58 | 2020-04-29 02:53:19 | 2020-04-29 02:53:19 |       23.00 |    72.00 |        21 |
| 59 | 2020-04-29 02:53:25 | 2020-04-29 02:53:25 |       12.00 |    76.00 |         6 |
| 60 | 2020-04-29 02:53:30 | 2020-04-29 02:53:30 |       16.00 |    52.00 |         3 |
| 61 | 2020-04-29 02:53:35 | 2020-04-29 02:53:35 |       22.00 |    58.00 |        17 |
| 62 | 2020-04-29 02:53:40 | 2020-04-29 02:53:40 |       17.00 |    69.00 |        16 |
| 63 | 2020-04-29 02:53:45 | 2020-04-29 02:53:45 |       15.00 |    66.00 |        26 |
| 64 | 2020-04-29 02:53:50 | 2020-04-29 02:53:50 |       16.00 |    71.00 |         4 |
| 65 | 2020-04-29 02:53:55 | 2020-04-29 02:53:55 |       19.00 |    50.00 |         1 |
| 66 | 2020-04-29 02:54:00 | 2020-04-29 02:54:00 |       17.00 |    45.00 |         4 |
| 67 | 2020-04-29 02:54:05 | 2020-04-29 02:54:05 |       16.00 |    46.00 |        18 |
| 68 | 2020-04-29 02:54:10 | 2020-04-29 02:54:10 |       20.00 |    77.00 |        25 |
| 69 | 2020-04-29 02:54:15 | 2020-04-29 02:54:15 |       13.00 |    61.00 |        20 |
| 70 | 2020-04-29 02:54:20 | 2020-04-29 02:54:20 |       18.00 |    47.00 |         3 |
| 71 | 2020-04-29 02:54:25 | 2020-04-29 02:54:25 |       12.00 |    51.00 |         1 |
| 72 | 2020-04-29 02:54:31 | 2020-04-29 02:54:31 |       16.00 |    44.00 |         3 |
| 73 | 2020-04-29 02:54:36 | 2020-04-29 02:54:36 |       17.00 |    51.00 |        20 |
| 74 | 2020-04-29 02:54:41 | 2020-04-29 02:54:41 |       23.00 |    51.00 |        28 |
| 75 | 2020-04-29 02:54:46 | 2020-04-29 02:54:46 |       18.00 |    79.00 |        18 |
| 76 | 2020-04-29 02:54:51 | 2020-04-29 02:54:51 |       20.00 |    60.00 |        20 |
| 77 | 2020-04-29 02:54:56 | 2020-04-29 02:54:56 |       16.00 |    72.00 |        18 |
| 78 | 2020-04-29 02:55:01 | 2020-04-29 02:55:01 |       20.00 |    56.00 |        27 |
| 79 | 2020-04-29 02:55:06 | 2020-04-29 02:55:06 |       14.00 |    67.00 |         6 |
| 80 | 2020-04-29 02:55:11 | 2020-04-29 02:55:11 |       19.00 |    74.00 |         4 |
+----+---------------------+---------------------+-------------+----------+-----------+
80 rows in set (0.00 sec)