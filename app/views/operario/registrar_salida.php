<?php require_once APPROOT . '../app/views/layouts/header.php'; ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?php echo $data['title']; ?></h3>
    </div>
    <div class="card-body">
        <p>Selecciona el insumo y la cantidad a descontar del inventario para asignarlo a un pedido específico.</p>
        
        <form action="<?php echo URLROOT; ?>operario/registrarSalida" method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="idInsumo" class="form-label">Seleccionar Insumo:</label>
                    <select name="idInsumo" id="idInsumo" class="form-select" required>
                        <option value="" disabled selected>-- Elige un insumo --</option>
                        <?php foreach($data['insumos'] as $insumo): ?>
                            <option value="<?php echo $insumo->idInsumo; ?>"><?php echo $insumo->nombre; ?> (Stock: <?php echo $insumo->stockActual; ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="cantidad" class="form-label">Cantidad a Descontar:</label>
                    <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="idPedido" class="form-label">Asignar al Pedido:</label>
                    <select name="idPedido" id="idPedido" class="form-select" required>
                        <option value="" disabled selected>-- Elige un pedido --</option>
                        <?php foreach($data['pedidos'] as $pedido): ?>
                            <option value="<?php echo $pedido->idPedido; ?>">Pedido #<?php echo $pedido->idPedido; ?> - <?php echo $pedido->cliente; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-danger">
                    <i class="fa-solid fa-arrow-up me-2"></i>Registrar Salida
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once APPROOT . '../app/views/layouts/footer.php'; ?>