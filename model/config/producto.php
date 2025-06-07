<?php

class Producto {
    private $conn;
    private $table_name = "productos";

    public $id;
    public $nombre;
    public $cantidad;
    public $precio_unitario;

    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre, cantidad=:cantidad, precio_unitario=:precio_unitario";
        $stmt = $this->conn->prepare($query);

        
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->cantidad = htmlspecialchars(strip_tags($this->cantidad));
        $this->precio_unitario = htmlspecialchars(strip_tags($this->precio_unitario));

        
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":cantidad", $this->cantidad);
        $stmt->bindParam(":precio_unitario", $this->precio_unitario);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    
    public function read() {
        $query = "SELECT id, nombre, cantidad, precio_unitario FROM " . $this->table_name . " ORDER BY nombre ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>