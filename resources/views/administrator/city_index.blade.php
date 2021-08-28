<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            {{ __('Филиалы') }}
        </h2>
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="col-12">
                    <a class="mb-4 btn btn-primary" data-bs-toggle="collapse" href="#addCityCollapse" role="button" aria-expanded="false" aria-controls="addCityCollapse">
                        Добавить филиал
                    </a>
                    @include('common.errors')
                    <div class="collapse" id="addCityCollapse">
                        <div class="card card-body p-4">
                            <form action="{{ route('cities.store') }}" method="POST" novalidate class="needs-validation">
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
                                    <label for="inputAddress" class="col-lg-2 col-form-label">Адрес</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="address" class="form-control" id="inputAddress">
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
                    @if($cities && $cities->count())
                        <table class="table table-striped table-sm align-middle mt-4">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Название</th>
                                    <th scope="col">Адрес</th>
                                    <th scope="col">Опции</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cities as $key => $city)
                                    <tr>
                                        <th>{{ $key+1 }}</th>
                                        <td>{{ $city->title }}</td>
                                        <td>{{ $city->address }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('cities.edit', ['city'=> $city->id]) }}" class="btn btn-outline-primary btn-sm mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Редактировать"><i class="bi bi-pencil-square"></i></a>
                                                <form action="{{ route('cities.destroy', ['city'=> $city->id]) }}" method="POST">
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
                        <p class="mt-4">Список филиалов пока что пуст</p>
                    @endif
                
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
