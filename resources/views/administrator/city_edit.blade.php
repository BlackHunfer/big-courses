<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            {{ $city->title }}
        </h2>
    </x-slot>
        
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('cities.index') }}">Филиалы</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $city->title }}</li>
                </ol>
            </nav>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="col-12">
                  
                    @include('common.errors')
                    <form action="{{ route('cities.update', ['city'=> $city->id]) }}" method="POST" novalidate class="needs-validation">
                                @csrf
                                @method('PUT')
                                <div class="mb-3 row">
                                    <label for="inputTitle" class="col-lg-2 col-form-label">Название*</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="title" value="{{ $city->title }}" class="form-control" id="inputTitle" required>
                                        <div class="invalid-feedback">
                                            Укажите название
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputAddress" class="col-lg-2 col-form-label">Адрес</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="address" value="{{ $city->address }}" class="form-control" id="inputAddress">
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
