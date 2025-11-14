<?php 

class Home extends Controller{
    public function index(){
        $this->view("home");
    }

    public function login(){
        $this->view("login");
    }

    public function upload(){
        // Mengambil data fakultas
        $fakultas = $this->model("FakultasModel")->getAll();

        $this->view("upload", ['fakultas' => $fakultas]);
    }
}