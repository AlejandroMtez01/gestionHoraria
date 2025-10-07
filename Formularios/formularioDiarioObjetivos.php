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
    $consulta = "SELECT * FROM diarioObjetivos WHERE id=" . $_GET["id"];
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
        <form method="post" action="../Operaciones/operacionesDarioObjetivos.php" id="form1" class="formularioEdicion">


            <div class="logo">
                <img src="" alt="Logo de Contraseña">
            </div>

            <div class="contenidoGlobal">

                <div class="contenidoM">

                    <?php if (isset($filaGeneral["id"])) {
                    ?>
                        <h2>Editar Resumen Diario</h2>

                    <?php
                    } else { ?>
                        <h2>Nuevo Resumen Diario</h2>

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
                                <div id="menuPersonalizado" class="menu-contextual">

                                    <div class="menu-opcion" onclick="ejecutarAccion('mayusculas')">Mayúsculas</div>
                                    <div class="menu-opcion" onclick="ejecutarAccion('minusculas')">Minúsculas</div>
                                    <div class="menu-opcion" onclick="ejecutarAccion('capitalizacion')">Capitalización</div>
                                    <hr>
                                    <div class="menu-opcion" onclick="ejecutarAccion('lista')">Lista</div>
                                    <div class="menu-opcion" onclick="ejecutarAccion('sublista')">Sublista</div>
                                    <!-- Cuando tenga https -->
                                    <!-- <hr>
                                    <div class="menu-opcion" onclick="ejecutarAccion('copiar')">Copiar</div>
                                    <div class="menu-opcion" onclick="ejecutarAccion('pegar')">Pegar</div> -->

                                </div>
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

    textArea = document.querySelector("textarea");
    textArea.addEventListener('contextmenu', function(event) {
        event.preventDefault();
        /// 2. Llama a tu función para mostrar el menú personalizado
        mostrarMenuPersonalizado(event.clientX, event.clientY);
    });

    function mostrarMenuPersonalizado(x, y) {
        // Aquí iría el código para mostrar tu menú personalizado
        console.log(`Clic derecho en la posición: (${x}, ${y})`);
        // Ejemplo: mostrar un div con las opciones
        const menu = document.getElementById('menuPersonalizado');
        menu.style.left = `${x}px`;
        menu.style.top = `${y}px`;
        menu.style.display = 'block';
    }

    function transformarSeleccion(transformador) {
        const textArea = document.querySelector('textarea');

        const inicio = textArea.selectionStart;
        const final = textArea.selectionEnd;
        const textoCompleto = textArea.value;
        const textoSeleccionado = textoCompleto.substring(inicio, final);

        if (textoSeleccionado.length === 0) return; // No hacer nada si no hay texto

        // 1. Aplica la función de transformación
        const textoTransformado = transformador(textoSeleccionado);

        // 2. Reemplaza el texto seleccionado con el texto transformado
        const nuevoTexto =
            textoCompleto.substring(0, inicio) +
            textoTransformado +
            textoCompleto.substring(final);

        textArea.value = nuevoTexto;

        // 3. Vuelve a seleccionar el texto transformado (opcional, para feedback)
        textArea.selectionStart = inicio;
        textArea.selectionEnd = inicio + textoTransformado.length;
    }


    function ejecutarAccion(accion) {
        //Para todos los métodos.
        const textArea = document.querySelector('textarea');
        inicio = textArea.selectionStart;
        final = textArea.selectionEnd;

        // Extraer la subcadena (el texto seleccionado) usando las posiciones
        const textoSeleccionado = textArea.value.substring(inicio, final);




        switch (accion) {
            case 'copiar':
                // Comando para copiar el texto seleccionado
                if (textoSeleccionado.length > 0) {
                    console.log("Copiada selección: \n" + textoSeleccionado);
                } else {
                    const textoSeleccionado = textArea.value;
                    console.log("Copiado todo el textArea: \n" + textoSeleccionado);
                }
                navigator.clipboard.writeText("Este es el texto a copiar")
                    .then(() => {
                        console.log('Contenido copiado al portapapeles');
                        /* Resuelto - texto copiado al portapapeles con éxito */
                    }, () => {
                        console.error('Error al copiar');
                        /* Rechazado - fallo al copiar el texto al portapapeles */
                    });
                break;
            case 'mayusculas':
                transformarSeleccion(texto => texto.toUpperCase());

                break;
            case 'minusculas':
                transformarSeleccion(texto => texto.toLowerCase());

                break;
            case 'capitalizacion':
                transformarSeleccion(texto => {
                    return texto.toLowerCase().split(' ').map(word => {
                        return word.charAt(0).toUpperCase() + word.slice(1);
                    }).join(' ');
                });
                break;
            case 'lista':
                transformarSeleccion(texto => {
                    const prefijo = '- '; // Prefijo fijo para lista simple

                    // Separa el texto por líneas, limpia espacios y elimina líneas vacías
                    const lineas = texto
                        .split('\n')
                        .map(line => line.trim())
                        .filter(line => line.length > 0);

                    // Añade el prefijo a cada línea y une con saltos de línea
                    return lineas.map(line => prefijo + line).join('\n');
                });


                break;
            case 'sublista':
                transformarSeleccion(texto => {
                    const prefijo = '- '; // Prefijo fijo para lista simple

                    // Separa el texto por líneas, limpia espacios y elimina líneas vacías
                    const lineas = texto
                        .split('\n')
                        .map(line => line.trim())
                        .filter(line => line.length > 0);

                    // Añade el prefijo a cada línea y une con saltos de línea
                    return lineas.map(line => "  → " + line).join('\n');
                });

                break;
            default:
                console.log(`Acción desconocida: ${accion}`);
        }
        const menu = document.getElementById('menuPersonalizado');

        menu.style.display = 'none';


        // Oculta el menú después de la acción
        document.getElementById('menuPersonalizado').style.display = 'none';
    }
    document.addEventListener('click', function(event) {
        // Asegúrate de que el clic no fue dentro del menú personalizado
        const menu = document.getElementById('menuPersonalizado');

        if (!menu.contains(event.target)) {

            menu.style.display = 'none';
        }
    });
</script>