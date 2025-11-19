                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Dokumen Mahasiswa</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Data Dokumen Mahasiswa</h6>
                            <div class="d-flex gap-2">
                                <button id="btnDownload1" class="btn btn-info btn-sm mr-2"><i class="fas fa-download"></i> Download</button>
                                <button id="btnPrint1" class="btn btn-success btn-sm"><i class="fas fa-print"></i> Print</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Judul Penelitian</th>
                                            <th>Nama Pembimbing</th>
                                            <th>Status Publish</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                        <?php
                                        if($data['dokumen']){
                                        $no = 1;
                                        foreach($data['dokumen'] as $dokumen): ?>
                                        <tr>
                                            <td><?= htmlspecialchars((string)$no++) ?></td>
                                            <td><?= htmlspecialchars($dokumen['mahasiswa_nama'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($dokumen['judul_penelitian'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($dokumen['dosen_nama'] ?? '-') ?></td>
                                            <td><span class="badge badge-pill badge-<?= ($dokumen['status_publish'] ?? '') === 'Published' ? 'success' : (($dokumen['status_publish'] ?? '') === 'Unpublished' ? 'danger' : 'secondary') ?>"><?= htmlspecialchars($dokumen['status_publish'] ?? 'Unknown') ?></span></td>
                                            <td>
                                                <a href="<?=BASE_URL?>/uploads/<?= $dokumen['file_dokumen'] ?>" download target="_blank" class="btn btn-primary btn-sm w-100"><i class="fas fa-eye fa-sm"></i> Lihat Dokumen</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; }else{?>
                                            <td class="text-center" colspan="6">Tidak ada dokumen mahasiswa yang masuk.</td>
                                            <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

<script>
document.getElementById('btnPrint1').addEventListener('click', function() {
    // Ambil tabel sumber
    var table = document.getElementById('dataTable');
    var rows = table.querySelectorAll('tbody tr');

    // Cek apakah ada data
    if(rows.length === 0 || rows[0].querySelector('td[colspan]')) {
        alert('Tidak ada data untuk dicetak!');
        return;
    }

    // Buat HTML tabel yang hanya berisi No, Nama Mahasiswa, Judul Penelitian
    var tableHTML = '<table style="width:100%; border-collapse: collapse;">' +
        '<thead>' +
        '<tr style="color: black; font-weight-bold">' +
        '<th style="border:1px solid #ddd;padding:8px;text-align:center;">No</th>' +
        '<th style="border:1px solid #ddd;padding:8px;text-align:center;">Nama Mahasiswa</th>' +
        '<th style="border:1px solid #ddd;padding:8px;text-align:center;">Judul Penelitian</th>' +
        '<th style="border:1px solid #ddd;padding:8px;text-align:center;">Pembimbing</th>' +
        '<th style="border:1px solid #ddd;padding:8px;text-align:center;">Status Publikasi</th>' +
        '</tr>' +
        '</thead><tbody>';

    rows.forEach(function(row) {
        var cells = row.querySelectorAll('td');
        if(cells.length > 0 && !cells[0].getAttribute('colspan')) {
            var no = cells[0].textContent.trim();
            var nama = cells[1].textContent.trim();
            var judul = cells[2].textContent.trim();
            tableHTML += '<tr>' +
                '<td style="border:1px solid #ddd;padding:8px; text-align: center">' + no + '</td>' +
                '<td style="border:1px solid #ddd;padding:8px;">' + nama + '</td>' +
                '<td style="border:1px solid #ddd;padding:8px;">' + judul + '</td>' +
                '</tr>';
        }
    });

    tableHTML += '</tbody></table>';

    // Buat window baru untuk print
    var printWindow = window.open('', '', 'width=900,height=600');

    // Buat konten print
    var printContent = `
    <!DOCTYPE html>
    <html>
    <head>
        <title>Print Dokumen Mahasiswa</title>
        <link rel="stylesheet" href="<?=BASE_URL?>/assets/css/sb-admin-2.min.css">
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }
            h2 {
                text-align: center;
                color: #333;
                margin-bottom: 30px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            table thead {
                background-color: #007bff;
                color: white;
            }
            table th, table td {
                border: 1px solid #ddd;
                padding: 10px;
                text-align: left;
            }
            table tbody tr:nth-child(even) {
                background-color: #f9f9f9;
            }
            .badge {
                display: inline-block;
                padding: 5px 10px;
                border-radius: 12px;
                font-size: 12px;
                font-weight: bold;
            }
            .badge-success {
                background-color: #28a745;
                color: white;
            }
            .badge-danger {
                background-color: #dc3545;
                color: white;
            }
            .badge-secondary {
                background-color: #6c757d;
                color: white;
            }
            @media print {
                button, a {
                    display: none !important;
                }
            }
        </style>
    </head>
    <body>
        <h2>Data Dokumen Mahasiswa</h2>
        ${tableHTML}
        <script>
            window.print();
            window.onafterprint = function() {
                window.close();
            }
        <\/script>
    </body>
    </html>
    `;
    
    // Tulis konten ke window baru
    printWindow.document.write(printContent);
    printWindow.document.close();
});

document.getElementById('btnDownload1').addEventListener('click', function() {
    // Ambil data dari tabel
    var table = document.getElementById('dataTable');
    var rows = table.querySelectorAll('tbody tr');
    
    // Cek apakah ada data
    if(rows.length === 0 || rows[0].querySelector('td[colspan]')) {
        alert('Tidak ada data untuk diunduh!');
        return;
    }
    
    // Buat HTML untuk PDF
    var htmlContent = `
        <h2 style="text-align: center; margin-bottom: 30px; font-weight: bold; color: black">Data Mahasiswa</h2>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 98%; border-collapse: collapse;">
            <thead>
                <tr style="color: black; font-weight-bold">
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: center">No</th>
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: center">Nama Mahasiswa</th>
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: center">Judul Penelitian</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    rows.forEach(function(row, index) {
        var cells = row.querySelectorAll('td');
        if(cells.length > 0 && !cells[0].getAttribute('colspan')) {
            htmlContent += '<tr>';
            for(var i = 0; i < 3; i++) {
                var text = cells[i].textContent.trim();
                htmlContent += '<td style="border: 1px solid #ddd; padding: 10px;">' + text + '</td>';
            }
            htmlContent += '</tr>';
        }
    });
    
    htmlContent += `
            </tbody>
        </table>
    `;
    
    // Gunakan html2pdf untuk membuat PDF
    if(typeof html2pdf !== 'undefined') {
        var element = document.createElement('div');
        element.innerHTML = htmlContent;
        
        var opt = {
            margin: 10,
            filename: 'dokumen_mahasiswa_' + new Date().getTime() + '.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { orientation: 'landscape', unit: 'mm', format: 'a4' }
        };
        
        html2pdf().set(opt).from(element).save();
    } else {
        alert('Library PDF tidak tersedia. Silakan refresh halaman.');
    }
});
</script>

<!-- Include html2pdf library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>