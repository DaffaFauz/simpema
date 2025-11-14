<?php 

class ProdiModel{
    private $pdo;
    private $table = 'prodi';

    public function __construct(){
        $this->pdo = new Db();
    }

    public function getAll(){
        $this->pdo->query("SELECT * FROM {$this->table}");
        return $this->pdo->resultSet();
    }

    public function getAllProdi(){
        $this->pdo->query("SELECT * FROM  {$this->table} INNER JOIN fakultas ON {$this->table}.id_fakultas = fakultas.id_fakultas");
        return $this->pdo->resultSet();
    }


    public function add($data){
        $this->pdo->query("INSERT INTO {$this->table} (nama_prodi, id_fakultas) VALUES (:nama_prodi, :id_fakultas)");
        $this->pdo->bind('nama_prodi', $data['nama_prodi']);
        $this->pdo->bind('id_fakultas', $data['fakultas']);
        $this->pdo->execute();
        return $this->pdo->rowCount();
    }

    public function edit($data){
        $this->pdo->query("UPDATE {$this->table} SET nama_prodi = :nama_prodi, id_fakultas = :id_fakultas WHERE id_prodi = :id_prodi");
        $this->pdo->bind("nama_prodi", $data["nama_prodi"]);
        $this->pdo->bind("id_fakultas", $data["fakultas"]);
        $this->pdo->bind("id_prodi", $data["id_prodi"]);
        $this->pdo->execute();
        return $this->pdo->rowCount();
    }

    public function hapus($id){
        $this->pdo->query("DELETE FROM {$this->table} WHERE id_prodi = :id_prodi");
        $this->pdo->bind("id_prodi", $id['id_prodi']);
        $this->pdo->execute();
        return $this->pdo->rowCount();
    }


    public function getProdiByFakultasId($id_fakultas){
        $this->pdo->query("SELECT * FROM {$this->table} WHERE id_fakultas = :id_fakultas");
        $this->pdo->bind(':id_fakultas', $id_fakultas);
        return $this->pdo->resultSet();
    }
}