<?php 

class PeriodeModel{
    private $pdo;
    private $table = 'periode';

    public function __construct(){
        $this->pdo = new Db;
    }

    public function getAll(){
        $sql = "SELECT * FROM {$this->table}";
        $this->pdo->query($sql);
        return $this->pdo->resultSet();
    }

    public function getAktif(){
        $sql = "SELECT * FROM {$this->table} WHERE status = 'Aktif' LIMIT 1";
        $this->pdo->query($sql);
        return $this->pdo->single();
    }

    public function add($data){
        $this->pdo->query("INSERT INTO {$this->table} (tahun, periode, status) VALUES (:tahun, :periode, 'Aktif')");
        $this->pdo->bind('tahun', $data['tahun']);
        $this->pdo->bind('periode', $data['periode']);
        $this->pdo->execute();
        return $this->pdo->rowCount();
    }

    public function ubahStatus($data){
        // Mendapatkan status tahun berdasarkan id
        $this->pdo->query("SELECT status FROM periode WHERE id_tahun = :id");
        $this->pdo->bind('id', $data['id_tahun']);
        $status = $this->pdo->single();
        
        try {
            $this->pdo->beginTransaction();
            
            if($status['status'] === 'Aktif'){
                // Jika yang diklik adalah tahun yang sudah aktif, maka nonaktifkan saja.
                $this->pdo->query("UPDATE periode SET status = 'Nonaktif' WHERE id_tahun = :id");
                $this->pdo->bind('id', $data['id_tahun']);
            } else {
                // Nonaktifkan semua periode terlebih dahulu
                $this->pdo->query("UPDATE periode SET status = 'Nonaktif'");
                $this->pdo->execute();
                
                // Kemudian aktifkan periode yang dipilih
                $this->pdo->query("UPDATE periode SET status = 'Aktif' WHERE id_tahun = :id");
                $this->pdo->bind('id', $data['id_tahun']);
            }
            
            $this->pdo->execute();
            $rowCount = $this->pdo->rowCount();
            
            $this->pdo->commit();
            return $rowCount;
            
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function hapus($data){
        $this->pdo->query("DELETE FROM {$this->table} WHERE id_tahun = :id_tahun");
        $this->pdo->bind('id_tahun', $data['id_tahun']);
        $this->pdo->execute();
        return $this->pdo->rowCount();
    }
    
}