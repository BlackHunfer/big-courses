<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            {{ __('Курсы') }}
        </h2>
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="row mt-4">
                    @foreach($courses as $course)
                        <div class="col-sm-4 mb-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $course->title }}</h5>
                                    @if($course->description)
                                        <p class="card-text">{{ $course->description }}</p>
                                    @endif
                                    <div class="d-flex">
                                        <a href="{{ route('student.courses.show', ['course'=> $course->id]) }}" class="btn btn-outline-primary btn-sm mr-2"><i class="bi bi-skip-end mr-2"></i>Начать обучение</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-12">
                    @if($courses && $courses->count())
                       
                    @else
                        <p class="mt-4">Список курсов пока что пуст</p>
                    @endif
                
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
