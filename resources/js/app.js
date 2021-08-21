require('./bootstrap');

require('alpinejs');

    window.$ = window.jQuery = require('jquery');
    require('bootstrap');

(function () {
    'use strict'
  
    // Получите все формы, к которым мы хотим применить пользовательские стили проверки Bootstrap
    var forms = document.querySelectorAll('.needs-validation');
  
    // Зацикливайтесь на них и предотвращайте отправку
    Array.prototype.slice.call(forms)
      .forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
  
          form.classList.add('was-validated')
        }, false)
      });


      
      
  })()

  
$(document).ready(function() {
    $('.toast').toast('show');
    $('.btn-close').on('click', function(){
        $(this).hide();
    })
 });

 var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})



 