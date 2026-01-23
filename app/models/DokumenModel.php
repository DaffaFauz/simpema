<?php

class DokumenModel
{
    private $pdo;
    private $table = 'dokumen';

    public function __construct()
    {
        $this->pdo = new Db();
    }

    public function uploadDokumen($data, $file)
    {
        // Upload file
        $fileName = $file['dokumen']['name'];
        $fileTmpName = $file['dokumen']['tmp_name'];
        $fileType = $file['dokumen']['type'];
        $fileError = $file['dokumen']['error'];

        // Validasi file harus berformat .docx
        $allowedTypes = ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        if (!in_array($fileType, $allowedTypes)) {
            redirectWithMsg(BASE_URL . '/Home/Upload', 'Dokumen harus berformat .docx', 'danger');
        }

        if ($fileError === 0) {
            // membuat folder untuk dokumen jika belum ada
            $uploadDir = __DIR__ . '../../public/uploads/dokumen/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            move_uploaded_file($fileTmpName, $uploadDir . $fileName);
        }

        // Simpan ke database
        $this->pdo->query("INSERT INTO {$this->table} (id_mahasiswa, id_dosen, file_dokumen, judul_penelitian, status_publish, dokumen_baru, link_jurnal) VALUES(:id_mahasiswa, :id_dosen, :file_dokumen, :judul_penelitian, :status_publish, :dokumen_baru, :link_jurnal)");

        $this->pdo->bind(':id_mahasiswa', $data['nim']);
        $this->pdo->bind(':id_dosen', $data['pembimbing']);
        $this->pdo->bind(':file_dokumen', $fileName);
        $this->pdo->bind(':judul_penelitian', $data['judul']);
        $this->pdo->bind(':status_publish', 'Unknown');
        $this->pdo->bind(':dokumen_baru', null);
        $this->pdo->bind(':link_jurnal', null);

        $this->pdo->execute();
        return $this->pdo->rowCount();


    }

    public function getAll()
    {
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

    public function getDocForDashboard()
    {
        $this->pdo->query("SELECT {$this->table}.*, mahasiswa.nama as mahasiswa_nama, dosen.nama as dosen_nama FROM {$this->table} INNER JOIN mahasiswa ON {$this->table}.id_mahasiswa = mahasiswa.nim INNER JOIN dosen ON {$this->table}.id_dosen = dosen.nidn WHERE status_publish = 'Unknown'");
        return $this->pdo->resultSet();
    }

    public function updateStatusPublish($data)
    {
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

    public function getReqDoc()
    {
        $this->pdo->query("SELECT {$this->table}.*, mahasiswa.nama as mahasiswa_nama, dosen.nama as dosen_nama FROM {$this->table} INNER JOIN mahasiswa ON {$this->table}.id_mahasiswa = mahasiswa.nim  INNER JOIN dosen ON {$this->table}.id_dosen = dosen.nidn WHERE status = 'Requested' OR status = 'Accepted' OR status = 'Rejected'");
        return $this->pdo->resultSet();
    }

    public function updateStatus($data)
    {
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

    public function getFiltered($fakultas, $prodi, $status)
    {
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
        if (!empty($fakultas))
            $this->pdo->bind(':fakultas', $fakultas);
        if (!empty($prodi))
            $this->pdo->bind(':prodi', $prodi);
        if (!empty($status))
            $this->pdo->bind(':status', $status);

        return $this->pdo->resultSet();
    }

    /**
     * Get filtered dokumen that are pengajuan (Requested/Accepted/Rejected)
     * Filters by fakultas and prodi and only periode aktif.
     */


    public function getDokumenKaprodi()
    {
        $prodi = $_SESSION['id_prodi'];
        $this->pdo->query("SELECT {$this->table}.*, mahasiswa.nama as mahasiswa_nama, mahasiswa.id_prodi, dosen.nama as dosen_nama, dosen.id_prodi FROM {$this->table} INNER JOIN mahasiswa ON {$this->table}.id_mahasiswa = mahasiswa.nim INNER JOIN prodi ON mahasiswa.id_prodi = prodi.id_prodi INNER JOIN dosen ON {$this->table}.id_dosen = dosen.nidn INNER JOIN periode ON mahasiswa.id_tahun = periode.id_tahun WHERE periode.status = 'Aktif' AND mahasiswa.id_prodi = $prodi");
        return $this->pdo->resultSet();
    }

    public function getDokumenUnpublished()
    {
        $pembimbing = $_SESSION['nidn'];
        $query = "SELECT 
                    d.*, 
                    p.status, p.catatan,
                    m.nama as mahasiswa_nama, 
                    m.nim, 
                    dsn.nama as dosen_nama, 
                    dsn.nidn 
                  FROM {$this->table} d
                  LEFT JOIN pengajuan p ON d.id_dokumen = p.id_dokumen
                  INNER JOIN mahasiswa m ON d.id_mahasiswa = m.nim
                  INNER JOIN dosen dsn ON d.id_dosen = dsn.nidn
                  INNER JOIN periode per ON m.id_tahun = per.id_tahun
                  WHERE d.id_dosen = :pembimbing 
                  AND per.status = 'Aktif' 
                  AND d.status_publish IN ('Unpublished', 'Published')";
        $this->pdo->query($query);
        $this->pdo->bind(':pembimbing', $pembimbing);
        return $this->pdo->resultSet();
    }
}