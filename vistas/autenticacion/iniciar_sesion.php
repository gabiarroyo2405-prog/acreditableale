<?php

// 1. Cargamos el inicio del HTML y los CSS
require_once '../../vistas/plantillas/cabecera.php';

?>

<!-- Quitamos el color de fondo gris por defecto y agregamos el azul del tema -->
<body class="bg-gradient-primary">

    <div class="container">
        <!-- Fila Exterior -->
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Fila Interior -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">¡Bienvenido!</h1>
                                        <p class="mb-4 text-gray-600">Sistema de la Parroquia Sagrado Corazón de Jesús</p>
                                    </div>
                                    <form class="user" action="../../vistas/inicio/panel_control.php" method="POST">
                                        
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="usuarioLogin" placeholder="Nombre de Usuario">
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="passwordHash" placeholder="Contraseña">
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Ingresar al Sistema
                                        </button>

                                    </form>
                                </div>
                            </div>
                        </div> <!-- Fin Fila interior -->
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php

// 2. Cargamos los Scripts de Bootstrap
require_once '../../vistas/plantillas/scripts.php';

?>
