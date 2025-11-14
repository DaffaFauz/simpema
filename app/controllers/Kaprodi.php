<?php 
class Kaprodi extends Controller {
    public function index() {
        checkLogin();
        
        $kaprodi =$this->model("KaprodiModel")->getAll();
        $dosen = $this->model("KaprodiModel")->dosen();

        $this->view("layout/head", ['pageTitle' => 'Data Kaprodi']);
        $this->view("layout/sidebar", ['user' => $_SESSION['role']]);
        $this->view('layout/headbar', ['nama'=> $_SESSION['nama']]);
        $this->view('lppm/kaprodi', ['kaprodi' => $kaprodi, 'dosen' => $dosen]);
        $this->view('layout/footer');
        $this->view('layout/script');
    }

    public function add(){
        if($this->model("KaprodiModel")->add($_POST) > 0){
            redirectWithMsg(BASE_URL.'/Kaprodi', "Dosen berhasil dijadikan sebagai kaprodi", "success");
        }else{
            redirectWithMsg(BASE_URL.'/Kaprodi', "Dosen gagal dijadikan sebagai kaprodi", "error");
        }
    }

    public function lepas(){
        if($this->model('KaprodiModel')->lepas($_POST) > 0){
            redirectWithMsg(BASE_URL.'/Kaprodi', 'Dosen berhasil dilepas dari kaprodi', 'success');
        }else{
            redirectWithMsg(BASE_URL.'/Kaprodi','Dosen gagal dilepas dari kaprodi ', 'error');
        }
    }
}