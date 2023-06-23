@include('layout.header')

<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> </span>Editar rol <i class="bx bx-plus"></i></h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-12">

                    @if ($massage != "")
                    <div class="alert alert-{{$status}} alert-dismissible text-center" role="alert" style="font-size: 20px;">
                        {{ $massage }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Formulario editar rol</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('Rol.Update', ['valor' => 'Update' ]) }}" enctype="multipart/formdata">

                            @csrf

                            <input type="hidden" name="idrol" value="{{$values[0]}}" id="idrol">

                            <div class="mb-3">
                                <label class="form-label" for="nombre_rol_edit">Nombre del Rol</label>
                                <div class="input-group input-group-merge">
                                    <span id="nombre_rol_edit2" class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input autocomplete="off" value="{{$values[1]}}" required type="text" class="form-control" name="nombre_rol_edit" id="nombre_rol_edit" placeholder="Nombres del usuario" aria-label="Nombres del usuario" aria-describedby="nombre_rol_edit2">
                                </div>
                            </div>


                            @if ($booton)
                            <button type="submit" class="btn btn-primary">Guardar <i class="bx bx-save"></i></button> -
                            @endif
                            <a href="{{ route('Admin.Rol', ['valor' => 'Lista' ]) }}" class="btn btn-danger"> Volver</a>

                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@include('layout.footer')