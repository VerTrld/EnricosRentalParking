const int ClockWiseBtn = 4;
const int AntiClockWiseBtn = 2;
const int StopBtn = 3;
const int IN1 = A0;
const int IN2 = A1;

void setup() {
  Serial.begin(9600);
  pinMode(IN1, OUTPUT);
  pinMode(IN2, OUTPUT);
  pinMode(ClockWiseBtn, INPUT);
  pinMode(AntiClockWiseBtn, INPUT);
  pinMode(StopBtn, INPUT);
}

void stop() {
  digitalWrite(IN1, LOW);
  digitalWrite(IN2, LOW);
}

void loop() {
  if (Serial.available() > 0) {
    char c = Serial.read();
    Serial.println(c);

    if (c == 'n') {
      Serial.println("ON");
      digitalWrite(IN2, HIGH);
      digitalWrite(IN1, LOW);
      delay(30000);
      digitalWrite(IN1, HIGH);
      digitalWrite(IN2, LOW);
      delay(10000);
      stop();
    } else if (c == 'f') {
      Serial.println("off");
      stop();
    }
  }
}
