@include('layout.header')

<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Lista Usuarios <i class="bx bx-user"></i></h4>

        <!-- Basic Layout -->
        <div class="row">

            <div class="col-xl">
                <div class="card mb-12">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Lista de usuario</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap text-center">

                            <table class="table">
                                <thead style=" background-color: rgba(105, 108, 255, 0.16); color: #6610f2;">
                                    <tr>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Correo</th>
                                        <th>Usuario</th>
                                        <th>Estado</th>
                                        <th>Rol</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">


                                    @foreach($lista as $drug => $d)

                                    <tr>
                                        <td>{{ $d['nombre'] }} </td>
                                        <td>{{ $d['apellidos'] }}</td>
                                        <td>{{ $d['correo'] }}</td>
                                        <td>{{ $d['usuario'] }}</td>
                                        <td>
                                            @if($d['rol_id'] == 1)
                                            <strong> <span class="badge bg-label-success me-1">{{ $d['rol'] }}</span> </strong>
                                            @else
                                            <strong> <span class="badge bg-label-warning me-1">{{ $d['rol'] }}</span> </strong>
                                            @endif
                                        </td>

                                        <td>
                                            @if($d['estado'] == 1)
                                            <strong> <span class="badge bg-label-success me-1">Activo</span> </strong>
                                            @else
                                            <strong> <span class="badge bg-label-danger me-1">Inactivo</span> </strong>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('User.Editar', ['valor' => $d['id'] ]) }}"><i class="bx bx-edit-alt me-1"></i> Editar</a>

                                                    @if($d['estado'] == 1)
                                                    <a class="dropdown-item" onclick="DesactivarUsuario({{ $d['id'] }}, 0);"><i class="bx bx-trash me-1"></i> Desactivar</a>
                                                    @else
                                                    <a class="dropdown-item" onclick="DesactivarUsuario({{ $d['id'] }}, 1);"><i class="bx bx-trash me-1"></i> Activar</a>
                                                    @endif


                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                                <tfoot style="background: #696cff; background-color: rgba(105, 108, 255, 0.16); color: #6610f2;">
                                    <tr>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Correo</th>
                                        <th>Usuario</th>
                                        <th>Estado</th>
                                        <th>Rol</th>
                                        <th>Acción</th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- / Content -->
    @include('layout.footer')

    <script>
        function DesactivarUsuario(id, estado) {
            var res = "";
            if (estado == 1) {
                res = "activo";
            } else {
                res = "inactivo";
            }

            Swal.fire({
                title: "Cambiar estado?",
                text: "El estado del usuario se cambiara!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, cambiar!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('Usuario.EstadoUsuario') }}",
                        data: {
                            id: id,
                            estado: estado,
                            _token: token
                        },
                        success: function(response) {
                            if (response > 0) {
                                if (response == 1) {

                                    return Swal.fire({
                                        title: 'Estado',
                                        text: "EL estado se " + res + " con extio",
                                        icon: 'success',
                                        showCancelButton: false,
                                        allowOutsideClick: false,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Ok!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    })

                                }
                            } else {
                                return Swal.fire(
                                    "Estado",
                                    "No se pudo cambiar el estado, error en la matrix",
                                    "error"
                                );
                            }
                        },
                    });
                }
            });
        }
    </script>