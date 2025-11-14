<?php 

class FakultasModel {
    private $pdo;
    private $table = 'fakultas';

    public function __construct(){
        $this->pdo = new Db();
    }

    public function getAll(){
        $this->pdo->query("SELECT * FROM {$this->table}");
        return $this->pdo->resultSet();
    }

    public function tambah($data){
        $this->pdo->query("INSERT INTO fakultas (nama_fakultas) VALUES (:nama_fakultas)");
        $this->pdo->bind('nama_fakultas', $data['nama_fakultas']);
        $this->pdo->execute();
        return $this->pdo->rowCount();
    }

    public function edit($data){
        $this->pdo->query("UPDATE {$this->table} SET nama_fakultas = :nama_fakultas WHERE id_fakultas = :id_fakultas");
        $this->pdo->bind('nama_fakultas', $data['nama_fakultas']);
        $this->pdo->bind('id_fakultas', $data['id_fakultas']);
        $this->pdo->execute();
        return $this->pdo->rowCount();
    }

    public function hapus($id){
        $this->pdo->query('DELETE FROM fakultas WHERE id_fakultas = :id_fakultas');
        $this->pdo->bind('id_fakultas', $id['id_fakultas']);
        $this->pdo->execute();
        return $this->pdo->rowCount();
    }

    public function getAllFakultas(){
        $this->pdo->query('SELECT * FROM fakultas');
        return $this->pdo->resultSet();
    }
}