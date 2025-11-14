<?php 
class Fakultas extends Controller{
    public function index(){
        checkLogin();
        $data = $this->model('FakultasModel')->getAllFakultas();

        $this->view('layout/head', ['pageTitle'=> 'Data Fakultas']);
        $this->view('layout/sidebar', ['user' => $_SESSION['role']]);
        $this->view('layout/headbar');
        $this->view('lppm/fakultas', ['fakultas' => $data]);
        $this->view('layout/footer');
        $this->view('layout/script');
    }

    public function addFakultas(){
        if($this->model('FakultasModel')->tambah($_POST) > 0){
            redirectWithMsg(BASE_URL.'/fakultas', 'Data Fakultas Berhasil Ditambahkan!', 'success');
        }else{
            redirectWithMsg(BASE_URL.'/fakultas', 'Data fakultas gagal disimpan!', 'danger');
        }
    }

    public function editFakultas(){
        if($this->model('FakultasModel')->edit($_POST) > 0){
            redirectWithMsg(BASE_URL.'/fakultas', 'Data fakultas berhasil di ubah', 'success');
        }else{
            redirectWithMsg(BASE_URL.'/fakultas', 'Data fakultas gagal di ubah!', 'danger');
        }
    }

    public function hapus(){
        if($this->model('FakultasModel')->hapus($_POST) > 0){
            redirectWithMsg(BASE_URL.'/Fakultas', 'Data berhasil dihapus', 'success');
        }else{
            redirectWithMsg(BASE_URL.'/Fakultas', 'Data gagal dihapus', 'danger');
        }
    }
}