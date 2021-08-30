<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            {{ __('Ученики') }}
        </h2>
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Ученики</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('groups.index') }}">Группы учеников</a>
                </li>
            </ul>
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="col-12">
                    <a class="mb-4 btn btn-primary" data-bs-toggle="collapse" href="#addStudentCollapse" role="button" aria-expanded="false" aria-controls="addStudentCollapse">
                        Добавить ученика
                    </a>
                    @include('common.errors')
                    <div class="collapse" id="addStudentCollapse">
                        <div class="card card-body p-4">
                            <form action="{{ route('students.store') }}" method="POST" novalidate class="needs-validation">
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
                                <div class="mb-4 row">
                                    <label for="inputPhone" class="col-lg-2 col-form-label">Телефон</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="tel_phone" class="form-control" id="inputPhone" placeholder="+7 (666) 666-66-66">
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label for="inputBirthday" class="col-lg-2 col-form-label">Дата рождения</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="birthday" class="form-control" id="inputBirthday" placeholder="20.03.2005">
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
                    @if($students && $students->count())
                        <table class="table table-striped table-sm align-middle mt-4">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ФИО</th>
                                    <th scope="col">Почта</th>
                                    <th scope="col">Опции</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $key => $student)
                                    <tr>
                                        <th>{{ $key+1 }}</th>
                                        <td>{{ $student->second_name }} {{ $student->first_name }} {{ $student->last_name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <form action="{{ route('students.updateLetter', ['student'=> $student->id]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success btn-sm mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Повторно отправить письмо для первичной авторизации"> <i class="bi bi-envelope"></i></button>
                                                </form>
                                                <a href="{{ route('students.edit', ['student'=> $student->id]) }}" class="btn btn-outline-primary btn-sm mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Редактировать"><i class="bi bi-pencil-square"></i></a>
                                                <form action="{{ route('students.destroy', ['student'=> $student->id]) }}" method="POST">
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
                        <p class="mt-4">Список учеников пока что пуст</p>
                    @endif
                
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
