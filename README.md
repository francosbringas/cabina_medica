🇦🇷 [Español](#español) | 🇺🇸 [English](#english)

---

<a name="español"></a>
# Cabina Médica

Sistema end-to-end para atención médica automatizada con hardware físico integrado. Proyecto final de 6to año – E.E.T.P. N°478 (Abril–Diciembre 2025).

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

## Desafíos técnicos y gestión de crisis

El desarrollo de este proyecto se llevó a cabo bajo un entorno de alta volatilidad de requisitos y cambios estructurales en el equipo, lo que exigió una respuesta técnica inmediata y adaptabilidad:

- **Asunción de roles críticos:** Debido a la reasignación de integrantes del equipo hacia otras tareas, asumí la responsabilidad integral de áreas inicialmente fuera de mi alcance, incluyendo la normalización de la base de datos MySQL, la configuración del sistema operativo de la Raspberry Pi 3 y la programación de la lógica de hardware (GPIO).
- **Pivotaje tecnológico y adaptabilidad:** El sistema atravesó múltiples refactorizaciones completas debido a cambios constantes en los requerimientos. Esto incluyó la evaluación e integración sucesiva de tres plataformas de videollamada (Jitsi, Daily.co y finalmente Whereby) y el rediseño total de la interfaz de usuario para operar exclusivamente mediante mouse, eliminando la dependencia del teclado por restricciones físicas de la cabina.
- **Control de infraestructura crítica:** Implementé la lógica de control para la ePDU IP Power mediante protocolos HTTP, permitiendo la gestión energética secuencial de dispositivos (como la activación temporizada de una bomba de agua para el servicio de hidratación del paciente).
- **Integración de sistemas heterogéneos:** Logré la comunicación fluida entre un servidor Windows (XAMPP) y la Raspberry Pi (Linux) mediante la automatización de túneles SSH con Plink y scripts de procesamiento por lotes (.bat), asegurando que los actuadores respondieran en tiempo real a las órdenes del médico.
- **Liderazgo técnico:** Ante la disparidad de conocimientos en el grupo, actué como nexo técnico, capacitando al resto de los integrantes sobre el flujo del sistema para la defensa final del proyecto y asegurando que el MVP fuera funcional para la presentación.

## Autor

**Bringas Franco Sebastián**  
Técnico en Informática – E.E.T.P. N°478  
Cursando Ingeniería en Inteligencia Artificial – FICH-UNL  
[francosbringas@gmail.com](mailto:francosbringas@gmail.com)

---

<a name="english"></a>
# Medical Booth

End-to-end automated healthcare system with integrated physical hardware. Final project – 6th year, E.E.T.P. N°478 (April–December 2025).

## What does it do?

A physical booth with sensors and actuators controlled by a Raspberry Pi 3, connected to a PHP web server. The doctor operates from a PC; the patient interacts with the booth semi-autonomously.

**Full flow:**
1. The patient sits in the booth → pressure sensor detects presence → the system notifies the doctor
2. The doctor starts the video call from their panel → the patient receives the call on screen
3. The doctor remotely activates sensors → the Raspberry Pi measures temperature, oximetry or pulse
4. Data reaches the doctor's panel in real time
5. The doctor registers the diagnosis and prescriptions in the database
6. The doctor ends the session → actuators retract, the booth is ready for the next patient

## Technologies

- **Back-end:** PHP, MySQL
- **Hardware:** Raspberry Pi 3 (GPIO, physical sensors, PWM servomotors)
- **Remote control:** Python over SSH from Windows server (Plink)
- **Video call:** Whereby (embedded via iframe)
- **Actuators:** EPDU (rack power device) control over HTTP
- **Automation scripts:** `.bat` files to activate/deactivate individual GPIOs from the server

## Architecture

```
[Doctor PC - XAMPP]
    ├── Web panel (PHP/HTML/JS)
    ├── Real-time state polling (JS → PHP → MySQL)
    ├── Whereby embed (video call)
    └── Plink.exe → SSH → Raspberry Pi
                              └── gpio_control.py
                                    ├── Servomotors (PWM)
                                    ├── Temperature sensor
                                    ├── Oximetry sensor
                                    └── Pulse sensor

[Raspberry Pi 3]
    ├── Chair sensor (patient presence)
    ├── Python GPIO scripts
    └── Polling server (call state)

[MySQL Database]
    ├── doctors / patients
    ├── diagnoses
    ├── prescriptions / medications / stock
    └── states / chair_sensor / active_check
```

## Project structure

```
/
├── conexion.php                  # MySQLi connection
├── login_medico.html / .php      # Doctor authentication
├── login_paciente.html / .php    # Patient authentication
├── registro_medico.html / .php   # Doctor registration
├── registro_paciente.html / .php # Patient registration
├── llamada_medico.html           # Doctor main panel
├── llamada_paciente.html         # Patient screen in booth
├── espera_llamada.html / .php    # Patient waiting screen
├── registrar_diagnostico.php     # Saves diagnosis to DB
├── obtener_diagnostico.php       # Retrieves latest diagnosis
├── get_paciente.php              # Patient data by ID
├── set_estado_llamada.php        # Video call state control
├── estado_llamada.php            # Call state query
├── sensor_silla.php              # Presence sensor state
├── registrar_estado.php          # Logs state events
├── activar_chequeo.php           # Activates sensor type
├── obtener_chequeo_activo.php    # Queries active sensor
├── verificar_chequeo.php         # Checks if check is active
├── verificar_diagnostico.php     # Checks if diagnosis was completed
├── verificar_dni_paciente.php    # Validates patient ID existence
├── ipower_control.php            # EPDU control over HTTP
├── gpio_control.py               # GPIO control on Raspberry Pi
├── activar_gpio_*.bat            # Pin activation scripts
├── apagar_gpio_21.bat            # Shutdown script
├── led_blanco.bat / led_rojo.bat # LED control
└── centro_salud.sql              # Database schema
```

## Local setup

**Requirements:** PHP 8+, MySQL/MariaDB, XAMPP, Python 3 on Raspberry Pi, Plink (SSH client for Windows)

1. Import `centro_salud.sql` in phpMyAdmin
2. Copy `conexion.php.example` as `conexion.php` and fill in credentials
3. Set the Raspberry Pi IP address in the `.bat` files and in `ipower_control.php`
4. On the Raspberry Pi: copy `gpio_control.py` and make sure Python 3 and RPi.GPIO are installed
5. Open `http://localhost/cabina-medica/login_medico.html`

> **Note:** The system was developed and tested on a local network. The video call uses a fixed Whereby room; for real use, dynamic rooms per session would need to be generated.

## Known technical debt

- Doctor authentication does not consistently use `password_verify` in the original version (some test records have plain-text passwords)
- EPDU credentials are hardcoded; in production they would go in environment variables
- The project grew iteratively during the school year: three video call platforms (Jitsi, Daily.co) were evaluated before settling on Whereby

## What was learned building it

This project was developed learning on the go under school time constraints. It required solving in real time: PHP↔Python integration over SSH, physical hardware control from a web interface, state synchronization between two separate devices, and practical evaluation of three video call platforms until finding the one that worked within the environment's constraints.

## Technical challenges and crisis management

Development took place under highly volatile requirements and structural team changes, demanding immediate technical response and adaptability:

- **Taking on critical roles:** Due to team member reassignments, I took full responsibility for areas initially outside my scope, including MySQL database normalization, Raspberry Pi 3 OS setup and GPIO hardware logic programming.
- **Technology pivoting and adaptability:** The system went through multiple complete refactors due to constantly changing requirements. This included the successive evaluation and integration of three video call platforms (Jitsi, Daily.co and finally Whereby) and a complete UI redesign to operate exclusively via mouse, removing keyboard dependency due to physical booth constraints.
- **Critical infrastructure control:** I implemented control logic for the ePDU IP Power via HTTP protocols, enabling sequential power management of devices (such as timed activation of a water pump for patient hydration).
- **Heterogeneous system integration:** I achieved smooth communication between a Windows server (XAMPP) and the Raspberry Pi (Linux) by automating SSH tunnels with Plink and batch scripts (.bat), ensuring actuators responded to doctor commands in real time.
- **Technical leadership:** Facing a knowledge gap within the group, I acted as the technical bridge, training other team members on the system flow for the final presentation and ensuring the MVP was functional for delivery.

## Author

**Bringas Franco Sebastián**  
IT Technician – E.E.T.P. N°478  
B.Sc. in Artificial Intelligence Engineering – FICH-UNL  
[francosbringas@gmail.com](mailto:francosbringas@gmail.com)
