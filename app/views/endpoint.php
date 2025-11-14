<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Jabatan || SIMPENMA</title>
    <link rel="stylesheet" href="<?= ASSETS_URL;?>/css/sb-admin-2.min.css">
    <style>
        body {
            background:  #667eea;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }
        .card-body {
            padding: 3rem 2rem;
        }
        .welcome-header {
            margin-bottom: 2rem;
        }
        .welcome-header h4 {
            color: #667eea;
            font-weight: 700;
            font-size: 1.5rem;
        }
        .welcome-header p {
            color: #6c757d;
            font-size: 0.95rem;
        }
        .role-buttons-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .role-btn {
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            color: white;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .role-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }
        .role-btn:active {
            transform: translateY(0);
        }
        .role-badge {
            display: inline-block;
            background: #f8f9fa;
            color: #667eea;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }
        .divider {
            text-align: center;
            margin: 1.5rem 0;
            color: #adb5bd;
            font-size: 0.9rem;
        }
        .logout-link {
            margin-top: 2rem;
            text-align: center;
        }
        .logout-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        .logout-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card shadow-lg mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <div class="welcome-header">
                    <h4>👋 Selamat Datang, <strong><?= htmlspecialchars($_SESSION['nama'] ?? 'User'); ?></strong></h4>
                    <p>Anda memiliki <strong><?= count($_SESSION['jabatan_list'] ?? []); ?> peran</strong>. Silakan pilih salah satu untuk melanjutkan:</p>
                </div>

                <div class="role-buttons-container">
                    <?php 
                    $jabatanList = $_SESSION['jabatan_list'] ?? [];
                    if(!empty($jabatanList)): 
                        foreach ($jabatanList as $index => $jabatan): 
                    ?>
                        <form method="POST" action="<?= BASE_URL; ?>/Auth/selectJabatan" style="margin: 0;">
                            <input type="hidden" name="id_jabatan" value="<?= htmlspecialchars($jabatan['id_jabatan']); ?>">
                            <input type="hidden" name="nama_jabatan" value="<?= htmlspecialchars($jabatan['nama_jabatan']); ?>">
                            <button type="submit" class="role-btn btn-block">
                                <?= htmlspecialchars($jabatan['nama_jabatan']); ?>
                                <span class="role-badge">Pilih</span>
                            </button>
                        </form>
                    <?php 
                        endforeach; 
                    else: 
                    ?>
                        <div class="alert alert-warning" role="alert">
                            Tidak ada jabatan yang ditemukan. Hubungi administrator.
                        </div>
                    <?php endif; ?>
                </div>

                <div class="logout-link">
                    <a href="<?= BASE_URL; ?>/Auth/logout">← Kembali / Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= ASSETS_URL; ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= ASSETS_URL; ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>