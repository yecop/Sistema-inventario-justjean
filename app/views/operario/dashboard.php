<?php require_once APPROOT  . '../app/views/layouts/header.php'; ?>

<h1 class="mb-4"><?php echo $data['title']; ?></h1>
<p>Bienvenido al panel de operaciones. Selecciona una tarea para comenzar.</p>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card text-center h-100">
            <div class="card-body d-flex flex-column justify-content-center">
                <i class="fas fa-arrow-down fa-3x mb-3 text-success"></i>
                <h5 class="card-title">Registrar Entrada</h5>
                <p class="card-text">Registra nuevos insumos recibidos de un proveedor.</p>
                <a href="<?php echo URLROOT ; ?>operario/registrarEntrada" class="btn btn-success mt-auto">Iniciar</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-center h-100">
            <div class="card-body d-flex flex-column justify-content-center">
                <i class="fas fa-arrow-up fa-3x mb-3 text-danger"></i>
                <h5 class="card-title">Registrar Salida</h5>
                <p class="card-text">Descuenta insumos del inventario para una orden de producción.</p>
                <a href="<?php echo URLROOT ; ?>operario/registrarSalida" class="btn btn-danger mt-auto">Iniciar</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-center h-100">
            <div class="card-body d-flex flex-column justify-content-center">
                <i class="fas fa-link fa-3x mb-3 text-info"></i>
                <h5 class="card-title">Vincular a Pedido</h5>
                <p class="card-text">Asigna insumos específicos a un pedido de cliente.</p>
                <a href="<?php echo URLROOT ; ?>operario/vincularInsumoPedido" class="btn btn-info mt-auto">Iniciar</a>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT  . '../app/views/layouts/footer.php'; ?>