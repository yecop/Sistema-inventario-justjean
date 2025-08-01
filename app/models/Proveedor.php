<?php

class Proveedor {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    /**
     * Obtiene todos los proveedores de la base de datos.
     * @return array Un array de objetos de proveedores.
     */
    public function obtenerTodos() {
        $this->db->query('SELECT * FROM proveedores ORDER BY nombre ASC');
        return $this->db->resultSet();
    }

    /**
     * Obtiene un proveedor por su ID.
     * @param int $id El ID del proveedor.
     * @return object El objeto del proveedor.
     */
    public function obtenerPorId($id) {
        $this->db->query('SELECT * FROM proveedores WHERE idProveedor = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Crea un nuevo proveedor en la base de datos.
     * Corresponde al método 'crear' del Diagrama de Clases.
     * @param array $data Datos del proveedor (nombre, contacto, email).
     * @return bool True si se creó correctamente, false en caso contrario.
     */
    public function crear($data) {
        $this->db->query('INSERT INTO proveedores (nombre, contacto, email) VALUES (:nombre, :contacto, :email)');
        
        // Vincular valores
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':contacto', $data['contacto']);
        $this->db->bind(':email', $data['email']);

        // Ejecutar
        return $this->db->execute();
    }

    /**
     * Actualiza un proveedor existente.
     * Corresponde al método 'actualizar' del Diagrama de Clases.
     * @param array $data Datos del proveedor a actualizar (id, nombre, contacto, email).
     * @return bool True si se actualizó correctamente, false en caso contrario.
     */
    public function actualizar($data) {
        $this->db->query('UPDATE proveedores SET nombre = :nombre, contacto = :contacto, email = :email WHERE idProveedor = :id');
        
        // Vincular valores
        $this->db->bind(':id', $data['idProveedor']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':contacto', $data['contacto']);
        $this->db->bind(':email', $data['email']);

        // Ejecutar
        return $this->db->execute();
    }

    /**
     * Elimina un proveedor de la base de datos.
     * @param int $id El ID del proveedor a eliminar.
     * @return bool True si se eliminó correctamente, false en caso contrario.
     */
    public function eliminar($id) {
        $this->db->query('DELETE FROM proveedores WHERE idProveedor = :id');
        $this->db->bind(':id', $id);
        
        // Ejecutar
        return $this->db->execute();
    }
    public function contarTodos() {
        $this->db->query('SELECT COUNT(*) as total FROM proveedores');
        return $this->db->single()->total;
    }
}