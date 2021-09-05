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

    
    //Новый слайд у теоритического урока
    $(".btn-create-slide__material").on("click", function(){
        var $countSlides = $(".list-slides__material .list-group-item").length;
        $newSlide = $countSlides + 1;
        $newSlideEditor = '#slide'+ $newSlide+' .editor-text';

        $(".list-slides__material").append('<a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-bs-toggle="list" href="#slide'+ $newSlide +'" role="tab"><span class="title-slide__material">Слайд '+ $newSlide +'</span> <button class="btn btn-danger btn-sm delete-slide__material" title="Удалить"><i class="bi bi-x-lg"></i></button></a>');
        $(".content-slides__material").append('<div class="tab-pane fade" id="slide'+ $newSlide +'" role="tabpanel"><div class="col-12"><textarea name="text[]" class="editor-text"></textarea></div></div>');
        
        ClassicEditor
            .create( document.querySelector($newSlideEditor), {
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
						'strikethrough',
						'underline',
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
						// 'imageUpload',
						'imageInsert',
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
				table: {
					contentToolbar: [
						'tableColumn',
						'tableRow',
						'mergeTableCells',
						'tableCellProperties',
						'tableProperties'
					]
				},
                simpleUpload: {
                    uploadUrl: '/laravel-filemanager/upload?type=Images&_token=' + $('meta[name=csrf-token]').attr("content"),
                },
	
				licenseKey: '',

				} );
			

        $(".list-slides__material .list-group-item").each(function(index){
          $(this).attr("href", "#slide" + (index + 1));
          $(this).find(".title-slide__material").text("Слайд " + (index + 1));
        });

        $(".content-slides__material .tab-pane").each(function(index){
          $(this).attr("id", "slide" + (index + 1));
        });
        
    });

    $(document).on('click','.delete-slide__material', function(){
      var $idSlide = $(this).parents('.list-group-item').attr("href");

      $(this).parents('.list-group-item').remove();
      $(".content-slides__material").find($idSlide).remove();

      $(".list-slides__material .list-group-item").each(function(index){
        $(this).attr("href", "#slide" + (index + 1));
        $(this).find(".title-slide__material").text("Слайд " + (index + 1));
      });

      $(".content-slides__material .tab-pane").each(function(index){
        $(this).attr("id", "slide" + (index + 1));
      });

      // var firstTabEl = document.querySelector('#list-tabSlides a[href="#slide1"]')
      // var firstTab = new bootstrap.Tab(firstTabEl)
      // firstTab.show()

      // $(".content-slides__material .tab-pane[id='slide1']").show();

    });

 });

 var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
  