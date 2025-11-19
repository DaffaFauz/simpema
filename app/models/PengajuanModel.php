<?php 
class PengajuanModel{
    private $pdo;
    private $table = 'pengajuan';

    public function __construct() {
        $this->pdo = new Db();
    }

    // Untuk di LPPM
    public function getPengajuan($id_tahun = null){
        $query = "SELECT pengajuan.*, 
                                  dokumen.*, 
                                  mahasiswa.nama as mahasiswa_nama, 
                                  dosen.nama as dosen_nama 
                           FROM pengajuan 
                           INNER JOIN dokumen ON pengajuan.id_dokumen = dokumen.id_dokumen 
                           INNER JOIN mahasiswa ON dokumen.id_mahasiswa = mahasiswa.nim 
                           INNER JOIN dosen ON dokumen.id_dosen = dosen.nidn
                           INNER JOIN periode ON mahasiswa.id_tahun = periode.id_tahun";
        
        $conditions = ["pengajuan.status IN ('Requested', 'Accepted', 'Rejected')"];
        if ($id_tahun !== null) $conditions[] = "periode.id_tahun = :id_tahun";
        $query .= " WHERE " . implode(' AND ', $conditions);
        $this->pdo->query($query);
        if ($id_tahun !== null) $this->pdo->bind(':id_tahun', $id_tahun);
        return $this->pdo->resultSet();
    }

    public function ajuan($data){
        // Mendapat id tahun
        $this->pdo->query("SELECT periode.id_tahun FROM periode WHERE periode.status = 'Aktif'");
        $tahun = $this->pdo->single();

        $this->pdo->query("INSERT INTO {$this->table} (id_dokumen, link, nama_jurnal, tgl, status, id_tahun) VALUES (:id_dokumen, :link, :nama_jurnal, :tgl, 'Requested', :id_tahun)");
        $this->pdo->bind(':id_dokumen', $data['id_dokumen']);
        $this->pdo->bind(':link', $data['link']);
        $this->pdo->bind(':nama_jurnal', $data['nama_jurnal']);
        $this->pdo->bind(':tgl', $data['tgl']);
        $this->pdo->bind(':tgl', $tahun);
        $this->pdo->execute();
        return $this->pdo->rowCount();
    }

    public function updatePublish($data,$file){
        if (isset($file['dokumen']) && $file['dokumen']['error'] === UPLOAD_ERR_OK) {
            $fileName = $file['dokumen']['name'];
            $fileTmpName = $file['dokumen']['tmp_name'];
            $fileActualExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $allowed = ['docx', 'pdf']; // Izinkan docx dan pdf

            if (in_array($fileActualExt, $allowed)) {
                $fileNameNew = uniqid('publish_', true) . "." . $fileActualExt;
                $publishDir = __DIR__ . '/../../public/publish/';
                if (!is_dir($publishDir)) {
                    mkdir($publishDir, 0777, true);
                }
                $fileDestination = $publishDir . $fileNameNew;
                
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    try {
                        $this->pdo->query("UPDATE dokumen SET status_publish = :status_publish, dokumen_baru = :dokumen_baru, link_jurnal = :link WHERE id_dokumen = :id_dokumen");
                        $this->pdo->bind(':status_publish', 'Published');
                        $this->pdo->bind(':dokumen_baru', $fileNameNew);
                        $this->pdo->bind(':link', $data['link']);
                        $this->pdo->bind(':id_dokumen', $data['id_dokumen']);
                        $this->pdo->execute();
                        return $this->pdo->rowCount();
                    } catch (Exception $e) {
                        error_log("Database error in updatePublish: " . $e->getMessage());
                    }
                }
            }
        }
        return 0; // Gagal
    }

    // Untuk LPPM
    public function updateStatus($data){
        if (!isset($data['status']) || !isset($data['id_dokumen'])) {
            error_log('updateStatus: missing required fields');
            return 0;
        }

        $this->pdo->query("UPDATE {$this->table} SET status = :status, catatan = :catatan WHERE id_dokumen = :id_dokumen");
        
        // Validate and set status_publish
        $status = 'Requested';
        if ($data['status'] === 'Accepted') {
            $status = 'Accepted';
        } else if ($data['status'] === 'Rejected') {
            $status = 'Rejected';
        }
        
        $this->pdo->bind(':status', $status);
        $this->pdo->bind(':id_dokumen', $data['id_dokumen']);
        if(isset($data['catatan'])){
            $this->pdo->bind(':catatan', $data['catatan']);
        }
        $this->pdo->execute();
        return $this->pdo->rowCount();
    }

    public function getFilteredRequests($fakultas, $prodi, $tahun){
    $query = "SELECT 
        dokumen.id_dokumen, 
        dokumen.judul_penelitian, 
        dokumen.status_publish, 
        dokumen.file_dokumen, 
        {$this->table}.status,
        mahasiswa.nama as mahasiswa_nama, 
        dosen.nama as dosen_nama
        FROM {$this->table}
        INNER JOIN dokumen ON dokumen.id_dokumen = {$this->table}.id_dokumen
        INNER JOIN mahasiswa ON dokumen.id_mahasiswa = mahasiswa.nim
        INNER JOIN periode ON mahasiswa.id_tahun = periode.id_tahun
        INNER JOIN prodi ON mahasiswa.id_prodi = prodi.id_prodi
        INNER JOIN fakultas ON prodi.id_fakultas = fakultas.id_fakultas
        INNER JOIN dosen ON dokumen.id_dosen = dosen.nidn";

    $conditions = [
        "{$this->table}.status IN ('Requested','Accepted','Rejected')"
    ];

    if (!empty($tahun)) $conditions[] = "periode.id_tahun = :tahun";
    if (!empty($fakultas)) {
        $conditions[] = "fakultas.id_fakultas = :fakultas";
    }
    if (!empty($prodi)) {
        $conditions[] = "prodi.id_prodi = :prodi";
    }

    if (count($conditions) > 0) {
        $query .= " WHERE " . implode(' AND ', $conditions);
    }

    // PERBAIKAN: gunakan $this->db, bukan $this->pdo
    $this->pdo->query($query);

    if (!empty($tahun)) $this->pdo->bind(':tahun', $tahun);
    if (!empty($fakultas)) $this->pdo->bind(':fakultas', $fakultas);
    if (!empty($prodi)) $this->pdo->bind(':prodi', $prodi);

    return $this->pdo->resultSet();
}

}