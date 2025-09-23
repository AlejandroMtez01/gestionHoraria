// Obtener mes actual en diferentes formatos
class UtilsFechas{

static obtenerMesActual() {
    const fecha = new Date();
    const mesNumero = fecha.getMonth();

    return mesNumero + 1; // 1-12
}
static obtenerYearActual() {
    const fecha = new Date();
    const year = fecha.getFullYear();

    return year;
}
}

