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
    $consulta = "SELECT * FROM plazosObjetivos WHERE id=" . $_GET["id"];
    $resultado = $conn->query($consulta);
    $filaGeneral = $resultado->fetch_assoc();
} else if (isset($_GET["tipoObjetivo"]) &&  isset($_GET["descripcion"]) &&  isset($_GET["observaciones"]) &&  isset($_GET["fInicio"]) && isset($_GET["fFinal"])) {
    $filaGeneral["tipoObjetivo"] = $_GET["tipoObjetivo"];
    $filaGeneral["descripcion"] = $_GET["descripcion"];
    $filaGeneral["observaciones"] = $_GET["observaciones"];
    $filaGeneral["fechaInicio"] = $_GET["fInicio"];
    $filaGeneral["fechaFinal"] = $_GET["fFinal"];
}



?>

<!-- The Modal -->
<div id="modal" class="modal">

    <!-- Modal content -->
    <div class="contenidoModal">
        <form method="post" action="../Operaciones/operacionesPlazosObjetivos.php" id="form1" class="formularioEdicion">


            <div class="logo">
                <img src="" alt="Logo de Contraseña">
            </div>

            <div class="contenidoGlobal">

                <div class="contenidoM">

                    <?php if (isset($filaGeneral["id"])) {
                    ?>
                        <h2>Editar Plazos</h2>

                    <?php
                    } else { ?>
                        <h2>Nuevo Plazo</h2>

                    <?php } ?>

                    </p>
                    <div class="contenedor">
                        <div class="subtitulo">
                            <h3>CARACTERÍSTICAS</h3>
                        </div>

                        <input type="text" hidden name="id" value="<?php existeVariableMostrar($filaGeneral["id"]) ?>">


                        <div class="subContenido">
                            <div><span>Objetivo</span></div>
                            <div class="grid">
                                <select name="tipoObjetivo" id="">
                                    <?php
                                    $consulta = "SELECT * FROM tipoObjetivosUsuarios WHERE idUsuario = " . $_SESSION["id"];
                                    $resultado = $conn->query($consulta);
                                    while ($fila = $resultado->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $fila["id"]; ?>" <?php if ($filaGeneral["idTipoObjetivo"]  == $fila["id"]) echo "selected"; ?>><?php echo $fila["descripcion"] ?></option>

                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="subContenido">
                            <div><span>Descripcion</span></div>
                            <div class="grid">
                                <input type="text" name="descripcion" value="<?php existeVariableMostrar($filaGeneral["descripcion"]) ?>">
                            </div>
                        </div>
                        <div class="subContenido">
                            <div><span>Observaciones</span></div>
                            <div class="grid">
                                <textarea name="observaciones" rows="6" id=""><?php existeVariableMostrar($filaGeneral["observaciones"]) ?></textarea>
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
                        <span class="error"><?php if (isset($_GET["error"])) {
                                                echo $_GET["error"];
                                            } ?></span>


                    </div>
                </div>


            </div>
            <div class="contenidoFinal1">

                <div class="botones">

                    <?php
                    if ($edicion) {
                    ?>
                        <input type="submit" name="editar" value="Editar">
                        <input type="submit" name="editar1" value="Editar y Cerrar">
                        <input type="submit" name="eliminar" value="Eliminar">
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
    cambioEnFormulario(document.getElementById("form1"));

    clickFueraModalConPreguntaModificacion();

    fInicio = document.querySelectorAll("[name='fInicio']")[0];
    fFinal = document.querySelectorAll("[name='fFinal']")[0];

    copiarAlSalir(fInicio, fFinal);
</script>