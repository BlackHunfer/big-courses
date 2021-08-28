<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            {{ $student->first_name }}
        </h2>
    </x-slot>
        
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Ученики</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $student->first_name }}</li>
                </ol>
            </nav>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="col-12">
                  
                    @include('common.errors')
                    <form action="{{ route('students.update', ['student'=> $student->id]) }}" method="POST" novalidate class="needs-validation">
                                @csrf
                                @method('PUT')
                                <div class="mb-3 row">
                                    <label for="inputFirstName" class="col-lg-2 col-form-label">Имя*</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="first_name" value="{{ $student->first_name }}" class="form-control" id="inputFirstName" required>
                                        <div class="invalid-feedback">
                                            Укажите имя
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputEmail" class="col-lg-2 col-form-label">Почта*</label>
                                    <div class="col-lg-4">
                                        <input type="email" name="email" value="{{ $student->email }}" class="form-control" id="inputEmail" required>
                                        <div class="invalid-feedback">
                                            Укажите email
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputSecondName" class="col-lg-2 col-form-label">Фамилия</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="second_name" value="{{ $student->second_name }}" class="form-control" id="inputSecondName">
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label for="inputLastName" class="col-lg-2 col-form-label">Отчество</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="last_name" value="{{ $student->last_name }}" class="form-control" id="inputLastName">
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label for="inputPhone" class="col-lg-2 col-form-label">Телефон</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="tel_phone" value="{{ $student->tel_phone }}" class="form-control" id="inputPhone" placeholder="+7 (666) 666-66-66">
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label for="inputBirthday" class="col-lg-2 col-form-label">Дата рождения</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="birthday" value="{{ \Carbon\Carbon::parse($student->birthday)->format('d.m.Y') }}" class="form-control" id="inputBirthday" placeholder="20.03.2005">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputCity" class="col-lg-2 col-form-label">Филиал</label>
                                    <div class="col-lg-4">
                                        <select class="form-select" name="city_id" id="inputCity" aria-label="Выберите филиал">
                                            @if($cities && $cities->count())
            
                                                @if($student->city_id)
                                                    <option selected value="0">Без филиала</option>
                                                @else
                                                    <option value="0">Выберите филиал</option>
                                                @endif
                                                @foreach($cities as $city)
                                                    @if($student->city_id)
                                                        <option value="{{ $city->id }}" @if($student->city_id == $city->id) selected @endif>{{ $city->title }}</option>
                                                    @else
                                                        <option value="{{ $city->id }}">{{ $city->title }}</option>
                                                    @endif
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
    </div>
</x-app-layout>
