@include('layout.header')

<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> </span>Registro de usuario <i class="bx bx-plus"></i></h4>

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
                        <h5 class="mb-0">Formulario registro de usuario</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('registeruser.RegisterUser', ['valor' => 'Create' ]) }}" enctype="multipart/formdata">

                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="nombre_completos">Nombres</label>
                                <div class="input-group input-group-merge">
                                    <span id="nombre_completos2" class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input autocomplete="off" value="{{$values[0]}}" required type="text" class="form-control" name="nombre_completos" id="nombre_completos" placeholder="Nombres del usuario" aria-label="Nombres del usuario" aria-describedby="nombre_completos2">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="apellidos_completos">Apellidos</label>
                                <div class="input-group input-group-merge">
                                    <span id="apellidos_completos2" class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input autocomplete="off" value="{{$values[1]}}" required type="text" class="form-control" name="apellidos_completos" id="apellidos_completos" placeholder="Apellidos del usuario" aria-label="Apellidos del usuario" aria-describedby="apellidos_completos2">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="correo_usuario">Correo</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input autocomplete="off" value="{{$values[2]}}" required type="email" name="correo_usuario" id="correo_usuario" class="form-control" placeholder="Ingrese correo" aria-label="Ingrese correo" aria-describedby="correo_usuario2">
                                    <span id="correo_usuario2" class="input-group-text">@example.com</span>
                                </div>
                                <div class="form-text">Puedes usar letras, números y puntos</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="rol_user">Rol del usuario</label>
                                <div class="input-group input-group-merge"> 
                                    <select style="width: 100%;" name="rol_user" id="rol_user" class="form-control">

                                        @foreach ($rol as $user)
                                        @if ($user["estado"] == 1)
                                        <option value="{{ $user['id'] }}" @if($user["id"] == $values[5]) selected @endif>{{ $user["rol"] }}</option>
                                        @endif
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="usuario_completo">Usuario</label>
                                <div class="input-group input-group-merge">
                                    <span id="usuario_completo2" class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input autocomplete="off" value="{{$values[3]}}" required type="text" name="usuario_completo" class="form-control" id="usuario_completo" placeholder="Ingrese usuario" aria-label="Ingrese usuario" aria-describedby="usuario_completo2">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="passworduser">Password</label>
                                <div class="input-group input-group-merge">
                                    <span id="passworduser2" class="input-group-text"><i class="bx bx-key"></i></span>
                                    <input autocomplete="off" value="{{$values[4]}}" required type="text" class="form-control" name="passworduser" id="passworduser" placeholder="Ingrese usuario" aria-label="Ingrese usuario" aria-describedby="passworduser2">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="imagenuser">Foto</label>
                                <div class="input-group input-group-merge">
                                    <span id="imagenuser2" class="input-group-text"><i class="bx bx-photo"></i></span>
                                    <input type="file" id="imagenuser" class="form-control phone-mask" aria-describedby="imagenuser2">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar <i class="bx bx-save"></i></button> - <a href="{{ route('Admin.Usuario', ['valor' => 'Create' ]) }}" class="btn btn-danger"> Limpiar</a>

                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<!-- / Content -->

<script>
 
    document.getElementById("imagenuser").addEventListener("change", () => {
        var filename = document.getElementById("imagenuser").value;
        var idxdot = filename.lastIndexOf(".") + 1;
        var extfile = filename.substr(idxdot, filename.length).toLowerCase();
        if (extfile == "jpg" || extfile == "jpeg" || extfile == "png") {} else {
            swal.fire(
                "Mensaje de alerta",
                "Solo se aceptan imagenes - USTED SUBIO UN ARCHIVO CON LA EXTENCIO ." + extfile,
                "warning"
            );
            document.getElementById("imagenuser").value = "";
        }
    });
</script>

@include('layout.footer')

<script>
     $("#rol_user").select2();
</script>