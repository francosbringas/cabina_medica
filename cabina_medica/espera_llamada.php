<?php
require 'conexion.php';
session_start();
if (!isset($_SESSION['dni_paciente'])) {
    die("Acceso no autorizado.");
}
$dni_paciente = intval($_SESSION['dni_paciente']);
// Crear o actualizar el registro de estado_llamada al cargar la página
$sql = "REPLACE INTO estado_llamada (id, estado, dni_paciente) VALUES (1, 1, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $dni_paciente);
$stmt->execute();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Pantalla de Espera</title>
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      width: 100%;
      overflow: hidden;
      background: linear-gradient(100deg, #001F3F, #0074D9);
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: white;
      user-select: none;
    }
    .loader { display: flex; gap: 15px; }
    .dot {
      width: 25px;
      height: 25px;
      background-color: #2ECC40;
      border-radius: 100%;
      animation: bounce 1.5s infinite ease-in-out;
    }
    .dot:nth-child(1) { animation-delay: 0s; }
    .dot:nth-child(2) { animation-delay: 0.2s; }
    .dot:nth-child(3) { animation-delay: 0.4s; }
    @keyframes bounce {
      0%, 80%, 100% { transform: scale(0); opacity: 0.3; }
      40% { transform: scale(1); opacity: 1; }
    }
    .message {
      position: absolute;
      top: 30%;
      width: 100%;
      text-align: center;
      font-size: 2.5rem;
      letter-spacing: 0.1em;
      text-shadow: 0 0 8px rgba(0,0,0,0.7);
    }
    #btn-videollamada {
      display: none;
      margin-top: 40px;
      padding: 16px 40px;
      font-size: 1.3em;
      background: #2ECC40;
      color: white;
      border: none;
      border-radius: 10px;
      cursor: pointer;
    }
    #btn-videollamada:hover {
      background: #28b232;
    }
  </style>
</head>
<body>
  <div class="message" id="statusMessage">
    Se notificó al médico para iniciar la llamada. Por favor, espere a que atienda...
  </div>
  <div class="loader" aria-label="Cargando animación">
    <div class= "dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
  </div>
  <button id="btn-videollamada">Entrar a la videollamada</button>

  <script>
    let videollamadaWindow = null;
    let llamadaAbierta = false;
    const dniPaciente = <?php echo json_encode($dni_paciente); ?>;
    let urlVideollamada = "";
    let nombrePaciente = "Paciente";

    async function obtenerNombrePaciente() {
      try {
        const resp = await fetch(`get_paciente.php?dni=${encodeURIComponent(dniPaciente)}`);
        const data = await resp.json();
        if (data.success) {
          return `${data.nombre} ${data.apellido}`;
        }
      } catch (e) {}
      return "Paciente";
    }

    async function checkCallStatus() {
      try {
        const res = await fetch('estado_llamada.php', { cache: "no-store" });
        if (!res.ok) throw new Error('Error en la respuesta del servidor');
        const data = await res.json();
        console.log('Estado de llamada (paciente):', data);

        // Habilita el botón cuando el médico acepta
        if (data.estado === 2 && data.dni_paciente == dniPaciente && !llamadaAbierta) {
          llamadaAbierta = true;
          nombrePaciente = await obtenerNombrePaciente();
          urlVideollamada = `https://whereby.com/llamada-medica?embed&userName=${encodeURIComponent(nombrePaciente)}`;
          document.getElementById('statusMessage').textContent =
            'El médico ha aceptado. Presione el botón para entrar a la videollamada.';
          document.getElementById('btn-videollamada').style.display = 'inline-block';
        }
        // Si la llamada se termina y el botón está activo o la ventana abierta
        else if (data.estado === 0 && (llamadaAbierta || document.getElementById('btn-videollamada').style.display === 'inline-block')) {
          document.getElementById('statusMessage').textContent =
            'La videollamada ha finalizado. Será redirigido al inicio.';
          if (videollamadaWindow && !videollamadaWindow.closed) {
            videollamadaWindow.close();
          }
          setTimeout(() => {
            window.location.href = 'login_paciente.html';
          }, 3000);
          llamadaAbierta = false;
          document.getElementById('btn-videollamada').style.display = 'none';
        }
        // Si la llamada es rechazada antes de abrir la ventana
        else if (data.estado === 0 && !llamadaAbierta) {
          document.getElementById('statusMessage').textContent =
            'No hay médicos disponibles o la llamada fue rechazada. Redirigiendo...';
          setTimeout(() => {
            window.location.href = 'login_paciente.html';
          }, 3000);
        }
      } catch (err) {
        console.error('Error al consultar estado de llamada:', err);
        document.getElementById('statusMessage').textContent = 'Error de conexión. Reintentando...';
      }
    }

    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('btn-videollamada').onclick = function() {
        if (urlVideollamada) {
          videollamadaWindow = window.open(urlVideollamada, '_blank');
          document.getElementById('statusMessage').textContent =
            'La videollamada está activa. Esta ventana se cerrará cuando el médico finalice la llamada.';
          this.style.display = 'none';
        }
      };
    });

    setInterval(checkCallStatus, 2000);
    checkCallStatus();
  </script>
</body>
</html>