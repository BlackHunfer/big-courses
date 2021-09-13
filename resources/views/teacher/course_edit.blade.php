<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            {{ $course->title }}
        </h2>
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Курсы</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $course->title }}</li>
                </ol>
            </nav>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow-sm sm:rounded-lg">
                <div class="col-12">
                    @include('common.errors')
                </div>
                <div class="col-12">
                    @foreach($themes as $theme)
                        <div class="card mb-4">
                            <div class="card-header d-flex flex-wrap justify-between align-items-center">
                                <p class="mb-0">Тема: {{ $theme->title }}</p>
                                <div class="d-flex">
                                    <a href="#" data-title="{{ $theme->title }}" data-route="{{ route('themes.update', ['theme' => $theme->id]) }}" class="theme-edit-btn btn btn-outline-primary btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#themeEditModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Редактировать"><i class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('themes.destroy', ['theme'=> $theme->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить"><i class="bi bi-x-lg"></i></button>
                                    </form>     
                                </div>
                            </div>
                            <div class="card-body">
                                
                                @foreach($theme->materials as $material)
                                    <div class="card mb-2">
                                        <div class="card-body py-2 d-flex justify-between align-items-center">
                                            <div class="material_with_text d-flex flex-wrap align-items-center">
                                                <span class="mr-2 badge {{ \App\Http\Helper::typeMaterialIdToStr($material->material_type_id)['color'] }}">
                                                    {{ \App\Http\Helper::typeMaterialIdToStr($material->material_type_id)['title'] }}
                                                </span>
                                                <i class="bi {{ \App\Http\Helper::opensMaterialIdToStr($material->material_open_id)['icon'] }} mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ \App\Http\Helper::opensMaterialIdToStr($material->material_open_id)['title'] }}" style="padding-top: 3px; font-size: 1.2rem;"></i>
                                                <p class="card-text mb-0">{{ $material->title }}</p>
                                            </div>
                                            <div class="material_with_btns d-flex">
                                                <a href="" class="btn btn-outline btn-sm mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Зажми и перемещай">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrows-expand" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8zM7.646.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 1.707V5.5a.5.5 0 0 1-1 0V1.707L6.354 2.854a.5.5 0 1 1-.708-.708l2-2zM8 10a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 14.293V10.5A.5.5 0 0 1 8 10z"/>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('materials.edit', ['material'=> $material->id]) }}" class="btn btn-outline-primary btn-sm mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Редактировать"><i class="bi bi-pencil-square"></i></a>
                                                <form action="{{ route('materials.destroy', ['material'=> $material->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить"><i class="bi bi-x-lg"></i></button>
                                                </form>
                                                        
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop2" type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Добавить
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                                        <li><a class="dropdown-item" href="{{ route('materials.create', ['theme' => $theme->id, 'course' => $course->id, 'material_type_id' => 0]) }}">Теоритический урок</a></li>
                                        <li><a class="dropdown-item" href="{{ route('materials.create', ['theme' => $theme->id, 'course' => $course->id, 'material_type_id' => 1]) }}">Видео урок</a></li>
                                        <li><a class="dropdown-item" href="#">Файл</a></li>
                                        <li><a class="dropdown-item" href="#">Тест</a></li>
                                        <li><a class="dropdown-item" href="#">Задание с ручной проверкой</a></li>
                                        <li><a class="dropdown-item btn-create-theme" href="#" data-route="{{ route('themes.store', ['course' => $course->id, 'theme' => $theme->id]) }}" data-bs-toggle="modal" data-bs-target="#themeModal">Тему</a></li>
                                    </ul>
                                </div>
                                @foreach($theme->childrenThemes as $childTheme)
                                    @include('common.child_theme', ['child_theme' => $childTheme])
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    <a href="#" data-route="{{ route('themes.store', ['course' => $course->id]) }}" class="btn-create-theme btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#themeModal">Добавить тему</a>
                </div>
                <!-- <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            Тема: Введение
                        </div>
                        <div class="card-body">
                            <div class="card mb-2">
                                <div class="card-body py-2 d-flex justify-between align-items-center">
                                    <div class="material_with_text d-flex flex-wrap align-items-center">
                                        <span class="mr-2 badge bg-secondary">теоритический урок</span><i class="bi bi-clock mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Доступ открыт всегда" style="padding-top: 3px; font-size: 1.2rem;"></i><p class="card-text mb-0">Название урока</p>
                                    </div>
                                    <div class="material_with_btns d-flex">
                                        <a href="" class="btn btn-outline btn-sm mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Зажми и перемещай">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrows-expand" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8zM7.646.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 1.707V5.5a.5.5 0 0 1-1 0V1.707L6.354 2.854a.5.5 0 1 1-.708-.708l2-2zM8 10a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 14.293V10.5A.5.5 0 0 1 8 10z"/>
                                            </svg>
                                        </a>
                                        <a href="" class="btn btn-outline-primary btn-sm mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Редактировать"><i class="bi bi-pencil-square"></i></a>
                                        <form action="" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить"><i class="bi bi-x-lg"></i></button>
                                        </form>
                                                
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-2">
                                <div class="card-body py-2 d-flex justify-between align-items-center">
                                    <div class="material_with_text d-flex flex-wrap align-items-center">
                                        <span class="mr-2 badge bg-secondary">тест</span><i class="bi bi-list-nested mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Доступ открывается в последовательном режиме" style="padding-top: 3px; font-size: 1.2rem;"></i><p class="card-text mb-0">Введение</p>
                                    </div>
                                    <div class="material_with_btns d-flex">
                                        <a href="" class="btn btn-outline btn-sm mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Зажми и перемещай">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrows-expand" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8zM7.646.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 1.707V5.5a.5.5 0 0 1-1 0V1.707L6.354 2.854a.5.5 0 1 1-.708-.708l2-2zM8 10a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 14.293V10.5A.5.5 0 0 1 8 10z"/>
                                            </svg>
                                        </a>
                                        <a href="" class="btn btn-outline-primary btn-sm mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Редактировать"><i class="bi bi-pencil-square"></i></a>
                                        <form action="" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить"><i class="bi bi-x-lg"></i></button>
                                        </form>
                                                
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-2">
                                <div class="card-body py-2 d-flex justify-between align-items-center">
                                    <div class="material_with_text d-flex flex-wrap align-items-center">
                                        <span class="mr-2 badge bg-secondary">файл</span><i class="bi bi-clock-history mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Доступ открывается по расписанию" style="padding-top: 3px; font-size: 1.2rem;"></i><p class="card-text mb-0">Структурная схема проводки</p>
                                    </div>
                                    <div class="material_with_btns d-flex">
                                        <a href="" class="btn btn-outline btn-sm mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Зажми и перемещай">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrows-expand" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8zM7.646.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 1.707V5.5a.5.5 0 0 1-1 0V1.707L6.354 2.854a.5.5 0 1 1-.708-.708l2-2zM8 10a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 14.293V10.5A.5.5 0 0 1 8 10z"/>
                                            </svg>
                                        </a>
                                        <a href="" class="btn btn-outline-primary btn-sm mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Редактировать"><i class="bi bi-pencil-square"></i></a>
                                        <form action="" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить"><i class="bi bi-x-lg"></i></button>
                                        </form>
                                                
                                    </div>
                                </div>
                            </div>
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop2" type="button" class="btn  btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                     Добавить
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                                    <li><a class="dropdown-item" href="route('materials.create', ['theme' = $theme->id, 'course' = $course->id, 'material_type_id' => '2'])">Теоритический урок</a></li>
                                    <li><a class="dropdown-item" href="#">Видео</a></li>
                                    <li><a class="dropdown-item" href="#">Файл</a></li>
                                    <li><a class="dropdown-item" href="#">Тест</a></li>
                                    <li><a class="dropdown-item" href="#">Задание с ручной проверкой</a></li>
                                    <li><a class="dropdown-item" href="#">Тему</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="btn btn-primary btn-sm">Добавить тему</a>
                </div> -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="themeModal" tabindex="-1" aria-labelledby="themeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="themeModalLabel">Новая тема</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" novalidate class="needs-validation">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="formGroupTitleInput2" class="form-label">Название*</label>
                            <input type="text" name="title" class="form-control" id="formGroupTitleInput2" placeholder="" required>
                            <div class="invalid-feedback">
                                Укажите название
                            </div>
                        </div>       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-success">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="themeEditModal" tabindex="-1" aria-labelledby="themeEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="themeEditModalLabel">Редактирование названия темы</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" novalidate class="needs-validation">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="formGroupTitleInput" class="form-label">Название*</label>
                            <input type="text" name="title" class="form-control" id="formGroupTitleInput" placeholder="" required>
                            <div class="invalid-feedback">
                                Укажите название
                            </div>
                        </div>       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-success">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
