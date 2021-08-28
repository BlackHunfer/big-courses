<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            {{ __('Специальности') }}
        </h2>
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="col-12">
                    <a class="mb-4 btn btn-primary" data-bs-toggle="collapse" href="#addSpecialityCollapse" role="button" aria-expanded="false" aria-controls="addSpecialityCollapse">
                        Добавить специальность
                    </a>
                    @include('common.errors')
                    <div class="collapse" id="addSpecialityCollapse">
                        <div class="card card-body p-4">
                            <form action="{{ route('specialities.store') }}" method="POST" novalidate class="needs-validation">
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
                    @if($specialities && $specialities->count())
                        <table class="table table-striped table-sm align-middle mt-4">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Название</th>
                                    <th scope="col">Опции</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($specialities as $key => $speciality)
                                    <tr>
                                        <th>{{ $key+1 }}</th>
                                        <td>{{ $speciality->title }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('specialities.edit', ['speciality'=> $speciality->id]) }}" class="btn btn-outline-primary btn-sm mr-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Редактировать"><i class="bi bi-pencil-square"></i></a>
                                                <form action="{{ route('specialities.destroy', ['speciality'=> $speciality->id]) }}" method="POST">
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
                        <p class="mt-4">Список специальностей пока что пуст</p>
                    @endif
                
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
