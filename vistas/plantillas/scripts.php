    <!-- Botón flotante para subir -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Modal Base para Cerrar Sesión -->
    <div class="modal fade" id="modalCerrarSesion" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¿Listo para salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecciona "Cerrar Sesión" abajo si estás listo para terminar tu sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <!-- Más adelante este href apuntará al controlador -->
                    <a class="btn btn-primary" href="../../vistas/autenticacion/iniciar_sesion.php">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Archivos JavaScript Base -->
    <script src="../../recursos/librerias/jquery/jquery.min.js"></script>
    <script src="../../recursos/librerias/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../recursos/librerias/jquery-easing/jquery.easing.min.js"></script>
    
    <!-- Scripts Propios del Tema -->
    <script src="../../recursos/js/sb-admin-2.min.js"></script>
</body>
</html>
