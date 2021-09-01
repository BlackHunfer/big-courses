<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            {{ __('Курсы') }}
        </h2>
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="col-12">
                    <a class="mb-4 btn btn-primary" data-bs-toggle="collapse" href="#addCourseCollapse" role="button" aria-expanded="false" aria-controls="addCourseCollapse">
                        Создать курс
                    </a>
                    @include('common.errors')
                    <div class="collapse" id="addCourseCollapse">
                        <div class="card card-body p-4">
                            <form action="{{ route('courses.store') }}" method="POST" novalidate class="needs-validation">
                                @csrf
                                <div class="mb-3 row">
                                    <label for="inputTitle" class="col-lg-2 col-form-label">Название*</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="title" class="form-control" id="inputTitle" required>
                                        <div class="invalid-feedback">
                                            Укажите название
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputDescription" class="col-lg-2 col-form-label">Описание</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="description" class="form-control" id="inputDescription">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <button type="submit" class="btn btn-success">Сохранить</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
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
                                        <a href="{{ route('courses.edit', ['course'=> $course->id]) }}" class="btn btn-outline-primary btn-sm mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Редактировать"><i class="bi bi-pencil-square mr-2"></i>Редактировать</a>
                                        <form action="{{ route('courses.destroy', ['course'=> $course->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить"><i class="bi bi-x-lg"></i></button>
                                        </form>   
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
