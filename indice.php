<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link rel="stylesheet" href="/GestionHoraria/css/style.css">
    <link rel="stylesheet" href="/GestionHoraria/css/modal.css">

</head>

<?php
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($_SESSION["idUsuario"])) {
    header("Location: login.php");
}
$_SESSION["pagina"] = basename(__FILE__, '.php');


include 'php/Funciones/objetivos.php';
include 'php/DAO/UsuariosDAO.php';
include 'php/baseDeDatos.php';
include 'php/Utils/Consultas.php';
include 'php/Utils/UtilsFormularios.php';
$usuario = obtenerUsuario($conn);



?>

<body>
    <header>
        <div class="informacion">
            <span>Nombre: </span><span><?php echo $usuario["nombre"];
                                        ?></span>
        </div>
        <div class="informacion">
            <span>Apellidos: </span><span><?php echo $usuario["apellidos"];
                                            ?></span>
    </header>

    </div>
    <div class="panelPrincipal">
        <h3>RESUMEN PRINCIPAL</h3>
        <div class="estadisticas">
            <div class="estadistica">
                <span>Días Completados:</span>
                <span id="bbdd">20</span>
            </div>
            <div class="estadistica">
                <span>Temas Superados:</span>
                <span id="bbdd">7</span>
            </div>
            <button id="addTipoObjetivo">Añadir Objetivo</button>
            <button id="addObjetivo">Añadir Plazo</button>

        </div>
        <h3>RESUMEN MENSUAL</h3>
        <div class="objetivosMensuales">
            <div class="gridDual">
                <div class="itemTitulo">Objetivo</div>
                <div class="calendarioTitulo">Mes</div>
                <div>&nbsp;</div>
                <div class="diasMes">
                    <?php diasMes(); ?>
                </div>
                <?php
                //Obtenemos los items por sesión de usuario
                $resultadoItems = obtenerTipoObjetivosPorUsuarios($conn) ?>

                <?php
                while ($fila = $resultadoItems->fetch_assoc()) {
                ?>
                    <div class="item">
                        <a href="Formularios/formularioTipoObjetivos.php?id=<?php echo $fila["id"]; ?>"><?php echo $fila["descripcion"]; ?></a>
                        
                    </div>
                    <div class="calendario">
                        <?php mesConFechas($conn,$fila["id"]); ?>
                    </div>
                <?php
                }

                ?>



            </div>
        </div>
    </div>
</body>
<script>
    var botonTipoObjetivo = document.getElementById("addTipoObjetivo");

    botonTipoObjetivo.onclick = function(event) {
        window.open("Formularios/formularioTipoObjetivos.php");
    }

        var botonObjetivo = document.getElementById("addObjetivo");

    botonObjetivo.onclick = function(event) {
        window.open("Formularios/formularioObjetivos.php");
    }
</script>

</html>