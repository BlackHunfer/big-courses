<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            {{ $group->title }}
        </h2>
    </x-slot>
        
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('groups.index') }}">Группы учеников</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $group->title }}</li>
                </ol>
            </nav>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="col-12">
                  
                    @include('common.errors')
                    <form action="{{ route('groups.update', ['group'=> $group->id]) }}" method="POST" novalidate class="needs-validation">
                                @csrf
                                @method('PUT')
                                <div class="mb-3 row">
                                    <label for="inputTitle" class="col-lg-2 col-form-label">Название*</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="title" value="{{ $group->title }}" class="form-control" id="inputTitle" required>
                                        <div class="invalid-feedback">
                                            Укажите название
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputStudents" class="col-lg-2 col-form-label">Ученики</label>
                                    <div class="col-lg-4">
                                        <select class="multiple form-select" name="students_id[]" id="inputStudents" aria-label="Выберите учеников" multiple required>
                                            @if($students && $students->count())
                                                @foreach($students as $student)
                                                    @if($student->groups)
                                                        <option value="{{ $student->id }}" 
                                                            @foreach($student->groups as $groupStudent) 
                                                                @if($groupStudent->id == $group->id) selected @endif 
                                                            @endforeach
                                                        >{{ $student->second_name }} {{ $student->first_name }} {{ $student->last_name }}</option>
                                                    @else
                                                        <option value="{{ $student->id }}">{{ $student->second_name }} {{ $student->first_name }} {{ $student->last_name }}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                                <option selected>Список учеников пуст</option>
                                            @endif
                                        </select>
                                        <div class="invalid-feedback">
                                            Выберите хотя бы одного ученика
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputSpeciality" class="col-lg-2 col-form-label">Специальность</label>
                                    <div class="col-lg-4">
                                        <select class="form-select" name="speciality_id" id="inputSpeciality" aria-label="Выберите специальность">
                                            @if($specialities && $specialities->count())
                                                @if($group->speciality)
                                                    <option selected value="0">Без специальности</option>
                                                @else
                                                    <option value="0">Выберите специальность</option>
                                                @endif
                                                @foreach($specialities as $speciality)
                                                    @if($group->speciality)
                                                        <option value="{{ $speciality->id }}" @if($group->speciality->id == $speciality->id) selected @endif>{{ $speciality->title }}</option>
                                                    @else
                                                        <option value="{{ $speciality->id }}">{{ $speciality->title }}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                                <option selected>Список специальностей пуст</option>
                                            @endif
                                        </select>
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
</x-app-layout>
