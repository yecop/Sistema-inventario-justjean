<?php require_once APPROOT . '../app/views/layouts/header.php'; ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?php echo $data['title']; ?></h3>
    </div>
    <div class="card-body">
        <p>Utiliza este formulario para añadir al inventario los insumos recibidos de un proveedor.</p>
        
        <form action="<?php echo URLROOT; ?>operario/registrarEntrada" method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="idInsumo" class="form-label">Seleccionar Insumo:</label>
                    <select name="idInsumo" id="idInsumo" class="form-select" required>
                        <option value="" disabled selected>-- Elige un insumo --</option>
                        <?php foreach($data['insumos'] as $insumo): ?>
                            <option value="<?php echo $insumo->idInsumo; ?>"><?php echo $insumo->nombre; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="cantidad" class="form-label">Cantidad Recibida:</label>
                    <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="idProveedor" class="form-label">Proveedor:</label>
                    <select name="idProveedor" id="idProveedor" class="form-select" required>
                        <option value="" disabled selected>-- Elige un proveedor --</option>
                        <?php foreach($data['proveedores'] as $proveedor): ?>
                            <option value="<?php echo $proveedor->idProveedor; ?>"><?php echo $proveedor->nombre; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-check me-2"></i>Registrar Entrada
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once APPROOT . '../app/views/layouts/footer.php'; ?>