                        <div class="card border-light mt-4">
                            <div class="card-header bg-transparent d-flex flex-wrap justify-between align-items-center">
                                <p class="mb-0">{{ $child_theme->title }}</p>
                            </div>
                            <div class="card-body">
                            @foreach($child_theme->materialsCourseStudent as $material)
                                    <div class="card mb-2">
                                        <div class="card-body py-2 d-flex justify-between align-items-center">
                                            <div class="material_with_text d-flex flex-wrap align-items-center">
                                                <span class="mr-2 badge {{ \App\Http\Helper::typeMaterialIdToStr($material->material_type_id)['color'] }}">
                                                    {{ \App\Http\Helper::typeMaterialIdToStr($material->material_type_id)['title'] }}
                                                </span>
                                                @if($material->result_for_student($material->id)->studied != null)
                                                    <i class="bi bi-check-square-fill mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Пройден" style="padding-top: 3px; font-size: 1.2rem; color: #198754;"></i>
                                                @else
                                                    <i class="bi bi-x-square-fill mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Не пройден" style="padding-top: 3px; font-size: 1.2rem; color: #dc3545;"></i>
                                                @endif
                                                <p class="card-text mb-0">{{ $material->title }}</p>
                                            </div>
                                            <div class="material_with_btns d-flex">
                                                @if($material->result_for_student($material->id)->closed_at)
                                                    <?php
                                                            $close_day = \Carbon\Carbon::parse($material->result_for_student($material->id)->closed_at);
                                                            $courseWithStudent = Auth::user()->student_courses()->where('course_id', $course->id)->first();
                                                            $courseToStudentDate = $courseWithStudent->pivot->created_at;
                                                            $days_to_close = $close_day->diffInDays(\Carbon\Carbon::parse($courseToStudentDate));
                                                            $days_to_close_now = $close_day->diffInDays(\Carbon\Carbon::now());

                                                            $days_to_closePrecent = $days_to_close/100;
                                                            $days_to_closePrecent30 = $days_to_closePrecent*30;
                                                    ?>
                                                    @if($days_to_close_now <= $days_to_closePrecent30)
                                                        <i class="bi bi-exclamation-triangle mr-4" data-bs-toggle="tooltip" data-bs-placement="top" title="Доступ закроется {{ \Carbon\Carbon::parse($material->result_for_student($material->id)->closed_at)->format('d.m.Y в H:i') }}" style="padding-top: 3px; font-size: 1.2rem; color: #ffc107;"></i>
                                                    @endif
                                                @endif
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