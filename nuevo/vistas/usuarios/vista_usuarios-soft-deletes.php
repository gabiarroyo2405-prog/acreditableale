<?php 
/**
 * Archivo: vistas/usuarios/vista_usuarios-soft-deletes.php
 * Objetivo: Interfaz de usuario para la gestion de usuarios con entorno de Soft Delete (Borrado lógico)
 */

require_once '../../vistas/plantillas/cabecera.php'; 

// Ajuste educativo para el require explícito en los clones
require_once '../../modelos/Conexion.php';
require_once '../../modelos/UsuarioModelo-soft-deletes.php';
require_once '../../controladores/UsuarioControlador-soft-deletes.php';

use Controladores\UsuarioControladorSoftDeletes;

$controlador = new UsuarioControladorSoftDeletes();
$listaUsuarios = $controlador->obtenerLista();

require_once '../../vistas/plantillas/menu_lateral.php'; 
?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once '../../vistas/plantillas/barra_superior.php'; ?>

        <div class="container-fluid">

            <!-- BLOQUE DE NOTIFICACIONES ADAPTADOS AL SOFT DELETE -->
            <?php if (isset($_GET['exito'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Datos guardados correctamente en la base de datos.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                </div>
            <?php elseif (isset($_GET['editado'])): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    ✏️ ¡Usuario actualizado correctamente!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                </div>
            <?php elseif (isset($_GET['desactivado'])): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    🚫 Usuario desactivado. Sus datos se conservan de forma segura en el sistema.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                </div>
            <?php elseif (isset($_GET['reactivado'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ✅ Usuario reactivado correctamente.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                </div>                
            <?php elseif (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Hubo un problema al procesar la peticion. Verifique los datos o la conexion.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                </div>
            <?php endif; ?>

            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Administracion de Usuarios (Soft Deletes Mode)</h1>
                <button class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#modalNuevoUsuario">
                    <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Nuevo Usuario
                </button>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Usuarios Activos en el Sistema (<?php echo count($listaUsuarios); ?>)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre Completo</th>
                                    <th>Usuario (Login)</th>
                                    <th>Rol</th>
                                    <th>Estado Activo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($listaUsuarios)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No se encontraron registros activos.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($listaUsuarios as $usuario): ?>
                                        <tr>
                                            <td><?php echo $usuario['idUsuario']; ?></td>
                                            <td><?php echo htmlspecialchars($usuario['nombreCompleto']); ?></td>
                                            <td><?php echo htmlspecialchars($usuario['usuarioLogin']); ?></td>
                                            <td><span class="badge badge-info"><?php echo htmlspecialchars($usuario['rol']); ?></span></td>
                                            <td><span class="badge badge-success">Activo</span></td>
                                            <td>
                                                <!-- Boton para Editar -->
                                                <button class="btn btn-warning btn-sm btn-editar" title="Editar"
                                                        data-id="<?php echo $usuario['idUsuario']; ?>"
                                                        data-nombre="<?php echo htmlspecialchars($usuario['nombreCompleto']); ?>"
                                                        data-rol="<?php echo htmlspecialchars($usuario['rol']); ?>"
                                                        data-login="<?php echo htmlspecialchars($usuario['usuarioLogin']); ?>"
                                                        data-toggle="modal"
                                                        data-target="#modalEditarUsuario">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                
                                                <!-- Boton para Desactivar (Soft Delete) -->
                                                <button class="btn btn-secondary btn-sm btn-desactivar" title="Desactivar Logicamentee"
                                                        data-id="<?php echo $usuario['idUsuario']; ?>"
                                                        data-nombre="<?php echo htmlspecialchars($usuario['nombreCompleto']); ?>"
                                                        data-toggle="modal"
                                                        data-target="#modalConfirmarDesactivar">
                                                    <i class="fas fa-user-slash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div> <!-- Fin de container-fluid -->

        <!-- MODAL PARA NUEVO USUARIO -->
        <div class="modal fade" id="modalNuevoUsuario" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Registrar Nuevo Usuario</h5>
                        <button class="close text-white" type="button" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <!-- Acción modificada para apuntar al controlador clonado -->
                    <form action="../../controladores/UsuarioControlador-soft-deletes.php" method="POST">
                        <input type="hidden" name="accion" value="guardar">
                        <div class="modal-body">
                            <div class="form-group"><label>Nombre y Apellido</label><input type="text" name="nombreCompleto" class="form-control" required></div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0"><label>Usuario (Login)</label><input type="text" name="usuarioLogin" class="form-control" required></div>
                                <div class="col-sm-6"><label>Contrasena</label><input type="password" name="passwordHash" class="form-control" required></div>
                            </div>
                            <div class="form-group">
                                <label>Rol en la Parroquia</label>
                                <select name="rol" class="form-control" required>
                                    <option value="Coordinador">Coordinador</option>
                                    <option value="Secretaria">Secretaria</option>
                                    <option value="Tesorera">Tesorera</option>
                                    <option value="Parroco">Parroco</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODAL PARA EDITAR USUARIO -->
        <div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title"><i class="fas fa-user-edit mr-2"></i>Editar Usuario</h5>
                        <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <form action="../../controladores/UsuarioControlador-soft-deletes.php" method="POST">
                        <input type="hidden" name="accion" value="actualizar">
                        <input type="hidden" name="idUsuario" id="editIdUsuario">
                        <div class="modal-body">
                            <div class="form-group"><label>Nombre y Apellido</label><input type="text" name="nombreCompleto" id="editNombre" class="form-control" required></div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0"><label>Usuario</label><input type="text" name="usuarioLogin" id="editLogin" class="form-control" required></div>
                                <div class="col-sm-6">
                                    <label>Rol</label>
                                    <select name="rol" id="editRol" class="form-control" required>
                                        <option value="Coordinador">Coordinador</option>
                                        <option value="Secretaria">Secretaria</option>
                                        <option value="Tesorera">Tesorera</option>
                                        <option value="Parroco">Parroco</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer"><button class="btn btn-warning" type="submit">Guardar</button></div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- MODAL CONFIRMAR DESACTIVACIÓN (SOFT DELETE) -->
        <div class="modal fade" id="modalConfirmarDesactivar" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-secondary text-white">
                        <h5 class="modal-title"><i class="fas fa-user-slash mr-2"></i>Desactivar Usuario</h5>
                        <button class="close text-white" type="button" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    
                    <div class="modal-body text-center">
                        <p class="mb-1">¿Deseas desactivar al usuario:</p>
                        <strong id="nombreADesactivar" class="d-block my-2 h5 text-secondary"></strong>
                        <small class="text-muted">El usuario no podrá iniciar sesión, pero los datos seguirán íntegros.</small>
                    </div>

                    <!-- Enrutado a soft-deletes -->
                    <form action="../../controladores/UsuarioControlador-soft-deletes.php" method="POST">
                        <input type="hidden" name="accion" value="desactivar">
                        <input type="hidden" name="idUsuario" id="desactivarIdUsuario">
                        <div class="modal-footer justify-content-center">
                            <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancelar</button>
                            <button class="btn btn-secondary" type="submit"><i class="fas fa-user-slash mr-1"></i> Desactivar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.btn-editar').forEach(function(boton) {
            boton.addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                var nombre = this.getAttribute('data-nombre');
                var rol = this.getAttribute('data-rol');
                var login = this.getAttribute('data-login');

                document.getElementById('editIdUsuario').value = id;
                document.getElementById('editNombre').value = nombre;
                document.getElementById('editLogin').value = login;

                var selectRol = document.getElementById('editRol');
                for (var i = 0; i < selectRol.options.length; i++) {
                    if (selectRol.options[i].value === rol) { selectRol.selectedIndex = i; break; }
                }
            });
        });

        // Logica para rellenar modal de Soft Delete
        document.querySelectorAll('.btn-desactivar').forEach(function(boton) {
            boton.addEventListener('click', function() {
                document.getElementById('desactivarIdUsuario').value = this.getAttribute('data-id');
                document.getElementById('nombreADesactivar').textContent = this.getAttribute('data-nombre');
            });
        });
    });
</script>

<?php 
require_once '../../vistas/plantillas/pie_pagina.php'; 
require_once '../../vistas/plantillas/scripts.php'; 
?>
