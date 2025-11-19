<script>
// load option prodi
$(document).ready(function(){
        $('#fakultas').on('change', function(){
        // Mendapatkan input fakultas
        var id_fakultas = $('#fakultas').val();
        $('#prodi').html(`<option selected disabled value=""> Pilih Prodi</option>`);

        if(id_fakultas){
            $.ajax({
                url: '<?=BASE_URL;?>/Prodi/getProdi/' + id_fakultas,
                type: 'POST',
                data: {fakultas: id_fakultas},
                success: function(response){
                    var data;
                    try {
                        data = (typeof response === 'string') ? JSON.parse(response) : response;
                    } catch(err) {
                        console.error('Invalid JSON response (Prodi):', response);
                        alert('Gagal memproses data prodi. Periksa respons server di Network.');
                        return;
                    }
                    if(data && data.length > 0){
                        $.each(data, function(index, item){
                            // Pastikan value adalah id_prodi, bukan nama
                            $('#prodi').append($('<option>', {
                                value: item.id_prodi || item.id,
                                text: item.nama_prodi || item.nama
                            }));
                        });
                    } else{
                        $('#prodi').append('<option disabled>Tidak ada Prodi</option>');
                    }
                },
                error: function(xhr, status, error){
                    console.log("AJAX Error (Prodi):" + error);
                    alert("Gagal memuat data prodi")
                }
            });

        }
    })
   // Hilangkan submit form tradisional: gunakan AJAX untuk update tabel
   // Ketika prodi/status/fakultas berubah, jalankan applyFilters
   $('#prodi').on('change', function(){ applyFilters(); })
   $('#status').on('change', function(){ applyFilters(); })
    // Fungsi untuk menerapkan filter dan memperbarui tabel
    function applyFilters() {
        var fakultas = $('#fakultas').val();
        var prodi = $('#prodi').val();
        var status = $('#status').val();

        $.ajax({
            url: '<?=BASE_URL;?>/Dokumen/filter',
            type: 'POST',
            data: {
                fakultas: fakultas,
                prodi: prodi,
                status: status
            },
            dataType: 'json',
            success: function(response) {
                var tableBody = $('#dokumen-table-body');
                tableBody.empty();
                if (response.length > 0) {
                    var no = 1;
                    $.each(response, function(index, item) {
                        var statusBadge = '';
                        if (item.status_publish === 'Published') {
                            statusBadge = '<span class="badge badge-pill badge-success">Published</span>';
                        } else if (item.status_publish === 'Unpublished') {
                            statusBadge = '<span class="badge badge-pill badge-danger">Unpublished</span>';
                        } else {
                            statusBadge = '<span class="badge badge-pill badge-secondary">Unknown</span>';
                        }

                        // tentukan redirect_page berdasarkan URL saat ini (pengajuan / dashboard / kosong)
                        var _pathname = window.location.pathname || '';
                        var redirectVal = '';
                        if(_pathname.toLowerCase().indexOf('pengajuan') !== -1){
                            redirectVal = 'pengajuan';
                        } else if(_pathname.toLowerCase().indexOf('dashboard') !== -1){
                            redirectVal = 'dashboard';
                        }

                        var actionsHtml = '<div class="dropdown">' +
                            '<button class="btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>' +
                            '<div class="dropdown-menu" aria-labelledby="dropdownMenu2">' +
                            '<form action="<?=BASE_URL?>/Dokumen/status_publish" method="POST">' +
                            '<input type="hidden" name="redirect_page" value="' + redirectVal + '">' +
                            '<input type="hidden" name="id_dokumen" value="' + item.id_dokumen + '"/>';
                        
                        if (item.status_publish === 'Unknown') {
                            actionsHtml += '<button type="submit" class="btn btn-success btn-sm w-100 mb-1" name="status_publish" value="Published">Sudah publish</button>' +
                                         '<button type="submit" class="btn btn-danger btn-sm w-100 mb-1" name="status_publish" value="Unpublished">Belum Publish</button>';
                        } else if (item.status_publish === 'Published') {
                            actionsHtml += '<button type="submit" class="btn btn-danger btn-sm w-100 mb-1" name="status_publish" value="Unpublished">Belum Publish</button>';
                        } else if (item.status_publish === 'Unpublished') {
                            actionsHtml += '<button type="submit" class="btn btn-success btn-sm w-100 mb-1" name="status_publish" value="Published">Sudah publish</button>';
                        }
                        
                        actionsHtml += '</form>' +
                            '<a href="<?=BASE_URL?>/uploads/' + item.file_dokumen + '" download target="_blank" class="btn btn-primary btn-sm w-100"><i class="fas fa-eye fa-sm"></i> Lihat Dokumen</a>' +
                            '</div></div>';

                        var row = '<tr>' +
                            '<td>' + (no++) + '</td>' +
                            '<td>' + (item.mahasiswa_nama || '-') + '</td>' +
                            '<td>' + (item.judul_penelitian || '-') + '</td>' +
                            '<td>' + (item.dosen_nama || '-') + '</td>' +
                            '<td>' + statusBadge + '</td>' +
                            '<td>' + actionsHtml + '</td>' +
                            '</tr>';
                        tableBody.append(row);
                    });
                } else {
                    tableBody.append('<tr><td colspan="6" class="text-center">Data tidak ditemukan</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error (Filter):', error);
                alert('Gagal memuat data yang difilter.');
            }
        });
    }

    // Event listener untuk filter
    $('#fakultas, #prodi, #status').on('change', function(){ applyFilters(); });
    
})  
</script>

<script>
    $(document).ready(function () {
        $('.dataTable').DataTable();
    });
</script>

    <!-- Ini untuk filter di dokumen pengajuan -->
     <script>
        $(document).ready(function() {
        // Hanya jalankan skrip ini di halaman pengajuan
        if ($('#formFilterPengajuan').length > 0) {

            // Ambil data prodi berdasarkan fakultas
            $('#fakultas1').on('change', function() {
                var fakultas = $(this).val();
                var prodi = $('#prodi1');
                prodi.html('<option selected disabled value=""> Pilih Prodi</option>');

                $.ajax({
                    url: `<?=BASE_URL?>/Prodi/getProdi/${fakultas}`,
                    type: 'POST',
                    data: {fakultas: fakultas},
                    success: function(response) {
                        var data;
                        try {
                                data = (typeof response === 'string') ? JSON.parse(response) : response;
                            } catch(err) {
                                return;
                            }
                            if(data && data.length > 0){
                                $.each(data, function(index, item){
                                    $('#prodi1').append($('<option>', {
                                        value: item.id_prodi,
                                        text: item.nama_prodi
                                    }));
                                });
                            } else{
                                $('#prodi1').append('<option disabled>Tidak ada Prodi</option>');
                            }
                        },
                        error: function(xhr, status, error){
                            console.log("AJAX Error (Prodi):" + error);
                            alert("Gagal memuat data prodi")
                        }
                })
            })

            function applyPengajuanFilters() {
                var fakultas = $('#formFilterPengajuan #fakultas1').val();
                var prodi = $('#formFilterPengajuan #prodi1').val();
                var tahun = $('#formFilterPengajuan #tahun1').val();

                $.ajax({
                    url: '<?=BASE_URL;?>/Pengajuan/filter',
                    type: 'POST',
                    headers: { "X-Requested-With": "XMLHttpRequest" },
                    data: {
                        fakultas: fakultas,
                        prodi: prodi,
                        tahun: tahun
                    },
                    dataType: 'json',
                    success: function(response) {
                        
                        // Bersihkan semua tab body
                        $('#table-requested tbody, #table-rejected tbody, #table-accepted tbody, #table-published tbody').empty();

                        if (response.length > 0) {
                            var noReq = 1, noRej = 1, noAcc = 1, noPub = 1;
                            $.each(response, function(index, item) {
                                var statusPengajuanBadge = item.status === 'Accepted' ? '<span class="badge badge-pill badge-success">Accepted</span>' : (item.status === 'Rejected' ? '<span class="badge badge-pill badge-danger">Rejected</span>' : '<span class="badge badge-pill badge-warning">Requested</span>');
                                var statusPublishBadge = item.status_publish === 'Published' ? '<span class="badge badge-pill badge-success">Published</span>' : (item.status_publish === 'Unpublished' ? '<span class="badge badge-pill badge-danger">Unpublished</span>' : '<span class="badge badge-pill badge-secondary">Unknown</span>');

                                var actionsHtml = `
                                    <div class="dropdown">
                                        <button class="btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                            <button type="button" class="btn btn-primary btn-sm w-100 mb-1" data-toggle="modal" data-target="#modalDetailPengajuan${item.id_dokumen}"><i class="fas fa-eye fa-sm"></i> Detail Pengajuan</button>
                                            <form action="<?=BASE_URL?>/Dokumen/status_publish" method="POST">
                                                <input type="hidden" name="id_dokumen" value="${item.id_dokumen}"/>
                                                <input type="hidden" name="redirect_page" value="pengajuan">
                                                ${item.status_publish === 'Unknown' ? '<button type="submit" class="btn btn-success btn-sm w-100 mb-1" name="status_publish" value="Published">Sudah publish</button><button type="submit" class="btn btn-danger btn-sm w-100 mb-1" name="status_publish" value="Unpublished">Belum Publish</button>' : ''}
                                                ${item.status_publish === 'Unpublished' ? '<button type="submit" class="btn btn-success btn-sm w-100 mb-1" name="status_publish" value="Published"><i class="fas fa-check fa-sm"></i> Sudah publish</button>' : ''}
                                            </form>
                                            ${item.status_publish === 'Published' ? `<button type="button" class="btn btn-primary btn-sm w-100 mb-1" data-toggle="modal" data-target="#modalDetailJurnal${item.id_dokumen}"><i class="fas fa-eye fa-sm"></i> Detail Jurnal</button>` : ''}
                                        </div>
                                    </div>`;

                                var rowHtml = `<tr>
                                    <td>${(item.status === 'Requested' ? noReq++ : (item.status === 'Rejected' ? noRej++ : (item.status_publish === 'Unpublished' && item.status === 'Accepted' ? noAcc++ : noPub++)))}</td>
                                    <td>${item.mahasiswa_nama || '-'}</td>
                                    <td>${item.judul_penelitian || '-'}</td>
                                    <td>${item.dosen_nama || '-'}</td>
                                    <td>${statusPengajuanBadge}</td>
                                    <td>${statusPublishBadge}</td>
                                    <td>${actionsHtml}</td>
                                </tr>`;

                                if (item.status === 'Requested') {
                                    $('#table-requested tbody').append(rowHtml);
                                }
                                if (item.status === 'Rejected') {
                                    $('#table-rejected tbody').append(rowHtml);
                                }
                                if (item.status_publish === 'Unpublished' && item.status === 'Accepted') {
                                     $('#table-accepted tbody').append(rowHtml);
                                }
                                if (item.status_publish === 'Published' && item.status === 'Accepted') {
                                    $('#table-published tbody').append(rowHtml);
                                }
                            });
                        } else {
                            var emptyRow = '<tr><td colspan="7" class="text-center">Data tidak ditemukan</td></tr>';
                            $('#table-requested tbody, #table-rejected tbody, #table-accepted tbody, #table-published tbody').append(emptyRow);
                        }
                        // Inisialisasi ulang DataTable pada semua tabel
                        $('.dataTable').DataTable();
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error (Filter Pengajuan):', error, xhr.responseText);
                        // Tidak menampilkan alert, cukup log di console
                    }
                });
            }

            // Event listener untuk select filter
            $('#formFilterPengajuan #fakultas1, #formFilterPengajuan #prodi1, #formFilterPengajuan #tahun1').on('change', function() {
                applyPengajuanFilters();
            });
        }
    });
    </script>