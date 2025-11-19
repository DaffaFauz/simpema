                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Dokumen Pengajuan Dosen</h1>
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
                            <h6 class="m-0 font-weight-bold text-primary">Data Dokumen Pengajuan Dosen</h6>
                            <form action="<?= BASE_URL?>/Pengajuan/filter" id="formFilterPengajuan" class="d-flex" method="POST">
                                <input type="hidden" name="redirect_page" value="pengajuan" />
                                <select name="tahun" id="tahun1" class="form-control form-control-sm mr-2">
                                    <option value="">Semua Tahun</option>
                                    <?php foreach($data['periode'] as $row): ?>
                                        <?php $isSelected = (!empty($data['selectedtahun']) && $data['selectedtahun'] == $row['id_tahun']); ?>
                                        <option value="<?= $row['id_tahun'] ?>" <?= $isSelected ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($row['tahun'] . ' - ' . $row['periode']) ?> <?= ($row['status'] == 'Aktif') ? '(Aktif)' : '' ?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                                <select name="fakultas" id="fakultas1" class="form-control form-control-sm mr-2">
                                    <option value="">Semua fakultas</option>
                                    <?php foreach($data['fakultasfilter'] as $row): ?>
                                    <option value="<?= $row['id_fakultas'] ?>" <?= (!empty($data['selectedfakultas']) && $data['selectedfakultas'] == $row['id_fakultas'] ? 'selected' : '') ?>><?= $row['nama_fakultas'] ?></option>
                                    <?php endforeach;?>
                                </select>
                                <select name="prodi" id="prodi1" class="form-control form-control-sm mr-2">
                                    <option value="">Semua Prodi</option>
                                    <?php if(!empty($data['prodifilter'])): ?>
                                        <?php foreach($data['prodifilter'] as $p): ?>
                                            <option value="<?= $p['id_prodi'] ?>" <?= (!empty($data['selectedprodi']) && $data['selectedprodi'] == $p['id_prodi'] ? 'selected' : '') ?>><?= $p['nama_prodi'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </form>
                            <div class="d-flex gap-2">
                                <button id="btnDownload1" class="btn btn-info btn-sm mr-2"><i class="fas fa-download"></i> Download</button>
                                <button id="btnPrint1" class="btn btn-success btn-sm"><i class="fas fa-print"></i> Print</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Requested</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#rejected" type="button" role="tab" aria-controls="profile" aria-selected="false">Rejected</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Accepted</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Published</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="table-responsive">
                                        <table class="table table-bordered dataTable" id="table-requested" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Mahasiswa</th>
                                                    <th>Judul Penelitian</th>
                                                    <th>Nama Pembimbing</th>
                                                    <th>Status Pengajuan</th>
                                                    <th>Status publish</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach($data['dokumen'] as $dokumen): 
                                                    if($dokumen['status'] === 'Requested'){
                                                ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars((string)$no++) ?></td>
                                                        <td><?= htmlspecialchars($dokumen['mahasiswa_nama'] ?? '-') ?></td>
                                                        <td><?= htmlspecialchars($dokumen['judul_penelitian'] ?? '-') ?></td>
                                                        <td><?= htmlspecialchars($dokumen['dosen_nama'] ?? '-') ?></td>
                                                        <td><span class="badge badge-pill badge-<?= ($dokumen['status'] ?? '') === 'Accepted' ? 'success' : (($dokumen['status'] ?? '') === 'Rejected' ? 'danger' : 'warning') ?>"><?= htmlspecialchars($dokumen['status'] ?? 'Requested') ?></span></td>
                                                        <td><span class="badge badge-pill badge-<?= ($dokumen['status_publish'] ?? '') === 'Published' ? 'success' : (($dokumen['status_publish'] ?? '') === 'Unpublished' ? 'danger' : 'secondary') ?>"><?= htmlspecialchars($dokumen['status_publish'] ?? 'Unknown') ?></span></td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fas fa-ellipsis-v"></i>
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                                    <button type="button" class="btn btn-primary btn-sm w-100 mb-1" data-toggle="modal" data-target="#modalDetailPengajuan<?=$dokumen['id_dokumen']?>"><i class="fas fa-eye fa-sm"></i> Detail Pengajuan</button>
                                                                    <form action="<?=BASE_URL?>/Dokumen/status_publish" class="" method="POST">
                                                                        <input type="hidden" name="id_dokumen" value="<?= $dokumen['id_dokumen'] ?>"/>
                                                                        <input type="hidden" name="redirect_page" value="pengajuan">
                                                                        <?php if ($dokumen['status_publish'] === 'Unknown'){?>
                                                                            <button type="submit" class="btn btn-success btn-sm w-100 mb-1" name="status_publish" value="Published">Sudah publish</button>
                                                                            <button type="submit" class="btn btn-danger btn-sm w-100 mb-1" name="status_publish" value="Unpublished">Belum Publish</button>
                                                                        <?php } else if($dokumen['status_publish'] === 'Unpublished'){ ?>
                                                                            <button type="submit" class="btn btn-success btn-sm w-100 mb-1" name="status_publish" value="Published"><i class="fas fa-check fa-sm"></i> Sudah publish</button>
                                                                        <?php }?>
                                                                    </form>
                                                                    <?php if($dokumen['status_publish'] === 'Published'){ ?>
                                                                        <button type="button" class="btn btn-primary btn-sm w-100 mb-1" data-toggle="modal" data-target="#modalDetailJurnal<?=$dokumen['id_dokumen']?>"><i class="fas fa-eye fa-sm"></i> Detail Jurnal</button>
                                                                    <?php }?>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="table-responsive">
                                        <table class="table table-bordered dataTable" id="table-rejected" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Mahasiswa</th>
                                                    <th>Judul Penelitian</th>
                                                    <th>Nama Pembimbing</th>
                                                    <th>Status Pengajuan</th>
                                                    <th>Status publish</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach($data['dokumen'] as $dokumen): 
                                                    if($dokumen['status'] === 'Rejected'){
                                                ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars((string)$no++) ?></td>
                                                        <td><?= htmlspecialchars($dokumen['mahasiswa_nama'] ?? '-') ?></td>
                                                        <td><?= htmlspecialchars($dokumen['judul_penelitian'] ?? '-') ?></td>
                                                        <td><?= htmlspecialchars($dokumen['dosen_nama'] ?? '-') ?></td>
                                                        <td><span class="badge badge-pill badge-<?= ($dokumen['status'] ?? '') === 'Accepted' ? 'success' : (($dokumen['status'] ?? '') === 'Rejected' ? 'danger' : 'warning') ?>"><?= htmlspecialchars($dokumen['status'] ?? 'Requested') ?></span></td>
                                                        <td><span class="badge badge-pill badge-<?= ($dokumen['status_publish'] ?? '') === 'Published' ? 'success' : (($dokumen['status_publish'] ?? '') === 'Unpublished' ? 'danger' : 'secondary') ?>"><?= htmlspecialchars($dokumen['status_publish'] ?? 'Unknown') ?></span></td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fas fa-ellipsis-v"></i>
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                                    <button type="button" class="btn btn-primary btn-sm w-100 mb-1" data-toggle="modal" data-target="#modalDetailPengajuan<?=$dokumen['id_dokumen']?>"><i class="fas fa-eye fa-sm"></i> Detail Pengajuan</button>
                                                                    <form action="<?=BASE_URL?>/Dokumen/status_publish" class="" method="POST">
                                                                        <input type="hidden" name="id_dokumen" value="<?= $dokumen['id_dokumen'] ?>"/>
                                                                        <input type="hidden" name="redirect_page" value="pengajuan">
                                                                        <?php if ($dokumen['status_publish'] === 'Unknown'){?>
                                                                            <button type="submit" class="btn btn-success btn-sm w-100 mb-1" name="status_publish" value="Published">Sudah publish</button>
                                                                            <button type="submit" class="btn btn-danger btn-sm w-100 mb-1" name="status_publish" value="Unpublished">Belum Publish</button>
                                                                        <?php } else if($dokumen['status_publish'] === 'Unpublished'){ ?>
                                                                            <button type="submit" class="btn btn-success btn-sm w-100 mb-1" name="status_publish" value="Published"><i class="fas fa-check fa-sm"></i> Sudah publish</button>
                                                                        <?php }?>
                                                                    </form>
                                                                    <?php if($dokumen['status_publish'] === 'Published'){ ?>
                                                                        <button type="button" class="btn btn-primary btn-sm w-100 mb-1" data-toggle="modal" data-target="#modalDetailJurnal<?=$dokumen['id_dokumen']?>"><i class="fas fa-eye fa-sm"></i> Detail Jurnal</button>
                                                                    <?php }?>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="table-responsive">
                                        <table class="table table-bordered dataTable" id="table-accepted" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Mahasiswa</th>
                                                    <th>Judul Penelitian</th>
                                                    <th>Nama Pembimbing</th>
                                                    <th>Status Pengajuan</th>
                                                    <th>Status publish</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach($data['dokumen'] as $dokumen): 
                                                    if($dokumen['status_publish'] === 'Unpublished' && $dokumen['status'] === 'Accepted'){
                                                ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars((string)$no++) ?></td>
                                                        <td><?= htmlspecialchars($dokumen['mahasiswa_nama'] ?? '-') ?></td>
                                                        <td><?= htmlspecialchars($dokumen['judul_penelitian'] ?? '-') ?></td>
                                                        <td><?= htmlspecialchars($dokumen['dosen_nama'] ?? '-') ?></td>
                                                        <td><span class="badge badge-pill badge-<?= ($dokumen['status'] ?? '') === 'Accepted' ? 'success' : (($dokumen['status'] ?? '') === 'Rejected' ? 'danger' : 'warning') ?>"><?= htmlspecialchars($dokumen['status'] ?? 'Requested') ?></span></td>
                                                        <td><span class="badge badge-pill badge-<?= ($dokumen['status_publish'] ?? '') === 'Published' ? 'success' : (($dokumen['status_publish'] ?? '') === 'Unpublished' ? 'danger' : 'secondary') ?>"><?= htmlspecialchars($dokumen['status_publish'] ?? 'Unknown') ?></span></td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fas fa-ellipsis-v"></i>
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                                    <button type="button" class="btn btn-primary btn-sm w-100 mb-1" data-toggle="modal" data-target="#modalDetailPengajuan<?=$dokumen['id_dokumen']?>"><i class="fas fa-eye fa-sm"></i> Detail Pengajuan</button>
                                                                    <form action="<?=BASE_URL?>/Dokumen/status_publish" class="" method="POST">
                                                                        <input type="hidden" name="id_dokumen" value="<?= $dokumen['id_dokumen'] ?>"/>
                                                                        <input type="hidden" name="redirect_page" value="pengajuan">
                                                                        <?php if ($dokumen['status_publish'] === 'Unknown'){?>
                                                                            <button type="submit" class="btn btn-success btn-sm w-100 mb-1" name="status_publish" value="Published">Sudah publish</button>
                                                                            <button type="submit" class="btn btn-danger btn-sm w-100 mb-1" name="status_publish" value="Unpublished">Belum Publish</button>
                                                                        <?php } else if($dokumen['status_publish'] === 'Unpublished'){ ?>
                                                                            <button type="submit" class="btn btn-success btn-sm w-100 mb-1" name="status_publish" value="Published"><i class="fas fa-check fa-sm"></i> Sudah publish</button>
                                                                        <?php }?>
                                                                    </form>
                                                                    <?php if($dokumen['status_publish'] === 'Published'){ ?>
                                                                        <button type="button" class="btn btn-primary btn-sm w-100 mb-1" data-toggle="modal" data-target="#modalDetailJurnal<?=$dokumen['id_dokumen']?>"><i class="fas fa-eye fa-sm"></i> Detail Jurnal</button>
                                                                    <?php }?>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="table-responsive">
                                        <table class="table table-bordered dataTable" id="table-published" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Mahasiswa</th>
                                                    <th>Judul Penelitian</th>
                                                    <th>Nama Pembimbing</th>
                                                    <th>Status Pengajuan</th>
                                                    <th>Status publish</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach($data['dokumen'] as $dokumen): 
                                                    if($dokumen['status'] === 'Accepted'){
                                                ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars((string)$no++) ?></td>
                                                        <td><?= htmlspecialchars($dokumen['mahasiswa_nama'] ?? '-') ?></td>
                                                        <td><?= htmlspecialchars($dokumen['judul_penelitian'] ?? '-') ?></td>
                                                        <td><?= htmlspecialchars($dokumen['dosen_nama'] ?? '-') ?></td>
                                                        <td><span class="badge badge-pill badge-<?= ($dokumen['status'] ?? '') === 'Accepted' ? 'success' : (($dokumen['status'] ?? '') === 'Rejected' ? 'danger' : 'warning') ?>"><?= htmlspecialchars($dokumen['status'] ?? 'Requested') ?></span></td>
                                                        <td><span class="badge badge-pill badge-<?= ($dokumen['status_publish'] ?? '') === 'Published' ? 'success' : (($dokumen['status_publish'] ?? '') === 'Unpublished' ? 'danger' : 'secondary') ?>"><?= htmlspecialchars($dokumen['status_publish'] ?? 'Unknown') ?></span></td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fas fa-ellipsis-v"></i>
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                                    <button type="button" class="btn btn-primary btn-sm w-100 mb-1" data-toggle="modal" data-target="#modalDetailPengajuan<?=$dokumen['id_dokumen']?>"><i class="fas fa-eye fa-sm"></i> Detail Pengajuan</button>
                                                                    <form action="<?=BASE_URL?>/Dokumen/status_publish" class="" method="POST">
                                                                        <input type="hidden" name="id_dokumen" value="<?= $dokumen['id_dokumen'] ?>"/>
                                                                        <input type="hidden" name="redirect_page" value="pengajuan">
                                                                        <?php if ($dokumen['status_publish'] === 'Unknown'){?>
                                                                            <button type="submit" class="btn btn-success btn-sm w-100 mb-1" name="status_publish" value="Published">Sudah publish</button>
                                                                            <button type="submit" class="btn btn-danger btn-sm w-100 mb-1" name="status_publish" value="Unpublished">Belum Publish</button>
                                                                        <?php } else if($dokumen['status_publish'] === 'Unpublished'){ ?>
                                                                            <button type="submit" class="btn btn-success btn-sm w-100 mb-1" name="status_publish" value="Published"><i class="fas fa-check fa-sm"></i> Sudah publish</button>
                                                                        <?php }?>
                                                                    </form>
                                                                    <?php if($dokumen['status_publish'] === 'Published'){ ?>
                                                                        <button type="button" class="btn btn-primary btn-sm w-100 mb-1" data-toggle="modal" data-target="#modalDetailJurnal<?=$dokumen['id_dokumen']?>"><i class="fas fa-eye fa-sm"></i> Detail Jurnal</button>
                                                                    <?php }?>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Modal Detail Pengajuan -->
                     <?php foreach($data['dokumen'] as $dokumen): ?>
                        <div class="modal fade" id="modalDetailPengajuan<?= $dokumen['id_dokumen']?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Pengajuan</h5>
                                        <button class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="nama_mahasiswa">Nama Mahasiswa</label>
                                            <input type="text" class="form-control" disabled value="<?=$dokumen['mahasiswa_nama']?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="judul_penelitian">Judul Penelitian</label>
                                            <input type="text" class="form-control" disabled value="<?=$dokumen['judul_penelitian']?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="pembimbing">Pembimbing</label>
                                            <input type="text" class="form-control" disabled value="<?=$dokumen['dosen_nama']?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_jurnal">Nama Jurnal</label>
                                            <input type="text" class="form-control" disabled value="<?=$dokumen['nama_jurnal']?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="publish">Bulan Publish</label>
                                            <input type="text" class="form-control" disabled value="<?=date("F Y", strtotime($dokumen['tgl']))?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="link">Link Jurnal:</label>
                                            <a href="<?=$dokumen['link']?>" target="_blank" ><?=$dokumen['link']?></a>
                                        </div>
                                        <div class="form-group">
                                            <label for="dokumen">Dokumen: </label>
                                            <a href="<?=BASE_URL?>/uploads/<?= $dokumen['file_dokumen'] ?>" download target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-eye fa-sm"></i> Lihat Dokumen</a>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                                         <form action="<?=BASE_URL?>/Pengajuan/status" method="POST">
                                            <input type="hidden" name="id_dokumen" value="<?= $dokumen['id_dokumen'] ?>"/>
                                            <?php if($dokumen['status'] === 'Requested'){?>
                                                <input type="hidden" name="catatan">
                                                <button type="submit" class="btn btn-success btn-sm mb-1" name="status" value="Accepted">Terima</button>
                                                <button type="button" class="btn btn-danger btn-sm mb-1" name="status" value="Rejected" data-toggle="modal" data-target="#modalTolak<?= $dokumen['id_dokumen'] ?>">Tolak</button>
                                            <?php } else if($dokumen['status'] === 'Accepted'){ ?>
                                                <button type="button" class="btn btn-danger btn-sm mb-1" name="status" value="Rejected" data-toggle="modal" data-target="#modalTolak<?= $dokumen['id_dokumen'] ?>">Tolak</button>
                                            <?php } else if($dokumen['status'] === 'Rejected'){ ?>
                                                <input type="hidden" name="catatan">
                                                <button type="submit" class="btn btn-success btn-sm mb-1" name="status" value="Accepted">Terima</button>
                                            <?php }?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                     <?php endforeach;?>

                    <!-- Modal tolak pengajuan -->
                     <?php foreach($data['dokumen'] as $dokumen): ?>
                     <div class="modal fade" id="modalTolak<?= $dokumen['id_dokumen']?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tolak Pengajuan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?=BASE_URL?>/Pengajuan/status" method="post">
                                        <input type="hidden" name="id_dokumen" value="<?= $dokumen['id_dokumen'] ?>">
                                        <div class="form-group">
                                            <label for="catatan">Catatan Penolakan:</label>
                                            <textarea class="form-control" name="catatan" id="catatan" rows="3"></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger btn-sm" name="status" value="Rejected">Tolak</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                     </div>
                     <?php endforeach;?>

                     <!-- Modal Detail Jurnal -->
                      <?php foreach($data['dokumen'] as $dokumen): ?>
                        <div class="modal fade" id="modalDetailJurnal<?=$dokumen['id_dokumen']?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Jurnal</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="judul_penelitian">Judul Penelitian</label>
                                            <input type="text" disabled class="form-control" value="<?= $dokumen['judul_penelitian'] ?? '' ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="judul_penelitian">Link Jurnal</label>
                                            <a href="<?= $dokumen['link_jurnal']?>" target="_blank"><?= $dokumen['link_jurnal'] ?></a>
                                        </div>
                                        <div class="form-group">
                                            <label for="Dokumen">Dokumen Jurnal</label>
                                            <a href="<?=BASE_URL?>/publish/<?= $dokumen['dokumen_baru'] ?>" download target="_blank" class="btn btn-primary btn-sm w-100"><i class="fas fa-eye fa-sm"></i> Lihat Dokumen Jurnal</a>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                      <?php endforeach;?>

<script>
    document.getElementById('btnPrint1').addEventListener('click', function() {
    // Ambil tabel yang aktif di dalam tab
    var activeTabPane = document.querySelector('.tab-pane.active');
    var rows = activeTabPane.querySelectorAll('tbody tr');

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
        '<th style="border:1px solid #ddd;padding:8px;text-align:center;">Dosem Pembimbing</th>' +
        '<th style="border:1px solid #ddd;padding:8px;text-align:center;">Status Publikasi</th>' +
        '</tr>' +
        '</thead><tbody>';

    rows.forEach(function(row) {
        var cells = row.querySelectorAll('td');
        if(cells.length > 0 && !cells[0].getAttribute('colspan')) {
            var no = cells[0].textContent.trim();
            var nama = cells[1].textContent.trim();
            var judul = cells[2].textContent.trim();
            var pembimbing = cells[3].textContent.trim();
            var publikasi = cells[5].textContent.trim();
            tableHTML += '<tr>' +
                '<td style="border:1px solid #ddd;padding:8px; text-align: center">' + no + '</td>' +
                '<td style="border:1px solid #ddd;padding:8px;">' + nama + '</td>' +
                '<td style="border:1px solid #ddd;padding:8px;">' + judul + '</td>' +
                '<td style="border:1px solid #ddd;padding:8px;">' + pembimbing + '</td>' +
                '<td style="border:1px solid #ddd;padding:8px;">' + publikasi + '</td>' +
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
        <h2>Laporan Dokumen Mahasiswa</h2>
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
    var activeTabPane = document.querySelector('.tab-pane.active');
    var rows = activeTabPane.querySelectorAll('tbody tr');
    
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
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: center">Dosen Pembimbing</th>
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: center">Status Publikasi</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    rows.forEach(function(row, index) {
        var cells = row.querySelectorAll('td');
        if(cells.length > 0 && !cells[0].getAttribute('colspan')) {
            htmlContent += '<tr>';
            for(var i = 0; i < 4; i++) {
                var text = cells[i].textContent.trim();
                htmlContent += '<td style="border: 1px solid #ddd; padding: 10px;">' + text + '</td>';
            }
            htmlContent += '<td style="border: 1px solid #ddd; padding: 10px;">' + cells[5].textContent.trim() + '</td>';
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
                     
