@include('layout.header')

<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> </span>Registro de rol <i class="bx bx-plus"></i></h4>

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
                        <h5 class="mb-0">Formulario registro de rol</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('registerrol.RegisterRol', ['valor' => 'Create' ]) }}" enctype="multipart/formdata">

                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="nombre_rol">Rol de usuario</label>
                                <div class="input-group input-group-merge">
                                    <span id="nombre_rol" class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input maxlength="50" autocomplete="off" value="{{$values[0]}}" required type="text" class="form-control" name="nombre_rol" id="nombre_rol" placeholder="Nombres del rol">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar <i class="bx bx-save"></i></button> - <a href="{{ route('Admin.Rol', ['valor' => 'Create' ]) }}" class="btn btn-danger"> Limpiar</a>

                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>


@include('layout.footer')