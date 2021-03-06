const { on } = require('video.js/dist/video.min.js');

window.$ = window.jQuery = require('jquery');
bootstrap = require('bootstrap/dist/js/bootstrap.bundle.min.js');
require('./jquery.maskedinput.min');
require('./bootstrap-datetimepicker.min');
require('./locales/bootstrap-datetimepicker.ru');
require('alpinejs');
videojs = require('video.js/dist/video.min.js');
require('video.js/dist/lang/ru.js');


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

    var route_prefix = "/filemanager";
        // $('#lfm').filemanager('image', {prefix: route_prefix});
        // $('#lfm').filemanager('file', {prefix: route_prefix});

        var lfm = function(id, type, options) {
          let button = document.getElementById(id);
    
          $(button).on('click', function(){
            var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
            var target_input = document.getElementById(button.getAttribute('data-input'));
            var target_preview = document.getElementById(button.getAttribute('data-preview'));
            // console.log(options.type);
            // window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
            // window.open(route_prefix + '?type=video', "uploadFileIframe");
            // $("#fileModal iframe").attr('src', '/filemanager?type=video');
            // console.log(window.opener);
            if (window.opener) {
              $("#fileModal").modal('show');
            }else{
              var FileWindow = window.open(route_prefix + '?type=' + options.type || 'file', "uploadFileIframe");
              // $("#fileModal iframe").attr('src', '/filemanager?type=video');
              $("#fileModal").modal('show');
            }
            
            window.SetUrl = function (items) {
              var file_path = items.map(function (item) {
                return item.url;
              }).join(',');
              $("#fileModal").modal('hide');
              $("#add_video").hide();
              $("#lfm2_remove").show();
              $("#fileModal iframe").attr("src", "about: blank");
              $("#fileModal iframe").html("");
              // set the value of the desired input to image url
              target_input.value = file_path;
              target_input.dispatchEvent(new Event('change'));
    
              // clear previous preview
              target_preview.innerHtml = '';
              // set or change the preview image src
              console.log(options.type);
              items.forEach(function (item) {
                console.log(item);
                // let img = document.createElement('img')
                // img.setAttribute('style', 'height: 5rem')
                // img.setAttribute('src', item.thumb_url)
                // target_preview.appendChild(img);
                if(options.type == 'video'){
                  if(item.icon == "mp4"){
                    $(target_preview).html('<video class="video_uploaded" controls="controls" controlsList="nodownload"><source src="'+ item.url +'" type="video/mp4; codecs="avc1.42E01E, mp4a.40.2"></video>');
                  }else if(item.icon == "webm"){
                    $(target_preview).html('<video class="video_uploaded" controls="controls" controlsList="nodownload"><source src="'+ item.url +'" type="video/webm; codecs="vp8, vorbis"></video>');
                  }else{
                    $(target_preview).html('<video class="video_uploaded" controls="controls" controlsList="nodownload"><source src="'+ item.url +'" type="video/mp4; codecs="avc1.42E01E, mp4a.40.2"></video>');
                  }
                }else{
                  // var valfiles = $("#thumbnail_files").val();
                  // if(valfiles){
                  //   $("#thumbnail_files").val(valfiles + "," + item.url);
                  // }else{
                  //   $("#thumbnail_files").val(item.url);
                  // }
                  
                  if(item.icon == "mp4" || item.icon == "webm"){
                    $(target_preview).append('<div class="holder__item d-flex align-items-center mb-3"><input type="hidden" name="upload_file_name[]" value="'+ item.name +'" readonly><input type="hidden" name="upload_file_type[]" value="'+ item.icon +'" readonly><input type="hidden" name="upload_file[]" value="'+ item.url +'" readonly><a href="'+ item.url +'" download class="holder__file text-decoration-none d-flex align-items-center mb-0 h5"><i class="bi bi-file-earmark-play mr-1 h4 mb-0"></i>'+ item.name + '</a><span class="delete__file pt-1 ml-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить"><i class="bi bi-x-lg text-danger"></i></span></div>'); 
                  }else if(item.icon == "zip" || item.icon == "rar" || item.icon == "7z"){
                    $(target_preview).append('<div class="holder__item d-flex align-items-center mb-3"><input type="hidden" name="upload_file_name[]" value="'+ item.name +'" readonly><input type="hidden" name="upload_file_type[]" value="'+ item.icon +'" readonly><input type="hidden" name="upload_file[]" value="'+ item.url +'" readonly><a href="'+ item.url +'" download class="holder__file text-decoration-none d-flex align-items-center mb-0 h5"><i class="bi bi-file-earmark-zip mr-1 h4 mb-0"></i>'+ item.name + '</a><span class="delete__file pt-1 ml-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить"><i class="bi bi-x-lg text-danger"></i></span></div>'); 
                  }else if(item.icon == "pdf"){
                    $(target_preview).append('<div class="holder__item d-flex align-items-center mb-3"><input type="hidden" name="upload_file_name[]" value="'+ item.name +'" readonly><input type="hidden" name="upload_file_type[]" value="'+ item.icon +'" readonly><input type="hidden" name="upload_file[]" value="'+ item.url +'" readonly><a href="'+ item.url +'" download class="holder__file text-decoration-none d-flex align-items-center mb-0 h5"><i class="bi bi-file-earmark-pdf mr-1 h4 mb-0"></i>'+ item.name + '</a><span class="delete__file pt-1 ml-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить"><i class="bi bi-x-lg text-danger"></i></span></div>'); 
                  }else if(item.icon == "doc" || item.icon == "docx"){
                    $(target_preview).append('<div class="holder__item d-flex align-items-center mb-3"><input type="hidden" name="upload_file_name[]" value="'+ item.name +'" readonly><input type="hidden" name="upload_file_type[]" value="'+ item.icon +'" readonly><input type="hidden" name="upload_file[]" value="'+ item.url +'" readonly><a href="'+ item.url +'" download class="holder__file text-decoration-none d-flex align-items-center mb-0 h5"><i class="bi bi-file-earmark-text mr-1 h4 mb-0"></i>'+ item.name + '</a><span class="delete__file pt-1 ml-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить"><i class="bi bi-x-lg text-danger"></i></span></div>'); 
                  }else if(item.icon == "xls" || item.icon == "xlsx"){
                    $(target_preview).append('<div class="holder__item d-flex align-items-center mb-3"><input type="hidden" name="upload_file_name[]" value="'+ item.name +'" readonly><input type="hidden" name="upload_file_type[]" value="'+ item.icon +'" readonly><input type="hidden" name="upload_file[]" value="'+ item.url +'" readonly><a href="'+ item.url +'" download class="holder__file text-decoration-none d-flex align-items-center mb-0 h5"><i class="bi bi-file-earmark-spreadsheet mr-1 h4 mb-0"></i>'+ item.name + '</a><span class="delete__file pt-1 ml-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить"><i class="bi bi-x-lg text-danger"></i></span></div>'); 
                  }else if(item.icon == "ppt" || item.icon == "pptx"){
                    $(target_preview).append('<div class="holder__item d-flex align-items-center mb-3"><input type="hidden" name="upload_file_name[]" value="'+ item.name +'" readonly><input type="hidden" name="upload_file_type[]" value="'+ item.icon +'" readonly><input type="hidden" name="upload_file[]" value="'+ item.url +'" readonly><a href="'+ item.url +'" download class="holder__file text-decoration-none d-flex align-items-center mb-0 h5"><i class="bi bi-file-earmark-slides mr-1 h4 mb-0"></i>'+ item.name + '</a><span class="delete__file pt-1 ml-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить"><i class="bi bi-x-lg text-danger"></i></span></div>'); 
                  }else if(item.icon == "png" || item.icon == "jpg" || item.icon == "jpeg" || item.icon == "gif" || item.icon == "fa-image"){
                    $(target_preview).append('<div class="holder__item d-flex align-items-center mb-3"><input type="hidden" name="upload_file_name[]" value="'+ item.name +'" readonly><input type="hidden" name="upload_file_type[]" value="'+ item.icon +'" readonly><input type="hidden" name="upload_file[]" value="'+ item.url +'" readonly><a href="'+ item.url +'" download class="holder__file text-decoration-none d-flex align-items-center mb-0 h5"><i class="bi bi-file-earmark-image mr-1 h4 mb-0"></i>'+ item.name + '</a><span class="delete__file pt-1 ml-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить"><i class="bi bi-x-lg text-danger"></i></span></div>'); 
                  }else{
                    $(target_preview).append('<div class="holder__item d-flex align-items-center mb-3"><input type="hidden" name="upload_file_name[]" value="'+ item.name +'" readonly><input type="hidden" name="upload_file_type[]" value="'+ item.icon +'" readonly><input type="hidden" name="upload_file[]" value="'+ item.url +'" readonly><a href="'+ item.url +'" download class="holder__file text-decoration-none d-flex align-items-center mb-0 h5"><i class="bi bi-file-earmark mr-1 h4 mb-0"></i>'+ item.name + '</a><span class="delete__file pt-1 ml-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить"><i class="bi bi-x-lg text-danger"></i></span></div>'); 
                  }
                }
                
                // Превьюхи картинок
                // else{
                //   let img = document.createElement('img')
                //   img.setAttribute('style', 'height: 5rem')
                //   img.setAttribute('src', item.thumb_url)
                //   target_preview.appendChild(img);
                // }

                
              });
    
              // trigger change event
              target_preview.dispatchEvent(new Event('change'));

              // $("[name=uploadFileIframe]").html('');
              
            };
          });
        };
    
        lfm('lfm2', 'File', {prefix: route_prefix, type: 'video'});
        lfm('lfm_files', 'File', {prefix: route_prefix});

        $("#lfm2_remove").on("click", function(){
          $("#add_video").show();
          $("#lfm2_remove").hide();
          $('input[name=video]').val('');
          $('#holder2').html('');
        });

        $(document).on('click','.delete__file', function(){
          $(this).parents('.holder__item').remove();
          // var hrefFile = $(this).parents('.holder__item').find('.holder__file').attr("href");
          // var hrefFiles = $("#thumbnail_files").val();
          
          // $filesmass = [];
          // $.each(hrefFiles.split(","), function(index, item) {
          //   if(hrefFile != item){
          //     $filesmass.push(item);
          //   }
          // });
         
          // var stringUpdateFiles = $filesmass.join(',');
          // $("#thumbnail_files").val(stringUpdateFiles);
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
});

var options = {
  "playbackRates": [0.5, 1, 1.5, 2],
  "controls": true,
  // "autoplay": false,
  "language": "ru"
};

var player = videojs('sutdent__video', options, function onPlayerReady() {

  // In this context, `this` is the player that was created by Video.js.
  this.play();

  // How about an event listener?
  this.on('ended', function() {
    videojs.log('Awww...over so soon?!');
  });
});
  