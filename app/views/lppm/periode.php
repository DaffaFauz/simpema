                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Periode Tahun Akademik</h1>

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
                            <h6 class="m-0 font-weight-bold text-primary">Data Periode Tahun Akademik</h6>
                            <button type="button" data-toggle="modal" data-target="#modalTambahPeriode" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah periode</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tahun</th>
                                            <th>Periode</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach($data['periode'] as $periode): ?>
                                        <tr>
                                            <td><?= htmlspecialchars((string)$no++) ?></td>
                                            <td><?= htmlspecialchars($periode['tahun'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($periode['periode'] ?? '-') ?></td>
                                            <td><span class=" badge badge-<?=($periode['status'] === 'Aktif') ? 'success': 'danger'?>"><?= htmlspecialchars($periode['status'] ?? '-') ?></span></td>
                                            <td>
                                                <form action="<?=BASE_URL?>/Periode/ubahStatus" method="post" class="d-inline">
                                                    <button type="submit" class="btn btn-<?=($periode['status'] == 'Aktif' ? 'danger' : 'success')?> btn-sm " name="id_tahun" value="<?= htmlspecialchars($periode['id_tahun'])?>" onclick="return confirm('Yakin akan <?= htmlspecialchars(($periode['status'] == 'Aktif' ? 'menonaktifkan' :'mengaktifkan'))?> periode ini?') "><i class="fas fa-power-off fa-sm"></i> <?= htmlspecialchars(($periode['status'] == 'Aktif' ? 'Nonaktifkan' :'Aktifkan'))?></button>
                                                </form>
                                                <!-- <form action="<?php ///BASE_URL?>/Periode/hapus" method="POST" class="d-inline">
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin akan menghapus periode ini?')" name="id_tahun" value="<?php //htmlspecialchars($periode['id_tahun'])?>"><i class="fas fa-trash"></i> Hapus </button>
                                                </form> -->
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Modal tambah periode -->
                     <div class="modal fade" tabindex="-1" id="modalTambahPeriode">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title">Tambah Periode</h6>
                                </div>
                                <div class="modal-body">
                                    <form action="<?=BASE_URL?>/Periode/addPeriode" method="post">
                                        <div class="form-group">
                                            <label for="tahun">Tahun</label>
                                            <input type="text" class="form-control" id="tahun" name="tahun" value="<?= date('Y').'/'.date('Y')+1 ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="periode">Periode</label>
                                            <select name="periode" id="periode" class="form-control">
                                                <option value="Ganjil">Ganjil</option>
                                                <option value="Ganjil">Genap</option>
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