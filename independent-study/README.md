# How to send data from Arduino to Laravel Application and visualize the data with Laravel Charts




### Arduino Set up and Code
The board I'm using:
[Adafruit Feather HUZZAH with ESP8266](https://www.adafruit.com/product/2821)

Download the [Arduino IDE]([https://www.arduino.cc/en/Main/Software](https://www.arduino.cc/en/Main/Software))

Enter `http://arduino.esp8266.com/stable/package_esp8266com_index.json` into _Additional Board Manager URLs_ field in the Arduino IDE preferences.


Next, navigate to **Tools->Board->Board manager**, search for and install the package esp8266 by ESP8266 Community. Under **Tools**, make sure these settings are set appropriately. 

* CPU Frequency is set to 80 Mhz
* Flash Size is set to "4M (3M SPIFFS) 
* Upload speed is set to 115200 baud

Example Arduino code [source](https://github.com/bkolicoski/arduino-laravel-communication):
	
		 
	#include <ESP8266WiFi.h>
	#include <WiFiClient.h> 
	#include <ESP8266WebServer.h>
	#include <ESP8266HTTPClient.h>
	 
	const char *ssid = "YourWIFINetwork";  
	const char *password = "your_password";
	 
	//Web/Server address to read/write from 
	const char *host = "http://192.168.2.114/api";   //your IP/web server address

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

	  //Prepare data
	  String temperature, humidity, postData;
	  int tmp_value=random(10, 25);
	  int h_value=random(40, 80);
	  temperature = String(tmp_value);
	  humidity = String(h_value);
	 
	  //prepare request
	  postData = "temperature=" + temperature + "&humidity=" + humidity ;
	  http.begin(host);
	  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
	  int httpCode = http.POST(postData);
	  String payload = http.getString();
	 
	  Serial.println(httpCode);
	  Serial.println(payload);
	  http.end();
	  delay(5000);
	}

### Laravel configuration
Going to based the code off [source](https://github.com/bkolicoski/arduino-laravel-communication/blob/master/Laravel/routes/api.php)
	  
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

	Route::post('/', function (\Illuminate\Http\Request $request) {
	    \Illuminate\Support\Facades\Storage::append("arduino-log.txt",
	        "Time: " . now()->format("Y-m-d H:i:s") . ', ' .
	        "Temperature: " . $request->get("temperature", "n/a") . '°C, ' .
	        "Humidity: " . $request->get("humidity", "n/a") . '%'
	    );
	});

Instead of writing to `.txt` file, I'm going to try to incorporate writing to a database. 

Api with auth: https://www.toptal.com/laravel/restful-laravel-api-tutorial

### Laravel Charts: to visualize that data coming in from Arduino

[Package](https://packagist.org/packages/laraveldaily/laravel-charts)