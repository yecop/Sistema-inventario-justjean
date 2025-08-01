<?php require_once APPROOT . '../app/views/layouts/header.php'; ?>

<div class="card mb-4">
    <div class="card-header">
        <h3 class="mb-0"><?php echo $data['title']; ?></h3>
    </div>
    <div class="card-body">
        <form action="<?php echo URLROOT; ?>administrador/generarReporte" method="POST">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label for="tipo_reporte" class="form-label">Seleccione el tipo de reporte:</label>
                    <select name="tipo_reporte" id="tipo_reporte" class="form-select">
                        <option value="inventario_actual">Inventario Actual</option>
                        </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Generar Reporte</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php // Solo mostrar la sección de resultados si hay datos para el reporte ?>
<?php if (!empty($data['reporte_data'])) : ?>
<div class="card">
    <div class="card-header">
        <h4>Resultados del Reporte</h4>
    </div>
    <div class="card-body">
        <?php // Mostrar la tabla para el reporte de inventario actual ?>
        <?php if ($data['reporte_tipo'] == 'inventario_actual') : ?>
            <h5>Reporte de Inventario Actual</h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Insumo</th>
                            <th>Tipo</th>
                            <th class="text-center">Stock Actual</th>
                            <th class="text-center">Stock Mínimo</th>
                            <th class="text-end">Costo Unitario</th>
                            <th class="text-end">Valor Total del Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $valor_total_inventario = 0;
                            foreach($data['reporte_data'] as $insumo) : 
                            $valor_stock_insumo = $insumo->stockActual * $insumo->costo;
                            $valor_total_inventario += $valor_stock_insumo;
                        ?>
                            <tr>
                                <td><?php echo $insumo->nombre; ?></td>
                                <td><?php echo $insumo->tipo; ?></td>
                                <td class="text-center">
                                    <?php echo $insumo->stockActual; ?>
                                    <?php if($insumo->stockActual < $insumo->stockMinimo && $insumo->stockMinimo > 0) : ?>
                                        <i class="fa-solid fa-exclamation-triangle text-danger ms-2" title="Stock bajo"></i>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?php echo $insumo->stockMinimo; ?></td>
                                <td class="text-end">$<?php echo number_format($insumo->costo, 2); ?></td>
                                <td class="text-end">$<?php echo number_format($valor_stock_insumo, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="table-dark">
                            <td colspan="5" class="text-end fw-bold">Valor Total del Inventario</td>
                            <td class="text-end fw-bold">$<?php echo number_format($valor_total_inventario, 2); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>


<?php require_once APPROOT . '../app/views/layouts/footer.php'; ?>