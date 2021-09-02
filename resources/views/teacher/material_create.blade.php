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
                                    <textarea name="text" name="text" class="editor-text"></textarea>
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
