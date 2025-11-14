                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Program Studi</h1>

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
                            <h6 class="m-0 font-weight-bold text-primary">Data Program Studi</h6>
                            <button type="button" data-toggle="modal" data-target="#modalTambahProdi" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah data prodi</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Program Studi</th>
                                            <th>Fakultas</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach($data['prodi'] as $p): ?>
                                        <tr>
                                            <td><?= htmlspecialchars((string)$no++) ?></td>
                                            <td><?= htmlspecialchars($p['nama_prodi'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($p['nama_fakultas'] ?? '-') ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditProdi<?= htmlspecialchars($p['id_prodi'])?>"><i class="fas fa-edit"></i> Ubah</button>
                                                <form action="<?=BASE_URL?>/Prodi/hapus" method="POST" class="d-inline">
                                                    <input type="hidden" name="id_prodi" value="<?= $p['id_prodi'] ?>"/>
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin akan menghapus program studi ini?')"><i class="fas fa-trash"></i> Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <!-- Modal tambah prodi -->
                     <div class="modal fade" id="modalTambahProdi" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Program Studi</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?= BASE_URL?>/Prodi/addProdi" method="POST">
                                        <div class="form-group">
                                            <label for="nama_prodi">Nama Program Studi</label>
                                            <input type="text" id="nama_prodi" class="form-control" name="nama_prodi" placeholder="Masukkan program studi">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_fakultas">Fakultas</label>
                                            <select name="fakultas" id="nama_fakultas" class="form-control">
                                                
                                                <option selected disabled value="">-- Pilih Fakultas --</option>
                                                <?php foreach($data['fakultas'] as $f): ?>
                                                <option value="<?= htmlspecialchars($f['id_fakultas'])?>"><?= htmlspecialchars($f['nama_fakultas'])?></option>
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

                     <!-- Modal ubah prodi -->
                      <?php foreach($data['prodi'] as $p):?>
                      <div class="modal fade" id="modalEditProdi<?= $p['id_prodi']?>" tabindex='-1'>
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ubah Data prodi</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?=BASE_URL?>/Prodi/editProdi" method="post">
                                        <input type="hidden" name="id_prodi" value="<?= $p['id_prodi']?>">
                                        <div class="form-group">
                                            <label for="nama_prodi">Program Studi</label>
                                            <input type="text" name="nama_prodi" id="nama_prodi" class="form-control" value="<?= htmlspecialchars($p['nama_prodi'])?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="fakultas">Fakultas</label>
                                            <select name="fakultas" id="fakultas" class="form-control">
                                                <?php foreach($data['fakultas'] as $f):?>
                                                <option value="<?= htmlspecialchars($f['id_fakultas'])?>" <?= ($f['id_fakultas'] == $p['id_fakultas'] ? 'selected' : '')?>><?= htmlspecialchars($f['nama_fakultas'])?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Ubah</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                      </div>
                      <?php endforeach;?>