void setup() {
  Serial.begin(115200);
}

void loop() {
  if(Serial.available()){
    Serial.println(Serial.readString());
  }
  delay(1000L);
}
