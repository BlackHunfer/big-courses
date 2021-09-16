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
                    <form action="{{ route('materials.store', ['theme' => $theme->id, 'course' => $course->id, 'material_type_id' => $material_type_id]) }}" method="POST" novalidate class="needs-validation">
                                @csrf
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#content-materialToggle" type="button" role="tab" aria-selected="true">Контент</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link"  data-bs-toggle="tab" data-bs-target="#settings-materialToggle" type="button" role="tab" aria-selected="false">Настройки</button>
                                    </li>
                                </ul>
                                <div class="tab-content mt-4">
                                    <div class="tab-pane fade show active" id="content-materialToggle" role="tabpanel">
                                        <div class="mb-4 row">
                                            <label for="inputTitle" class="col-lg-2 col-form-label">Заголовок*</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="title" value="" class="form-control" id="inputTitle" required>
                                                <div class="invalid-feedback">
                                                    Укажите заголовок
                                                </div>
                                            </div>
                                        </div>
                                        @if($material_type_id == 0)
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
                                        @endif

                                        @if($material_type_id == 1)
                                        <div class="mb-5 mt-5 row">
                                            <div class="col-lg-12 d-flex justify-content-center">
                                                <a id="lfm2" data-input="thumbnail2" data-preview="holder2" class="btn btn-outline-primary mt-5 mb-5">Загрузить видео</a>
                                                <a id="lfm2_remove" class="btn btn-outline-danger" style="display: none;">Удалить видео</a>
                                                <input id="thumbnail2" class="form-control" type="hidden" name="video">
                                            </div>
                                            <div class="col-lg-12 d-flex justify-content-center mt-4">
                                                <div id="holder2" style="max-width: 600px; max-height:350px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-2">
                                                <label for="inputTitle" class="col-12 col-form-label">Дополнительный контент</label>
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
                                        @endif

                                        @if($material_type_id == 2)
                                        <div class="mb-4 row">
                                            <div class="col-2">
                                                <label for="inputTitle" class="col-12 col-form-label">Дополнительный контент</label>
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
                                            <div class="col-2">
                                                <label for="inputTitle" class="col-12 col-form-label">Файлы</label>
                                            </div>
                                            <div class="col-10">
                                                <a id="lfm_files" data-input="thumbnail3" data-preview="holder-files" class="btn btn-outline-primary mb-3">Загрузить файлы</a>
                                                <input id="thumbnail3" class="form-control mb-3" type="hidden">
                                                <!-- <input id="thumbnail_files" class="form-control mb-3" type="hidden" name="upload_file" readonly> -->
                                                <div id="holder-files">
                                                    <!-- <div class="holder__item d-flex align-items-center mb-3">
                                                        <a href="#" target="_blank" class="holder__file text-decoration-none d-flex align-items-center mb-0 h5"><i class="bi bi-file-earmark-zip mr-1 h4 mb-0"></i>Название файла.zip</a>
                                                        <span class="delete__file pt-1 ml-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить"><i class="bi bi-x-lg text-danger"></i></span>
                                                    </div> -->
                                                    <!-- <a href="#" target="_blank" class="holder__file text-decoration-none d-flex align-items-center mb-3 h5"><i class="bi bi-file-earmark-zip mr-1 h4 mb-0"></i>Название файла.zip</a>
                                                    <a href="#" target="_blank" class="holder__file text-decoration-none d-flex align-items-center mb-3 h5"><i class="bi bi-file-earmark-text mr-1 h4 mb-0"></i>Документ.doc</a>
                                                    <a href="#" target="_blank" class="holder__file text-decoration-none d-flex align-items-center mb-3 h5"><i class="bi bi-file-earmark-slides mr-1 h4 mb-0"></i>Презентация.ppt</a>
                                                    <a href="#" target="_blank" class="holder__file text-decoration-none d-flex align-items-center mb-3 h5"><i class="bi bi-file-earmark-spreadsheet mr-1 h4 mb-0"></i>Таблица.xls</a>
                                                    <a href="#" target="_blank" class="holder__file text-decoration-none d-flex align-items-center mb-3 h5"><i class="bi bi-file-earmark-pdf mr-1 h4 mb-0"></i>Документ.pdf</a>
                                                    <a href="#" target="_blank" class="holder__file text-decoration-none d-flex align-items-center mb-3 h5"><i class="bi bi-file-earmark-image mr-1 h4 mb-0"></i>Картинка.png</a> -->
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="settings-materialToggle" role="tabpanel">
                                        <div class="mb-3 row">
                                            <label for="inputMaterialOpen" class="col-lg-2 col-form-label">Тип доступа</label>
                                            <div class="col-lg-4">
                                                <select class="form-select select-material_open_id" name="material_open_id" id="inputMaterialOpen" aria-label="Выберите тип доступа" required>
                                                        @foreach($opensMaterialIds as $key => $opensMaterialId)
                                                                <option value="{{ $key }}">{{ $opensMaterialId['title'] }}</option>
                                                        @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Выберите тип доступа
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center opentype__inputs opentype_1 hidden">
                                            <label for="inputMaterialId" class="col-lg-2 col-form-label">Откроется после изучения</label>
                                            <div class="col-lg-4">
                                                <select class="form-select" name="material_id" id="inputMaterialId" aria-label="Выберите материал">
                                                    <option value="0" >Выберите материал</option>
                                                        @foreach($course->materials as $materialCourse)
                                                                <option value="{{ $materialCourse->id }}">{{ $materialCourse->title }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row opentype__inputs opentype_2 hidden">
                                            <label class="col-lg-2 col-form-label">Откроется через</label>
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <input type="number" min="0" name="date_open_days" value="" class="form-control" placeholder="0">
                                                    <span class="input-group-text">дней</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <input type="number" min="0" name="date_open_hours" value="" class="form-control" placeholder="0">
                                                    <span class="input-group-text">часов</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <input type="number" min="0" name="date_open_minutes" value="" class="form-control" placeholder="0">
                                                    <span class="input-group-text">минут</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 d-flex align-items-center">
                                                <p class="mb-0 small">с момента привязки курса к ученику</p>
                                            </div>
                                        </div>
                                        <div class="mb-3 row opentype__inputs opentype_2_1 hidden">
                                            <div class="col-lg-5">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="open_exact_date" id="open_exact_date">
                                                    <label class="form-check-label" for="open_exact_date">
                                                        Выбрать конкретную дату открытия доступа
                                                    </label>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="mb-3 row opentype__inputs opentype_3 hidden">
                                            <label class="col-lg-2 col-form-label">Откроется</label>
                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                                    <input type="text" value="" class="form-control form_datetime">
                                                    <button class="btn btn-outline-secondary reset-date" type="button" id="button-addon2" data-bs-toggle="tooltip" data-bs-placement="top" title="Очистить поле"><i class="bi bi-x-lg"></i></button>
                                                    <input type="hidden" class="form_datetime__mirror" name="opens_after_day" id="mirror_field" value="" readonly />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-lg-2 col-form-label">Доступ <br>закроется через</label>
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <input type="number" min="0" name="date_close_days" value="" class="form-control" placeholder="">
                                                    <span class="input-group-text">дней</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <input type="number" min="0" name="date_close_hours" value="" class="form-control" placeholder="">
                                                    <span class="input-group-text">часов</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <input type="number" min="0" name="date_close_minutes" value="" class="form-control" placeholder="">
                                                    <span class="input-group-text">минут</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 d-flex align-items-center">
                                                <p class="mb-0 small">с момента привязки курса к ученику</p>
                                            </div>
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

    <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-lg-down">
                            <div class="modal-content">
                                    <div class="modal-body">
                                        <iframe name="uploadFileIframe" src="" width="100%" height="400px"></iframe>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Закрыть</button>
                                    </div>
                            </div>
                        </div>
    </div>

    @if($material_type_id == 0 || $material_type_id == 1 || $material_type_id == 2)
    <script src="{{ asset('/js/ckeditor/build/ckeditor.js') }}"></script>
    @endif
</x-app-layout>
