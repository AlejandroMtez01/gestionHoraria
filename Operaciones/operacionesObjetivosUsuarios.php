<?php
include "../php/baseDeDatos.php";
include "../php/Funciones.php";
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}


//Función para comprobar si el rango ya ha sido elegido


function comprobarExisteRangoFecha($conn, $fechaInicio, $fechaFinal, $idUsuario, $idTipoObjetivo = null, $excluirId = null)
{
    if ($excluirId == null) {

        $query = "SELECT id FROM objetivosUsuarios 
                  WHERE idUsuario = ? 
                  AND idTipoObjetivo = ?
                  AND fechaInicio <= ? 
                  AND fechaFinal >= ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiss", $idUsuario, $idTipoObjetivo, $fechaFinal, $fechaInicio);
    } else {
        $query = "SELECT id FROM objetivosUsuarios 
                  WHERE idUsuario = ? 
                  AND idTipoObjetivo = ?
                  AND fechaInicio <= ? 
                  AND fechaFinal >= ?
                  AND id <> ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iissi", $idUsuario, $idTipoObjetivo, $fechaFinal, $fechaInicio, $excluirId);
    }

    $stmt->execute();
    $result = $stmt->get_result();


    return $result->num_rows > 0;
}
////


if (isset($_POST["crear"])) {
    //Especificamos de que tipo de alerta se trata.
    try {
        //-- Comprueba si pasan las validaciones
        if (comprobarExisteRangoFecha($conn, $_POST["fInicio"], $_POST["fFinal"], $_SESSION["idUsuario"], $_POST["tipoObjetivo"]) == true) { //Si no cumple la VALIDACIÓN.
            header(
                "Location:  /GestionHoraria/Formularios/formularioObjetivos.php?"
                    . "&error=<b>ERROR!</b> La fecha que intentas utilizar ya es utilizada completa o parcialmente para algun plazo del objetivo seleccionado."
                    . "&tipoObjetivo=" . $_POST["tipoObjetivo"]
                    . "&descripcion=" . $_POST["descripcion"]
                    . "&observaciones=" . $_POST["observaciones"]
                    . "&fInicio=" . $_POST["fInicio"]
                    . "&fFinal=" . $_POST["fFinal"]
            );
        } else {
            //--
            echo "Entro aquí";

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
            echo $id;


            $conn->commit();
            header("Location:  /GestionHoraria/Formularios/formularioObjetivos.php?id=" . $id);
        }
    } catch (Exception $e) {
        echo "Error al insertar el registro: " . $e->getMessage() . "<br> Consulta: " . $query;
        $conn->rollback();

        exit();
    }
} else if (isset($_POST["editar"])) {
    try {

        if (comprobarExisteRangoFecha($conn, $_POST["fInicio"], $_POST["fFinal"], $_SESSION["idUsuario"], $_POST["tipoObjetivo"], $_POST["id"]) == true) { //Si no cumple la VALIDACIÓN.
            header(
                "Location:  /GestionHoraria/Formularios/formularioObjetivos.php?"
                    . "&error=<b>ERROR!</b> La fecha que intentas utilizar ya es utilizada completa o parcialmente para algun plazo del objetivo seleccionado."
                    . "&id=" . $_POST["id"]
            );
        } else {
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



            header("Location: /GestionHoraria/Formularios/formularioObjetivos.php?id=" . $_POST["id"]);
        }
    } catch (Exception $e) {
        echo "Error al insertar el registro: " . $e->getMessage() . "<br> Consulta: " . $query;
        $conn->rollback();

        exit();
    }
} else if (isset($_POST["editar1"])) {
    try {

        if (comprobarExisteRangoFecha($conn, $_POST["fInicio"], $_POST["fFinal"], $_SESSION["idUsuario"], $_POST["tipoObjetivo"], $_POST["id"]) == true) { //Si no cumple la VALIDACIÓN.
            header(
                "Location:  /GestionHoraria/Formularios/formularioObjetivos.php?"
                    . "&error=<b>ERROR!</b> La fecha que intentas utilizar ya es utilizada completa o parcialmente para algun plazo del objetivo seleccionado."
                    . "&id=" . $_POST["id"]
            );
        } else {
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
        }
    } catch (Exception $e) {
        echo "Error al insertar el registro: " . $e->getMessage() . "<br> Consulta: " . $query;
        $conn->rollback();

        exit();
    }
} else if (isset($_POST["cancelar"])) {
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
