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


        $query = "INSERT INTO objetivosUsuarios (idTipoObjetivo,descripcion, observaciones, fechaInicio, fechaFinal, idUsuario) VALUES (?,?,?,?,?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "ssssss",
            $_POST["tipoObjetivo"],
            $_POST["descripcion"],
            $_POST["observaciones"],
            $_POST["fInicio"],
            $_POST["fFinal"],
            $_SESSION["idUsuario"]
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
        $query = "UPDATE objetivosUsuarios SET descripcion=?, observaciones=?, fechaInicio=?, fechaFinal=?, idTipoObjetivo=? WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "ssssss",
            $_POST["descripcion"],
            $_POST["observaciones"],
            $_POST["fInicio"],
            $_POST["fFinal"],
            $_POST["tipoObjetivo"],
            $_POST["id"] //Valor oculto del formulario
        );
        $stmt->execute();

        $conn->commit();



        header("Location: /GestionHoraria/Formularios/formularioObjetivos.php?id=".$_POST["id"]);
    } catch (Exception $e) {
        echo "Error al insertar el registro: " . $e->getMessage() . "<br> Consulta: " . $query;
        $conn->rollback();

        exit();
    }
} else if (isset($_POST["editar1"])) {
    try {


        $conn->begin_transaction();

        //En primer lugar se realizan las modificaciones en la tabla alertas
        $query = "UPDATE objetivosUsuarios SET descripcion=?, observaciones=?, fechaInicio=?, fechaFinal=?, idTipoObjetivo=? WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "ssssss",
            $_POST["descripcion"],
            $_POST["observaciones"],
            $_POST["fInicio"],
            $_POST["fFinal"],
            $_POST["tipoObjetivo"],
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
}
 else if (isset($_POST["cancelar"])) {
        header("Location: /GestionHoraria/indice.php?exito=Alerta creada correctamente.");
} else if (isset($_POST["eliminar"])) {
    $conn->begin_transaction();

    //En primer lugar se realizan las modificaciones en la tabla alertas
    $query = "DELETE FROM objetivosUsuarios  WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "s",
        $_POST["id"] //Valor oculto del formulario
    );
    $stmt->execute();

    $conn->commit();
    header("Location: /GestionHoraria/indice.php");
} else {
    echo "La acción contemplada no es correcta.";
}

////
