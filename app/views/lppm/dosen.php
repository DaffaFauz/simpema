                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Dosen</h1>

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
                            <h6 class="m-0 font-weight-bold text-primary">Data Dosen</h6>
                            <button type="button" data-toggle="modal" data-target="#modalTambahDosen" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Data Dosen</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIDN</th>
                                            <th>Nama Dosen</th>
                                            <th>Email</th>
                                            <th>Program Studi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach($data['dosen'] as $dokumen): ?>
                                        <tr>
                                            <td><?= htmlspecialchars((string)$no++) ?></td>
                                            <td><?= htmlspecialchars($dokumen['nidn'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($dokumen['nama'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($dokumen['email'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($dokumen['nama_prodi'] ?? '-') ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditDosen<?= htmlspecialchars($dokumen['nidn'])?>"><i class="fas fa-edit fa-sm"></i> Ubah</button>
                                                <form action="<?=BASE_URL?>/Dosen/hapus" method="POST" class="d-inline">
                                                        <button type="submit" class="btn btn-danger btn-sm" name="id_user" onclick="return confirm('Apakah Anda Yakin menghapus dosen ini?')" value="<?= htmlspecialchars($dokumen['id_user'])?>"><i class="fas fa-trash fa-sm"></i> Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Modal tambah Dosen -->
                     <div class="modal fade" id="modalTambahDosen" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Dosen</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?= BASE_URL?>/Dosen/Tambah" method="post">
                                        <div class="form-group">
                                            <label for="nidn">NIDN</label>
                                            <input type="text" class="form-control" name="nidn" id="nidn" placeholder="NIDN dosen">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Nama Dosen</label>
                                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Dosen">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" id="email" placeholder="Email Dosen">
                                        </div>
                                        <div class="form-group">
                                            <label for="prodi">Program Studi</label>
                                            <select name="prodi" id="prodi" class="form-control">
                                                <option value="">Pilih Prodi</option>
                                                <?php foreach($data['prodi'] as $p):?>
                                                <option value="<?= htmlspecialchars($p['id_prodi'])?>"><?= htmlspecialchars($p['nama_prodi'])?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                </div>
                                </form>
                            </div>
                        </div>
                     </div>

                     <!-- Modal ubah dosen -->
                      <?php foreach($data['dosen'] as $dokumen):?>
                        <div class="modal fade" id="modalEditDosen<?= $dokumen['nidn']?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ubah Dosen</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?= BASE_URL?>/Dosen/ubah" method="post">
                                        <input type="hidden" class="form-control" name="id_user" id="id_user" value="<?=htmlspecialchars($dokumen['id_user'])?>">
                                        <div class="form-group">
                                            <label for="nidn">NIDN</label>
                                            <input type="text" class="form-control" name="nidn" id="nidn" placeholder="NIDN dosen" value="<?=htmlspecialchars($dokumen['nidn'])?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Nama Dosen</label>
                                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Dosen" value="<?= htmlspecialchars($dokumen['nama'])?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" id="email" placeholder="Email Dosen" value="<?=htmlspecialchars($dokumen['email'])?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="prodi">Program Studi</label>
                                            <select name="prodi" id="prodi" class="form-control">
                                                <option value="">Pilih Prodi</option>
                                                <?php foreach($data['prodi'] as $p):?>
                                                <option value="<?= htmlspecialchars($p['id_prodi'])?>" <?= ($p['id_prodi'] == $dokumen['id_prodi'] ? 'selected' : '')?>><?= htmlspecialchars($p['nama_prodi'])?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                </div>
                                </form>
                            </div>
                        </div>
                     </div>
                      <?php endforeach;?>