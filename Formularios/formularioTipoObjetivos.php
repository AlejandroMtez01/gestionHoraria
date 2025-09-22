<?php

session_start();
//Variable de seesión utilizada para indicar el nombre de la página en la que se navega.
//include 'DAO/Alertas/Alertas.php';
include '../php/FuncionesFormulario.php';


if (!isset($_SESSION["idUsuario"])) {
    header("Location: login.php");
}

include "../" . $_SESSION["pagina"] . ".php";
$cambiarPagina = false;

include "/GestionHoraria/Utils/Consultas";
//Variables importantes que serán utilizadas varias veces en el documetno



$edicion = isset($_GET["id"]);

if ($edicion) {
     $consulta = "SELECT * FROM tipoObjetivosUsuarios WHERE id=" . $_GET["id"];
    $resultado = $conn->query($consulta);
     $filaGeneral = $resultado->fetch_assoc();
}



?>

<!-- The Modal -->
<div id="modal" class="modal">

    <!-- Modal content -->
    <div class="contenidoModal">
        <form method="post" action="../Operaciones/operacionesTipoObjetivo.php" id="form1" class="formularioEdicion">


            <div class="logo">
                <img src="" alt="Logo de Contraseña">
            </div>

            <div class="contenidoGlobal">

                <div class="contenidoM">


                    <h2>Nuevo Tipo de Objetivo</h2>

                    </p>
                    <div class="contenedor">
                        <div class="subtitulo">
                            <h3>CARACTERÍSTICAS</h3>
                        </div>

                                <input type="text" hidden name="id" value="<?php existeVariableMostrar($filaGeneral["id"]) ?>">


                        <div class="subContenido">
                            <div><span>Nombre</span></div>
                            <div class="grid">
                                <input type="text" name="nombre" value="<?php existeVariableMostrar($filaGeneral["descripcion"]) ?>" required>
                            </div>
                        </div>
                        <div class="subContenido">
                            <div><span>Descripcion</span></div>
                            <div class="grid">
                                <textarea name="descripcion" id=""><?php existeVariableMostrar($filaGeneral["observaciones"]) ?></textarea>
                            </div>
                        </div>
                        <div class="grid-dual">

                            <div class="subContenido">
                                <div><span>Fecha Inicio</span></div>
                                <div class="grid">
                                    <input type="date" name="fInicio" id="" value="<?php existeVariableMostrar($filaGeneral["fechaInicio"]) ?>" required>
                                    </select>
                                </div>
                            </div>


                            <div class="subContenido">
                                <div><span>Fecha Final</span></div>
                                <div class="grid">
                                    <input type="date" name="fFinal" value="<?php existeVariableMostrar($filaGeneral["fechaFinal"]) ?>" id="" required>
                                    </select>
                                </div>
                            </div>


                        </div>



                    </div>





                    <div class="panelInformacion">
                        <span class="error"></span>


                    </div>
                </div>


            </div>
            <div class="contenidoFinal1">

                <div class="botones">

                    <?php
                    if ($edicion) {
                    ?>
                        <input type="submit" name="editar" value="Editar">
                        <input type="submit" name="cancelar" value="Cancelar">

                    <?php
                    } else {
                    ?>
                        <input type="submit" name="crear" value="Crear">
                        <input type="submit" name="cancelar" value="Cancelar">
                    <?php
                    } ?>


                </div>
            </div>
    </div>
    </form>
</div>

</div>

<script>

</script>



<script>
    // Get the modal
    var modal = document.getElementById("modal");


    // Get the <span> element that closes the modal



    function confirmarSalida(pagina) {
        const respuesta = confirm("¿Estás seguro de que desea salir?");
        if (respuesta) {
            window.location.href = pagina;
        } else {}
    }





    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {



        if (event.target == modal) {

            window.location.href = "<?php
                                    if (isset($_GET["idAlumno"])) {
                                        echo $_SESSION["pagina"] . ".php?idAlumno=" . $idAlumno;
                                    } else {
                                        echo "../" . $_SESSION["pagina"] . ".php";
                                    }
                                    ?>"

        }
    }
</script>

<?php



// if ($cambiarPagina) {
//     header("Location: " . "index" . ".php");
// } 
?>