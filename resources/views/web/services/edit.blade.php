@extends('web.layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap mb-2">
                <div>
                    <a class="h5"><i class="fas fa-palette"></i> {{ __('Editar Servicio:') . ' ' . $service->name }}</a>
                </div>
                <div>
                    <a href="{{ '/web/services/' . $service->getRouteKey() }}" class="btn btn-primary"><i class="fas fa-eye"></i> {{ __('Ver Servicio') }}</a>
                    <a href="/web/services" class="btn btn-outline-primary"><i class="fas fa-list"></i> {{ __('Lista') }}</a>
                    <a href="#" class="btn btn-outline-warning" onclick="{{ 'deactivate' . $service->id . '()' }}"><i class="fas fa-exclamation-triangle"></i></a>
                    <a href="#" class="btn btn-outline-danger" onclick="{{ 'delete' . $service->id . '()' }}"><i class="fas fa-trash"></i></a>
                    <form id="{{ 'delete-record' . $service->getRouteKey() }}" method="post" action="{{ '/web/services/' . $service->getRouteKey() }}">
                        <input name="_method" type="hidden" value="DELETE">
                        @csrf
                    </form>
                    <form id="{{ 'deactivate-record' . $service->getRouteKey() }}" method="post" action="{{ '/web/services/' . $service->getRouteKey() . '/inactivate' }}">
                        <input name="_method" type="hidden" value="PUT">
                        @csrf
                    </form>
                </div>
            </div>
            <form method="POST" action="{{ '/web/services/' . $service->getRouteKey() }}" enctype="multipart/form-data">
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
                                    <div class="col-md-4 mb-3">
                                        <label for="name"><a class="text-danger">*</a> {{ __('Nombre') }}<span class="text-muted ml-1">{{ __('  (Obligatorio)') }}</span></label>
                                        <input type="text" class="form-control" id="name" value="{{ $service->name }}" name="name" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="price"> {{ __('Precio Base') }}<span class="text-muted ml-1">{{ __('  (Opcional)') }}</span></label>
                                        <input type="numeric" class="form-control" id="price" name="price" value="{{ $service->price }}" required>
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
        function {{ 'delete' . $service->id . '()' }} {
            swal({
                title: "{{ __('Seguro que desea eliminar el servicio?') . ' ' . $service->getNameValue() }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#e84860',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Si, Borrar',
                cancelButtonText: "No, Cancelar"
            }).then((result) => {
                    if (result.value) {
                        event.preventDefault();
                        document.getElementById('{{ 'delete-record' . $service->getRouteKey() }}').submit();
                    }
                }
            )
        }
    </script>

    <script>
        function {{ 'deactivate' . $service->id . '()' }} {
            swal({
                title: "{{ __('Seguro que desea desactivar el servicio?') . ' ' . $service->getNameValue() }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#f6993f',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Si, Borrar',
                cancelButtonText: "No, Cancelar"
            }).then((result) => {
                    if (result.value) {
                        event.preventDefault();
                        document.getElementById('{{ 'deactivate-record' . $service->getRouteKey() }}').submit();
                    }
                }
            )
        }
    </script>

@endpush