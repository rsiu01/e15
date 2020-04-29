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



		


Api with auth: https://www.toptal.com/laravel/restful-laravel-api-tutorial

### Laravel Charts: to visualize that data coming in from Arduino

[Package](https://packagist.org/packages/laraveldaily/laravel-charts)