# /home/pi/cabina_scripts/gpio_control.py
import RPi.GPIO as GPIO
import time
import sys

# Configuración de pines BCM
PIN_PRESION = 1
PIN_SERVO_MED1 = 22
PIN_SERVO_MED2 = 23
PIN_SERVO_MED3 = 24
PIN_SERVO_DOMO = 4
PIN_LED_BLANCO = 3
PIN_LED_ROJO = 2 # Asumiendo GPIO 2 para el LED rojo

# Configuración de servomotores (ajusta estos valores para tus servos)
# 0 grados = 2.5% duty cycle, 180 grados = 12.5% duty cycle para 50Hz
SERVO_MIN_DUTY = 2.5
SERVO_MAX_DUTY = 12.5
SERVO_FREQ = 50 # Hz

def setup_gpio():
    GPIO.setmode(GPIO.BCM)
    # Pines de salida
    GPIO.setup([PIN_SERVO_MED1, PIN_SERVO_MED2, PIN_SERVO_MED3, PIN_SERVO_DOMO, PIN_LED_BLANCO, PIN_LED_ROJO], GPIO.OUT)
    # Pin de entrada
    GPIO.setup(PIN_PRESION, GPIO.IN, pull_up_down=GPIO.PUD_DOWN) # O PUD_UP si tu sensor lo requiere

def cleanup_gpio():
    GPIO.cleanup()

def set_servo_angle(pin, angle):
    if not (0 <= angle <= 180):
        print(f"Error: Ángulo inválido para servo en pin {pin}. Debe ser entre 0 y 180.")
        return

    duty = SERVO_MIN_DUTY + (angle / 180.0) * (SERVO_MAX_DUTY - SERVO_MIN_DUTY)
    
    pwm = GPIO.PWM(pin, SERVO_FREQ)
    pwm.start(0)
    pwm.ChangeDutyCycle(duty)
    time.sleep(0.7) # Dar tiempo al servo para moverse
    pwm.stop()
    print(f"Servo en GPIO {pin} movido a {angle} grados.")

def set_led_state(pin, state):
    if state == 1:
        GPIO.output(pin, GPIO.HIGH)
        print(f"LED en GPIO {pin} encendido.")
    elif state == 0:
        GPIO.output(pin, GPIO.LOW)
        print(f"LED en GPIO {pin} apagado.")
    else:
        print(f"Estado inválido para LED en pin {pin}. Use 0 (apagado) o 1 (encendido).")

def read_pressure_sensor():
    value = GPIO.input(PIN_PRESION)
    print(f"Sensor de presión (GPIO {PIN_PRESION}): {value}")
    return value

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Uso: python3 gpio_control.py <comando> [argumentos]")
        print("Comandos:")
        print("  read_pressure")
        print("  servo_med1 <angulo>")
        print("  servo_med2 <angulo>")
        print("  servo_med3 <angulo>")
        print("  servo_domo <angulo>")
        print("  led_blanco <estado>")
        print("  led_rojo <estado>")
        sys.exit(1)

    setup_gpio()
    command = sys.argv[1]

    try:
        if command == "read_pressure":
            result = read_pressure_sensor()
            # Imprimir el resultado para que el .bat pueda capturarlo
            print(f"RESULT:{result}")
        elif command == "servo_med1":
            angle = int(sys.argv[2])
            set_servo_angle(PIN_SERVO_MED1, angle)
        elif command == "servo_med2":
            angle = int(sys.argv[2])
            set_servo_angle(PIN_SERVO_MED2, angle)
        elif command == "servo_med3":
            angle = int(sys.argv[2])
            set_servo_angle(PIN_SERVO_MED3, angle)
        elif command == "servo_domo":
            angle = int(sys.argv[2])
            set_servo_angle(PIN_SERVO_DOMO, angle)
        elif command == "led_blanco":
            state = int(sys.argv[2])
            set_led_state(PIN_LED_BLANCO, state)
        elif command == "led_rojo":
            state = int(sys.argv[2])
            set_led_state(PIN_LED_ROJO, state)
        else:
            print(f"Comando desconocido: {command}")
    except IndexError:
        print("Error: Faltan argumentos para el comando.")
    except ValueError:
        print("Error: Argumento inválido. Se esperaba un número.")
    except Exception as e:
        print(f"Ocurrió un error inesperado: {e}")
    finally:
        cleanup_gpio()