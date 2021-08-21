<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
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
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ФИО</th>
                            <th scope="col">Почта</th>
                            <th scope="col">Опции</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers as $key => $teacher)
                            <tr>
                                <th>{{ $key+1 }}</th>
                                <td>{{ $teacher->second_name }} {{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                                <td>{{ $teacher->email }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        <form action="{{ route('teachers.updateToken', ['teacher'=> $teacher->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Повторно отправить письмо для первичной авторизации"> <i class="bi bi-envelope"></i></button>
                                        </form>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Редактировать"><i class="bi bi-pencil-square"></i></button>
                                        <form action="{{ route('teachers.destroy', ['teacher'=> $teacher->id]) }}" method="POST">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить"><i class="bi bi-x-lg"></i></button>
                                        </form>
                                        
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
