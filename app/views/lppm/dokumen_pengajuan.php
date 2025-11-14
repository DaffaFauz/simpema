                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Dokumen Pengajuan Dosen</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Data Dokumen Pengajuan Dosen</h6>
                            <form action="<?= BASE_URL?>/Dokumen/filter" id="formfilter" class="d-flex" method="POST">
                                <input type="hidden" name="redirect_page" value="pengajuan" />
                                <select name="fakultas" id="fakultas" class="form-control form-control-sm mr-2">
                                    <option value="">Semua fakultas</option>
                                    <?php foreach($data['fakultasfilter'] as $row): ?>
                                    <option value="<?= $row['id_fakultas'] ?>" <?= (!empty($data['selectedfakultas']) && $data['selectedfakultas'] == $row['id_fakultas'] ? 'selected' : '') ?>><?= $row['nama_fakultas'] ?></option>
                                    <?php endforeach;?>
                                </select>
                                <select name="prodi" id="prodi" class="form-control form-control-sm mr-2">
                                    <option value="">Semua Prodi</option>
                                    <?php if(!empty($data['prodifilter'])): ?>
                                        <?php foreach($data['prodifilter'] as $p): ?>
                                            <option value="<?= $p['id_prodi'] ?>" <?= (!empty($data['selectedprodi']) && $data['selectedprodi'] == $p['id_prodi'] ? 'selected' : '') ?>><?= $p['nama_prodi'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                                    <tbody id="dokumen-table-body">
                                        <?php
                                        $no = 1;
                                        foreach($data['dokumen'] as $dokumen): ?>
                                        <tr>
                                            <td><?= htmlspecialchars((string)$no++) ?></td>
                                            <td><?= htmlspecialchars($dokumen['mahasiswa_nama'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($dokumen['judul_penelitian'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($dokumen['dosen_nama'] ?? '-') ?></td>
                                            <td><span class="badge badge-pill badge-<?= ($dokumen['status'] ?? '') === 'Accepted' ? 'success' : (($dokumen['status'] ?? '') === 'Rejected' ? 'danger' : 'warning') ?>"><?= htmlspecialchars($dokumen['status'] ?? 'Requested') ?></span></td>
                                            <td><span class="badge badge-pill badge-<?= ($dokumen['status_publish'] ?? '') === 'Published' ? 'success' : (($dokumen['status_publish'] ?? '') === 'Unpublished' ? 'danger' : 'secondary') ?>"><?= htmlspecialchars($dokumen['status_publish'] ?? 'Unknown') ?></span></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn " type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                        <form action="<?=BASE_URL?>/Dokumen/status" class="" method="POST">
                                                            <input type="hidden" name="id_dokumen" value="<?= $dokumen['id_dokumen'] ?>"/>
                                                            <?php if($dokumen['status'] === 'Requested'){?>
                                                                <button type="submit" class="btn btn-success btn-sm w-100 mb-1" name="status" value="Accepted">Terima</button>
                                                                <button type="submit" class="btn btn-danger btn-sm w-100 mb-1" name="status" value="Rejected">Tolak</button>
                                                            <?php } else if($dokumen['status'] === 'Accepted'){ ?>
                                                                <button type="submit" class="btn btn-danger btn-sm w-100 mb-1" name="status" value="Rejected">Tolak</button>
                                                            <?php } else if($dokumen['status'] === 'Rejected'){ ?>
                                                                <button type="submit" class="btn btn-success btn-sm w-100 mb-1" name="status" value="Accepted">Terima</button>
                                                            <?php }?>
                                                        </form>
                                                         <form action="<?=BASE_URL?>/Dokumen/status_publish" class="" method="POST">
                                                            <input type="hidden" name="id_dokumen" value="<?= $dokumen['id_dokumen'] ?>"/>
                                                            <input type="hidden" name="redirect_page" value="pengajuan">
                                                            <?php if ($dokumen['status_publish'] === 'Unknown'){?>
                                                                <button type="submit" class="btn btn-success btn-sm w-100 mb-1" name="status_publish" value="Published">Sudah publish</button>
                                                                <button type="submit" class="btn btn-danger btn-sm w-100 mb-1" name="status_publish" value="Unpublished">Belum Publish</button>
                                                            <?php } else if($dokumen['status_publish'] === 'Published'){ ?>
                                                                <button type="submit" class="btn btn-danger btn-sm w-100 mb-1" name="status_publish" value="Unpublished">Belum Publish</button>
                                                            <?php } else if($dokumen['status_publish'] === 'Unpublished'){ ?>
                                                                <button type="submit" class="btn btn-success btn-sm w-100 mb-1" name="status_publish" value="Published">Sudah publish</button>
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