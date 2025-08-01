<?php require_once APPROOT . '../app/views/layouts/header.php'; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0"><?php echo $data['title']; ?></h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
            <i class="fa-solid fa-plus me-2"></i>Crear Insumo
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Stock Actual</th>
                        <th>Stock Mínimo</th>
                        <th>Unidad</th>
                        <th>Costo Unitario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['insumos'] as $insumo) : ?>
                        <tr>
                            <td><?php echo $insumo->nombre; ?></td>
                            <td><?php echo $insumo->tipo; ?></td>
                            <td>
                                <?php echo $insumo->stockActual; ?>
                                <?php if($insumo->stockActual < $insumo->stockMinimo && $insumo->stockMinimo > 0) : ?>
                                    <i class="fa-solid fa-exclamation-triangle text-danger ms-2" title="Stock bajo"></i>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $insumo->stockMinimo; ?></td>
                            <td><?php echo $insumo->unidadMedida; ?></td>
                            <td>$<?php echo number_format($insumo->costo, 2); ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar" 
                                        data-id="<?php echo $insumo->idInsumo; ?>" 
                                        data-nombre="<?php echo htmlspecialchars($insumo->nombre); ?>"
                                        data-descripcion="<?php echo htmlspecialchars($insumo->descripcion); ?>"
                                        data-tipo="<?php echo htmlspecialchars($insumo->tipo); ?>"
                                        data-unidad="<?php echo htmlspecialchars($insumo->unidadMedida); ?>"
                                        data-stockactual="<?php echo $insumo->stockActual; ?>"
                                        data-stockminimo="<?php echo $insumo->stockMinimo; ?>"
                                        data-costo="<?php echo $insumo->costo; ?>">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalEliminar"
                                        data-id="<?php echo $insumo->idInsumo; ?>">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCrear" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crear Nuevo Insumo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo URLROOT; ?>administrador/registrarInsumo" method="POST">
                <input type="hidden" name="action" value="crear">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion" rows="2"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipo (Tela, Hilo, Botón, etc.)</label>
                            <input type="text" class="form-control" name="tipo" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Unidad de Medida (Metros, Unidades)</label>
                            <input type="text" class="form-control" name="unidadMedida" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock Inicial</label>
                            <input type="number" class="form-control" name="stockActual" value="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock Mínimo</label>
                            <input type="number" class="form-control" name="stockMinimo" value="0" required>
                        </div>
                    </div>
                     <div class="mb-3">
                        <label class="form-label">Costo Unitario</label>
                        <input type="number" step="0.01" class="form-control" name="costo" value="0.00" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Insumo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo URLROOT; ?>administrador/registrarInsumo" method="POST">
                <input type="hidden" name="action" value="editar">
                <input type="hidden" id="edit_id" name="idInsumo">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" id="edit_descripcion" name="descripcion" rows="2"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipo</label>
                            <input type="text" class="form-control" id="edit_tipo" name="tipo" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Unidad de Medida</label>
                            <input type="text" class="form-control" id="edit_unidad" name="unidadMedida" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock Actual</label>
                            <input type="number" class="form-control" id="edit_stockactual" name="stockActual" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock Mínimo</label>
                            <input type="number" class="form-control" id="edit_stockminimo" name="stockMinimo" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Costo Unitario</label>
                        <input type="number" step="0.01" class="form-control" id="edit_costo" name="costo" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Insumo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo URLROOT; ?>administrador/registrarInsumo" method="POST">
                <input type="hidden" name="action" value="eliminar">
                <input type="hidden" id="delete_id_insumo" name="idInsumo">
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este insumo? Se eliminará de forma permanente.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalEditar = document.getElementById('modalEditar');
    if (modalEditar) {
        modalEditar.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const insumoData = {
                id: button.getAttribute('data-id'),
                nombre: button.getAttribute('data-nombre'),
                descripcion: button.getAttribute('data-descripcion'),
                tipo: button.getAttribute('data-tipo'),
                unidad: button.getAttribute('data-unidad'),
                stockactual: button.getAttribute('data-stockactual'),
                stockminimo: button.getAttribute('data-stockminimo'),
                costo: button.getAttribute('data-costo')
            };

            modalEditar.querySelector('#edit_id').value = insumoData.id;
            modalEditar.querySelector('#edit_nombre').value = insumoData.nombre;
            modalEditar.querySelector('#edit_descripcion').value = insumoData.descripcion;
            modalEditar.querySelector('#edit_tipo').value = insumoData.tipo;
            modalEditar.querySelector('#edit_unidad').value = insumoData.unidad;
            modalEditar.querySelector('#edit_stockactual').value = insumoData.stockactual;
            modalEditar.querySelector('#edit_stockminimo').value = insumoData.stockminimo;
            modalEditar.querySelector('#edit_costo').value = insumoData.costo;
        });
    }

    const modalEliminar = document.getElementById('modalEliminar');
    if(modalEliminar) {
        modalEliminar.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            modalEliminar.querySelector('#delete_id_insumo').value = id;
        });
    }
});
</script>

<?php require_once APPROOT . '../app/views/layouts/footer.php'; ?>