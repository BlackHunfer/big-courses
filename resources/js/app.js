require('./bootstrap');
require('./jquery.maskedinput.min');

require('alpinejs');

    window.$ = window.jQuery = require('jquery');
    // require('bootstrap');

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
    });


    $.fn.setCursorPosition = function(pos) {
      if ($(this).get(0).setSelectionRange) {
        $(this).get(0).setSelectionRange(pos, pos);
      } else if ($(this).get(0).createTextRange) {
        var range = $(this).get(0).createTextRange();
        range.collapse(true);
        range.moveEnd('character', pos);
        range.moveStart('character', pos);
        range.select();
      }
    };

    $("[name=tel_phone]").mask("+7 (999) 999-99-99");
    $("[name=birthday]").mask("99.99.9999");
 });

 var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})



 