<?php
include "../php/baseDeDatos.php";
include "../php/Funciones.php";
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_POST["crear"])) {
    //Especificamos de que tipo de alerta se trata.
    try {
        $conn->begin_transaction();


        $query = "INSERT INTO tipoObjetivosUsuarios (descripcion,observaciones, idUsuario, fechaInicio, fechaFinal) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "sssss",
            $_POST["nombre"],
            $_POST["descripcion"],
            $_SESSION["idUsuario"],
            $_POST["fInicio"],
            $_POST["fFinal"]
        );

        $stmt->execute();
        $id = $stmt->insert_id;


        $conn->commit();
    } catch (Exception $e) {
        echo "Error al insertar el registro: " . $e->getMessage() . "<br> Consulta: " . $query;
        $conn->rollback();

        exit();
    }



    header("Location: /GestionHoraria/indice.php?exito=Alerta creada correctamente.");
} else if (isset($_POST["editar"])) {
    try {


        $conn->begin_transaction();

        //En primer lugar se realizan las modificaciones en la tabla alertas
        $query = "UPDATE tipoObjetivosUsuarios SET descripcion=?, observaciones=?, fechaInicio=?, fechaFinal=? WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "ssssi",
            $_POST["nombre"],
            $_POST["descripcion"],
            $_POST["fInicio"],
            $_POST["fFinal"],
            $_POST["id"] //Valor oculto del formulario
        );
        $stmt->execute();

        $conn->commit();



    header("Location: /GestionHoraria/indice.php?exito=Alerta creada correctamente.");
    } catch (Exception $e) {
        echo "Error al insertar el registro: " . $e->getMessage() . "<br> Consulta: " . $query;
        $conn->rollback();

        exit();
    }
} else if (isset($_POST["cancelar"])) {
    header("Location: ../alertas.php?exito=Alerta cancelada correctamente.");
} else {
    echo "La acción contemplada no es correcta.";
}

////
