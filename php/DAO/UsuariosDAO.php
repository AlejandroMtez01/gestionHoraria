<?php
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

function obtenerUsuario($conn)
{
    $consulta = "SELECT * FROM usuarios WHERE id=?";
    $stmt = $conn->prepare($consulta);
    $stmt->bind_param("i", $_SESSION["id"]);

    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();
    return $fila;
}
