#include <Servo.h>

// Create servo object
Servo servo;

// Declare global variables
int angle = 90; // set the initial angle to 90 degrees
int speed = 20; // set the speed (delay value) to half of the normal speed

void setup() {
  // Attach servo object to pin
  servo.attach(8);
  // Initialize serial communication
  Serial.begin(9600);
}


void loop() {
  if (Serial.available() > 0) {
    char c = Serial.read();
    Serial.println(c);
    delay(100);

    if (c == '1') {
      if (angle == 90) {
        moveServo(0); // move the servo to 0 degrees
        angle = 0; // update the angle variable
      } else {
        moveServo(90); // move the servo to 90 degrees
        angle = 90; // update the angle variable
      }
    }
  }
}

void moveServo(int targetAngle) {
  if (angle < targetAngle) {
    for (int i = angle; i <= targetAngle; i++) {
      servo.write(i);
      delay(speed); // Adjust the delay based on the desired speed
    }
  } else if (angle > targetAngle) {
    for (int i = angle; i >= targetAngle; i--) {
      servo.write(i);
      delay(speed); // Adjust the delay based on the desired speed
    }
  }
}
