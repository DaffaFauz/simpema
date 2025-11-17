<?php 
class Auth extends Controller {
    public function index() {
        if($this->model('UserModel')->login($_POST)){
            // Get number of jabatan
            $jumlah_jabatan = $_SESSION['jumlah_jabatan'] ?? 1;
            
            // Jika user memiliki 2 jabatan, arahkan ke endpoint
            if($jumlah_jabatan >= 2) {
                $this->view('endpoint');
                exit;
            }
            
            // Get Role
            $role = $_SESSION['role'];

            // Login sesuai role
            switch($role){
                case 'Mahasiswa':
                    header('location: '. BASE_URL .'/Dashboard');
                    break;
                case 'Pembimbing':
                    header('location: '. BASE_URL .'/Dashboard');
                    break;
                case 'Kaprodi':
                    header('location: '. BASE_URL .'/Dashboard');
                    break;
                case 'LPPM':
                    header('location: '. BASE_URL .'/Dashboard');
                    break;
                case 'Admin':
                    header('location: '. BASE_URL .'/Dashboard');
                    break;
                default:
                    redirectWithMsg(BASE_URL .'/Home/login', 'Role tidak ditemukan.', 'danger');
                    break;
            }
            exit;
        }else{
            redirectWithMsg(BASE_URL .'/Home/login', 'Gagal Login, Username atau Password salah.', 'danger');
            exit;
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        redirectWithMsg(BASE_URL . "/Home/login", "Anda telah logout.", "success");
        exit();
    }

    public function selectJabatan() {
        // Check if user is logged in
        if(!isset($_SESSION['id_user'])) {
            redirectWithMsg(BASE_URL . "/Home/login", "Silakan login terlebih dahulu.", "danger");
            exit;
        }

        // Get selected jabatan from POST
        if(!isset($_POST['id_jabatan']) || !isset($_POST['nama_jabatan'])) {
            redirectWithMsg(BASE_URL . "/Home/login", "Data jabatan tidak valid.", "danger");
            exit;
        }

        $id_jabatan = $_POST['id_jabatan'];
        $nama_jabatan = $_POST['nama_jabatan'];

        // Update session role dengan jabatan yang dipilih
        $_SESSION['role'] = $nama_jabatan;
        $_SESSION['id_jabatan'] = $id_jabatan;

        // Routing sesuai dengan role yang dipilih
        switch($nama_jabatan) {
            case 'Mahasiswa':
                header('location: ' . BASE_URL . '/Dashboard');
                break;
            case 'Pembimbing':
                header('location: ' . BASE_URL . '/Dashboard');
                break;
            case 'Kaprodi':
                header('location: ' . BASE_URL . '/Dashboard');
                break;
            case 'LPPM':
                header('location: ' . BASE_URL . '/Dashboard');
                break;
            case 'Admin':
                header('location: ' . BASE_URL . '/Dashboard');
                break;
            default:
                redirectWithMsg(BASE_URL . "/Home/login", "Role tidak ditemukan.", "danger");
                exit;
        }
        exit;
    }
}