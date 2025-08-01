<?php

class OperarioController extends Controller {
private $insumoModel;
    private $movimientoInventarioModel;
    private $proveedorModel;
    private $pedidoModel;
     public function __construct() {
        // --- Verificación de Seguridad ---
        if (!isset($_SESSION['idUsuario'])) {
            header('Location: ' . URLROOT . 'auth/index');
            exit();
        }

        // Cargar los modelos necesarios para las operaciones
        $this->insumoModel = $this->model('Insumo');
        $this->movimientoInventarioModel = $this->model('MovimientoInventario');
        $this->proveedorModel = $this->model('Proveedor');
        $this->pedidoModel = $this->model('Pedido');
    }

    /**
     * Método principal que carga el dashboard del operario.
     */
    public function index() {
        $this->dashboard();
    }

    public function dashboard() {
        $data = [
            'title' => 'Dashboard Operario'
        ];
        
        $this->view('operario/dashboard', $data);
    }
    
    /**
     * Carga la vista para registrar una nueva entrada de insumos.
     * Corresponde al Caso de Uso 2.
     */
    public function registrarEntrada() {
        // Si la solicitud es POST, procesar el formulario
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'idInsumo' => trim($_POST['idInsumo']),
                'cantidad' => trim($_POST['cantidad']),
                'idProveedor' => trim($_POST['idProveedor']),
                'idUsuario' => $_SESSION['idUsuario'],
                'tipoMovimiento' => 'entrada',
                'idPedido' => null,      // No aplica para entradas
                'idOrdenCompra' => null // Se puede extender para vincular a una OC
            ];

            // 1. Actualizar el stock del insumo
            if ($this->insumoModel->actualizarStock($data['idInsumo'], $data['cantidad'])) {
                // 2. Registrar el movimiento en el historial
                $this->movimientoInventarioModel->registrar($data);
            }
            
            header('Location: ' . URLROOT . 'operario/registrarEntrada');
            exit();
        }

        // Si es GET, preparar los datos para el formulario
        $insumos = $this->insumoModel->obtenerTodos();
        $proveedores = $this->proveedorModel->obtenerTodos();
        
        $data = [
            'title' => 'Registrar Entrada de Insumos',
            'insumos' => $insumos,
            'proveedores' => $proveedores
        ];
        $this->view('operario/registrar_entrada', $data);
    }

    /**
     * Carga la vista para registrar una salida de insumos para un pedido.
     * Corresponde al Caso de Uso 3.
     */
    public function registrarSalida() {
        // Si la solicitud es POST, procesar el formulario
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'idInsumo' => trim($_POST['idInsumo']),
                'cantidad' => trim($_POST['cantidad']),
                'idPedido' => trim($_POST['idPedido']),
                'idUsuario' => $_SESSION['idUsuario'],
                'tipoMovimiento' => 'salida',
                'idOrdenCompra' => null // No aplica para salidas
            ];

            // 1. Verificar si hay stock suficiente
            if ($this->insumoModel->verificarDisponibilidad($data['idInsumo'], $data['cantidad'])) {
                // 2. Si hay stock, actualizar (restando la cantidad)
                if ($this->insumoModel->actualizarStock($data['idInsumo'], -$data['cantidad'])) {
                    // 3. Registrar el movimiento en el historial
                    $this->movimientoInventarioModel->registrar($data);
                }
            } else {
                // Manejar el error de stock insuficiente (se puede implementar con mensajes flash)
                // Por ahora, simplemente no hacemos nada y redirigimos.
            }
            
            header('Location: ' . URLROOT . 'operario/registrarSalida');
            exit();
        }
        
        // Si es GET, preparar los datos para el formulario
        $insumos = $this->insumoModel->obtenerTodos();
        $pedidos = $this->pedidoModel->obtenerTodos(); // Usaremos un método del nuevo modelo
        
        $data = [
            'title' => 'Registrar Salida de Insumos',
            'insumos' => $insumos,
            'pedidos' => $pedidos
        ];
        $this->view('operario/registrar_salida', $data);
    }

    /**
     * Carga la vista para vincular insumos a un pedido existente.
     * Corresponde al Caso de Uso 5.
     */
    public function vincularInsumoPedido() {
        // Si la solicitud es POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idPedido = trim($_POST['idPedido']);
            $idInsumo = trim($_POST['idInsumo']);
            $cantidad = trim($_POST['cantidad']);

            // Llama al método del modelo Pedido para crear la asociación
            $this->pedidoModel->asignarInsumo($idPedido, $idInsumo, $cantidad);
            
            header('Location: ' . URLROOT . 'operario/vincularInsumoPedido');
            exit();
        }
        
        // Si es GET, preparar los datos para el formulario
        $insumos = $this->insumoModel->obtenerTodos();
        $pedidos = $this->pedidoModel->obtenerTodos();
        
        $data = [
            'title' => 'Vincular Insumos a Pedido',
            'insumos' => $insumos,
            'pedidos' => $pedidos
        ];
        $this->view('operario/vincular_insumo_pedido', $data);
    }
}