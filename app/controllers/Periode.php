<?php 
class Periode extends Controller{
    public function index(){
        $dataPeriode = $this->model('PeriodeModel')->getAll();

        $this->view('layout/head', ['pageTitle' => 'Data Periode']);
        $this->view('layout/sidebar', ['user' => $_SESSION['role']] );
        $this->view('layout/headbar', ['nama' => $_SESSION['nama']]);
        $this->view('lppm/periode', ['periode' => $dataPeriode]);
        $this->view('layout/footer');
        $this->view('layout/script');
    }

    public function addPeriode(){
        if($this->model('PeriodeModel')->add($_POST) > 0){
            redirectWithMsg(BASE_URL.'/Periode', 'Data Periode Berhasil Ditambahkan!', 'success');
        }else{
            redirectWithMsg(BASE_URL.'/Periode', 'Data Periode Gagal Ditambahkan!', 'danger');
        }
    }

    public function ubahStatus(){
        if($this->model('PeriodeModel')->ubahStatus($_POST) > 0){
            redirectWithMsg(BASE_URL.'/Periode', 'Status Periode Berhasil Diubah!', 'success');
        }else{
            redirectWithMsg(BASE_URL.'/Periode', 'Status Periode Gagal Diubah!', 'danger');
        }
    }

    public function hapus(){
        if($this->model('PeriodeModel')->hapus($_POST) > 0){
            redirectWithMsg(BASE_URL.'/Periode', 'Data periode berhasil dihapus!', 'success');
        }else{
            redirectWithMsg(BASE_URL.'/Periode', 'Data periode gagal dihapus!', 'danger');
        }
    }
}