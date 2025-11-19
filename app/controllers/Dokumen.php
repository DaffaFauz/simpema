<?php 

class Dokumen extends Controller{
    public function index(){
        checkLogin();
        if($_SESSION['role'] === 'Pembimbing'){

            // Mengambil dokumen mahasiswa yang belum di publish
            $dokumen = $this->model('DokumenModel')->getDokumenUnpublished();

            // view
            $this->view("layout/head", ['pageTitle' =>'Dokumen Mahasiswa']);
            $this->view("layout/sidebar", ['user' => $_SESSION['role']]);
            $this->view("layout/headbar", ['nama' => $_SESSION['nama']]);
            $this->view("pembimbing/dokumen_mahasiswa", ['dokumen' => $dokumen]);
            $this->view("layout/footer");
            $this->view("layout/footer");
        }else if($_SESSION["role"] === "Kaprodi"){

            // Mengambil dokumen mahasiswa di prodi dosen
            $dokumen = $this->model("DokumenModel")->getDokumenKaprodi();

            // View
            $this->view("layout/head", ['pageTitle' =>'Dokumen Mahasiswa']);
            $this->view("layout/sidebar", ['user' => $_SESSION['role']]);
            $this->view("layout/headbar", ['nama' => $_SESSION['nama']]);
            $this->view("kaprodi/dokumen_mahasiswa", ['dokumen' => $dokumen]);
            $this->view("layout/footer");
            $this->view("layout/script");
        }else if($_SESSION["role"] === "LPPM"){

            // Mengambil dokumen mahasiswa
            $dokumen = $this->model("DokumenModel")->getAll();

            // Mengambil data fakultas, prodi, dan status publish untuk filter
            $prodi = $this->model("ProdiModel")->getAll();
            $fakultas = $this->model("FakultasModel")->getAll();

            // View
            $this->view("layout/head", ['pageTitle' =>'Dokumen Mahasiswa']);
            $this->view("layout/sidebar", ['user' => $_SESSION['role']]);
            $this->view("layout/headbar", ['nama' => $_SESSION['nama']]);
            $this->view("lppm/dokumen_mahasiswa", ['dokumen' => $dokumen, 'prodifilter'=> $prodi, 'fakultasfilter' => $fakultas]);
            $this->view("layout/footer");
            $this->view("layout/script");
        }
    }

    public function upload_dokumen(){

        // Validasi input
        if(!isset($_POST['nim']) || !isset($_POST['nama']) || !isset($_POST['email']) || !isset($_POST['fakultas']) || !isset($_POST['prodi']) || !isset($_POST['judul']) || !isset($_POST['pembimbing'])){
            redirectWithMsg(BASE_URL.'/Home/upload', 'Semua field harus diisi.', 'danger');
            exit;
        }

        // Validasi file dokumen harus format .docx
        if(!isset($_FILES['dokumen']) || $_FILES['dokumen']['error'] != UPLOAD_ERR_OK) {
            redirectWithMsg(BASE_URL.'/Home/upload', 'File dokumen tidak ditemukan atau gagal diupload.', 'danger');
            exit;
        }

        $file_name = $_FILES['dokumen']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Cek apakah ekstensi file adalah .docx
        if($file_ext !== 'docx') {
            redirectWithMsg(BASE_URL.'/Home/upload', 'Dokumen harus berformat .docx', 'danger');
            exit;
        }

        // Validasi MIME type untuk keamanan tambahan (opsional tapi direkomendasikan)
        $allowed_mime = ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $file_mime = mime_content_type($_FILES['dokumen']['tmp_name']);
        
        if(!in_array($file_mime, $allowed_mime)) {
            redirectWithMsg(BASE_URL.'/Home/upload', 'File tidak valid. Gunakan dokumen Word (.docx) yang asli.', 'danger');
            exit;
        }

        // Jika validasi lolos, lanjut ke model
        if ($this->model('MahasiswaModel')->create($_POST) > 0 && $this->model('DokumenModel')->uploadDokumen($_POST, $_FILES) > 0){
            redirectWithMsg(BASE_URL.'/Home/upload', 'Dokumen berhasil diupload', 'success');
        }else{
            redirectWithMsg(BASE_URL.'/Home/upload', 'Dokumen gagal diupload', 'danger');
        }
    }

    public function status_publish(){
        $redirect_page = isset($_POST['redirect_page']) ? trim($_POST['redirect_page']) : '';

        // resolver untuk redirect_page agar aman dan dinamis
        $resolveRedirect = function($token){
            // token allowed: alnum, dash, underscore, slash
            if(empty($token)){
                // kembalikan ke referer jika ada, atau default ke Dokumen
                if(!empty($_SERVER['HTTP_REFERER'])) return $_SERVER['HTTP_REFERER'];
                return BASE_URL . '/Pengajuan';
            }
            $token = trim($token, " /\\");
            // mapping sederhana untuk token yang dikenal
            if(strtolower($token) === 'pengajuan') return BASE_URL . '/Pengajuan';
            if(strtolower($token) === 'dashboard') return BASE_URL . '/Dashboard';
            // jika token mengandung slash (Controller/method), lampirkan ke BASE_URL
            if(strpos($token, '/') !== false){
                // sanitasi: hanya izinkan chars tertentu
                if(preg_match('/^[a-zA-Z0-9_\/\-]+$/', $token)){
                    return rtrim(BASE_URL, '/') . '/' . $token;
                }
            }
            // jika hanya kata, anggap sebagai method di Dokumen controller
            if(preg_match('/^[a-zA-Z0-9_\-]+$/', $token)){
                return BASE_URL . '/Dokumen/' . $token;
            }
            // fallback
            return BASE_URL . '/Dokumen';
        };

        $redirect_url = $resolveRedirect($redirect_page);

        if($this->model('DokumenModel')->updateStatusPublish($_POST) > 0){
            redirectWithMsg($redirect_url, 'Dokumen sudah dipublish', 'success');
        }else{
            redirectWithMsg($redirect_url, 'Status Publish gagal diubah', 'danger');
        }
    }

    public function status(){
        // support dynamic redirect_page if provided, otherwise fallback to role defaults
        $redirect_page = isset($_POST['redirect_page']) ? trim($_POST['redirect_page']) : '';

        $resolveRedirect = function($token){
            if(empty($token)){
                if(!empty($_SERVER['HTTP_REFERER'])) return $_SERVER['HTTP_REFERER'];
                return BASE_URL . '/Dokumen';
            }
            $token = trim($token, " /\\");
            if(strtolower($token) === 'pengajuan') return BASE_URL . '/Dokumen/pengajuan';
            if(strtolower($token) === 'dashboard') return BASE_URL . '/Dashboard';
            if(strpos($token, '/') !== false){
                if(preg_match('/^[a-zA-Z0-9_\/\-]+$/', $token)){
                    return rtrim(BASE_URL, '/') . '/' . $token;
                }
            }
            if(preg_match('/^[a-zA-Z0-9_\-]+$/', $token)){
                return BASE_URL . '/Dokumen/' . $token;
            }
            return BASE_URL . '/Dokumen';
        };

        $redirect_url = $resolveRedirect($redirect_page);

        if($this->model('DokumenModel')->updateStatus($_POST) > 0){
            redirectWithMsg($redirect_url, 'Status berhasil diubah', 'success');
        }else{
            redirectWithMsg($redirect_url, 'Status gagal diubah', 'danger');
        }
    }
    public function filter(){

        // Mengambil data fakultas untuk filter
            $fakultas = $this->model("FakultasModel")->getAll();

        // Ambil input filter dari request (POST)
        $fakultas_selected = isset($_POST['fakultas']) ? trim($_POST['fakultas']) : '';
        $prodi_selected = isset($_POST['prodi']) ? trim($_POST['prodi']) : '';
        $status_selected = isset($_POST['status']) ? trim($_POST['status']) : '';
        $redirect_page = isset($_POST['redirect_page']) ? trim($_POST['redirect_page']) : '';

        // Jika request berasal dari AJAX (applyFilters JS), kembalikan JSON
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if($isAjax){
            if($redirect_page === 'pengajuan'){
                $dokumen = $this->model('PengajuanModel')->getFilteredRequests($fakultas_selected, $prodi_selected);
            } else {
                $dokumen = $this->model('DokumenModel')->getFiltered($fakultas_selected, $prodi_selected, $status_selected);
            }
            header('Content-Type: application/json');
            echo json_encode($dokumen);
            exit;
        }

        // Jika bukan AJAX, render halaman normal dengan hasil filter atau semua
        if($redirect_page === 'pengajuan'){
            if(!empty($fakultas_selected) || !empty($prodi_selected)){
                $dokumen = $this->model('PengajuanModel')->getFilteredRequests($fakultas_selected, $prodi_selected);
            }else{
                $dokumen = $this->model('DokumenModel')->getReqDoc();
            }
            // view pengajuan
            $prodifilter = $this->model("ProdiModel")->getAll();
            $this->view('layout/head', ['pageTitle' =>'Pengajuan Dokumen']);
            $this->view('layout/sidebar', ['user' => $_SESSION['role']]);
            $this->view('layout/headbar', ['nama' => $_SESSION['nama']]);
            $this->view('lppm/dokumen_pengajuan', ['dokumen' => $dokumen, 'prodifilter' => $prodifilter, 'fakultasfilter' => $fakultas, 'selectedprodi' => $prodi_selected, 'selectedfakultas' => $fakultas_selected]);
            $this->view('layout/footer');
            $this->view('layout/script');
            return;
        }

        // Default: dokumen mahasiswa listing
        if(!empty($fakultas_selected) || !empty($prodi_selected) || !empty($status_selected)){
            $dokumen = $this->model('DokumenModel')->getFiltered($fakultas_selected, $prodi_selected, $status_selected);
        }else{
            $dokumen = $this->model('DokumenModel')->getAll();
        }

        $this->view('layout/head', ['pageTitle' =>'Dokumen Mahasiswa']);
        $this->view('layout/sidebar', ['user' => $_SESSION['role']]);
        $this->view('layout/headbar', ['nama' => $_SESSION['nama']]);
        // kirim data prodi dan fakultas untuk populate form
        $prodifilter = $this->model("ProdiModel")->getAll();
        $this->view('lppm/dokumen_mahasiswa', ['dokumen' => $dokumen, 'prodifilter' => $prodifilter, 'fakultasfilter' => $fakultas, 'selectedprodi' => $prodi_selected, 'selectedstatus' => $status_selected, 'selectedfakultas' => $fakultas_selected]);
        $this->view('layout/footer');
        $this->view('layout/script');

    }

}