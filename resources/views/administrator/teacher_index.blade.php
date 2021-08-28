<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            {{ __('Учителя') }}
        </h2>
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="col-12">
                    <a class="mb-4 btn btn-primary" data-bs-toggle="collapse" href="#addTeacherCollapse" role="button" aria-expanded="false" aria-controls="addTeacherCollapse">
                        Добавить учителя
                    </a>
                    @include('common.errors')
                    <div class="collapse" id="addTeacherCollapse">
                        <div class="card card-body p-4">
                            <form action="{{ route('teachers.store') }}" method="POST" novalidate class="needs-validation">
                                @csrf
                                <div class="mb-3 row">
                                    <label for="inputFirstName" class="col-lg-2 col-form-label">Имя*</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="first_name" class="form-control" id="inputFirstName" required>
                                        <div class="invalid-feedback">
                                            Укажите имя
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputEmail" class="col-lg-2 col-form-label">Почта*</label>
                                    <div class="col-lg-4">
                                        <input type="email" name="email" class="form-control" id="inputEmail" required>
                                        <div class="invalid-feedback">
                                            Укажите email
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputSecondName" class="col-lg-2 col-form-label">Фамилия</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="second_name" class="form-control" id="inputSecondName">
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label for="inputLastName" class="col-lg-2 col-form-label">Отчество</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="last_name" class="form-control" id="inputLastName">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputCity" class="col-lg-2 col-form-label">Филиал</label>
                                    <div class="col-lg-4">
                                        <select class="form-select" name="city_id" id="inputCity" aria-label="Выберите филиал">
                                            @if($cities && $cities->count())
                                                <option selected value="0">Выберите филиал</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->title }}</option>
                                                @endforeach
                                            @else
                                                <option selected>Список филиалов пуст</option>
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
                    @if($teachers && $teachers->count())
                        <table class="table table-striped table-sm align-middle mt-4">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ФИО</th>
                                    <th scope="col">Почта</th>
                                    <th scope="col">Филиал</th>
                                    <th scope="col">Опции</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teachers as $key => $teacher)
                                    <tr>
                                        <th>{{ $key+1 }}</th>
                                        <td>{{ $teacher->second_name }} {{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                                        <td>{{ $teacher->email }}</td>
                                        <td>{{ $teacher->city ? $teacher->city->title : 'Без филиала' }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <form action="{{ route('teachers.updateLetter', ['teacher'=> $teacher->id]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success btn-sm mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Повторно отправить письмо для первичной авторизации"> <i class="bi bi-envelope"></i></button>
                                                </form>
                                                <a href="{{ route('teachers.edit', ['teacher'=> $teacher->id]) }}" class="btn btn-outline-primary btn-sm mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Редактировать"><i class="bi bi-pencil-square"></i></a>
                                                <form action="{{ route('teachers.destroy', ['teacher'=> $teacher->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить"><i class="bi bi-x-lg"></i></button>
                                                </form>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="mt-4">Список учителей пока что пуст</p>
                    @endif
                
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
