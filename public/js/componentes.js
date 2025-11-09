export class MiComponente {
  constructor(idElemento) {
    this.elemento = document.getElementById(idElemento);
    if (!this.elemento) {
      throw new Error(`El elemento con id "${idElemento}" no fue encontrado.`);
    }
  }

  /**
   * Actualiza el contenido HTML del elemento.
   * @param {string} nuevoContenido El nuevo HTML para el elemento.
   */
  render(nuevoContenido) {
    this.elemento.innerHTML = nuevoContenido;
  }

  /**
   * Agrega un listener de evento al elemento.
   * @param {string} evento El nombre del evento (ej. 'click').
   * @param {function} callback La función a ejecutar cuando ocurra el evento.
   */
  on(evento, callback) {
    this.elemento.addEventListener(evento, callback);
  }
}
