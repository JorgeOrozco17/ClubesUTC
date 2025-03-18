<?php
include_once __DIR__ . '/../Core/dbconexion.php';

class ClubModel {
    private $db;

    public function __construct() {
        $database = new Connection();
        $this->db = $database->open();
    }

    public function obtenerClubPorId($id) {
        $sql = $this->db->prepare("SELECT * FROM club WHERE id = ?");
        $sql->execute([$id]);
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarClub($id, $nombre, $ubicacion, $titular, $status) {
        $sql = $this->db->prepare("UPDATE club SET nombre = ?, ubicacion = ?, titular = ?, status = ? WHERE id = ?");
        return $sql->execute([$nombre, $ubicacion, $titular, $status, $id]);
    }

    public function eliminarClub($id) {
        $sql = $this->db->prepare("DELETE FROM club WHERE id = ?");
        return $sql->execute([$id]);
    }

    public function registrarClub($nombre, $titular, $ubicacion, $status){
        $sql = $this->db->prepare("INSERT INTO club (nombre, titular, ubicacion, status) VALUE(?, ?, ?, ?)");
        return $sql->execute([$nombre, $titular, $ubicacion, $status]);
    }
        
}
