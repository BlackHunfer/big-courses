<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            {{ $material->title }}
        </h2>
    </x-slot>
        
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('student.courses.index') }}">Курсы</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('student.courses.show', ['course' => $material->course->id]) }}">{{ $material->course->title }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $material->title }}</li>
                </ol>
            </nav>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            @if($material->video)
                <div class="col-12 for-video-cont p-4 pt-5">
                    <h1 class="text-center" style="color: white">{{ $material->title }}</h1>
                </div>
                <div class="col-lg-12 d-flex justify-content-center pb-5 mb-4 for-video-cont">
                    <div class="pb-5">
                        <div class="video-in-cont">
                                <video class="video_uploaded video-js" width="100%" height="100%" id="sutdent__video" oncontextmenu="return false;">
                                    <source src="{{ $material->video }}" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                                    <source src="{{ $material->video }}" type='video/webm; codecs="vp8, vorbis"'>
                                </video>
                        </div>
                    </div>
                </div>
            @endif
            @if($texts)
                @if($textsTotal > 1)
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $textsOnePrecent*$texts->currentPage() }}%" aria-valuenow="{{ $textsOnePrecent*$texts->currentPage() }}" aria-valuemin="0" aria-valuemax="100">{{-- number_format($textsOnePrecent*$texts->currentPage(), 0, ',', ' ') --}}</div>
                </div>
                @endif
                <div class="col-12 p-6">
                    @foreach($texts as $key => $text)
                        <div class="row">
                            <div class="col">
                                <div class="ck ck-content">
                                    {!! $text !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if($material->upload_file)
                    <div class="row p-6">
                            @foreach($material->upload_file as $file)
                                <div class="holder__item d-flex align-items-center mb-3">
                                    <a href="{{ $file['url'] }}" download class="holder__file text-decoration-none d-flex align-items-center mb-0 h6"><i class="bi 
                                    @if($file['type'] == 'fa-image' || $file['type'] == 'png' || $file['type'] == 'jpg' || $file['type'] == 'jpeg' || $file['type'] == 'gif')
                                        bi-file-earmark-image
                                    @elseif($file['type'] == 'mp4' || $file['type'] == 'webm')
                                        bi-file-earmark-play
                                    @elseif($file['type'] == 'zip' || $file['type'] == 'rar' || $file['type'] == '7z')
                                        bi-file-earmark-zip
                                    @elseif($file['type'] == 'pdf')
                                        bi-file-earmark-pdf
                                    @elseif($file['type'] == 'doc' || $file['type'] == 'docx')
                                        bi-file-earmark-text
                                    @elseif($file['type'] == 'xls' || $file['type'] == 'xlsx')
                                        bi-file-earmark-spreadsheet
                                    @elseif($file['type'] == 'ppt' || $file['type'] == 'pptx')
                                        bi-file-earmark-slides
                                    @else
                                        bi-file-earmark
                                    @endif
                                    mr-1 h5 mb-0"></i>{{ $file['name'] }}</a>
                                </div>
                            @endforeach
                    </div>    
                    @endif
                    <nav class="d-flex justify-content-between flex-wrap mt-4">
                        {{ $texts->links('vendor.pagination.custom') }}
                        @if($texts->currentPage() == $texts->lastPage())
                            <form class="ml-auto" action="{{ route('student.materials.finish', ['material'=> $material->id, 'course' => $course->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success ml-auto">Завершить</button>
                            </form>
                        @endif
                    </nav>
                </div>
            @else
                <div class="col-12 p-6 pb-0">
                    <h2>{{ $material->title }}</h2> 
                </div>
                @if($material->upload_file)
                <div class="col-12 p-6">
                        @foreach($material->upload_file as $file)
                                <div class="holder__item d-flex align-items-center mb-3">
                                    <a href="{{ $file['url'] }}" download class="holder__file text-decoration-none d-flex align-items-center mb-0 h6"><i class="bi 
                                    @if($file['type'] == 'fa-image' || $file['type'] == 'png' || $file['type'] == 'jpg' || $file['type'] == 'jpeg' || $file['type'] == 'gif')
                                        bi-file-earmark-image
                                    @elseif($file['type'] == 'mp4' || $file['type'] == 'webm')
                                        bi-file-earmark-play
                                    @elseif($file['type'] == 'zip' || $file['type'] == 'rar' || $file['type'] == '7z')
                                        bi-file-earmark-zip
                                    @elseif($file['type'] == 'pdf')
                                        bi-file-earmark-pdf
                                    @elseif($file['type'] == 'doc' || $file['type'] == 'docx')
                                        bi-file-earmark-text
                                    @elseif($file['type'] == 'xls' || $file['type'] == 'xlsx')
                                        bi-file-earmark-spreadsheet
                                    @elseif($file['type'] == 'ppt' || $file['type'] == 'pptx')
                                        bi-file-earmark-slides
                                    @else
                                        bi-file-earmark
                                    @endif
                                    mr-1 h5 mb-0"></i>{{ $file['name'] }}</a>
                                </div>
                        @endforeach
                </div>    
                @endif                    
                <div class="col-12 p-6">
                    <form class="" action="{{ route('student.materials.finish', ['material'=> $material->id, 'course' => $course->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Завершить</button>
                    </form>
                </div>
            @endif
            </div>
        </div>
    </div>
    @if($texts)
    <!-- <script async charset="utf-8" src="//cdn.embedly.com/widgets/platform.js"></script>  Если закончится iframly -->
    <script charset="utf-8" src="//cdn.iframe.ly/embed.js?api_key=9758ced385cbc5d8bab6c6"></script>
    <script src="{{ asset('/js/ckeditor/build/ckeditor.js') }}"></script>
    @endif
    <script>
        document.getElementById("sutdent__video").oncontextmenu = function (e) {
            return false;
        };
    </script>
    <!-- <link href="https://vjs.zencdn.net/7.14.3/video-js.css" rel="stylesheet" /> -->

    <!-- <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet"> -->
    <!-- <script src="{{ asset('/vendor/video.js-main/build/docs/styles/videojs.css') }}"></script> -->

    <!-- <link href="https://unpkg.com/@videojs/themes@1/dist/city/index.css" rel="stylesheet"> -->
    
    <!-- <script src="https://vjs.zencdn.net/7.14.3/video.min.js"></script> -->
    <!-- <script src="{{ asset('/vendor/video.js-main/build/minify.js') }}"></script> -->
</x-app-layout>
