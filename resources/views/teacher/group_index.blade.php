<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            {{ __('Группы учеников') }}
        </h2>
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="col-12">
                    <a class="mb-4 btn btn-primary" data-bs-toggle="collapse" href="#addGroupCollapse" role="button" aria-expanded="false" aria-controls="addGroupCollapse">
                        Создать группу
                    </a>
                    @include('common.errors')
                    <div class="collapse" id="addGroupCollapse">
                        <div class="card card-body p-4">
                            <form action="{{ route('groups.store') }}" method="POST" novalidate class="needs-validation">
                                @csrf
                                <div class="mb-3 row">
                                    <label for="inputTitle" class="col-lg-2 col-form-label">Название*</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="title" class="form-control" id="inputTitle" required>
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
                                                    <option value="{{ $student->id }}">{{ $student->second_name }} {{ $student->first_name }} {{ $student->last_name }}</option>
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
                                                <option selected value="0">Выберите специальность</option>
                                                @foreach($specialities as $speciality)
                                                    <option value="{{ $speciality->id }}">{{ $speciality->title }}</option>
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

                <div class="col-12">
                    @if($groups && $groups->count())
                        <table class="table table-striped table-sm align-middle mt-4">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Название</th>
                                    <th scope="col">Учеников</th>
                                    <th scope="col">Специальность</th>
                                    <th scope="col">Опции</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($groups as $key => $group)
                                    <tr>
                                        <th>{{ $key+1 }}</th>
                                        <td>{{ $group->title }}</td>
                                        <td>{{ $group->students->count() }}</td>
                                        <td>{{ $group->speciality ? $group->speciality->title : '' }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('groups.edit', ['group'=> $group->id]) }}" class="btn btn-outline-primary btn-sm mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Редактировать"><i class="bi bi-pencil-square"></i></a>
                                                <form action="{{ route('groups.destroy', ['group'=> $group->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить"><i class="bi bi-x-lg"></i></button>
                                                </form>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="3">
                                            <table class="table table-bordered table-sm mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">ФИО</th>
                                                        <th scope="col">Опции</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($group->students as $key2 => $student)
                                                        <tr>
                                                            <td>{{ $key2 + 1 }}</td>
                                                            <td>{{ $student->second_name }} {{ $student->first_name }} {{ $student->last_name }}</td>
                                                            <td>
                                                                <form action="{{ route('groups.ungroup.student', ['group'=> $group->id, 'student' => $student->id]) }}" method="POST">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Открепить от группы"><i class="bi bi-person-dash-fill"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="mt-4">Список групп пока что пуст</p>
                    @endif
                
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
