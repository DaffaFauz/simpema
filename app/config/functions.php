<?php 
function redirectWithMsg($url, $msg, $type)
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['msg'] = $msg;
    $_SESSION['msg_type'] = $type;
    header("location: $url");
    exit;
}

function checkLogin(){
    if(!isset($_SESSION['id_user'])){
        redirectWithMsg(BASE_URL .'/Home/login', 'Anda belum login.', 'danger');
        exit;
    }

    // Mendapatkan path halaman yang sedang diakses
    $currentPath = str_replace('\\','/', dirname($_SERVER['PHP_SELF']));

    // Ambil folder utama setelah views
    $pathParts = explode('/', $currentPath);
    $folderName = '';
    if(($key = array_search('views', $pathParts)) !== false && isset($pathParts[$key + 1])){
        $folderName = strtolower($pathParts[$key + 1]);
    }

    // Map folder ke role
    $roleMap = [
        'admin' => 'Admin',
        'kaprodi' => 'Kaprodi',
        'pembimbing' => 'Pembimbing',
        'mahasiswa' => 'Mahasiswa'
    ];

    // Cek folder yang memiliki role
    if(array_key_exists($folderName, $roleMap)){
        $expectedRole = $roleMap[$folderName];
        $userRole = strtolower($_SESSION['role']);
        $expectedRoleLower = strtolower($expectedRole);

        if($userRole !== $expectedRoleLower){
            redirectWithMsg(BASE_URL .'/Auth/login', 'Anda tidak memiliki izin untuk mengakses halaman ini.', 'danger');
            exit;
        }
    }


// Helper function untuk check jabatan user
function hasMultipleJabatan() {
    return isset($_SESSION['jumlah_jabatan']) && $_SESSION['jumlah_jabatan'] >= 2;
}

function getJabatanList() {
    return $_SESSION['jabatan_list'] ?? [];
}

function getUserJabatanCount() {
    return $_SESSION['jumlah_jabatan'] ?? 1;
}
        

}

// Jika halaman ini membutuhkan role tertentu, kita cek sesuai kebutuhan
function checkRole($allowed_roles = []) {
    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowed_roles)) {
        redirectWithMsg(BASE_URL .'/Auth/login', 'Anda tidak memiliki izin untuk mengakses halaman ini.', 'danger');
        exit;
    }
}