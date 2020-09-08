#include <SPI.h>
#include <WiFi.h>

char ssid[] = "zeze's iPhone";          //  your network SSID (name)
char pass[] = "iphonewifiau4a83";   // your network password

int status = WL_IDLE_STATUS;
char servername[]="172.104.78.53";  // remote server we will connect to

WiFiClient client;

void setup() {
  Serial.begin(9600);
  Serial.println("Attempting to connect to WPA network...");
  Serial.print("SSID: ");
  Serial.println(ssid);

  status = WiFi.begin(ssid, pass);
  if ( status != WL_CONNECTED) {
    Serial.println("Couldn't get a wifi connection");
    // don't do anything else:
    while(true);
  }
  else {
    Serial.println("Connected to wifi");
    Serial.println("\nStarting connection...");
    // if you get a connection, report back via serial:
    if (client.connect(servername, 23456)) {
      Serial.println("connected");
      // Make a HTTP request:
      client.println("aaaaaaa");
      client.println();
    }
  }
}

void loop() {

}
