<?php 

class Dashboard extends Controller {
    public function index() {
        checkLogin();
        if($_SESSION['role'] === 'Pembimbing'){
            checkRole(['Pembimbing']);
            $this->view('layout/head', ['pageTitle' =>'Dashboard Pembimbing']);
            $this->view('layout/sidebar',  ['user' => $_SESSION['role']]);
            $this->view('layout/headbar', ['nama' => $_SESSION['nama']]);
            $this->view('pembimbing/dashboard');
            $this->view('layout/footer');
        }
        else if($_SESSION['role'] === 'Kaprodi'){
            checkRole(['Kaprodi']);
            $this->view('layout/head', ['pageTitle' =>'Dashboard Kaprodi']);
            $this->view('layout/sidebar', ['user'=> $_SESSION['role']]);
            $this->view('layout/headbar', ['nama'=> $_SESSION['nama']]);
            $this->view('kaprodi/dashboard'); 
            $this->view('layout/footer');
        }
        else if( $_SESSION['role'] === 'LPPM'){
            checkRole(['LPPM']);

            // Mengambil dokumen baru di upload oleh mahasiswa yang statusnya unknown
            $dokumen = $this->model('DokumenModel')->getDocForDashboard();


            $this->view('layout/head', ['pageTitle' =>'Dashboard LPPM']);
            $this->view('layout/sidebar', ['user'=> $_SESSION['role']]);
            $this->view('layout/headbar', ['nama'=> $_SESSION['nama']]);
            $this->view('lppm/dashboard', ['dokumen' => $dokumen]);
            $this->view('layout/footer');
        } else if($_SESSION['role'] === 'Admin'){
            checkRole(['Admin']);
             // Mengambil dokumen baru di upload oleh mahasiswa yang statusnya unknown
            $dokumen = $this->model('DokumenModel')->getDocForDashboard();
            
            $this->view('layout/head', ['pageTitle' =>'Dashboard Admin']);
            $this->view('layout/sidebar', ['user'=> $_SESSION['role']]);
            $this->view('layout/headbar', ['nama'=> $_SESSION['nama']]);
            $this->view('admin/dashboard', ['dokumen' => $dokumen]);
            $this->view('layout/footer');
        }
    }
}