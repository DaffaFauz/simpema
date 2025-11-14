<?php 

class Pembimbing extends Controller{
    public function index(){
        // if($user === 'LPPM'){
        // $this->view();
        // }else if($user === 'Kaprodi'){
        checkLogin();

        // mengambil data pembimbing
        $pembimbing = $this->model("PembimbingModel")->getAll();
        $dosen = $this->model("PembimbingModel")->dosen();

        
            $this->view('layout/head', ['pageTitle' =>'Data Pembimbing']);
            $this->view('layout/sidebar', ['user' => $_SESSION['role']]);
            $this->view('layout/headbar', ['nama' => $_SESSION['nama']]);
            $this->view('lppm/pembimbing', ['pembimbing' => $pembimbing, 'dosen' => $dosen]);
            $this->view('layout/footer');
            $this->view('layout/script');
        // }
    }

    public function add(){
        if($this->model("PembimbingModel")->add($_POST) > 0){
            redirectWithMsg(BASE_URL."/Pembimbing", "Dosen berhasil dijadikan sebagai pembimbing", "success");
        }else{
            redirectWithMsg(BASE_URL.'/Pembimbing', "Dosen gagal dijadikan sebagai pembimbing", "error");
        }
    }

    public function lepas(){
        if($this->model('PembimbingModel')->lepas($_POST) > 0){
            redirectWithMsg(BASE_URL.'/Pembimbing', 'Dosen berhasil dilepas dari pembimbing', 'success');
        }else{
            redirectWithMsg(BASE_URL.'/Pembimbing','Dosen gagal dilepas dari pembimbing ', 'error');
        }
    }
}