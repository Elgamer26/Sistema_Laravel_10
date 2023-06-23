@include('layout.header')

<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Lista de Roles <i class="bx bx-user"></i></h4>

        <!-- Basic Layout -->
        <div class="row">

            <div class="col-xl">
                <div class="card mb-12">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Lista de roles</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap text-center">

                            <table class="table">
                                <thead style=" background-color: rgba(105, 108, 255, 0.16); color: #6610f2;">
                                    <tr>
                                        <th>Nombres</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">


                                    @foreach($lista as $drug => $d)

                                    <tr>
                                        <td>{{ $d['rol'] }} </td>

                                        <td>
                                            @if($d['estado'] == 1)
                                            <strong> <span class="badge bg-label-success me-1">Activo</span> </strong>
                                            @else
                                            <strong> <span class="badge bg-label-danger me-1">Inactivo</span> </strong>
                                            @endif
                                        </td>

                                        <td>
                                        @if($d['id'] == 1)

                                            <strong> <span class="badge bg-label-success me-1">Rol adminitrador</span> </strong>
                                            @else
                                          <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('Rol.Editar', ['valor' => $d['id'] ]) }}"><i class="bx bx-edit-alt me-1"></i> Editar</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Eliminar</a>
                                                </div>
                                            </div>
                                            @endif
                                            
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                                <tfoot style="background: #696cff; background-color: rgba(105, 108, 255, 0.16); color: #6610f2;">
                                    <tr>
                                        <th>Nombres</th>
                                        <th>Estado</th>
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

    @include('layout.footer')