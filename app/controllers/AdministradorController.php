<?php

class AdministradorController extends Controller {

    private $userModel;
    private $proveedorModel;
    private $insumoModel; // Añadimos la propiedad para el modelo Insumo
    private $ordenDeCompraModel;      // Añadimos propiedad
    private $detalleOrdenCompraModel; 
    private $pedidoModel;

    public function __construct() {
        // Cargar modelos
        $this->userModel = $this->model('Usuario');
        $this->proveedorModel = $this->model('Proveedor');
        $this->insumoModel = $this->model('Insumo');
        $this->ordenDeCompraModel = $this->model('OrdenDeCompra');
        $this->detalleOrdenCompraModel = $this->model('DetalleOrdenCompra');
        $this->pedidoModel = $this->model('Pedido');

        // --- Verificación de Seguridad ---
        if (!isset($_SESSION['idUsuario'])) {
            header('Location: ' . URLROOT . 'auth/index');
            exit();
        }

        if (!$this->userModel->verificarPermiso('Administrador')) {
            header('Location: ' . URLROOT . 'operario/dashboard');
            exit();
        }
    }

    public function index() {
        $this->dashboard();
    }
    
    public function dashboard() {
        // Cargar los modelos necesarios que no estén en el constructor
        $pedidoModel = $this->model('Pedido');
        
        // Obtener las estadísticas desde los modelos
        $totalInsumos = $this->insumoModel->contarTodos();
        $alertasStock = $this->insumoModel->contarBajoStock();
        $totalProveedores = $this->proveedorModel->contarTodos();
        $pedidosActivos = $pedidoModel->contarActivos();

        $data = [
            'title' => 'Dashboard Administrador',
            'totalInsumos' => $totalInsumos,
            'alertasStock' => $alertasStock,
            'totalProveedores' => $totalProveedores,
            'pedidosActivos' => $pedidosActivos
        ];
        
        $this->view('administrador/dashboard', $data);
    }

    public function gestionarProveedores() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'idProveedor' => isset($_POST['idProveedor']) ? trim($_POST['idProveedor']) : '',
                'nombre' => isset($_POST['nombre']) ? trim($_POST['nombre']) : '',
                'contacto' => isset($_POST['contacto']) ? trim($_POST['contacto']) : '',
                'email' => isset($_POST['email']) ? trim($_POST['email']) : ''
            ];

            switch ($_POST['action']) {
                case 'crear':
                    $this->proveedorModel->crear($data);
                    break;
                case 'editar':
                    $this->proveedorModel->actualizar($data);
                    break;
                case 'eliminar':
                    $this->proveedorModel->eliminar($data['idProveedor']);
                    break;
            }
            header('Location: ' . URLROOT . 'administrador/gestionarProveedores');
            exit();
        }

        $proveedores = $this->proveedorModel->obtenerTodos();
        $data = [
            'title' => 'Gestionar Proveedores',
            'proveedores' => $proveedores
        ];
        
        $this->view('administrador/gestionar_proveedores', $data);
    }


    /**
     * Gestiona el CRUD para Insumos.
     * Corresponde al Caso de Uso 1: Registrar nuevo insumo.
     */
    public function registrarInsumo() {
        // Si la solicitud es POST, procesar la acción
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'idInsumo' => isset($_POST['idInsumo']) ? trim($_POST['idInsumo']) : '',
                'nombre' => isset($_POST['nombre']) ? trim($_POST['nombre']) : '',
                'descripcion' => isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '',
                'tipo' => isset($_POST['tipo']) ? trim($_POST['tipo']) : '',
                'unidadMedida' => isset($_POST['unidadMedida']) ? trim($_POST['unidadMedida']) : '',
                'stockActual' => isset($_POST['stockActual']) ? trim($_POST['stockActual']) : 0,
                'stockMinimo' => isset($_POST['stockMinimo']) ? trim($_POST['stockMinimo']) : 0,
                'costo' => isset($_POST['costo']) ? trim($_POST['costo']) : 0.0
            ];

            switch ($_POST['action']) {
                case 'crear':
                    $this->insumoModel->crear($data);
                    break;
                case 'editar':
                    $this->insumoModel->actualizar($data);
                    break;
                case 'eliminar':
                    $this->insumoModel->eliminar($data['idInsumo']);
                    break;
            }
            header('Location: ' . URLROOT . 'administrador/registrarInsumo');
            exit();
        }

        // Si la solicitud es GET, mostrar la lista de insumos
        $insumos = $this->insumoModel->obtenerTodos();
        $data = [
            'title' => 'Gestionar Insumos',
            'insumos' => $insumos
        ];

        $this->view('administrador/registrar_insumo', $data);
    }
    public function definirStockMinimo() {
        // Si la solicitud es POST, procesar la actualización
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['stock_minimo']) && is_array($_POST['stock_minimo'])) {
                foreach ($_POST['stock_minimo'] as $idInsumo => $minimo) {
                    $this->insumoModel->actualizarStockMinimo((int)$idInsumo, (int)$minimo);
                }
            }
            header('Location: ' . URLROOT . 'administrador/definirStockMinimo');
            exit();
        }

        // Si es GET, mostrar la lista de insumos
        $insumos = $this->insumoModel->obtenerTodos();
        $data = [
            'title' => 'Definir Nivel de Stock Mínimo',
            'insumos' => $insumos
        ];
        $this->view('administrador/definir_stock_minimo', $data);
    }
    public function generarReporte() {
        $data = [
            'title' => 'Generar Reportes',
            'reporte_data' => null, // Inicialmente no hay datos
            'reporte_tipo' => ''
        ];

        // Si se solicita un reporte vía POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            switch ($_POST['tipo_reporte']) {
                case 'inventario_actual':
                    $data['reporte_data'] = $this->insumoModel->obtenerTodos();
                    $data['reporte_tipo'] = 'inventario_actual';
                    break;
                
                // Aquí se podrían añadir más casos para otros reportes en el futuro
                // case 'movimientos_rango_fechas':
                //     ...
                //     break;
            }
        }
        
        $this->view('administrador/generar_reporte', $data);
    }
    public function gestionarOrdenesCompra() {
        $ordenes = $this->ordenDeCompraModel->obtenerTodas();
        $data = [
            'title' => 'Gestionar Órdenes de Compra',
            'ordenes' => $ordenes
        ];
        $this->view('administrador/gestionar_ordenes_compra', $data);
    }
     public function crearOrdenCompra() {
        // Si la solicitud es POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // 1. Crear la cabecera de la orden
            $ordenData = [
                'idProveedor' => $_POST['idProveedor'],
                'fecha' => $_POST['fecha'],
                'estado' => 'Pendiente'
            ];
            $idOrdenCompra = $this->ordenDeCompraModel->crear($ordenData);

            // 2. Si la orden se creó, agregar los detalles
            if ($idOrdenCompra) {
                for ($i = 0; $i < count($_POST['insumos']); $i++) {
                    $detalleData = [
                        'idOrdenCompra' => $idOrdenCompra,
                        'idInsumo' => $_POST['insumos'][$i],
                        'cantidadSolicitada' => $_POST['cantidades'][$i],
                        'costoUnitario' => $_POST['costos'][$i]
                    ];
                    $this->detalleOrdenCompraModel->agregarInsumo($detalleData);
                }
            }
            header('Location: ' . URLROOT . 'administrador/gestionarOrdenesCompra');
            exit();
        }

        // Si es GET, preparar datos para el formulario
        $proveedores = $this->proveedorModel->obtenerTodos();
        $insumos = $this->insumoModel->obtenerTodos();
        $data = [
            'title' => 'Crear Nueva Orden de Compra',
            'proveedores' => $proveedores,
            'insumos' => $insumos
        ];
        $this->view('administrador/crear_orden_compra', $data);
    }

    /**
     * Muestra el detalle de una orden de compra específica.
     * @param int $id El ID de la orden de compra.
     */
    public function verDetalleOrden($id) {
        $orden = $this->ordenDeCompraModel->obtenerPorId($id);
        $detalles = $this->detalleOrdenCompraModel->obtenerPorOrdenId($id);

        $data = [
            'title' => 'Detalle de Orden de Compra #' . $id,
            'orden' => $orden,
            'detalles' => $detalles
        ];
        $this->view('administrador/ver_detalle_orden', $data);
    }

    public function gestionarPedidos() {
        // Si la solicitud es POST, procesar la creación del nuevo pedido
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'cliente' => trim($_POST['cliente']),
                'fecha' => trim($_POST['fecha']),
                'estado' => 'Registrado' // Estado inicial por defecto
            ];

            // Llamar al modelo para crear el pedido
            $this->pedidoModel->crear($data);
            
            // Redirigir a la misma página para ver la lista actualizada
            header('Location: ' . URLROOT . 'administrador/gestionarPedidos');
            exit();
        }

        // Si la solicitud es GET, mostrar la lista de todos los pedidos
        $pedidos = $this->pedidoModel->obtenerTodos();
        $data = [
            'title' => 'Gestionar Pedidos de Clientes',
            'pedidos' => $pedidos
        ];
        
        $this->view('administrador/gestionar_pedidos', $data);
    }
}