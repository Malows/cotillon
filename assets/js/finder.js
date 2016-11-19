(function () {
  var todos = document.querySelectorAll('.contenedor a');
  var input = document.querySelector('input');

  input.addEventListener('change', function () {
    todos.forEach(function (elem) {
      if (elem.innerHTML.indexOf( input ) === -1)
        elem.style.display = 'none';
      else
        elem.style.display = '';
      }
    });
  });
})();
