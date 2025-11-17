<?php 

class UserModel {
    private $pdo;
    private $table = 'user';

    public function __construct() {
        $this->pdo = new DB();
    }

    public function login($data) {
        try {
            
            $query = "SELECT `user`.*, user_jabatan.id_jabatan, jabatan.nama_jabatan FROM `{$this->table}` LEFT JOIN user_jabatan ON `user`.id_user = user_jabatan.id_user LEFT JOIN jabatan ON user_jabatan.id_jabatan = jabatan.id_jabatan WHERE `user`.username = :email LIMIT 1";
            $this->pdo->query($query);
            $this->pdo->bind(':email', $data['email']);
            $user = $this->pdo->single();

            // Cek validasi username dan password
            if($user && password_verify($data['password'], $user['password'])) {
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['nama'] = $user['name'];
                $_SESSION['role'] = $user['nama_jabatan'];

                // Get all jabatan for this user
                $queryJabatan = "SELECT jabatan.id_jabatan, nama_jabatan FROM user_jabatan INNER JOIN jabatan ON user_jabatan.id_jabatan = jabatan.id_jabatan WHERE user_jabatan.id_user = :id_user";
                $this->pdo->query($queryJabatan);
                $this->pdo->bind('id_user', $user['id_user']);
                $jabatanList = $this->pdo->resultSet();
                $_SESSION['jabatan_list'] = $jabatanList;
                $_SESSION['jumlah_jabatan'] = count($jabatanList);
                
                // Mendapatkan data user dari database
                $query = "SELECT nama, id_prodi, nidn FROM dosen WHERE id_user = :id_user";
                $this->pdo->query($query);
                $this->pdo->bind(':id_user', $user['id_user']);
                $dosen = $this->pdo->single();
                if($dosen) {
                    $_SESSION['id_prodi'] = $dosen['id_prodi'];
                    $_SESSION['nidn'] = $dosen['nidn'];
                }
                
                return true;
            }
            return false;
        } catch (Exception $e) {
            echo"Error login:". $e;
            return false;
        }

        
    }

    public function tambah($data){

        $password = password_hash($data['nidn'], PASSWORD_DEFAULT);
        $this->pdo->query("INSERT INTO {$this->table} (name, username, password) VALUES (:name, :username, :password)");
        $this->pdo->bind(':name', $data['nama']);
        $this->pdo->bind(':username', $data['email']);
        $this->pdo->bind(':password', $password);
        $this->pdo->execute();
        // Return last inserted id on success, or 0 on failure
        if ($this->pdo->rowCount() > 0) {
            return $this->pdo->lastInsertId();
        }
        return 0;
    }

    public function edit($data){
        $password = password_hash($data['nidn'], PASSWORD_DEFAULT);
        $this->pdo->query("UPDATE {$this->table} SET name = :name, username = :username, password = :password WHERE id_user = :id_user");
        $this->pdo->bind(':name', trim($data['nama']));
        $this->pdo->bind('username', trim($data['email']));
        $this->pdo->bind('password', $password);
        $this->pdo->bind('id_user', $data['id_user']);
        $this->pdo->execute();
        return $this->pdo->rowCount();
    }

    public function hapus($id){
        // Hapus jabatan user terlebih dahulu jika ada
        $this->pdo->query("DELETE FROM user_jabatan WHERE id_user = :id_user");
        $this->pdo->bind('id_user', $id['id_user']);
        $this->pdo->execute();

        // Kemudian hapus user-nya
        $this->pdo->query("DELETE FROM {$this->table} WHERE id_user = :id_user");
        $this->pdo->bind('id_user', $id['id_user']);
        $this->pdo->execute();
        return $this->pdo->rowCount();
    }
}