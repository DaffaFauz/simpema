                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Pembimbing Penelitian</h1>

                    <?php if (isset($_SESSION['msg'])):?>
                                <div class="alert alert-<?= $_SESSION['msg_type'] ?> alert-dismissible fade show" role="alert">
                                    <?= $_SESSION['msg'] ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php unset($_SESSION['msg']);
                        endif; ?>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Data Pembimbing</h6>
                            <button type="button" data-toggle="modal" data-target="#modalTambahPembimbing" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Data Pembimbing</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIDN</th>
                                            <th>Nama Pembimbing</th>
                                            <th>Program Studi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach($data['pembimbing'] as $dokumen): ?>
                                        <tr>
                                            <td><?= htmlspecialchars((string)$no++) ?></td>
                                            <td><?= htmlspecialchars($dokumen['nidn'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($dokumen['nama'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($dokumen['nama_prodi'] ?? 'Unknown') ?></td>
                                            <td>

                                                <form action="<?=BASE_URL?>/Pembimbing/lepas" method="POST" class="d-inline">
                                                    <button type="submit" class="btn btn-danger btn-sm" name="id_user" value="<?= htmlspecialchars($dokumen['id_user'])?>" onclick="return confirm('Yakin akan mencabut dosen ini sebagai pembimbing?')"><i class="fas fa-link fa-sm"></i> Lepas jabatan</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Modal untuk menambahkan pembimbing -->
                     <div class="modal fade" id="modalTambahPembimbing" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Kaprodi</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?=BASE_URL?>/Pembimbing/add" method="post">
                                        <div class="form-group">
                                            <label for="prodi">Dosen</label>
                                            <select name="dosen" id="dosen" class="form-control">
                                                <option value="">Pilih Pembimbing</option>
                                                <?php foreach($data['dosen'] as $d): ?>
                                                <option value="<?= htmlspecialchars($d['id_user'])?>"><?=htmlspecialchars($d['nama'])?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                     </div>