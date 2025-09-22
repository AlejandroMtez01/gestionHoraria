<?php 
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
function obtenerResultadoConsulta()
{
    require '././php/baseDeDatos.php';
    $query = "SELECT * FROM tipoObjetivo";

    $resultado = $conn->query($query);
    return $resultado;
}
function obtenerTipoObjetivosUsuarios($id,$idUsuario){
        require '././php/baseDeDatos.php';
    $query = "SELECT * FROM tipoObjetivo WHERE id=$id AND idUsuario=$idUsuario";

    $resultado = $conn->query($query);
    return $resultado;
}
function obtenerTipoObjetivosPorUsuarios($conn){
    $query = "SELECT * FROM tipoObjetivosUsuarios WHERE idUsuario=".$_SESSION["id"];

    $resultado = $conn->query($query);
    return $resultado;
}

?>