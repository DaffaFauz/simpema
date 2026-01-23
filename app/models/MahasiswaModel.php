<?php

class MahasiswaModel
{
    private $pdo;
    private $table = 'mahasiswa';

    public function __construct()
    {
        $this->pdo = new Db();
    }

    public function create($data)
    {
        try {

            // Cek apakah sudah ada data mahasiswa yang terdaftar
            $this->pdo->query("SELECT * FROM mahasiswa WHERE nim = :nim");
            $this->pdo->bind(":nim", $data["nim"]);
            $mahasiswa = $this->pdo->single();

            if (empty($mahasiswa)) {

                // Mendapatkan data tahun akademik yang aktif
                $this->pdo->query("SELECT * FROM periode WHERE status = 'Aktif' ");
                $tahun = $this->pdo->single();

                // Memasukkan data mahasiswa ke dalam tabel mahasiswa
                $this->pdo->query("INSERT INTO mahasiswa (nim, nama, email, id_prodi, id_tahun) VALUES (:nim, :nama, :email, :id_prodi, :id_tahun)");
                $this->pdo->bind(":nim", $data["nim"]);
                $this->pdo->bind(":nama", $data["nama"]);
                $this->pdo->bind(":email", $data["email"]);
                $this->pdo->bind(":id_prodi", $data["prodi"]);
                $this->pdo->bind(":id_tahun", $tahun["id_tahun"]);
                $this->pdo->execute();
                return $this->pdo->rowCount();
            } else {
                redirectWithMsg(BASE_URL . "/Home/upload", 'Data Anda sudah terdaftar, hubungi admin untuk tindak lanjut.', 'danger');
                return 0;
            }
        } catch (PDOException $e) {
            error_log("SQL Error in MahasiswaModel::create - " . $e->getMessage());
            return 0; // Return 0 instead of error message to match controller's expectation
        }
    }
}