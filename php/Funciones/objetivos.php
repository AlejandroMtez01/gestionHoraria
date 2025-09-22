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

function obtenerMesDescripcionSegunParametro($numero_mes) {
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
function obtenerMesDescripcion() {
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
    
    return $meses[date('n')] ?? 'Mes inválido';
}
function diasMes()
{

    $dias_mes = cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y'));
    //echo "Días en el mes: $dias_mes\n\n";
    // Recorrer todos los días

    for ($dia = 1; $dia <= $dias_mes; $dia++) {
        echo "<div class='dia'><span>$dia</span></div>";
    }
}
// function mesConFechas($conn, $idTipoObjetivo)
// {
//     // Fecha de inicio del mes (primer día)
//     $fecha_inicio = date('Y-m-01');

//     // Fecha de fin del mes (último día)
//     $fecha_fin = date('Y-m-t');
//     $consulta = "SELECT * FROM objetivosUsuarios WHERE idUsuario=" . $_SESSION["idUsuario"] . " and fechaInicio>='$fecha_inicio' and fechaFinal<='$fecha_fin'";
//     //echo $consulta;


//     //Obtener el mes actual
//     $mes = date('n'); //Mes Actual
//     $anio = date('Y'); //Año Actual

//     //Días del mes
//     $dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
//     //echo "Días en el mes: $dias_mes\n\n";
//     // Recorrer todos los días

//     for ($dia = 1; $dia <= $dias_mes; $dia++) {

//         $resultado = $conn->query($consulta);
//         $contieneObjetivo = false;
//         while ($fila = $resultado->fetch_assoc()) {
//             //Si en uno de los registros cumple la condición
//             //echo $fila["fechaInicio"] . "<br>";
//             //echo $fila["fechaFinal"] . "<br>";

//             $fechaInicio = new DateTime($fila["fechaInicio"]);
//             $fechaFinal = new DateTime($fila["fechaFinal"]);
//             $fechaBucle  = (new DateTime())->setDate(date('Y'), $mes, $dia);


//             if ($fechaBucle >= $fechaInicio && $fechaBucle <= $fechaFinal && $idTipoObjetivo == $fila["idTipoObjetivo"]) {
//                 $contieneObjetivo = true;
//                 $id = $fila["id"];
//             }
//         }
//         if ($contieneObjetivo) {
//         
?>
<!-- //             <a class="calendarioItem especial" href="Formularios/formularioObjetivos.php?<?php echo "id=" . $id; ?>">X</a> -->

<?php
//         } else {
//         
?>
<!-- //             <div class="calendarioItem"></div> -->

<?php
//         }


//         
?>
<?php
//     }
// }
function mesConFechas($conn, $idTipoObjetivo)
{
    // Fecha de inicio del mes (primer día)
    $fecha_inicio = date('Y-m-01');

    // Fecha de fin del mes (último día)
    $fecha_fin = date('Y-m-t');

    // Obtener el ID del usuario de la sesión
    $idUsuario = $_SESSION["idUsuario"];

    // Consulta para obtener todos los objetivos del usuario en el mes actual
    $consulta = "SELECT * FROM objetivosUsuarios 
                WHERE idUsuario = $idUsuario 
                AND fechaInicio >= '$fecha_inicio' 
                AND fechaFinal <= '$fecha_fin'
                AND idTipoObjetivo = $idTipoObjetivo";

    // Ejecutar la consulta UNA SOLA VEZ
    $resultado = $conn->query($consulta);

    // Crear un array para marcar los días que tienen objetivos
    $diasConObjetivo = array();
    $objetivosPorDia = array();

    // Procesar los resultados
    while ($fila = $resultado->fetch_assoc()) {
        $fechaInicio = new DateTime($fila["fechaInicio"]);
        $fechaFinal = new DateTime($fila["fechaFinal"]);
        $idObjetivo = $fila["id"];

        // Marcar todos los días entre fechaInicio y fechaFinal
        $intervalo = DateInterval::createFromDateString('1 day');
        $periodo = new DatePeriod($fechaInicio, $intervalo, $fechaFinal->modify('+1 day'));

        foreach ($periodo as $fecha) {
            $dia = (int)$fecha->format('d');
            $diasConObjetivo[$dia] = true;
            $objetivosPorDia[$dia] = $idObjetivo;
        }
    }

    // Obtener información del mes actual
    $mes = date('n');
    $anio = date('Y');
    $dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);

    // Recorrer todos los días del mes
    for ($dia = 1; $dia <= $dias_mes; $dia++) {
        if (isset($diasConObjetivo[$dia])) {
            $id = $objetivosPorDia[$dia];
?>
            <a class="calendarioItem especial" href="Formularios/formularioObjetivos.php?id=<?php echo $id; ?>"></a>
        <?php
        } else {
        ?>
            <div class="calendarioItem"></div>
<?php
        }
    }
}

?>