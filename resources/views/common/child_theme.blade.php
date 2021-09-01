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
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop2" type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Добавить
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                                        <li><a class="dropdown-item" href="route('materials.create', ['theme' = $child_theme->id, 'course' => $course->id, 'material_type_id' => '2'])">Теоритический урок</a></li>
                                        <li><a class="dropdown-item" href="#">Видео</a></li>
                                        <li><a class="dropdown-item" href="#">Файл</a></li>
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