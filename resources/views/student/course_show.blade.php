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
                    <li class="breadcrumb-item"><a href="{{ route('student.courses.index') }}">Курсы</a></li>
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
                        <div class="card border-light mb-4">
                            <div class="card-header bg-transparent d-flex flex-wrap justify-between align-items-center">
                                <p class="mb-0">{{ $theme->title }}</p>
                            </div>
                            <div class="card-body">
                                
                                @foreach($theme->materialsCourseStudent as $material)
                                    <div class="card mb-2">
                                        <div class="card-body py-2 d-flex justify-between align-items-center">
                                            <div class="material_with_text">
                                                <span class="mr-2 badge {{ \App\Http\Helper::typeMaterialIdToStr($material->material_type_id)['color'] }}">
                                                    {{ \App\Http\Helper::typeMaterialIdToStr($material->material_type_id)['title'] }}
                                                </span>
                                                <div class="d-flex align-items-center">
                                                <!-- <i class="bi {{ \App\Http\Helper::opensMaterialIdToStr($material->material_open_id)['icon'] }} mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ \App\Http\Helper::opensMaterialIdToStr($material->material_open_id)['title'] }}" style="padding-top: 3px; font-size: 1.2rem;"></i> -->
                                                @if($material->result_for_student($material->id)->studied != null)
                                                    <i class="bi bi-check-square-fill mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Пройден" style="padding-top: 3px; font-size: 1.2rem; color: #198754;"></i>
                                                @else
                                                    <i class="bi bi-x-square-fill mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Не пройден" style="padding-top: 3px; font-size: 1.2rem; color: #dc3545;"></i>
                                                @endif

                                                <p class="card-text mb-0 mr-2">{{ $material->title }}</p>
                                                </div>
                                               
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
                                @foreach($theme->childrenThemes as $childTheme)
                                    @include('student.common.child_theme', ['child_theme' => $childTheme])
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
