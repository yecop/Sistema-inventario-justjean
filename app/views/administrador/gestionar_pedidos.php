<?php require_once APPROOT . '/app/views/layouts/header.php'; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0"><?php echo $data['title']; ?></h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
            <i class="fa-solid fa-plus me-2"></i>Crear Pedido
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center"># Pedido</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th class="text-center">Estado</th>
                        </tr>
                </thead>
                <tbody>
                    <?php foreach($data['pedidos'] as $pedido) : ?>
                        <tr>
                            <td class="text-center fw-bold"><?php echo $pedido->idPedido; ?></td>
                            <td><?php echo $pedido->cliente; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($pedido->fecha)); ?></td>
                            <td class="text-center"><span class="badge bg-success"><?php echo $pedido->estado; ?></span></td>
                            </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCrearLabel">Crear Nuevo Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo URLROOT; ?>administrador/gestionarPedidos" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cliente" class="form-label">Nombre del Cliente o Institución</label>
                        <input type="text" class="form-control" id="cliente" name="cliente" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha del Pedido</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Pedido</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php require_once APPROOT . '/app/views/layouts/footer.php'; ?>