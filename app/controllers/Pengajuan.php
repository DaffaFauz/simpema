<?php 

class Pengajuan extends Controller{
    public function index(){
        // Untuk LPPM
        if($_SESSION["role"] === "LPPM"){

        // 1. Dapatkan periode aktif
        $periode_aktif = $this->model("PeriodeModel")->getAktif();
        $id_tahun_aktif = $periode_aktif ? $periode_aktif['id_tahun'] : null;

        // 2. Ambil dokumen hanya untuk periode aktif secara default
        $dokumen = $this->model("PengajuanModel")->getPengajuan($id_tahun_aktif);

        // Mengambil data fakultas dan periode untuk filter
        $fakultas = $this->model("FakultasModel")->getAll();
        $periode = $this->model("PeriodeModel")->getAll();

        // 3. Kirim id tahun aktif ke view agar dropdown bisa 'selected'
        $this->view('layout/head', ['pageTitle' => 'Pengajuan']);
        $this->view('layout/sidebar',    ['user' => $_SESSION['role']]);
        $this->view('layout/headbar', ['nama' => $_SESSION['nama']]);
        $this->view('lppm/dokumen_pengajuan', ['dokumen' => $dokumen,'fakultasfilter' => $fakultas, 'periode' => $periode, 'selectedtahun' => $id_tahun_aktif]);
        $this->view('layout/footer');
        $this->view('layout/script');
        }
    }

    // Untuk Pembimbing
    public function pengajuan(){
        if($this->model('PengajuanModel')->ajuan($_POST) > 0){
            redirectWithMsg(BASE_URL.'/Dokumen/', 'Dokumen berhasil diajukan, Tunggu respon dari LPPM', 'success');
        }else{
            redirectWithMsg(BASE_URL.'/Dokumen/', 'Dokumen gagal diajukan, coba lagi.', 'danger');
        }
    }

    public function report(){

        if($this->model('PengajuanModel')->updatePublish($_POST, $_FILES) > 0){
            redirectWithMsg(BASE_URL.'/Dokumen/', 'Dokumen berhasil dipublish', 'success');
        }else{
            redirectWithMsg(BASE_URL.'/Dokumen/', 'Dokumen gagal dipublish, coba lagi.', 'danger');
        }
    }

    // Untuk LPPM
    public function status(){
        if($this->model('PengajuanModel')->updateStatus($_POST) > 0){
            if($_POST['status'] == 'Accepted'){
            redirectWithMsg(BASE_URL.'/Pengajuan/', 'Pengajuan diterima', 'success');
            }else{
            redirectWithMsg(BASE_URL.'/Pengajuan/', 'Pengajuan ditolak', 'success');
            }
        }else{
            redirectWithMsg(BASE_URL.'/Pengajuan/', 'Status dokumen gagal diperbarui, coba lagi.', 'danger');
        }
    }

    public function filter(){
        // Ambil input filter dari request (POST)
        $fakultas_selected = isset($_POST['fakultas']) ? trim($_POST['fakultas']) : '';
        $prodi_selected = isset($_POST['prodi']) ? trim($_POST['prodi']) : '';
        $tahun_selected = isset($_POST['tahun']) ? trim($_POST['tahun']) : '';

        // Jika request berasal dari AJAX, kembalikan JSON
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if($isAjax){
            $dokumen = $this->model('PengajuanModel')->getFilteredRequests($fakultas_selected, $prodi_selected, $tahun_selected);
            header('Content-Type: application/json');            

            // Jika tidak ada dokumen yang ditemukan, kembalikan array JSON kosong
            if (empty($dokumen)) {
                echo json_encode([]);
                exit;
            }
            echo json_encode($dokumen);
            exit;
        }

        // Fallback jika diakses langsung (sebaiknya tidak terjadi jika alur via AJAX)
        redirectWithMsg(BASE_URL.'/Pengajuan/', 'Akses tidak valid.', 'danger');
    }


}
