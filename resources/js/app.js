window.$ = window.jQuery = require('jquery');
bootstrap = require('../modules/bootstrap/dist/js/bootstrap.bundle.min.js');
require('./jquery.maskedinput.min');
require('alpinejs');

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
  // $('#text-editor').summernote({
  //   placeholder: 'Hello Bootstrap 4',
  //   tabsize: 2,
  //   height: 100,
  //   lang: 'ru-RU',
  // });

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

    $(".btn-create-theme").on("click", function(){
      var route = $(this).attr("data-route");

      $("#themeModal form").attr("action", route);
    });

    $(".theme-edit-btn").on("click", function(){
      var route = $(this).attr("data-route");
      var title = $(this).attr("data-title");

      // $("#themeEditModal .modal-title").text(title);
      $("#themeEditModal [name='title']").val(title);
      $("#themeEditModal form").attr("action", route);
    });


 });

 var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})


            
// ClassicEditor
// .create( document.querySelector( '#editor1' ), {
//     language: 'ru',
//     simpleUpload: {
//       uploadUrl: 'http://big-courses',
//     }
// } )
// .then( editor => {
//     console.log( editor );
// } )
// .catch( error => {
//     console.error( error );
// } );

ClassicEditor
				.create( document.querySelector( '.editor-text' ), {
					
				toolbar: {
					items: [
						'heading',
						'|',
						'removeFormat',
						'|',
						'fontColor',
						'fontBackgroundColor',
						'|',
						'fontSize',
						'bold',
						'italic',
						'underline',
						'strikethrough',
						'link',
						'|',
						'bulletedList',
						'numberedList',
						'alignment',
						'|',
						'outdent',
						'indent',
						'|',
						'superscript',
						'subscript',
						'specialCharacters',
						'|',
						'imageUpload',
						'blockQuote',
						'insertTable',
						'mediaEmbed',
						'findAndReplace',
						'undo',
						'redo',
						'horizontalLine',
						'code',
						'sourceEditing'
					]
				},
				language: 'ru',
				image: {
					toolbar: [
						'imageTextAlternative',
						'imageStyle:inline',
						'imageStyle:block',
						'imageStyle:side'
					]
				},
        simpleUpload: {
          uploadUrl: 'http://big-courses',
        },
				table: {
					contentToolbar: [
						'tableColumn',
						'tableRow',
						'mergeTableCells',
						'tableCellProperties',
						'tableProperties'
					]
				},
					licenseKey: '',
					
					
					
				} )
				.then( editor => {
					window.editor = editor;
			
					
					
					
				} )
				.catch( error => {
					console.error( 'Oops, something went wrong!' );
					console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
					console.warn( 'Build id: st1iocv1ttuq-kjyx4eesmz9c' );
					console.error( error );
				} );