window.$ = window.jQuery = require('jquery');
bootstrap = require('../modules/bootstrap/dist/js/bootstrap.bundle.min.js');
require('./jquery.maskedinput.min');
require('./bootstrap-datetimepicker.min');
require('./locales/bootstrap-datetimepicker.ru');
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

  $(".form_datetime").datetimepicker({
    format: "dd.mm.yyyy - hh:ii",
    autoclose: true,
    minuteStep: 10,
    startDate: new Date(),
    language: 'ru',
    linkField: "mirror_field",
    linkFormat: "yyyy-mm-dd hh:ii"
  });

  $('.reset-date').on("click", function(){
    $('.form_datetime').val('');
    $('.form_datetime__mirror').val('');
    $('.form_datetime').datetimepicker('update');
  });

    var valueSelected = $('.select-material_open_id').val();

    if(valueSelected == 0){
      $('.opentype_1').addClass("hidden");
      $('.opentype_2').addClass("hidden");
      $('.opentype_2_1').addClass("hidden");
      $('.opentype_1').find("select").val("0");
      $('.opentype_2').find("input").val("");
      $("#open_exact_date").prop('checked', false);
    }

    if(valueSelected == 1){
      $('.opentype_1').removeClass("hidden");
      $('.opentype_2').addClass("hidden");
      $('.opentype_2_1').addClass("hidden");
      $('.opentype_2').find("input").val("");
      $("#open_exact_date").prop('checked', false);
    }

    if(valueSelected == 2){
      $('.opentype_1').addClass("hidden");
      $('.opentype_2').removeClass("hidden");
      $('.opentype_2_1').removeClass("hidden");
      $('.opentype_1').find("select").val("0");
      // $("#open_exact_date").prop('checked', false);
    }

    if(valueSelected == 3){
      $('.opentype_1').removeClass("hidden");
      $('.opentype_2').removeClass("hidden");
      $('.opentype_2_1').removeClass("hidden");
      // $("#open_exact_date").prop('checked', false);
    }
    
  
  $('.select-material_open_id').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;

    if(valueSelected == 0){
      $('.opentype_1').addClass("hidden");
      $('.opentype_2').addClass("hidden");
      $('.opentype_2_1').addClass("hidden");
      $('.opentype_1').find("select").val("0");
      $('.opentype_2').find("input").val("");

      $("#open_exact_date").prop('checked', false);
    }

    if(valueSelected == 1){
      $('.opentype_1').removeClass("hidden");
      $('.opentype_2').addClass("hidden");
      $('.opentype_2_1').addClass("hidden");
      $('.opentype_2').find("input").val("");
      $("#open_exact_date").prop('checked', false);
    }

    if(valueSelected == 2){
      $('.opentype_1').addClass("hidden");
      $('.opentype_2').removeClass("hidden");
      $('.opentype_2_1').removeClass("hidden");
      $('.opentype_1').find("select").val("0");
      $("#open_exact_date").prop('checked', false);
    }

    if(valueSelected == 3){
      $('.opentype_1').removeClass("hidden");
      $('.opentype_2').removeClass("hidden");
      $('.opentype_2_1').removeClass("hidden");
      $("#open_exact_date").prop('checked', false);
    }

    if($("#open_exact_date").prop('checked')){
      $('.opentype_3').removeClass("hidden");
    }else{
      $('.opentype_3').addClass("hidden");
      $('.opentype_3').find("input").val("");
    }

  });

  if($("#open_exact_date").prop('checked')){
   
      $('.opentype_3').removeClass("hidden");
      $('.opentype_2').addClass("hidden");
    $('.opentype_2').find("input").val("");
  }else{
    if(valueSelected == 0 || valueSelected == 1){
      $('.opentype_2').addClass("hidden");
    }else{
      $('.opentype_2').removeClass("hidden");
    }
    $('.opentype_3').addClass("hidden"); 
    $('.opentype_3').find("input").val("");
  }
  
  $("#open_exact_date").on('click', function (e) {
    if($("#open_exact_date").prop('checked')){
      $('.opentype_3').removeClass("hidden");
      $('.opentype_2').addClass("hidden");
      $('.opentype_2').find("input").val("");
    }else{
      $('.opentype_2').removeClass("hidden");
      $('.opentype_3').addClass("hidden");
      $('.opentype_3').find("input").val("");
    }
  });

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
                  'fontSize',
                  'fontColor',
                  'fontBackgroundColor',
                  '|',
                  'bold',
                  'italic',
                  'underline',
                  'strikethrough',
                  'link',
                  'bulletedList',
                  'numberedList',
                  'alignment',
                  '|',
                  'outdent',
                  'indent',
                  '|',
                  'imageInsert',
                  'blockQuote',
                  'insertTable',
                  'mediaEmbed',
                  'todoList',
                  'specialCharacters',
                  'superscript',
                  'subscript',
                  'htmlEmbed',
                  'codeBlock',
                  'horizontalLine',
                  'undo',
                  'redo',
                  'findAndReplace',
                  'sourceEditing'
                ]
              },
              language: 'ru',
              image: {
                toolbar: [
                  'imageTextAlternative',
                  'imageStyle:inline',
                  'imageStyle:block',
                  'imageStyle:side',
                  'linkImage'
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


document.querySelectorAll( 'oembed[url]' ).forEach( element => {
  iframely.load( element, element.attributes.url.value );
} );

 //Если закончился iframly
//  document.querySelectorAll( 'oembed[url]' ).forEach( element => {
//   // Create the <a href="..." class="embedly-card"></a> element that Embedly uses
//   // to discover the media.
//   const anchor = document.createElement( 'a' );

//   anchor.setAttribute( 'href', element.getAttribute( 'url' ) );
//   anchor.className = 'embedly-card';

//   element.appendChild( anchor );
// } );

 var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
  