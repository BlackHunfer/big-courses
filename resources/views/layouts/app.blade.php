<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

      
        
        
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <div class="toast-container position-absolute top-0 end-0 p-3">

            @if(Session::has('message'))
                <!-- Затем положите тосты внутрь -->
                <div class="toast" role="alert" aria-live="polite" aria-atomic="true" data-bs-delay="8000">
                    <div class="toast-header">
                        <!-- <img src="..." class="rounded me-2" alt="..."> -->
                        <strong class="me-auto">BigCourses</strong>
                        <!-- <small class="text-muted">just now</small> -->
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Закрыть"></button>
                    </div>
                    <div class="toast-body">
                        {{ Session::get('message') }}
                    </div>
                </div>
            @endif

            @if(Session::has('messageNoAutoHide'))
                <div class="toast" role="alert" aria-live="polite" aria-atomic="true" data-bs-autohide="false">
                    <div class="toast-header">
                        <!-- <img src="..." class="rounded me-2" alt="..."> -->
                        <strong class="me-auto">BigCourses</strong>
                        <!-- <small class="text-muted">2 секунды назад</small> -->
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Закрыть"></button>
                    </div>
                    <div class="toast-body">
                        {{ Session::get('messageNoAutoHide') }}
                    </div>
                </div>
            @endif
        </div>
          <!-- Scripts -->
          <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous"> -->
          <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script> -->
    
            
            <script src="{{ asset('js/app.js') }}" defer></script>
    
            @if(\Request::route()->getName() == 'materials.create' || \Request::route()->getName() == 'materials.edit')
            <script>
            let allEditors = document.querySelectorAll('.editor-text');
                for (let i = 0; i < allEditors.length; ++i) {

                        ClassicEditor
                        .create( allEditors[i], {
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
                                uploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
                            },
                
                            licenseKey: '',

                            } );
                            // .then( editor => {
                            // 	window.editor = editor;
                        
                                
                            // } )
                            // .catch( error => {
                            // 	console.error( 'Oops, something went wrong!' );
                            // 	console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
                            // 	console.warn( 'Build id: st1iocv1ttuq-kjyx4eesmz9c' );
                            // 	console.error( error );
                            // } );
                };
                </script>
                @endif
    </body>
</html>
