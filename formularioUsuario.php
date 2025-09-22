<?php
include "php/baseDeDatos.php";

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

/**
 * 
 * @param mixed $numero Define la longitud del código a verificar.
 * @return string Devuelve el código para verificar.
 */
function generarCodigoVerificacion($numero)
{
    //Creación de valor aleatorio de 5 carácteres.
    $caracteresMayusculas = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZ';
    $caracteresMinusculas = 'abcdefghijklmnñopqrstuvwxyz';
    $caracteresNumericos = '0123456789';
    $caracteresEspeciales = '@#!$%&/()=?*_:';

    $aleatorio = "";

    for ($i = 0; $i < $numero; $i++) {
        $numeroAleatorio = random_int(4, 4);
        switch ($numeroAleatorio) {
            case 1:
                $aleatorio = $aleatorio . substr($caracteresMayusculas, random_int(0, strlen($caracteresMayusculas) - 1), 1);
                break;
            case 2:
                $aleatorio = $aleatorio . substr($caracteresMinusculas, random_int(0, strlen($caracteresMinusculas) - 1), 1);
                break;
            case 3:
                $aleatorio = $aleatorio . substr($caracteresNumericos, random_int(0, strlen($caracteresNumericos) - 1), 1);
                break;
            case 4:
                $aleatorio = $aleatorio . substr($caracteresEspeciales, random_int(0, strlen($caracteresEspeciales) - 1), 1);
                break;

            default:
                $aleatorio = "NO FUNCIONA";
                break;
        }
    }
    return $aleatorio;
}

$fechaActual = new DateTime();
$fechaYHoraActual = $fechaActual->format('Y-m-d H:i:s');

// Clonar el objeto para no modificar $fechaActual
$fechaValidez = (clone $fechaActual)->add(new DateInterval('PT15M'))->format('Y-m-d H:i:s');
//Existen 3 opciones en este gestor de operaciones
if (isset($_POST["Login"])) {
    $sqlSelect = "SELECT DISTINCT usuarios.id,usuarios.password FROM usuarios WHERE email = ?";

    // Utilizamos prepareStatement.
    $stmt = $conn->prepare($sqlSelect);



    echo $_POST["email"] . "<br>";

    $stmt->bind_param(
        "s",
        $_POST["email"]
    );

    $stmt->execute();

    $resultado = $stmt->get_result();
    $nFilas = $resultado->num_rows;
    $fila = $resultado->fetch_assoc();
    echo $fila["password"];
    echo "Filas " . $nFilas;

    if ($nFilas == 1) { //Si tiene 1 fila, significa que el email se encuentra en la base de datos.
        echo "<br>Email encontrado<br>";
        if (password_verify($_POST["password"], $fila["password"])) { //La contraseña es correcta
            //Verificar si el usuario tiene permitido el acceso. (Se ha verificado).
            if ($fila["idEstado"] == 1) { //No está verificado

                $_SESSION["id"] = $fila["id"];
                //header("Location: confirm-register.php");

            } else {
                $_SESSION["idUsuario"] = $fila["id"];
                $_SESSION["id"] = $fila["id"];

                header("Location: indice.php");
                //echo "La contraseña es correcta . ".$fila["id"];;

            }
        } else { //La contraseña no es correcta
            header("Location: login.php?error=La contraseña introducida no es correcta.");
        }
    } else { //El email introducido no existe
        //header("Location: login.php?error=El email introducido no existe ".$_POST["email"]);

    }


    $stmt->close();
} else
    if (isset($_POST["Register"])) {



    try {

        //Bloque de SQL (1). Insercción de usuarios (1a Fase).
        //-----------
        $sqlInsercionUsuarios = "INSERT INTO usuarios (
        email,
        password,
        nombre,
        apellidos) VALUES (?, ?, ?, ?)";

        // Utilizamos prepareStatement.
        $stmt = $conn->prepare($sqlInsercionUsuarios);

        //echo $sql;
        //echo "<br>";
        //print_r($_POST);


        //Bindeo de las cadenas
        $stmt->bind_param(
            "ssss",

            $_POST['email'],
            password_hash($_POST['password'], PASSWORD_BCRYPT),
            $_POST['nombre'],
            $_POST['apellidos']
        );
        //$stmt->close();

        //echo "<br>";
        $stmt->execute();

        $id = $stmt->insert_id;


        $stmt->close();
        
        $_SESSION["id"] = $id;
        echo "El id obtenido es " . $_SESSION["id"] . "<br>";

        /*echo $sqlSelect."<br>";
        echo $_POST['email']."<br>";
        echo password_hash($_POST['password'], PASSWORD_BCRYPT)."<br>";
        echo $_POST['nombre']."<br>";
        echo $_POST['apellidos']."<br>";*/
        $stmt->close();



        if (!$stmt->execute()) {
            die("Error al ejecutar la consulta: " . $stmt->error); // Mensaje de error al ejecutar
        }
        $stmt->close();
        //------------------

        //header("Location: confirm-register.php");
    } catch (Exception $e) {
        echo $e;
    }
}
