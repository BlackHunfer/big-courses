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
