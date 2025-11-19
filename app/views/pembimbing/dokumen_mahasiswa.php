                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Dokumen Mahasiswa</h1>
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
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Dokumen Mahasiswa</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Judul Penelitian</th>
                                            <th>Status publish</th>
                                            <th>Status Pengajuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach($data['dokumen'] as $dokumen): ?>
                                        <tr>
                                            <td><?= htmlspecialchars((string)$no++) ?></td>
                                            <td><?= htmlspecialchars($dokumen['mahasiswa_nama'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($dokumen['judul_penelitian'] ?? '-') ?></td>
                                            <td><span class="badge badge-pill badge-<?= ($dokumen['status_publish'] ?? '') === 'Published' ? 'success' : (($dokumen['status_publish'] ?? '') === 'Unpublished' ? 'danger' : 'secondary') ?>"><?= htmlspecialchars($dokumen['status_publish'] ?? 'Unknown') ?></span></td>
                                            <td><span class="badge badge-pill badge-<?= ($dokumen['status'] ?? '') === 'Accepted' ? 'success' : (($dokumen['status'] ?? '') === 'Rejected' ? 'danger' : (($dokumen['status'] ?? '') === 'Requested' ? 'warning' : 'secondary')) ?>"><?= htmlspecialchars($dokumen['status'] ?? 'Not yet Request') ?></span></td>
                                            <td><div class="dropdown">
                                                    <button class="btn" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                         <form action="<?=BASE_URL?>/Dokumen/status" method="POST" class="d-inline">
                                                    <input type="hidden" name="id_dokumen" value="<?= $dokumen['id_dokumen'] ?>"/>
                                                    <?php if($dokumen['status_publish'] === 'Unpublished' && $dokumen['status'] === NULL){ ?>
                                                        <button type="button" class="btn btn-success btn-sm mb-1 w-100" name="status" value="Requested" data-toggle="modal" data-target="#modalAjukan<?= $dokumen['id_dokumen']?>"><i class="fas fa-upload fa-sm"></i> Ajukan</button>
                                                    <?php }?>
                                                </form>
                                                    <?php if($dokumen['status'] === 'Accepted' && $dokumen['status_publish'] === 'Unpublished'){ ?>
                                                        <button type="button" class="btn btn-success btn-sm mb-1 w-100" data-toggle="modal" data-target="#reportPublish<?= $dokumen['id_dokumen']?>"><i class="fas fa-check fa-sm"></i> Report publish</button>
                                                    <?php }else if($dokumen['status'] === 'Rejected'){?>
                                                        <button type="button" class="btn btn-danger btn-sm mb-1 w-100" data-toggle="modal" data-target="#modalCatatan<?=$dokumen['id_dokumen']?>"><i class="fas fa-eye fa-sm"></i> Lihat catatan Penolakan</button>
                                                    <?php }?>
                                                        <a href="<?=BASE_URL?>/uploads/<?= $dokumen['file_dokumen'] ?>" download target="_blank" class="btn btn-primary btn-sm w-100 mb-1"><i class="fas fa-eye fa-sm"></i> Lihat Draft Dokumen</a>
                                                        <?php if($dokumen['status_publish'] === 'Published'){ ?>
                                                        <a href="<?=BASE_URL?>/publish/<?= $dokumen['dokumen_baru'] ?>" download target="_blank" class="btn btn-primary btn-sm w-100"><i class="fas fa-eye fa-sm"></i> Lihat Dokumen Jurnal</a>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>




                    <!-- Modal Pengajuan -->
                     <?php foreach($data['dokumen'] as $dokumen): ?>
                     <div class="modal fade" id="modalAjukan<?= $dokumen['id_dokumen']?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Pengajuan Publish Jurnal</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?= BASE_URL ?>/Pengajuan/pengajuan" method="post">
                                        <input type="hidden" name="id_dokumen" value="<?= $dokumen['id_dokumen']?>">
                                        <div class="form-group">
                                            <label for="nama">Nama Mahasiswa</label>
                                            <input type="text" class="form-control" value="<?= $dokumen['mahasiswa_nama']?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="judul">Judul Penelitian</label>
                                            <input type="text" class="form-control" value="<?=$dokumen['judul_penelitian']?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="link">Link Jurnal</label>
                                            <input type="text" name="link" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_jurnal">Nama Jurnal</label>
                                            <input type="text" name="nama_jurnal" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="tgl">Bulan Publish</label>
                                            <input type="date" name="tgl" class="form-control">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Ajukan</button>
                                </div>
                                </form>
                            </div>
                        </div>
                     </div>
                     <?php endforeach;?>

                     <!-- Modal Report Publish -->
                      <?php foreach($data['dokumen'] as $dokumen): ?>
                        <div class="modal fade" id="reportPublish<?= $dokumen['id_dokumen']?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Report Publish</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= BASE_URL?>/Pengajuan/report" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id_dokumen" value="<?=$dokumen['id_dokumen']?>">
                                            <div class="form-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="inputFileDokumen" aria-describedby="inputGroupFileAddon01" name="dokumen">
                                                    <label class="custom-file-label" for="inputFileDokumen">Pilih File</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="link">Link Jurnal</label>
                                                <input type="text" name="link" class="form-control">
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                      <?php endforeach;?>

                      <!-- Modal catatan -->
                       <?php foreach($data['dokumen'] as $dokumen): ?>
                       <div class="modal fade" id="modalCatatan<?= $dokumen['id_dokumen']?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Catatan Penolakan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="catatan">Catatan:</label>
                                            <textarea class="form-control" name="catatan" id="catatan" rows="3" disabled><?= $dokumen['catatan'] ?? '-'?></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <?php endforeach;?>
