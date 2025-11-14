<?php 
class KaprodiModel{
    private $pdo;
    private $table = 'dosen';

    public function __construct(){
        $this->pdo = new Db();
    }

    public function getAll(){
        $this->pdo->query("SELECT * FROM {$this->table} INNER JOIN user ON {$this->table}.id_user = user.id_user INNER JOIN user_jabatan ON user.id_user = user_jabatan.id_user INNER JOIN prodi ON {$this->table}.id_prodi = prodi.id_prodi WHERE user_jabatan.id_jabatan = 3");
        return $this->pdo->resultSet();
    }

    public function dosen(){
        // Return dosen (lecturers) who are NOT kaprodi (id_jabatan = 3).
        // Use a NOT IN subquery to exclude any user who has the kaprodi role.
        // This avoids including users who also have other roles (which can happen
        // when joining directly to user_jabatan and filtering with != 3).
        $this->pdo->query("SELECT * FROM {$this->table} INNER JOIN user ON {$this->table}.id_user = user.id_user WHERE user.id_user NOT IN (SELECT id_user FROM user_jabatan WHERE id_jabatan = 3)");
        return $this->pdo->resultSet();
    }

    public function add($data){
        if(empty($data["dosen"])){
            return false;
        }
        
        // Validasi apakah id_user ada di tabel user
        $this->pdo->query("SELECT id_user FROM user WHERE id_user = :id_user");
        $this->pdo->bind(":id_user", $data["dosen"]);
        $userExists = $this->pdo->resultSet();
        
        if(empty($userExists)){
            return false;
        }
        
        try {
            $this->pdo->query("INSERT INTO user_jabatan (id_user, id_jabatan) VALUES (:id_user, 3)");
            $this->pdo->bind(":id_user", $data["dosen"]);
            $this->pdo->execute();
            return $this->pdo->rowCount();
        } catch(Exception $e){
            return false;
        }
    }

    public function lepas($id){
        $this->pdo->query("DELETE FROM user_jabatan WHERE id_user = :id_user AND id_jabatan = 3");
        $this->pdo->bind("id_user", $id["id_user"]);
        $this->pdo->execute();
        return $this->pdo->rowCount();
    }
}