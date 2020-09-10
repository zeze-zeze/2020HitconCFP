#include "Adafruit_Thermal.h"
#include "foxqrcode.h"
#include "testqr.h"
#include "logo.h"
#include <SoftwareSerial.h>

#define TX_PIN 27
#define RX_PIN 16

SoftwareSerial mySerial(RX_PIN, TX_PIN);
Adafruit_Thermal printer(&mySerial);

void setup() {
  Serial.begin(9600);
  // set up printer
  pinMode(7, OUTPUT); digitalWrite(7, LOW);

  mySerial.begin(9600);  // Initialize SoftwareSerial
  printer.begin();        // Init printer (same regardless of serial type)
}

void loop() {
  delay(1000);

  if(Serial.available()) {
    Serial.println("START");
    String line = "";
    while(line.length() < 18448 || line.indexOf("STARTSTART") == -1 || line.indexOf("ENDEND") == -1){
       line += Serial.readString();
    }
    String line2 = line.substring(line.indexOf("STARTSTART") + 10, line.indexOf("ENDEND") - 1);
    //String line = Serial.readString();
    uint8_t PROGMEM testqr = atoi(line2.c_str()); 
    printer.setSize('M');        // Set type size, accepts 'S', 'M', 'L'
    printer.justify('C');
    printer.println(F("BambooFox Currency"));
    //printer.printBitmap(logo_width, logo_height, fox);
    //printer.printBitmap(foxqrcode_width, foxqrcode_height, foxqrcode);
    printer.printBitmap(384, 384, &testqr);
    printer.print(F("$"));
    printer.println(line2.length());
    printer.println(F(""));
    
    printer.feed(2);
    printer.sleep();      // Tell printer to sleep
    delay(3000L);         // Sleep for 3 seconds
    printer.wake();       // MUST wake() before printing again, even if reset
    printer.setDefault(); // Restore printer to defaults
    //}
  }
}
