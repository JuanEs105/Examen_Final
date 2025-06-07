<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Producto.php';

class ProductoController {
    private $db;
    private $producto;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->producto = new Producto($this->db);
    }

    public function index() {
        $stmt = $this->producto->read();
        $productos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $productos[] = $row;
        }
        include __DIR__ . '/../views/from_producto.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->producto->nombre = $_POST['nombre'];
            $this->producto->cantidad = $_POST['cantidad'];
            $this->producto->precio_unitario = $_POST['precio_unitario'];

            if ($this->producto->create()) {
                header("Location: index.php?action=list"); 
                exit();
            } else {
                echo "<p >Error al registrar el producto.</p>";
            }
        }
       
        include __DIR__ . 'index.html';
    }
}
?>