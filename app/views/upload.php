<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SIMPEMA - Unggah Dokumen</title>

    <!-- Custom fonts for this template-->
    <link href="<?= ASSETS_URL ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= ASSETS_URL ?>/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center align-items-center">

            <div class="col-xl-8 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Unggah Dokumen Penelitian</h1>
                                    </div>
                                    <?php if (isset($_SESSION['msg'])): ?>
                                        <div class="alert alert-<?= $_SESSION['msg_type'] ?> alert-dismissible fade show"
                                            role="alert">
                                            <?= $_SESSION['msg'] ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <?php unset($_SESSION['msg']);
                                    endif; ?>
                                    <form class="user" action="<?= BASE_URL ?>/Dokumen/upload_dokumen" method="POST"
                                        enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-6">
                                                <!-- NIM -->
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="nim"
                                                        aria-describedby="emailHelp" name="nim"
                                                        placeholder="Masukkan NIM">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <!-- Nama -->
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="nama"
                                                        aria-describedby="emailHelp" name="nama"
                                                        placeholder="Masukkan Nama Anda">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Email -->
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email"
                                                aria-describedby="emailHelp" name="email"
                                                placeholder="Masukkan Email Anda    ">
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <!-- Fakultas -->
                                                <div class="form-group">
                                                    <select name="fakultas" class="form-control" id="fakultas">
                                                        <option selected value="">-- Pilih Fakultas --</option>
                                                        <?php foreach ($data['fakultas'] as $row): ?>
                                                            <option value="<?= $row['id_fakultas'] ?>">
                                                                <?= $row['nama_fakultas'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <div class="invalid-feedback">Fakultas harus diisi.</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <!-- Jurusan / Prodi -->
                                                <div class="form-group">
                                                    <select name="prodi" class="form-control" id="prodi">
                                                        <option selected disabled value="">-- Pilih Prodi --</option>
                                                    </select>
                                                    <div class="invalid-feedback">Prodi harus diisi.</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- judul penelitian -->
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="judul"
                                                aria-describedby="emailHelp" name="judul"
                                                placeholder="Masukkan Judul Penelitian">
                                        </div>
                                        <!-- Upload dokumen -->
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="inputFileDokumen"
                                                    aria-describedby="inputGroupFileAddon01" name="dokumen">
                                                <label class="custom-file-label" for="inputFileDokumen">Pilih
                                                    File</label>
                                            </div>
                                            <span class="text-sm">Dokumen harus format .docx</span>
                                        </div>
                                        <!-- Dosen Pembimbing -->
                                        <div class="form-group">
                                            <select name="pembimbing" class="form-control" id="pembimbing">
                                                <option selected disabled value="">-- Masukkan Dosen Pembimbing Anda --
                                                </option>
                                            </select>
                                            <div class="invalid-feedback">Pembimbing harus diisi.</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                                                <a href="<?= BASE_URL ?>" class="btn btn-secondary btn-sm rounded">
                                                    <i class="fas fa-arrow-alt-circle-left"></i>
                                                    Kembali
                                                </a>
                                                <button type="submit" class="btn btn-primary btn-sm rounded">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                    Unggah
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= ASSETS_URL ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= ASSETS_URL ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= ASSETS_URL ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= ASSETS_URL ?>js/sb-admin-2.min.js"></script>

    <script>
        // load option prodi & pembimbing
        $(document).ready(function () {
            $('#fakultas').on('change', function () {
                // Mendapatkan input fakultas
                var id_fakultas = $('#fakultas').val();
                $('#prodi').html(`<option selected disabled value="">-- Pilih Prodi --</option>`);
                $('#pembimbing').html(`<option selected disabled value="">-- Pilih Dosen Pembimbing --</option>`);

                if (id_fakultas) {
                    $.ajax({
                        url: '<?= BASE_URL; ?>/Prodi/getProdi/' + id_fakultas,
                        type: 'POST',
                        data: { fakultas: id_fakultas },
                        success: function (response) {
                            var data;
                            try {
                                data = (typeof response === 'string') ? JSON.parse(response) : response;
                            } catch (err) {
                                console.error('Invalid JSON response (Prodi):', response);
                                alert('Gagal memproses data prodi. Periksa respons server di Network.');
                                return;
                            }
                            if (data && data.length > 0) {
                                $.each(data, function (index, item) {
                                    $('#prodi').append($('<option>', {
                                        value: item.id_prodi,
                                        text: item.nama_prodi
                                    }));
                                });
                            } else {
                                $('#prodi').append('<option disabled>Tidak ada Prodi</option>');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log("AJAX Error (Prodi):" + error);
                            alert("Gagal memuat data prodi")
                        }
                    });

                    // Panggilan AJAX untuk mendapatkan Dosen Pembimbing dari database
                    $.ajax({
                        url: '<?= BASE_URL; ?>/Dosen/getDosenByFakultas/',
                        type: 'POST',
                        data: { fakultas: id_fakultas },
                        success: function (response) {
                            var data;
                            try {
                                data = (typeof response === 'string') ? JSON.parse(response) : response;
                            } catch (err) {
                                console.error('Invalid JSON response (Dosen):', response);
                                alert('Gagal memproses data dosen. Periksa respons server di Network.');
                                return;
                            }

                            // Untuk fakultas 1 atau 4, tambahkan dua dosen tetap di awal daftar
                            if (id_fakultas == 4) {
                                var fixed = [
                                    { nidn: 428016502, nama: 'Ida Rapida, M.M' },
                                    { nidn: 416118503, nama: 'M Ryzki Wiryawan, S.IP., M.T' }
                                ];
                                data = fixed.concat(data || []);
                            }

                            if (data && data.length > 0) {
                                $.each(data, function (index, item) {
                                    $('#pembimbing').append($('<option>', {
                                        value: item.nidn,
                                        text: item.nama
                                    }));
                                });
                            } else {
                                $('#pembimbing').append('<option disabled>Tidak ada Dosen</option>');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log("AJAX Error (Dosen):" + error);
                            alert("Gagal memuat data dosen pembimbing")
                        }
                    });

                }
            })

            // Update filename label
            $('#inputFileDokumen').on('change', function () {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        })
    </script>


</body>

</html>