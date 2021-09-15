                        <div class="card mt-4">
                            <div class="card-header d-flex flex-wrap justify-between align-items-center">
                                <p class="mb-0">Тема: {{ $child_theme->title }}</p>
                                <div class="d-flex">
                                    <a href="#" data-title="{{ $child_theme->title }}" data-route="{{ route('themes.update', ['theme' => $child_theme->id]) }}" class="theme-edit-btn btn btn-outline-primary btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#themeEditModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Редактировать"><i class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('themes.destroy', ['theme'=> $child_theme->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить"><i class="bi bi-x-lg"></i></button>
                                    </form>  
                                </div>
                            </div>
                            <div class="card-body">
                            @foreach($child_theme->materials as $material)
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
                                        <li><a class="dropdown-item" href="{{ route('materials.create', ['theme' => $child_theme->id, 'course' => $course->id, 'material_type_id' => 0]) }}">{{ \App\Http\Helper::typeMaterialIdToStr(0)['title'] }}</a></li>
                                        <li><a class="dropdown-item" href="{{ route('materials.create', ['theme' => $child_theme->id, 'course' => $course->id, 'material_type_id' => 1]) }}">{{ \App\Http\Helper::typeMaterialIdToStr(1)['title'] }}</a></li>
                                        <li><a class="dropdown-item" href="{{ route('materials.create', ['theme' => $child_theme->id, 'course' => $course->id, 'material_type_id' => 2]) }}">{{ \App\Http\Helper::typeMaterialIdToStr(2)['title'] }}</a></li>
                                        <li><a class="dropdown-item" href="#">Тест</a></li>
                                        <li><a class="dropdown-item" href="#">Задание с ручной проверкой</a></li>
                                        <li><a class="dropdown-item btn-create-theme" href="#" data-route="{{ route('themes.store', ['course' => $course->id, 'theme' => $child_theme->id]) }}" data-bs-toggle="modal" data-bs-target="#themeModal">Тему</a></li>
                                    </ul>
                                </div>
                                @if ($child_theme->themes)
                                    @foreach($child_theme->themes as $childTheme)
                                        @include('common.child_theme', ['child_theme' => $childTheme])
                                    @endforeach
                                @endif
                            </div>
                        </div>