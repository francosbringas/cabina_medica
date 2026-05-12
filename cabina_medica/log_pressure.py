# /home/pi/cabina_scripts/log_pressure.py
import RPi.GPIO as GPIO
import time
import sys
import requests 

# Configuración de pines BCM
PIN_PRESION = 1


SAVE_STATE_URL = "http://192.168.1.YYY/cabina_medica/cambiar_estado.php" # O registrar_estado.php

def setup_gpio():
    GPIO.setmode(GPIO.BCM)
    GPIO.setup(PIN_PRESION, GPIO.IN, pull_up_down=GPIO.PUD_DOWN) # O PUD_UP

def cleanup_gpio():
    GPIO.cleanup()

def log_pressure_to_db():
    setup_gpio()
    try:
        current_state = GPIO.input(PIN_PRESION)
        print(f"Sensor de presión (GPIO {PIN_PRESION}): {current_state}")

        try:
            response = requests.post(SAVE_STATE_URL, data={'estado': current_state})
            response.raise_for_status() # error para codigos de estado HTTP 4xx/5xx
            print(f"Estado {current_state} enviado a la base de datos. Respuesta: {response.text}")
        except requests.exceptions.RequestException as e:
            print(f"Error al enviar estado a la base de datos: {e}")
            print(f"URL intentada: {SAVE_STATE_URL}")
            print(f"Datos enviados: {{'estado': {current_state}}}")

    except Exception as e:
        print(f"Ocurrió un error inesperado al leer o loguear presión: {e}")
    finally:
        cleanup_gpio()

if __name__ == "__main__":
    log_pressure_to_db()