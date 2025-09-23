class UtilsParametrosCabecera {
    static obtenerParametro(nombre) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(nombre);
    }
    static establecerParametro(clave, valor) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set(clave, valor);
    }
    static establecerParametrosyRedirigir(nuevosParametros = {}) {
        const urlParams = new URLSearchParams(window.location.search);
        const url = new URL(window.location.href);

        // Agregar/modificar parámetros
        Object.keys(nuevosParametros).forEach(key => {
            if (nuevosParametros[key] === null || nuevosParametros[key] === '') {
                url.searchParams.delete(key);
            } else {
                url.searchParams.set(key, nuevosParametros[key]);
            }
        });

        // Recargar con los nuevos parámetros
        window.location.href = url.toString();
    }
    static recargarPagina() {
        const url = new URL(window.location.href);

        // Recargar con los nuevos parámetros
        window.location.href = url.toString();


    }
}