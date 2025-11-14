<?php 
class PembimbingModel {
    private $pdo;
    private $table = 'dosen';

    public function __construct(){
        $this->pdo = new Db();
    }

    public function getAll(){
        $this->pdo->query("SELECT * FROM {$this->table} INNER JOIN user ON {$this->table}.id_user = user.id_user INNER JOIN user_jabatan ON user.id_user = user_jabatan.id_user INNER JOIN prodi ON {$this->table}.id_prodi = prodi.id_prodi WHERE user_jabatan.id_jabatan = 2");
        return $this->pdo->resultSet();
    }

    public function dosen(){
       $this->pdo->query("SELECT * FROM {$this->table} INNER JOIN user ON {$this->table}.id_user = user.id_user WHERE user.id_user NOT IN (SELECT id_user FROM user_jabatan WHERE id_jabatan = 2)");
        return $this->pdo->resultSet();
    }

    public function add($data){
        $this->pdo->query("INSERT INTO user_jabatan (id_user, id_jabatan) VALUES (:id_user, 2)");
        $this->pdo->bind("id_user", $data['dosen']);
        $this->pdo->execute();
        return $this->pdo->rowCount();
    }

    public function lepas($data){
        $this->pdo->query("DELETE FROM user_jabatan WHERE id_user = :id_user");
        $this->pdo->bind('id_user', $data['id_user']);
        $this->pdo->execute();
        return $this->pdo->rowCount();
    }
}