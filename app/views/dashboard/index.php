<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="<?= BASEURL; ?>dashboard/profile">
                    <i class="bi bi-person-circle"></i> Profil
                </a>
                <a class="nav-link" href="#" onclick="confirmLogout()">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-5">

        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Selamat Datang, <?= htmlspecialchars($_SESSION['nama_lengkap']); ?>!</h4>
            <p>Anda telah berhasil login ke dashboard.</p>
        </div>
        
        <h2 class="mb-4">Data Akun Terdaftar</h2>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Provinsi</th>
                        <th>Kota</th>
                        <th>Foto Profil</th>
                        <th>Tanda Tangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($data['users'])): ?>
                        <?php $no = 1; foreach($data['users'] as $user): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($user['nama_lengkap']); ?></td>
                            <td><?= htmlspecialchars($user['email']); ?></td>
                            <td><?= htmlspecialchars($user['nomor_telepon']); ?></td>
                            <td><?= htmlspecialchars($user['provinsi']); ?></td>
                            <td><?= htmlspecialchars($user['kota']); ?></td>
                            <td>
                                <img src="<?= BASEURL; ?>uploads/fotoprofil/<?= $user['foto_profil']; ?>" 
                                    alt="Foto" width="50" height="50" class="rounded" style="object-fit: cover;">
                            </td>
                            <td>
                                <img src="<?= BASEURL; ?>uploads/tandatangan/<?= $user['tanda_tangan']; ?>" 
                                    alt="Tanda Tangan" width="100" class="border">
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" 
                                        data-bs-target="#editModal<?= $user['id']; ?>">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-danger" 
                                        onclick="confirmDelete(<?= $user['id']; ?>, '<?= htmlspecialchars($user['nama_lengkap']); ?>')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?= $user['id']; ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Data User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="<?= BASEURL; ?>dashboard/edit/<?= $user['id']; ?>" method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Lengkap</label>
                                                <input type="text" class="form-control" name="nama_lengkap" 
                                                       value="<?= htmlspecialchars($user['nama_lengkap']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email" 
                                                       value="<?= htmlspecialchars($user['email']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Password Baru (Kosongkan jika tidak ingin diubah)</label>
                                                <input type="password" class="form-control" name="password">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nomor Telepon</label>
                                                <input type="text" class="form-control" name="nomor_telepon" 
                                                       value="<?= htmlspecialchars($user['nomor_telepon']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Provinsi</label>
                                                <input type="text" class="form-control" name="provinsi" 
                                                       value="<?= htmlspecialchars($user['provinsi']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Kota</label>
                                                <input type="text" class="form-control" name="kota" 
                                                       value="<?= htmlspecialchars($user['kota']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Foto Profil Baru (Kosongkan jika tidak ingin diubah)</label>
                                                <input type="file" class="form-control" name="foto_profil" accept="image/*">
                                                <small class="text-muted">Foto saat ini: <?= $user['foto_profil']; ?></small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        //SweetAlert untuk notifikasi
        <?php if(isset($_SESSION['success'])): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= $_SESSION['success']; ?>',
                confirmButtonColor: '#198754'
            });
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION['error'])): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= $_SESSION['error']; ?>',
                confirmButtonColor: '#dc3545'
            });
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        //Konfirmasi hapus dengan SweetAlert2
        function confirmDelete(userId, userName) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Anda akan menghapus akun "${userName}"`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= BASEURL; ?>dashboard/delete/' + userId;
                }
            });
        }

        //Konfirmasi logout
        function confirmLogout() {
            Swal.fire({
                title: 'Logout',
                text: 'Apakah Anda yakin ingin keluar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= BASEURL; ?>auth/logout';
                }
            });
        }
    </script>
</body>
</html>
