<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="css/login.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>

<body>
    <div class="pagina">
        <div class="subpagina">
            <div class="alertas">
                <?php if (isset($_GET["exito"])) { ?>
                    <div class="exito"><?php echo $_GET["exito"]; ?></div><?php
                } ?>

                <?php if (isset($_GET["error"])) { ?>
                    <div class="error"><?php echo "<span>Error! </span>" . $_GET["error"] . ""; ?></div><?php
                } ?>
            </div>
            <div class="seccion1">
                <div class="contenido">
                    <div>Comienza tu carrera en la docencia</div>
                    <h1>Regístrate</h1>
                    <form action="formularioUsuario.php" method="post">
                        <div class="input">
                            <input type="text" name="nombre" placeholder="Nombre">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <div class="input">
                            <input type="text" name="apellidos" placeholder="Apellidos">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <div class="input">
                            <input type="text" name="email" placeholder="E-mail">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <div class="input">
                            <input type="password" name="password" placeholder="Contaseña">
                            <i class="fa-regular fa-eye"></i>
                        </div>
                        <div class="input">
                            <input type="password" name="passwordRepetir" placeholder="Repetir Contaseña">
                            <i class="fa-regular fa-eye"></i>
                        </div>


                        <input type="submit" name="Register" value="Registro">
                    </form>

                    <div>¿Ya tienes cuenta? <a href="login.php">Logeate</a> </div>

                </div>
            </div>
            <!-- <div class="seccion2">
                <p>e</p>
            </div> -->

        </div>

</body>

</html>