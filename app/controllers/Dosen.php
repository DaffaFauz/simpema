<?php 

class Dosen extends Controller{
    public function index(){
        checkLogin();
        $dosen = $this->model("DosenModel")->getAllDosen();
        $prodi = $this->model("ProdiModel")->getAll();


        $this->view('layout/head', ['pageTitle' => 'Data Dosen']);
        $this->view('layout/sidebar', ['user' => $_SESSION['role']]);
        $this->view('layout/headbar', ['nama' => $_SESSION['nama']]);
        $this->view('lppm/dosen', ['dosen' => $dosen, 'prodi' => $prodi]);
        $this->view('layout/footer');
        $this->view('layout/script');
    }

    public function tambah(){
        // First create the user, then create the dosen record with the returned user id
        $userId = $this->model('UserModel')->tambah($_POST);
        if ($userId && $userId > 0) {
            // Prepare dosen data and include id_user
            $dosenData = $_POST;
            $dosenData['id_user'] = $userId;
            if ($this->model('DosenModel')->tambah($dosenData) > 0) {
                redirectWithMsg(BASE_URL.'/Dosen', 'Data Dosen berhasil disimpan!', 'success');
                return;
            }
        }
        // If we reach here something failed
        redirectWithMsg(BASE_URL.'/Dosen', 'Data Dosen gagal disimpan!', 'danger');
    }

    public function ubah(){
        if($this->model('DosenModel')->edit($_POST) > 0){
            redirectWithMsg(BASE_URL.'/Dosen', 'Data Dosen berhasil diubah!', 'success');
        }else{
            redirectWithMsg(BASE_URL.'/Dosen', 'Data Dosen gagal diubah!', 'danger');
        }
    }

    public function hapus(){
        if($this->model('DosenModel')->hapus($_POST) > 0 && $this->model('UserModel')->hapus($_POST) > 0 ){
            redirectWithMsg(BASE_URL.'/Dosen', 'Data Dosen berhasil dihapus!', 'success');
        }else{
            redirectWithMsg(BASE_URL.'/Dosen', 'Data Dosen gagal dihapus!', 'danger');
        }
    }


    public function getDosenByFakultas(){
        if (isset($_POST['fakultas'])) {
            $id_fakultas = $_POST['fakultas'];
            $dosen = $this->model('DosenModel')->getPembimbingByFakultasId($id_fakultas);
            echo json_encode($dosen);
        } else {
            echo json_encode([]);
        }
        exit;
    }
}