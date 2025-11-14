                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Fakultas</h1>
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
                            <h6 class="m-0 font-weight-bold text-primary">Data Fakultas</h6>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modaltambahFakultas"><i class="fas fa-plus"></i> Tambah data fakultas</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Fakultas</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach($data['fakultas'] as $f): ?>
                                        <tr>
                                            <td><?= htmlspecialchars((string)$no++) ?></td>
                                             
                                            <td><?= htmlspecialchars($f['nama_fakultas'] ?? '-') ?></td>
                                            <td> <button type="button" data-toggle="modal" data-target="#modaleditFakultas<?htmlspecialchars($f['id_fakultas'])?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Ubah</button>

                                                <!-- <form action="<?php //BASE_URL?>/Dokumen/status" method="POST" class="d-inline">
                                                    <input type="hidden" name="id_dokumen" value="<?= $f['id_fakultas'] ?>"/>
                                                    <?php //if($f['status_publish'] === 'Unpublished' && $f['status'] === NULL){ ?>
                                                        <button type="submit" class="btn btn-success btn-sm w-100 mb-1" name="status" value="Requested"><i class="fas fa-upload fa-sm"></i> Ajukan</button>
                                                    <?php //}?>
                                                </form> -->
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    <!-- Modal Tambah Fakultas -->
                    <div class="modal fade" id="modaltambahFakultas" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Fakultas</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?=BASE_URL?>/Fakultas/addFakultas" method="POST">
                                        <div class="form-group">
                                            <label for="nama_fakultas">Nama Fakultas</label>
                                            <input type="text" class="form-control" id="nama_fakultas" name="nama_fakultas" placeholder="Nama Fakultas">
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

                    <!-- Modal Ubah Fakultas -->
                     <?php foreach($data['fakultas'] as $f): ?>
                    <div class="modal fade" id="modaleditFakultas<?htmlspecialchars($f['id_fakultas'])?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ubah Fakultas</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?=BASE_URL?>/Fakultas/editFakultas" method="POST">
                                        <input type="hidden" name="id_fakultas">
                                        <div class="form-group">
                                            <label for="nama_fakultas">Nama Fakultas</label>
                                            <input type="text" class="form-control" id="nama_fakultas" name="nama_fakultas" placeholder="Nama Fakultas" value="<?= htmlspecialchars($f['nama_fakultas'])?>">
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