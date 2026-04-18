<?php 
// 1. Cargamos el CSS y el Menú Izquierdo
require_once '../../vistas/plantillas/cabecera.php'; 
require_once '../../vistas/plantillas/menu_lateral.php'; 
?>

<!-- Contenedor Principal Lado Derecho -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Div id="content" se abre aquí. El pie_pagina.php lo cierra. -->
    <div id="content">
        
        <?php 
        // 2. Cargamos la Barra Superior blanca
        require_once '../../vistas/plantillas/barra_superior.php'; 
        ?>

        <!-- INICIO DE TU CÓDIGO HTML ÚNICO -->
        <div class="container-fluid">

            <!-- Título de la Página -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Resumen Semanal</h1>
            </div>

            <!-- Fila de Tarjetas Informativas -->
            <div class="row">

                <!-- Tarjeta 1: Estudiantes -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Catequizandos Inscritos</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">150</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 2: Aulas -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Aulas Activas</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chalkboard fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- Cierre de la Fila -->

        </div>
        <!-- FIN DE TU CÓDIGO HTML ÚNICO -->

<?php 
// 3. Cargamos el Pie y los Archivos JS
require_once '../../vistas/plantillas/pie_pagina.php'; 
require_once '../../vistas/plantillas/scripts.php'; 
?>
