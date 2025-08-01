<div class="bg-dark border-right" id="sidebar-wrapper">
    <div class="sidebar-heading text-light text-center py-4 fs-4">
        <i class="fa-solid fa-shirt me-2"></i>Creaciones Justean
    </div>
    <div class="list-group list-group-flush">
        
        <?php if(isset($_SESSION['rol'])) : ?>
            
            <?php // Menú para el Administrador ?>
            <?php if($_SESSION['rol'] == 'Administrador') : ?>
                <a href="<?php echo URLROOT ; ?>administrador/dashboard" class="list-group-item list-group-item-action bg-dark text-light"><i class="fa-solid fa-gauge-high me-2"></i>Dashboard</a>
                
                <div class="list-group-item bg-dark text-secondary small text-uppercase">Gestión de Inventario</div>
                <a href="<?php echo URLROOT ; ?>operario/registrarEntrada" class="list-group-item list-group-item-action bg-dark text-light"><i class="fa-solid fa-arrow-down me-2"></i>Registrar Entrada</a>
                <a href="<?php echo URLROOT ; ?>operario/registrarSalida" class="list-group-item list-group-item-action bg-dark text-light"><i class="fa-solid fa-arrow-up me-2"></i>Registrar Salida</a>
                <a href="<?php echo URLROOT ; ?>administrador/definirStockMinimo" class="list-group-item list-group-item-action bg-dark text-light"><i class="fa-solid fa-bell me-2"></i>Definir Stock Mínimo</a>
                
                <div class="list-group-item bg-dark text-secondary small text-uppercase">Catálogo y Pedidos</div>
                <a href="<?php echo URLROOT ; ?>administrador/registrarInsumo" class="list-group-item list-group-item-action bg-dark text-light"><i class="fa-solid fa-plus me-2"></i>Nuevos Insumos</a>
                <a href="<?php echo URLROOT; ?>administrador/gestionarPedidos" class="list-group-item list-group-item-action bg-dark text-light"><i class="fa-solid fa-clipboard-list me-2"></i>Gestionar Pedidos</a>
                <a href="<?php echo URLROOT ; ?>operario/vincularInsumoPedido" class="list-group-item list-group-item-action bg-dark text-light"><i class="fa-solid fa-link me-2"></i>Vincular a Pedido</a>

                <div class="list-group-item bg-dark text-secondary small text-uppercase">Administración</div>
                <a href="<?php echo URLROOT ; ?>administrador/gestionarProveedores" class="list-group-item list-group-item-action bg-dark text-light"><i class="fa-solid fa-truck-field me-2"></i>Proveedores</a>
                <a href="<?php echo URLROOT ; ?>administrador/generarReporte" class="list-group-item list-group-item-action bg-dark text-light"><i class="fa-solid fa-file-alt me-2"></i>Reportes</a>

            <?php // Menú para el Operario ?>
            <?php elseif($_SESSION['rol'] == 'Operario') : ?>
                <a href="<?php echo URLROOT ; ?>operario/dashboard" class="list-group-item list-group-item-action bg-dark text-light"><i class="fa-solid fa-gauge-high me-2"></i>Dashboard</a>
                
                <div class="list-group-item bg-dark text-secondary small text-uppercase">Operaciones</div>
                <a href="<?php echo URLROOT ; ?>operario/registrarEntrada" class="list-group-item list-group-item-action bg-dark text-light"><i class="fa-solid fa-arrow-down me-2"></i>Registrar Entrada</a>
                <a href="<?php echo URLROOT ; ?>operario/registrarSalida" class="list-group-item list-group-item-action bg-dark text-light"><i class="fa-solid fa-arrow-up me-2"></i>Registrar Salida</a>
                <a href="<?php echo URLROOT ; ?>operario/vincularInsumoPedido" class="list-group-item list-group-item-action bg-dark text-light"><i class="fa-solid fa-link me-2"></i>Vincular a Pedido</a>
            <?php endif; ?>

        <?php endif; ?>
    </div>
</div>