<?php

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
function obtenerMesActual()
{
    //Obtener el mes actual
    $mes = date('n'); //Mes Actual
    $anio = date('Y'); //Año Actual

    //Días del mes
    $dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
    //echo "Días en el mes: $dias_mes\n\n";
    // Recorrer todos los días
    for ($dia = 1; $dia <= $dias_mes; $dia++) {
?>
        <div class="calendarioItem"></div>
    <?php
    }
}

function obtenerMesDescripcionSegunParametro($numero_mes)
{
    $meses = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre'
    ];

    return $meses[$numero_mes] ?? 'Mes inválido';
}
function obtenerMesDescripcion($m = null)
{
    $meses = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre'
    ];

    if ($m == null) {
        return $meses[date('n')] ?? 'Mes inválido';
    } else {
        return $meses[$m] ?? 'Mes inválido';
    }
}
function obtenerYear($y = null)
{

    if ($y == null) {
        return date('Y');
    } else {
        return $y;
    }
}
function diasSemana($mes = null, $year = null)
{
    if ($mes == null) {
        $mes = date('n');
    }
    if ($year == null) {
        $year = date('Y');
    }
    $dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $year);
    $inicialesDiasSem = [
        1 => 'L',
        2 => 'M',
        3 => 'X',
        4 => 'J',
        5 => 'V',
        6 => 'S',
        7 => 'D',
    ];


    for ($dia = 1; $dia <= $dias_mes; $dia++) {

        //Detecta si se trata del día de hoy
        if ($dia == date("d") && $mes == date("m")) {
            $diaHoy = "diaHoy";
        } else {
            $diaHoy = "";
        }

        $fechaBucle = new DateTime($year . "-" . $mes . "-" . $dia);
        $diaSem = $fechaBucle->format('N');
        if ($diaSem > 5) {
            echo "<div class='diaSem festivo $diaHoy'><span>" . $inicialesDiasSem[$diaSem] . "</span></div>";
        } else {
            echo "<div class='diaSem $diaHoy'><span>" . $inicialesDiasSem[$diaSem] . "</span></div>";
        }
    }
}
function diasMes($mes = null, $year = null)
{

    if ($mes == null) {
        $mes = date('n');
    }
    if ($year == null) {
        $year = date('Y');
    }
    $dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $year);
    //echo "Días en el mes: $dias_mes\n\n";
    // Recorrer todos los días

    for ($dia = 1; $dia <= $dias_mes; $dia++) {
        //Detecta si se trata del día de hoy
        if ($dia == date("d") && $mes == date("m")) {
            $diaHoy = "diaHoy";
        } else {
            $diaHoy = "";
        }
        echo "<div class='dia $diaHoy'><span>$dia</span></div>";
    }
}

function dailyMes($conn, $idTipoObjetivo, $mes = null, $year = null)
{
    if ($mes == null) {
        $mes = date('n');
    }
    if ($year == null) {
        $year = date('Y');
    }
    // Fecha de inicio del mes (primer día)
    $fecha_inicio = date("$year-$mes-01");

    // Fecha de fin del mes (último día)
    $fecha_fin = date("Y-m-t", strtotime("$year-$mes-01"));



    // Obtener el ID del usuario de la sesión
    $idUsuario = $_SESSION["idUsuario"];

    // Consulta para obtener todos los objetivos del usuario en el mes actual
    $consulta = "SELECT * FROM diarioObjetivos 
                WHERE idUsuario = $idUsuario
                AND idTipoObjetivo = $idTipoObjetivo
                AND fechaInicio <= '$fecha_fin' 
                AND fechaFinal >= '$fecha_inicio'";



    // Ejecutar la consulta UNA SOLA VEZ
    $resultado = $conn->query($consulta);

    // Crear un array para marcar los días que tienen objetivos
    $diasConObjetivo = array();
    $objetivosPorDia = array();



    while ($fila = $resultado->fetch_assoc()) {
        $fechaInicio = new DateTime($fila["fechaInicio"]);
        $fechaFinal = new DateTime($fila["fechaFinal"]);
        $idObjetivo = $fila["id"];

        // Determinar qué parte del objetivo cae dentro del mes actual
        $inicioMes = new DateTime($fecha_inicio);
        $finMes = new DateTime($fecha_fin);

        // El rango a mostrar es la intersección entre el objetivo y el mes
        $inicioMostrar = ($fechaInicio > $inicioMes) ? $fechaInicio : $inicioMes;
        $finMostrar = ($fechaFinal < $finMes) ? $fechaFinal : $finMes;

        // Marcar todos los días del rango que cae dentro del mes
        $intervalo = DateInterval::createFromDateString('1 day');
        $periodo = new DatePeriod($inicioMostrar, $intervalo, $finMostrar->modify('+1 day'));

        foreach ($periodo as $fecha) {
            $dia = (int)$fecha->format('d');
            $diasConObjetivo[$dia] = true;
            $objetivosPorDia[$dia] = $idObjetivo;
        }
    }

    // Obtener información del mes actual

    $dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $year);

    // Recorrer todos los días del mes
    for ($dia = 1; $dia <= $dias_mes; $dia++) {


        //Detecta si se trata del día de hoy
        if ($dia == date("d") && $mes == date("m")) {
            $diaHoy = "diaHoy";
        } else {
            $diaHoy = "";
        }
    ?>
        <div class="calendarioItem <?php echo $diaHoy; ?>">
            <?php if (isset($diasConObjetivo[$dia])) { //Si cumpla la condición se muestra el a
                $id = $objetivosPorDia[$dia]; ?>
                <a class="diario" href="Formularios/formularioDiarioObjetivos.php?id=<?php echo $id; ?>"></a>
            <?php } ?>
        </div>
    <?php }
}
function plazosMes($conn, $idTipoObjetivo, $mes = null, $year = null)
{
    if ($mes == null) {
        $mes = date('n');
    }
    if ($year == null) {
        $year = date('Y');
    }
    // Fecha de inicio del mes (primer día)
    $fecha_inicio = date("$year-$mes-01");

    // Fecha de fin del mes (último día)
    $fecha_fin = date("Y-m-t", strtotime("$year-$mes-01"));



    // Obtener el ID del usuario de la sesión
    $idUsuario = $_SESSION["idUsuario"];

    // Consulta para obtener todos los objetivos del usuario en el mes actual
    $consulta = "SELECT * FROM plazosObjetivos 
                WHERE idUsuario = $idUsuario
                AND idTipoObjetivo = $idTipoObjetivo
                AND fechaInicio <= '$fecha_fin' 
                AND fechaFinal >= '$fecha_inicio'";



    // Ejecutar la consulta UNA SOLA VEZ
    $resultado = $conn->query($consulta);

    // Crear un array para marcar los días que tienen objetivos
    $diasConObjetivo = array();
    $objetivosPorDia = array();



    while ($fila = $resultado->fetch_assoc()) {
        $fechaInicio = new DateTime($fila["fechaInicio"]);
        $fechaFinal = new DateTime($fila["fechaFinal"]);
        $idObjetivo = $fila["id"];

        // Determinar qué parte del objetivo cae dentro del mes actual
        $inicioMes = new DateTime($fecha_inicio);
        $finMes = new DateTime($fecha_fin);

        // El rango a mostrar es la intersección entre el objetivo y el mes
        $inicioMostrar = ($fechaInicio > $inicioMes) ? $fechaInicio : $inicioMes;
        $finMostrar = ($fechaFinal < $finMes) ? $fechaFinal : $finMes;

        // Marcar todos los días del rango que cae dentro del mes
        $intervalo = DateInterval::createFromDateString('1 day');
        $periodo = new DatePeriod($inicioMostrar, $intervalo, $finMostrar->modify('+1 day'));

        foreach ($periodo as $fecha) {
            $dia = (int)$fecha->format('d');
            $diasConObjetivo[$dia] = true;
            $objetivosPorDia[$dia] = $idObjetivo;
        }
    }

    // Obtener información del mes actual

    $dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $year);

    // Recorrer todos los días del mes
    for ($dia = 1; $dia <= $dias_mes; $dia++) {


        //Detecta si se trata del día de hoy
        if ($dia == date("d") && $mes == date("m")) {
            $diaHoy = "diaHoy";
        } else {
            $diaHoy = "";
        }
    ?>
        <div class="calendarioItem <?php echo $diaHoy; ?>">
            <?php if (isset($diasConObjetivo[$dia])) { //Si cumpla la condición se muestra el a
                $id = $objetivosPorDia[$dia]; ?>
                <a class="plazo" href="Formularios/formularioPlazosObjetivos.php?id=<?php echo $id; ?>"></a>
            <?php } ?>
        </div>
    <?php }
}

function plazosMes2($conn, $idTipoObjetivo, $mes = null, $year = null)
{
    if ($mes == null) {
        $mes = date('n');
    }
    if ($year == null) {
        $year = date('Y');
    }
    // Fecha de inicio del mes (primer día)
    $fecha_inicio = date("$year-$mes-01");

    // Fecha de fin del mes (último día)
    $fecha_fin = date("Y-m-t", strtotime("$year-$mes-01"));

    // Obtener el ID del usuario de la sesión
    $idUsuario = $_SESSION["idUsuario"];

    // Consulta para obtener todos los objetivos del usuario en el mes actual
    $consulta = "SELECT * FROM plazosObjetivos 
                WHERE idUsuario = $idUsuario
                AND idTipoObjetivo = $idTipoObjetivo
                AND fechaInicio <= '$fecha_fin' 
                AND fechaFinal >= '$fecha_inicio'";

    // Ejecutar la consulta UNA SOLA VEZ
    $resultado = $conn->query($consulta);

    // Crear un array para almacenar los objetivos por día
    $objetivosPorDia = array();

    while ($fila = $resultado->fetch_assoc()) {
        $fechaInicio = new DateTime($fila["fechaInicio"]);
        $fechaFinal = new DateTime($fila["fechaFinal"]);
        $idObjetivo = $fila["id"];
        $nombreObjetivo = $fila["nombre"]; // Asumiendo que hay un campo nombre

        // Determinar qué parte del objetivo cae dentro del mes actual
        $inicioMes = new DateTime($fecha_inicio);
        $finMes = new DateTime($fecha_fin);

        // El rango a mostrar es la intersección entre el objetivo y el mes
        $inicioMostrar = ($fechaInicio > $inicioMes) ? $fechaInicio : $inicioMes;
        $finMostrar = ($fechaFinal < $finMes) ? $fechaFinal : $finMes;

        // Marcar todos los días del rango que cae dentro del mes
        $intervalo = DateInterval::createFromDateString('1 day');
        $periodo = new DatePeriod($inicioMostrar, $intervalo, $finMostrar->modify('+1 day'));

        foreach ($periodo as $fecha) {
            $dia = (int)$fecha->format('d');

            // Inicializar el array para este día si no existe
            if (!isset($objetivosPorDia[$dia])) {
                $objetivosPorDia[$dia] = array();
            }

            // Agregar el objetivo al día correspondiente
            $objetivosPorDia[$dia][] = array(
                'id' => $idObjetivo,
                'nombre' => $nombreObjetivo
            );
        }
    }

    // Obtener información del mes actual
    $dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $year);

    // Recorrer todos los días del mes
    for ($dia = 1; $dia <= $dias_mes; $dia++) {
        //Detecta si se trata del día de hoy
        if ($dia == date("d") && $mes == date("m")) {
            $diaHoy = "diaHoy";
        } else {
            $diaHoy = "";
        }
    ?>
        <div class="calendarioItem2 <?php echo $diaHoy; ?>">
            <div class="plazos">
                <?php
                if (isset($objetivosPorDia[$dia])) {
                    $objetivosDelDia = $objetivosPorDia[$dia];
                    foreach ($objetivosDelDia as $clave => $valor) {
                        $id = $objetivosDelDia[$clave]['id'];
                ?>
                        <a class="plazo" href="Formularios/formularioPlazosObjetivos.php?id=<?php echo $id; ?>" title="<?php echo htmlspecialchars($objetivosDelDia[0]['nombre']); ?>"></a>

                    <?php }


                    ?>
                <?php } ?>
            </div>
        </div>

<?php
    }
}

?>