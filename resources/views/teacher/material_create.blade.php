<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            {{ $material_type }}
        </h2>
    </x-slot>
        
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Курсы</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('courses.edit', ['course' => $course->id]) }}">{{ $course->title }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $material_type }}</li>
                </ol>
            </nav>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow-sm sm:rounded-lg">
                <div class="col-12">
                  
                    @include('common.errors')
                    <form action="{{ route('materials.store', ['theme' => $theme->id, 'course' => $course->id, 'material_type_id' => '0']) }}" method="POST" novalidate class="needs-validation">
                                @csrf
                                <div class="mb-3 row">
                                    <label for="inputTitle" class="col-lg-2 col-form-label">Заголовок*</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="title" value="" class="form-control" id="inputTitle" required>
                                        <div class="invalid-feedback">
                                            Укажите заголовок
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-12">
                                        <label for="inputTitle" class="col-12 col-form-label">Содержание урока</label>
                                    </div>
                                    <div class="col-2">
                                            <div class="list-group list-slides__material" id="list-tabSlides" role="tablist">
                                            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center active" data-bs-toggle="list" href="#slide1" role="tab">
                                                <span class="title-slide__material">Слайд 1</span>

                                                <button class="btn btn-danger btn-sm delete-slide__material" title="Удалить"><i class="bi bi-x-lg"></i></button>
                                            </a>
                                        </div>
                                        <div class="d-grid gap-2 mt-3">
                                            <button type="button" class="btn btn-outline-primary btn-sm btn-create-slide__material">
                                                <i class="bi bi-plus-lg mr-1"></i> Новый слайд
                                            </button>
                                        </div>
                                        
                                    </div>
                                    <div class="col-10">
                                        <div class="tab-content content-slides__material">
                                            <div class="tab-pane fade show active" id="slide1" role="tabpanel"> 
                                                <div class="col-12">
                                                    <textarea name="text[]" class="editor-text"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="inputMaterialOpen" class="col-lg-2 col-form-label">Тип доступа</label>
                                    <div class="col-lg-4">
                                        <select class="form-select" name="material_open_id" id="inputMaterialOpen" aria-label="Выберите тип доступа" required>
                                                @foreach($opensMaterialIds as $key => $opensMaterialId)
                                                        <option value="{{ $key }}">{{ $opensMaterialId['title'] }}</option>
                                                @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Выберите тип доступа
                                        </div>
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
    </div>

    <script src="{{ asset('/js/ckeditor/build/ckeditor.js') }}"></script>
</x-app-layout>
