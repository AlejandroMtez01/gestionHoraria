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
function copiarAlSalir(etiqueta1, etiqueta2) {
    etiqueta1.addEventListener('blur', function () {
        // Pasar el valor de fInicio a fFinal
        etiqueta2.value = this.value;


    });
}
function siguienteMes() {
    console.log("Prueba Siguiente MES");
    if (UtilsParametrosCabecera.obtenerParametro("m") == null && UtilsParametrosCabecera.obtenerParametro("y") == null) { //Si no tiene mes
        console.log("Entro sin mes ni año!");
        mes = UtilsFechas.obtenerMesActual();
        year = UtilsFechas.obtenerYearActual();

    } else {
        mes = Number.parseInt(UtilsParametrosCabecera.obtenerParametro("m"));
        year = Number.parseInt(UtilsParametrosCabecera.obtenerParametro("y"));
    }

    console.log(mes);
    console.log(year);

    if (mes == 12) {
        mes = 1;
        year++;
    } else {
        mes++;
    }
    console.log("m " + mes + " y " + year);
    UtilsParametrosCabecera.establecerParametrosyRedirigir({
        "m": mes,
        "y": year
    });


}
function anteriorMes() {
    console.log("Prueba Anterior MES");
    if (UtilsParametrosCabecera.obtenerParametro("m") == null && UtilsParametrosCabecera.obtenerParametro("y") == null) { //Si no tiene mes
        console.log("Entro sin mes ni año!");
        mes = UtilsFechas.obtenerMesActual();
        year = UtilsFechas.obtenerYearActual();

    } else {
        mes = Number.parseInt(UtilsParametrosCabecera.obtenerParametro("m"));
        year = Number.parseInt(UtilsParametrosCabecera.obtenerParametro("y"));
    }

    console.log(mes);
    console.log(year);

    if (mes == 1) {
        mes = 12;
        year--;
    } else {
        mes--;
    }
    /*establecerParametro("m", mes);
    establecerParametro("y", year);
    recargarPagina();*/
    UtilsParametrosCabecera.establecerParametrosyRedirigir({
        "m": mes,
        "y": year
    });

}