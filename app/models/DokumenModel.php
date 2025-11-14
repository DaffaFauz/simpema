<?php 

class DokumenModel {
    private $pdo;
    private $table = 'dokumen';

    public function __construct(){
        $this->pdo = new Db();
    }

    public function uploadDokumen($data, $file){
        if (isset($file['dokumen']) && $file['dokumen']['error'] === UPLOAD_ERR_OK) {
            $fileName = $file['dokumen']['name'];
            $fileTmpName = $file['dokumen']['tmp_name'];
            $fileSize = $file['dokumen']['size'];
            $fileError = $file['dokumen']['error'];
            $fileType = $file['dokumen']['type'];

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allowed = ['docx'];

            if (in_array($fileActualExt, $allowed)) {
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $uploadsDir = __DIR__ . '/../../public/uploads/';
                if (!is_dir($uploadsDir)) {
                    mkdir($uploadsDir, 0777, true);
                }
                $fileDestination = $uploadsDir . $fileNameNew;
                
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    try {
                        // Simpan informasi file ke database
                        $this->pdo->query("INSERT INTO dokumen (id_mahasiswa, id_dosen, file_dokumen, judul_penelitian, status_publish, status) VALUES (:nim, :pembimbing, :file_dokumen, :judul, 'Unknown', NULL)");
                        $this->pdo->bind(':nim', $data['nim']);
                        $this->pdo->bind(':pembimbing', $data['pembimbing']);
                        $this->pdo->bind(':file_dokumen', $fileNameNew);
                        $this->pdo->bind(':judul', $data['judul']);
                        $this->pdo->execute();
                        return $this->pdo->rowCount(); 
                    } catch (Exception $e) {
                        error_log("Database error: " . $e->getMessage());
                        return 0;
                    }
                }
            }
        }
        return 0; // Gagal
    }

    public function getAll(){
        $this->pdo->query("SELECT 
            {$this->table}.id_dokumen,
            {$this->table}.judul_penelitian,
            {$this->table}.status_publish,
            {$this->table}.file_dokumen,
            mahasiswa.nama as mahasiswa_nama,
            dosen.nama as dosen_nama
            FROM {$this->table} 
            INNER JOIN mahasiswa ON {$this->table}.id_mahasiswa = mahasiswa.nim 
            INNER JOIN periode ON mahasiswa.id_tahun = periode.id_tahun 
            INNER JOIN dosen ON {$this->table}.id_dosen = dosen.nidn 
            WHERE periode.status = 'Aktif'");
        return $this->pdo->resultSet();
    }

    public function getDocForDashboard(){
        $this->pdo->query("SELECT {$this->table}.*, mahasiswa.nama as mahasiswa_nama, dosen.nama as dosen_nama FROM {$this->table} INNER JOIN mahasiswa ON {$this->table}.id_mahasiswa = mahasiswa.nim INNER JOIN dosen ON {$this->table}.id_dosen = dosen.nidn WHERE status_publish = 'Unknown'");
        return $this->pdo->resultSet();
    }

    public function updateStatusPublish($data){
        if (!isset($data['status_publish']) || !isset($data['id_dokumen'])) {
            error_log('updateStatusPublish: missing required fields');
            return 0;
        }

        $this->pdo->query("UPDATE {$this->table} SET status_publish = :status_publish WHERE id_dokumen = :id_dokumen");
        
        // Validate and set status_publish
        $status = 'Unknown';
        if ($data['status_publish'] === 'Published') {
            $status = 'Published';
        } else if ($data['status_publish'] === 'Unpublished') {
            $status = 'Unpublished';
        }
        
        
        $this->pdo->bind(':status_publish', $status);
        $this->pdo->bind(':id_dokumen', $data['id_dokumen']);
        
        $this->pdo->execute();
        return $this->pdo->rowCount();
    }

    public function getReqDoc(){
        $this->pdo->query("SELECT {$this->table}.*, mahasiswa.nama as mahasiswa_nama, dosen.nama as dosen_nama FROM {$this->table} INNER JOIN mahasiswa ON {$this->table}.id_mahasiswa = mahasiswa.nim  INNER JOIN dosen ON {$this->table}.id_dosen = dosen.nidn WHERE status = 'Requested' OR status = 'Accepted' OR status = 'Rejected'");
        return $this->pdo->resultSet();
    }

    public function updateStatus($data){
        if (!isset($data['status']) || !isset($data['id_dokumen'])) {
            error_log('updateStatus: missing required fields');
            return 0;
        }

        $this->pdo->query("UPDATE {$this->table} SET status = :status WHERE id_dokumen = :id_dokumen");
        
        // Validate and set status_publish
        $status = 'Requested';
        if ($data['status'] === 'Accepted') {
            $status = 'Accepted';
        } else if ($data['status'] === 'Rejected') {
            $status = 'Rejected';
        }
        
        $this->pdo->bind(':status', $status);
        $this->pdo->bind(':id_dokumen', $data['id_dokumen']);
        $this->pdo->execute();
        return $this->pdo->rowCount();

    }

    public function getFiltered($fakultas, $prodi, $status){
        $query = "SELECT 
            {$this->table}.id_dokumen, 
            {$this->table}.judul_penelitian, 
            {$this->table}.status_publish, 
            {$this->table}.file_dokumen, 
            mahasiswa.nama as mahasiswa_nama, 
            dosen.nama as dosen_nama
            FROM {$this->table}
            INNER JOIN mahasiswa ON {$this->table}.id_mahasiswa = mahasiswa.nim
            INNER JOIN periode ON mahasiswa.id_tahun = periode.id_tahun
            INNER JOIN prodi ON mahasiswa.id_prodi = prodi.id_prodi
            INNER JOIN fakultas ON prodi.id_fakultas = fakultas.id_fakultas
            INNER JOIN dosen ON {$this->table}.id_dosen = dosen.nidn";
        $conditions = ["periode.status = 'Aktif'"];
        if (!empty($fakultas)) {
            $conditions[] = "fakultas.id_fakultas = :fakultas";
        }
        if (!empty($prodi)) {
            $conditions[] = "prodi.id_prodi = :prodi";
        }
        if (!empty($status)) {
            $conditions[] = "{$this->table}.status_publish = :status";
        }

        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        $this->pdo->query($query);
        if (!empty($fakultas)) $this->pdo->bind(':fakultas', $fakultas);
        if (!empty($prodi)) $this->pdo->bind(':prodi', $prodi);
        if (!empty($status)) $this->pdo->bind(':status', $status);

        return $this->pdo->resultSet();
    }

    /**
     * Get filtered dokumen that are pengajuan (Requested/Accepted/Rejected)
     * Filters by fakultas and prodi and only periode aktif.
     */
    public function getFilteredRequests($fakultas, $prodi){
        $query = "SELECT 
            {$this->table}.id_dokumen, 
            {$this->table}.judul_penelitian, 
            {$this->table}.status_publish, 
            {$this->table}.file_dokumen, 
            {$this->table}.status,
            mahasiswa.nama as mahasiswa_nama, 
            dosen.nama as dosen_nama
            FROM {$this->table}
            INNER JOIN mahasiswa ON {$this->table}.id_mahasiswa = mahasiswa.nim
            INNER JOIN periode ON mahasiswa.id_tahun = periode.id_tahun
            INNER JOIN prodi ON mahasiswa.id_prodi = prodi.id_prodi
            INNER JOIN fakultas ON prodi.id_fakultas = fakultas.id_fakultas
            INNER JOIN dosen ON {$this->table}.id_dosen = dosen.nidn";

        $conditions = ["periode.status = 'Aktif'", "{$this->table}.status IN ('Requested','Accepted','Rejected')"];
        if (!empty($fakultas)) {
            $conditions[] = "fakultas.id_fakultas = :fakultas";
        }
        if (!empty($prodi)) {
            $conditions[] = "prodi.id_prodi = :prodi";
        }

        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        $this->pdo->query($query);
        if (!empty($fakultas)) $this->pdo->bind(':fakultas', $fakultas);
        if (!empty($prodi)) $this->pdo->bind(':prodi', $prodi);

        return $this->pdo->resultSet();
    }

    public function getDokumenKaprodi(){
     $prodi = $_SESSION['id_prodi'];
        $this->pdo->query("SELECT {$this->table}.*, mahasiswa.nama as mahasiswa_nama, mahasiswa.id_prodi, dosen.nama as dosen_nama, dosen.id_prodi FROM {$this->table} INNER JOIN mahasiswa ON {$this->table}.id_mahasiswa = mahasiswa.nim INNER JOIN prodi ON mahasiswa.id_prodi = prodi.id_prodi INNER JOIN dosen ON {$this->table}.id_dosen = dosen.nidn INNER JOIN periode ON mahasiswa.id_tahun = periode.id_tahun WHERE periode.status = 'Aktif' AND mahasiswa.id_prodi = $prodi");
        return $this->pdo->resultSet();
    }

    public function getDokumenUnpublished(){
        $pembimbing = $_SESSION['nidn'];
        $this->pdo->query("SELECT {$this->table}.*, mahasiswa.nama as mahasiswa_nama, mahasiswa.nim, dosen.nama as dosen_nama, dosen.nidn FROM {$this->table} INNER JOIN mahasiswa ON {$this->table}.id_mahasiswa = mahasiswa.nim INNER JOIN dosen ON {$this->table}.id_dosen = dosen.nidn INNER JOIN periode ON mahasiswa.id_tahun = periode.id_tahun WHERE {$this->table}.id_dosen = $pembimbing AND periode.status = 'Aktif' AND {$this->table}.status_publish = 'Unpublished' OR {$this->table}.status_publish = 'Published'");
        return $this->pdo->resultSet();
    }
}