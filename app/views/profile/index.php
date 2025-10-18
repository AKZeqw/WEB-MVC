<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= BASEURL; ?>dashboard/index">Dashboard</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link active" href="<?= BASEURL; ?>dashboard/profile">
                    <i class="bi bi-person-circle"></i> Profil
                </a>
                <a class="nav-link" href="<?= BASEURL; ?>auth/logout">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-person-badge"></i> Profil Saya</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4 text-center">
                                <img src="<?= BASEURL; ?>../uploads/fotoprofil/<?= $data['user']['foto_profil']; ?>" 
                                     alt="Foto Profil" class="img-fluid rounded-circle border border-3" 
                                     style="width: 200px; height: 200px; object-fit: cover;">
                            </div>
                            <div class="col-md-8">
                                <h3><?= htmlspecialchars($data['user']['nama_lengkap']); ?></h3>
                                <hr>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%"><strong><i class="bi bi-envelope"></i> Email</strong></td>
                                        <td>: <?= htmlspecialchars($data['user']['email']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="bi bi-telephone"></i> Nomor Telepon</strong></td>
                                        <td>: <?= htmlspecialchars($data['user']['nomor_telepon']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="bi bi-geo-alt"></i> Provinsi</strong></td>
                                        <td>: <?= htmlspecialchars($data['user']['provinsi']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="bi bi-pin-map"></i> Kota</strong></td>
                                        <td>: <?= htmlspecialchars($data['user']['kota']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="bi bi-calendar"></i> Terdaftar Sejak</strong></td>
                                        <td>: <?= date('d F Y', strtotime($data['user']['created_at'])); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h5><i class="bi bi-pen"></i> Tanda Tangan</h5>
                                <div class="border rounded p-3 bg-light text-center">
                                    <img src="<?= BASEURL; ?>../uploads/tandatangan/<?= $data['user']['tanda_tangan']; ?>" 
                                         alt="Tanda Tangan" class="img-fluid" style="max-height: 150px;">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="<?= BASEURL; ?>dashboard/index" class="btn btn-primary">
                                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
