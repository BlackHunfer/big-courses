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
                    <nav class="d-flex justify-content-between flex-wrap mt-4">   
                        {{ $texts->links('vendor.pagination.custom') }}
                        @if($texts->currentPage() == $texts->lastPage())
                            <form action="{{ route('student.materials.finish', ['material'=> $material->id, 'course' => $course->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success ml-auto">Завершить</button>
                            </form>
                        @endif
                    </nav>
                </div>
            @else
                <div class="col-12 p-6">
                    <form action="{{ route('student.materials.finish', ['material'=> $material->id, 'course' => $course->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success ml-auto">Завершить</button>
                    </form>
                </div>
            @endif
            </div>
        </div>
    </div>
    <!-- <script async charset="utf-8" src="//cdn.embedly.com/widgets/platform.js"></script>  Если закончится iframly -->
    <script charset="utf-8" src="//cdn.iframe.ly/embed.js?api_key=9758ced385cbc5d8bab6c6"></script>
    <script src="{{ asset('/js/ckeditor/build/ckeditor.js') }}"></script>
</x-app-layout>
