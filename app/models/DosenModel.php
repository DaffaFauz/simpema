<?php

class DosenModel {
    private $pdo;
    private $table = 'dosen'; // Sesuaikan dengan nama tabel dosen Anda

    public function __construct(){
        $this->pdo = new Db(); // Menggunakan kelas Db untuk koneksi database
    }

    public function getAllDosen(){
        $sql = "SELECT * FROM {$this->table} INNER JOIN prodi ON dosen.id_prodi = prodi.id_prodi";
        $this->pdo->query($sql);
        return $this->pdo->resultSet();
    }

    public function tambah($data){
        // $data must include: nidn, nama, email, id_prodi and id_user
        $sql = "INSERT INTO {$this->table} (nidn, nama, email, id_prodi, id_user) VALUES (:nidn, :nama, :email, :id_prodi, :id_user)";
        $this->pdo->query($sql);
        $this->pdo->bind(':nidn', $data['nidn']);
        $this->pdo->bind(':nama', $data['nama']);
        $this->pdo->bind(':email', $data['email']);
        $this->pdo->bind(':id_prodi', $data['prodi']);
        $this->pdo->bind(':id_user', $data['id_user']);
        $this->pdo->execute();
        return $this->pdo->rowCount();
    }

    public function edit($data){
        $sql = "UPDATE {$this->table} SET nidn = :nidn, nama = :nama, email = :email, id_prodi = :id_prodi WHERE id_user = :id_user";
        $this->pdo->query($sql);
        $this->pdo->bind(':nidn', $data['nidn']);
        $this->pdo->bind(':nama', $data['nama']);
        $this->pdo->bind(':email', $data['email']);
        $this->pdo->bind(':id_prodi', $data['prodi']);
        $this->pdo->bind('id_user', $data['id_user']);
        $this->pdo->execute();
        return $this->pdo->rowCount();
    }

    public function hapus($id){
        $sql = "DELETE FROM {$this->table} WHERE id_user = :id_user";
        $this->pdo->query($sql);
        $this->pdo->bind('id_user', $id['id_user']);
        $this->pdo->execute();
        return $this->pdo->rowCount();
    }



    public function getPembimbingByFakultasId($id_fakultas){
        $this->pdo->query("SELECT {$this->table}.id_user AS id_dosen, {$this->table}.nama, {$this->table}.nidn FROM {$this->table} INNER JOIN prodi ON {$this->table}.id_prodi = prodi.id_prodi INNER JOIN fakultas ON prodi.id_fakultas = fakultas.id_fakultas INNER JOIN user ON {$this->table}.id_user = user.id_user INNER JOIN user_jabatan ON user.id_user = user_jabatan.id_user INNER JOIN jabatan ON user_jabatan.id_jabatan = jabatan.id_jabatan WHERE fakultas.id_fakultas = :id_fakultas AND jabatan.nama_jabatan = 'Pembimbing'");
        $this->pdo->bind(':id_fakultas', $id_fakultas);
        return $this->pdo->resultSet();
    }

}
