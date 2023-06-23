<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login del sistema</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- MATERIAL DESIGN ICONIC FONT -->
    <link rel="stylesheet" href="{{ asset('public/login/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css') }} ">
    <!-- STYLE CSS -->
    <link rel="stylesheet" href="{{ asset('public/login/css/style.css') }} ">

    <link rel="icon" href="{{ asset('public/img/iconos/iconologin.jpg') }} ">

</head>

<body>
    <div class="wrapper">
        <div class="image-holder">
            <img src="https://t4.ftcdn.net/jpg/04/60/71/01/360_F_460710131_YkD6NsivdyYsHupNvO3Y8MPEwxTAhORh.jpg" alt="">
        </div>
        <div class="form-inner">

            <form>

                <div class="form-header">
                    <h3> inicia sesión</h3>
                    <img src="images/sign-up.png" alt="" class="sign-up-icon">
                </div>

                <div class="m-12">
                    <div class="card text-center">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="myTab">
                                <li class="nav-item">
                                    <a href="#admi" class="nav-link active" data-bs-toggle="tab"><b>Login</b></a>
                                </li>
                                <li class="nav-item">
                                    <a href="#repar" class="nav-link" data-bs-toggle="tab"><b>Recuperar password</b></a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body" style="background: #001004;">
                            <div class="tab-content">

                                <div class="tab-pane fade show active" id="admi">

                                    <div class="alert alert-danger text-center" id="none_usu" style="color: white; display:none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
                                        <span> Ingrese un usuario para continuar</span>
                                    </div>

                                    <div class="alert alert-danger text-center" id="none_pass" style="color: white; display:none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
                                        <span> Ingrese un password para continuar</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Usuario:</label>
                                        <input autocomplete="off" type="text" class="form-control" id="usuario">
                                    </div>

                                    <div class="form-group">
                                        <label for="">Password:</label>
                                        <input autocomplete="off" type="password" class="form-control" id="password">
                                    </div>

                                    <div class="alert alert-danger text-center" id="error_logeo" style="color: white; display:none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
                                        <span> Usuario o contraseña incorrectos</span>
                                    </div>

                                    <button id="ingresar">Ingresar</button>

                                </div>

                                <div class="tab-pane fade" id="repar">

                                    <div class="alert alert-danger text-center" id="p_none_usu" style="color: white; display:none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
                                        <span> Ingrese un usuario para continuar</span>
                                    </div>

                                    <div class="alert alert-danger text-center" id="p_none_pass" style="color: white; display:none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
                                        <span> Ingrese un password para continuar</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Ingrese correo:</label>
                                        <input autocomplete="off" type="text" class="form-control" id="usuario_d">
                                    </div>

                                    @csrf

                                    <div class="alert alert-danger text-center" id="p_error_logeo" style="color: white; display:none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
                                        <span> Usuario o contraseña incorrectos</span>
                                    </div>

                                    <button id="entrar">Recuperar clave</button>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <br>

            </form>
        </div>

    </div>

    <script src="{{ asset('public/login/js/jquery-3.3.1.min.js') }} "></script>
    <script src="{{ asset('public/login/js/jquery.form-validator.min.js') }} "></script>
    <script src="{{ asset('public/login/js/main.js') }} "></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>

<script>
    $(document).on("click", "#ingresar", function(e) {
        e.preventDefault();
        var usuario = $("#usuario").val();
        var password = $("#password").val();
        var token = $('input[name="_token"]').val();

        if (parseInt(usuario.length) <= 0 || usuario == "") {
            $("#none_pass").hide();
            $("#none_usu").hide();
            $("#error_logeo").hide();
            $("#none_usu").show(2000);
        } else if (parseInt(password.length) <= 0 || password == "") {
            $("#none_usu").hide();
            $("#none_pass").hide();
            $("#error_logeo").hide();
            $("#none_pass").show(2000);
        } else {
            $("#none_usu").hide();
            $("#none_pass").hide();
            $("#error_logeo").hide();

            $.ajax({
                url: "{{ route('cursos.Credenciales') }}",
                type: "POST",
                data: {
                    usuario: usuario,
                    clave: password,
                    _token: token
                },
            }).done(function(responce) { 
                if (responce == 0) {
                    $("#none_usu").hide();
                    $("#none_pass").hide();
                    $("#error_logeo").hide();
                    $("#error_logeo").show(2000);
                    return false;
                } else {
                    var data = JSON.parse(responce);
                    if (data["estado"] == 0) {
                        Swal.fire({
                            icon: "error",
                            title: "Usuario inactivo",
                            text: "El usuario se encuentra inactivo!",
                        });
                    } else { 
                        $.ajax({
                            url: "{{ route('tokensession.Token') }}",
                            type: "POST",
                            data: {
                                token_session: data["id"],
                                _token: token
                            },
                        }).done(function(res) {

                            console.log(res);

                            if (res == 1) {
                                let timerInterval;
                                Swal.fire({
                                    title: "Bienvenido al sistema!",
                                    html: "Usted sera redireccionado en <b></b> mi.",
                                    allowOutsideClick: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: () => {
                                        Swal.showLoading();
                                        const b = Swal.getHtmlContainer().querySelector("b");
                                        timerInterval = setInterval(() => {
                                            b.textContent = Swal.getTimerLeft();
                                        }, 100);
                                    },
                                    willClose: () => {
                                        clearInterval(timerInterval);
                                    },
                                }).then((result) => {
                                    /* Read more about handling dismissals below */
                                    if (result.dismiss === Swal.DismissReason.timer) {
                                        location.reload();
                                    }
                                });
                            }
                        });
                    }
                }
            });
        }
    });
</script>