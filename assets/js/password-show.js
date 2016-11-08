(function () {
  /* Declaro variables */
  var boton = document.querySelector('#show-me');
  var ojo = boton.firstChild;
  var formulario = document.querySelector('#password-form');
  /* Registro disparadores */
  //cuando aprieto para ver
  boton.addEventListener('mousedown' , function ( event ) {
    ojo.classList.remove('fa-eye');
    ojo.classList.add('fa-eye-slash');
    formulario.setAttribute('type', 'text');
  });
  //cuando suelto y se oculta
  boton.addEventListener('mouseup' , function ( event ) {
    ojo.classList.remove('fa-eye-slash');
    ojo.classList.add('fa-eye');
    formulario.setAttribute('type', 'password');
  });
})();
