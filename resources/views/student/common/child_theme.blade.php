                        <div class="card border-light mt-4">
                            <div class="card-header bg-transparent d-flex flex-wrap justify-between align-items-center">
                                <p class="mb-0">{{ $child_theme->title }}</p>
                            </div>
                            <div class="card-body">
                            @foreach($child_theme->materialsCourseStudent as $material)
                                    <div class="card mb-2">
                                        <div class="card-body py-2 d-flex justify-between align-items-center">
                                            <div class="material_with_text d-flex flex-wrap align-items-center">
                                                <span class="mr-2 badge bg-secondary">
                                                    {{ \App\Http\Helper::typeMaterialIdToStr($material->material_type_id)['title'] }}
                                                </span>
                                                <i class="bi {{ \App\Http\Helper::opensMaterialIdToStr($material->material_open_id)['icon'] }} mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ \App\Http\Helper::opensMaterialIdToStr($material->material_open_id)['title'] }}" style="padding-top: 3px; font-size: 1.2rem;"></i>
                                                <p class="card-text mb-0">{{ $material->title }}</p>
                                            </div>
                                            <div class="material_with_btns d-flex">
                                                <form action="{{ route('student.materials.start', ['material'=> $material->id, 'course' => $course->id]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-play mr-2"></i>Начать</button>
                                                </form>
                                                        
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @if ($child_theme->themes)
                                    @foreach($child_theme->themes as $childTheme)
                                        @include('student.common.child_theme', ['child_theme' => $childTheme])
                                    @endforeach
                                @endif
                            </div>
                        </div>