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