# Cabina Médica

Sistema end-to-end para atención médica automatizada con hardware físico integrado. Proyecto final de 6to año – E.E.T.P. N°478 (Mayo–Diciembre 2025).

## ¿Qué hace?

Una cabina física con sensores y actuadores controlados por una Raspberry Pi 3, conectada a un servidor web PHP. El médico opera desde una PC; el paciente interactúa con la cabina de forma semi-autónoma.

**Flujo completo:**
1. El paciente se sienta en la cabina → sensor de presión detecta presencia → el sistema notifica al médico
2. El médico inicia la videollamada desde su panel → el paciente recibe la llamada en pantalla
3. El médico activa los sensores de forma remota → la Raspberry Pi mide temperatura, oximetría o pulso
4. Los datos llegan al panel del médico en tiempo real
5. El médico registra el diagnóstico y las prescripciones en la base de datos
6. El médico cierra la sesión → los actuadores se retraen, la cabina queda lista para el siguiente paciente

## Tecnologías

- **Back-end:** PHP, MySQL
- **Hardware:** Raspberry Pi 3 (GPIO, sensores físicos, servomotores con PWM)
- **Control remoto:** Python sobre SSH desde el servidor Windows (Plink)
- **Videollamada:** Whereby (embebida por iframe)
- **Actuadores:** Control de EPDU (dispositivo de energía en rack) por HTTP
- **Scripts de automatización:** `.bat` para activar/apagar GPIOs individuales desde el servidor

## Arquitectura

```
[PC Médico - XAMPP]
    ├── Panel web (PHP/HTML/JS)
    ├── Polling de estado en tiempo real (JS → PHP → MySQL)
    ├── Whereby embed (videollamada)
    └── Plink.exe → SSH → Raspberry Pi
                              └── gpio_control.py
                                    ├── Servomotores (PWM)
                                    ├── Sensor de temperatura
                                    ├── Sensor de oximetría
                                    └── Sensor de pulso

[Raspberry Pi 3]
    ├── Sensor de silla (presencia del paciente)
    ├── Scripts Python de GPIO
    └── Polling al servidor (estado de llamada)

[Base de datos MySQL]
    ├── medicos / pacientes
    ├── diagnosticos
    ├── prescripciones / medicamentos / stock
    └── estados / sensor_silla / estado_chequeo
```

## Estructura del proyecto

```
/
├── conexion.php                  # Conexión MySQLi
├── login_medico.html / .php      # Autenticación médico
├── login_paciente.html / .php    # Autenticación paciente
├── registro_medico.html / .php   # Registro de médico
├── registro_paciente.html / .php # Registro de paciente
├── llamada_medico.html           # Panel principal del médico
├── llamada_paciente.html         # Pantalla del paciente en cabina
├── espera_llamada.html / .php    # Pantalla de espera del paciente
├── registrar_diagnostico.php     # Guarda diagnóstico en BD
├── obtener_diagnostico.php       # Recupera último diagnóstico
├── get_paciente.php              # Datos del paciente por DNI
├── set_estado_llamada.php        # Control de estado de la videollamada
├── estado_llamada.php            # Consulta estado de llamada
├── sensor_silla.php              # Estado del sensor de presencia
├── registrar_estado.php          # Registra eventos de estado
├── activar_chequeo.php           # Activa tipo de sensor
├── obtener_chequeo_activo.php    # Consulta sensor activo
├── verificar_chequeo.php         # Verifica si hay chequeo activo
├── verificar_diagnostico.php     # Verifica si el diagnóstico fue completado
├── verificar_dni_paciente.php    # Valida existencia de DNI
├── ipower_control.php            # Control de EPDU por HTTP
├── gpio_control.py               # Control de GPIO en Raspberry Pi
├── activar_gpio_*.bat            # Scripts de activación por pin
├── apagar_gpio_21.bat            # Script de apagado
├── led_blanco.bat / led_rojo.bat # Control de LEDs
└── centro_salud.sql              # Esquema de base de datos
```

## Configuración local

**Requisitos:** PHP 8+, MySQL/MariaDB, XAMPP, Python 3 en Raspberry Pi, Plink (cliente SSH para Windows)

1. Importar `centro_salud.sql` en phpMyAdmin
2. Copiar `conexion.php.example` como `conexion.php` y completar credenciales
3. Configurar la IP de la Raspberry Pi en los archivos `.bat` y en `ipower_control.php`
4. En la Raspberry Pi: copiar `gpio_control.py` y asegurarse de que Python 3 y RPi.GPIO estén instalados
5. Acceder a `http://localhost/cabina-medica/login_medico.html`

> **Nota:** El sistema fue desarrollado y probado en red local. La videollamada usa Whereby con una sala fija; para uso real sería necesario generar salas dinámicas por sesión.

## Deuda técnica conocida

- La autenticación de médicos no usa `password_verify` de forma consistente en la versión original (algunos registros de prueba tienen contraseñas sin hashear)
- Las credenciales de la EPDU están hardcodeadas; en producción irían en variables de entorno
- El proyecto creció iterativamente durante el cursado: se evaluaron otras plataformas de videollamada (Jitsi, Daily.co) antes de definir Whereby como solución final

## Lo que se aprendió construyéndolo

Este proyecto fue desarrollado aprendiendo en la marcha bajo restricciones de tiempo escolar. Implicó resolver en tiempo real: integración PHP↔Python sobre SSH, control de hardware físico desde una interfaz web, sincronización de estados entre dos dispositivos distintos, y evaluación práctica de tres plataformas de videollamada hasta encontrar la que funcionaba dentro de las restricciones del entorno.

## Autor

**Bringas Franco Sebastián**  
Técnico en Informática – E.E.T.P. N°478  
Cursando Ingeniería en Inteligencia Artificial – FICH-UNL  
[francosbringas@gmail.com](mailto:francosbringas@gmail.com)
