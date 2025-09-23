let cambiosRealizados = false;


function cambioEnFormulario(formulario) {


    // Detectar cambios en cualquier campo
    formulario.addEventListener('input', function () {
        cambiosRealizados = true;
        //console.log('Se detectaron cambios en el formulario');
    });

    // También puedes detectar cambios específicos por tipo de campo
    formulario.addEventListener('change', function (e) {
        console.log(`Campo cambiado: ${e.target.name}`);
        cambiosRealizados = true;
    });
}
function confirmarSalida(pagina) {
    const respuesta = confirm("¿Estás seguro de que desea salir?");
    if (respuesta) {
        window.location.href = pagina;
    } else { }
}

function clickFueraModalConPreguntaModificacion() {
    var modal = document.getElementById("modal");

    window.onclick = function (event) {


        if (event.target == modal) {

            var formulario = document.getElementById("form1");

            var pagina = "../indice.php";

            if (cambiosRealizados) {
                confirmarSalida(pagina);
            } else {
                window.location.href = pagina;

            }

        }
    }
}
function copiarAlSalir(etiqueta1,etiqueta2){
        etiqueta1.addEventListener('blur', function() {
        // Pasar el valor de fInicio a fFinal
        etiqueta2.value = this.value;


    });
}