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
                                                    <button class="btn " type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                         <form action="<?=BASE_URL?>/Dokumen/status" method="POST" class="d-inline">
                                                    <input type="hidden" name="id_dokumen" value="<?= $dokumen['id_dokumen'] ?>"/>
                                                    <?php if($dokumen['status_publish'] === 'Unpublished' && $dokumen['status'] === NULL){ ?>
                                                        <button type="submit" class="btn btn-success btn-sm mb-1 w-100" name="status" value="Requested"><i class="fas fa-upload fa-sm"></i> Ajukan</button>
                                                    <?php }?>
                                                </form>
                                                <form action="<?=BASE_URL?>/Dokumen/status_publish" class="d-inline" method="POST">
                                                    <input type="hidden" name="id_dokumen" value="<?= $dokumen['id_dokumen'] ?>"/>
                                                    <?php if($dokumen['status_publish'] === 'Unpublished'){ ?>
                                                        <button type="submit" class="btn btn-success btn-sm mb-1 w-100" name="status_publish" value="Published"><i class="fas fa-check fa-sm"></i> Sudah publish</button>
                                                    <?php }?>
                                                </form>
                                                        <a href="<?=BASE_URL?>/uploads/<?= $dokumen['file_dokumen'] ?>" download target="_blank" class="btn btn-primary btn-sm w-100"><i class="fas fa-eye fa-sm"></i> Lihat Dokumen</a>
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