@extends('web.layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
                <div>
                    <a class="h5"><i class="fas fa-credit-card"></i> {{ __('Editar Gasto') }}</a>
                </div>
                <div>
                    <a href="{{ '/web/expenses/' . $expense->getRouteKey() }}" class="btn btn-primary"><i class="fas fa-eye"></i> {{ __('Ver Gasto') }}</a>
                    <a href="/web/expenses" class="btn btn-outline-primary"><i class="fas fa-list"></i> {{ __('Lista') }}</a>
                    <a href="#" class="btn btn-outline-danger" onclick="{{ 'delete' . $expense->id . '()' }}"><i class="fas fa-trash"></i></a>
                    <form id="{{ 'delete-record' . $expense->getRouteKey() }}" method="post" action="{{ '/web/expenses/' . $expense->getRouteKey() }}">
                        <input name="_method" type="hidden" value="DELETE">
                        @csrf
                    </form>
                </div>
            </div>
            <form method="POST" action="{{ '/web/expenses/' . $expense->getRouteKey() }}" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="mt-2">{{ __('Información Principal') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="order-md-1">

                            <div id="entity_data">
                                <div class="row mt-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="date"><a class="text-danger">*</a> {{ __('Fecha') }}<span class="text-muted ml-1">{{ __('  (Obligatorio)') }}</span></label>
                                        <input type="date" class="form-control" id="date" name="date" value="{{ $expense->date }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="details">{{ __('Descripción') }}</label>
                                        <input type="text" class="form-control" id="description" value="{{ $expense_line->description }}" name="description" required>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="service">Categoria</label>
                                        <select class="custom-select d-block w-100" id="expense_category" name="expense_category_id" required>
                                            <option value="">{{ __('Seleccionar Categoria') }}</option>
                                            @foreach($expense_categories as $expense_category)
                                            <option value="{{ $expense_category->id }}" @if($expense_category->id === $expense_line->expense_category_id) selected @endif>{{ $expense_category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="amount">Monto</label>
                                        <input type="number" class="form-control" id="amount1" value="{{ $expense_line->amount }}" name="amount" required>
                                    </div>
                                </div>
                            </div> 

                            <hr class="mb-4">

                            <button class="btn btn-primary" type="submit">{{ __('Guardar') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('ps_scripts')
    <script>
        // Warning
        $(window).on('beforeunload', function(){
            return "Any changes will be lost";
        });
        // Form Submit
        $(document).on("submit", "form", function(event){
            // disable unload warning
            $(window).off('beforeunload');
        });
    </script>

@endsection

@push('form_scripts')

    <script>
        function {{ 'delete' . $expense->id . '()' }} {
            swal({
                title: "{{ __('Seguro que desea borrar el Gasto?') . ' ' . $expense->getNameValue() }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#f6993f',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Si, Borrar',
                cancelButtonText: "No, Cancelar"
            }).then((result) => {
                    if (result.value) {
                        event.preventDefault();
                        document.getElementById('{{ 'delete-record' . $expense->getRouteKey() }}').submit();
                    }
                }
            )
        }
    </script>

@endpush