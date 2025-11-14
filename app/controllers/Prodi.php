<?php 

class Prodi extends Controller{
    public function index(){
        checkLogin();

        $prodi = $this->model('ProdiModel')->getAllProdi();

        // ambil data fakultas juga agar dropdown fakultas pada modal terisi
        $fakultas = $this->model('FakultasModel')->getAllFakultas();

        $this->view('layout/head', ['pageTitle' => 'Data Program Studi']);
        $this->view('layout/sidebar', ['user' => $_SESSION['role']]);
        $this->view('layout/headbar', ['nama' => $_SESSION['nama']]);
        $this->view('lppm/prodi', ['prodi' => $prodi, 'fakultas' => $fakultas]);
        $this->view('layout/footer');
        $this->view('layout/script');
    }


    public function addProdi(){
        if($this->model('ProdiModel')->add($_POST) > 0 ){
            redirectWithMsg(BASE_URL.'/prodi', 'Data prodi berhasil disimpan!', 'success');
        }else{
            redirectWithMsg(BASE_URL.'/prodi', 'Data prodi gagal disimpan!', 'danger');
        }
    }

    public function editProdi(){
        if($this->model('ProdiModel')->edit($_POST) > 0){
            redirectWithMsg(BASE_URL.'/prodi', 'Data prodi berhasil diubah!', 'success');
        }else{
            redirectWithMsg(BASE_URL.'/prodi', 'Data prodi gagal diubah!', 'danger');
        }
    }

    public function hapus(){
        if($this->model('ProdiModel')->hapus($_POST) > 0){
            redirectWithMsg(BASE_URL.'/Prodi', 'Berhasil menghapus Program Studi', 'success');
        }else{
            redirectWithMsg(BASE_URL.'/Prodi', 'Gagal menghapus Program Studi', 'danger');
        }
    }
    
    
    public function getProdi($id){
        if (!empty($id)) {
            $id_fakultas = $id;
            $prodi = $this->model('ProdiModel')->getProdiByFakultasId($id_fakultas);
            header('Content-Type: application/json');
            echo json_encode($prodi);
        } else {
            echo json_encode([]);
        }
        exit;
    }

}