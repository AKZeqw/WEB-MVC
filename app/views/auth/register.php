<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #signature-pad {
            border: 2px solid #ddd;
            border-radius: 5px;
            cursor: crosshair;
        }
        .signature-container {
            position: relative;
        }
        .clear-signature {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Form Registrasi</h2>

                        <form id="registerForm" action="<?= BASEURL; ?>auth/register" method="POST" enctype="multipart/form-data" novalidate>
                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                                <div class="invalid-feedback">Nama lengkap harus diisi!</div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">Email harus valid!</div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="invalid-feedback">Password harus diisi!</div>
                            </div>

                            <!-- Nomor Telepon -->
                            <div class="mb-3">
                                <label for="nomor_telepon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" 
                                       pattern="[0-9]{10,12}" required>
                                <div class="invalid-feedback">Nomor telepon harus 10-12 digit angka!</div>
                            </div>

                            <!-- Provinsi -->
                            <div class="mb-3">
                                <label for="provinsi" class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <select class="form-select" id="provinsi" name="provinsi" required>
                                    <option value="">Pilih Provinsi</option>
                                </select>
                                <div class="invalid-feedback">Provinsi harus dipilih!</div>
                            </div>

                            <!-- Kota -->
                            <div class="mb-3">
                                <label for="kota" class="form-label">Kota <span class="text-danger">*</span></label>
                                <select class="form-select" id="kota" name="kota" required disabled>
                                    <option value="">Pilih Kota</option>
                                </select>
                                <div class="invalid-feedback">Kota harus dipilih!</div>
                            </div>

                            <!-- Foto Profil -->
                            <div class="mb-3">
                                <label for="foto_profil" class="form-label">Foto Profil <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="foto_profil" name="foto_profil" 
                                       accept="image/png,image/jpeg,image/jpg" required>
                                <div class="invalid-feedback">Foto profil harus diupload!</div>
                                <small class="text-muted">Format: JPG, JPEG, PNG (Max: 5MB)</small>
                            </div>

                            <!-- Tanda Tangan Canvas -->
                            <div class="mb-3">
                                <label class="form-label">Tanda Tangan <span class="text-danger">*</span></label>
                                <div class="signature-container">
                                    <button type="button" class="btn btn-sm btn-danger clear-signature" onclick="clearSignature()">
                                        Clear
                                    </button>
                                    <canvas id="signature-pad" width="700" height="200"></canvas>
                                </div>
                                <input type="hidden" id="signature" name="signature" required>
                                <div id="signature-error" class="text-danger small mt-1" style="display:none;">
                                    Tanda tangan harus diisi!
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">Daftar</button>
                                <a href="<?= BASEURL; ?>auth/login" class="btn btn-link">Sudah punya akun? Login disini</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        //SweetAlert untuk error dan success
        <?php if(isset($_SESSION['error'])): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= $_SESSION['error']; ?>',
                confirmButtonColor: '#dc3545'
            });
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION['success'])): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= $_SESSION['success']; ?>',
                confirmButtonColor: '#198754'
            });
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        //Data Provinsi dan Kota Indonesia
        const wilayahData = {
            "Aceh": ["Banda Aceh", "Langsa", "Lhokseumawe", "Sabang", "Subulussalam", "Aceh Barat", "Aceh Barat Daya", "Aceh Besar", "Aceh Jaya", "Aceh Selatan", "Aceh Singkil", "Aceh Tamiang", "Aceh Tengah", "Aceh Tenggara", "Aceh Timur", "Aceh Utara", "Bener Meriah", "Bireuen", "Gayo Lues", "Nagan Raya", "Pidie", "Pidie Jaya", "Simeulue"],
            "Sumatera Utara": ["Medan", "Binjai", "Gunungsitoli", "Padang Sidempuan", "Pematangsiantar", "Sibolga", "Tanjungbalai", "Tebing Tinggi", "Asahan", "Batubara", "Dairi", "Deli Serdang", "Humbang Hasundutan", "Karo", "Labuhanbatu", "Labuhanbatu Selatan", "Labuhanbatu Utara", "Langkat", "Mandailing Natal", "Nias", "Nias Barat", "Nias Selatan", "Nias Utara", "Padang Lawas", "Padang Lawas Utara", "Pakpak Bharat", "Samosir", "Serdang Bedagai", "Simalungun", "Tapanuli Selatan", "Tapanuli Tengah", "Tapanuli Utara", "Toba"],
            "Sumatera Barat": ["Bukittinggi", "Padang", "Padangpanjang", "Pariaman", "Payakumbuh", "Sawahlunto", "Solok", "Agam", "Dharmasraya", "Kepulauan Mentawai", "Lima Puluh Kota", "Padang Pariaman", "Pasaman", "Pasaman Barat", "Pesisir Selatan", "Sijunjung", "Solok", "Solok Selatan", "Tanah Datar"],
            "Riau": ["Dumai", "Pekanbaru", "Bengkalis", "Indragiri Hilir", "Indragiri Hulu", "Kampar", "Kepulauan Meranti", "Kuantan Singingi", "Pelalawan", "Rokan Hilir", "Rokan Hulu", "Siak"],
            "Jambi": ["Jambi", "Sungai Penuh", "Batanghari", "Bungo", "Kerinci", "Merangin", "Muaro Jambi", "Sarolangun", "Tanjung Jabung Barat", "Tanjung Jabung Timur", "Tebo"],
            "Sumatera Selatan": ["Lubuklinggau", "Pagar Alam", "Palembang", "Prabumulih", "Banyuasin", "Empat Lawang", "Lahat", "Muara Enim", "Musi Banyuasin", "Musi Rawas", "Musi Rawas Utara", "Ogan Ilir", "Ogan Komering Ilir", "Ogan Komering Ulu", "Ogan Komering Ulu Selatan", "Ogan Komering Ulu Timur", "Penukal Abab Lematang Ilir"],
            "Bengkulu": ["Bengkulu", "Bengkulu Selatan", "Bengkulu Tengah", "Bengkulu Utara", "Kaur", "Kepahiang", "Lebong", "Mukomuko", "Rejang Lebong", "Seluma"],
            "Lampung": ["Bandar Lampung", "Metro", "Lampung Barat", "Lampung Selatan", "Lampung Tengah", "Lampung Timur", "Lampung Utara", "Mesuji", "Pesawaran", "Pesisir Barat", "Pringsewu", "Tanggamus", "Tulang Bawang", "Tulang Bawang Barat", "Way Kanan"],
            "Kepulauan Bangka Belitung": ["Pangkalpinang", "Bangka", "Bangka Barat", "Bangka Selatan", "Bangka Tengah", "Belitung", "Belitung Timur"],
            "Kepulauan Riau": ["Batam", "Tanjung Pinang", "Bintan", "Karimun", "Kepulauan Anambas", "Lingga", "Natuna"],
            "DKI Jakarta": ["Jakarta Barat", "Jakarta Pusat", "Jakarta Selatan", "Jakarta Timur", "Jakarta Utara", "Kepulauan Seribu"],
            "Jawa Barat": ["Bandung", "Banjar", "Bekasi", "Bogor", "Cimahi", "Cirebon", "Depok", "Sukabumi", "Tasikmalaya", "Bandung Barat", "Ciamis", "Cianjur", "Garut", "Indramayu", "Karawang", "Kuningan", "Majalengka", "Pangandaran", "Purwakarta", "Subang", "Sumedang"],
            "Jawa Tengah": ["Magelang", "Pekalongan", "Salatiga", "Semarang", "Surakarta", "Tegal", "Banjarnegara", "Banyumas", "Batang", "Blora", "Boyolali", "Brebes", "Cilacap", "Demak", "Grobogan", "Jepara", "Karanganyar", "Kebumen", "Kendal", "Klaten", "Kudus", "Pati", "Pemalang", "Purbalingga", "Purworejo", "Rembang", "Sragen", "Sukoharjo", "Temanggung", "Wonogiri", "Wonosobo"],
            "DI Yogyakarta": ["Yogyakarta", "Bantul", "Gunungkidul", "Kulon Progo", "Sleman"],
            "Jawa Timur": ["Batu", "Blitar", "Kediri", "Madiun", "Malang", "Mojokerto", "Pasuruan", "Probolinggo", "Surabaya", "Bangkalan", "Banyuwangi", "Bojonegoro", "Bondowoso", "Gresik", "Jember", "Jombang", "Lamongan", "Lumajang", "Magetan", "Nganjuk", "Ngawi", "Pacitan", "Pamekasan", "Ponorogo", "Sampang", "Sidoarjo", "Situbondo", "Sumenep", "Trenggalek", "Tuban", "Tulungagung"],
            "Banten": ["Cilegon", "Serang", "Tangerang", "Tangerang Selatan", "Lebak", "Pandeglang"],
            "Bali": ["Denpasar", "Badung", "Bangli", "Buleleng", "Gianyar", "Jembrana", "Karangasem", "Klungkung", "Tabanan"],
            "Nusa Tenggara Barat": ["Bima", "Mataram", "Dompu", "Lombok Barat", "Lombok Tengah", "Lombok Timur", "Lombok Utara", "Sumbawa", "Sumbawa Barat"],
            "Nusa Tenggara Timur": ["Kupang", "Alor", "Belu", "Ende", "Flores Timur", "Lembata", "Malaka", "Manggarai", "Manggarai Barat", "Manggarai Timur", "Nagekeo", "Ngada", "Rote Ndao", "Sabu Raijua", "Sikka", "Sumba Barat", "Sumba Barat Daya", "Sumba Tengah", "Sumba Timur", "Timor Tengah Selatan", "Timor Tengah Utara"],
            "Kalimantan Barat": ["Pontianak", "Singkawang", "Bengkayang", "Kapuas Hulu", "Kayong Utara", "Ketapang", "Kubu Raya", "Landak", "Melawi", "Mempawah", "Sambas", "Sanggau", "Sekadau", "Sintang"],
            "Kalimantan Tengah": ["Palangka Raya", "Barito Selatan", "Barito Timur", "Barito Utara", "Gunung Mas", "Kapuas", "Katingan", "Kotawaringin Barat", "Kotawaringin Timur", "Lamandau", "Murung Raya", "Pulang Pisau", "Seruyan", "Sukamara"],
            "Kalimantan Selatan": ["Banjarbaru", "Banjarmasin", "Balangan", "Banjar", "Barito Kuala", "Hulu Sungai Selatan", "Hulu Sungai Tengah", "Hulu Sungai Utara", "Kotabaru", "Tabalong", "Tanah Bumbu", "Tanah Laut", "Tapin"],
            "Kalimantan Timur": ["Balikpapan", "Bontang", "Samarinda", "Berau", "Kutai Barat", "Kutai Kartanegara", "Kutai Timur", "Mahakam Ulu", "Paser", "Penajam Paser Utara"],
            "Kalimantan Utara": ["Tarakan", "Bulungan", "Malinau", "Nunukan", "Tana Tidung"],
            "Sulawesi Utara": ["Bitung", "Kotamobagu", "Manado", "Tomohon", "Bolaang Mongondow", "Bolaang Mongondow Selatan", "Bolaang Mongondow Timur", "Bolaang Mongondow Utara", "Kepulauan Sangihe", "Kepulauan Siau Tagulandang Biaro", "Kepulauan Talaud", "Minahasa", "Minahasa Selatan", "Minahasa Tenggara", "Minahasa Utara"],
            "Sulawesi Tengah": ["Palu", "Banggai", "Banggai Kepulauan", "Banggai Laut", "Buol", "Donggala", "Morowali", "Morowali Utara", "Parigi Moutong", "Poso", "Sigi", "Tojo Una-Una", "Toli-Toli"],
            "Sulawesi Selatan": ["Makassar", "Palopo", "Parepare", "Bantaeng", "Barru", "Bone", "Bulukumba", "Enrekang", "Gowa", "Jeneponto", "Kepulauan Selayar", "Luwu", "Luwu Timur", "Luwu Utara", "Maros", "Pangkajene Dan Kepulauan", "Pinrang", "Sidenreng Rappang", "Sinjai", "Soppeng", "Takalar", "Tana Toraja", "Toraja Utara", "Wajo"],
            "Sulawesi Tenggara": ["Bau-Bau", "Kendari", "Bombana", "Buton", "Buton Selatan", "Buton Tengah", "Buton Utara", "Kolaka", "Kolaka Timur", "Kolaka Utara", "Konawe", "Konawe Kepulauan", "Konawe Selatan", "Konawe Utara", "Muna", "Muna Barat", "Wakatobi"],
            "Gorontalo": ["Gorontalo", "Boalemo", "Bone Bolango", "Gorontalo Utara", "Pohuwato"],
            "Sulawesi Barat": ["Majene", "Mamasa", "Mamuju", "Mamuju Tengah", "Mamuju Utara", "Polewali Mandar"],
            "Maluku": ["Ambon", "Tual", "Buru", "Buru Selatan", "Kepulauan Aru", "Maluku Barat Daya", "Maluku Tengah", "Maluku Tenggara", "Maluku Tenggara Barat", "Seram Bagian Barat", "Seram Bagian Timur"],
            "Maluku Utara": ["Ternate", "Tidore Kepulauan", "Halmahera Barat", "Halmahera Selatan", "Halmahera Tengah", "Halmahera Timur", "Halmahera Utara", "Kepulauan Sula", "Pulau Morotai", "Pulau Taliabu"],
            "Papua": ["Jayapura", "Asmat", "Biak Numfor", "Boven Digoel", "Deiyai", "Dogiyai", "Intan Jaya", "Jayawijaya", "Keerom", "Kepulauan Yapen", "Lanny Jaya", "Mamberamo Raya", "Mamberamo Tengah", "Mappi", "Merauke", "Mimika", "Nabire", "Nduga", "Paniai", "Pegunungan Bintang", "Puncak", "Puncak Jaya", "Sarmi", "Supiori", "Tolikara", "Waropen", "Yahukimo", "Yalimo"],
            "Papua Barat": ["Sorong", "Fakfak", "Kaimana", "Manokwari", "Manokwari Selatan", "Maybrat", "Pegunungan Arfak", "Raja Ampat", "Sorong Selatan", "Tambrauw", "Teluk Bintuni", "Teluk Wondama"],
            "Papua Tengah": ["Nabire", "Deiyai", "Dogiyai", "Intan Jaya", "Mimika", "Paniai", "Puncak", "Puncak Jaya"],
            "Papua Pegunungan": ["Jayawijaya", "Lanny Jaya", "Mamberamo Tengah", "Nduga", "Pegunungan Bintang", "Tolikara", "Yahukimo", "Yalimo"],
            "Papua Selatan": ["Merauke", "Asmat", "Boven Digoel", "Mappi"],
            "Papua Barat Daya": ["Sorong", "Fakfak", "Kaimana", "Maybrat", "Raja Ampat", "Sorong Selatan", "Tambrauw"]
        };

        //Populate provinsi dropdown
        const provinsiSelect = document.getElementById('provinsi');
        const kotaSelect = document.getElementById('kota');

        Object.keys(wilayahData).sort().forEach(provinsi => {
            const option = document.createElement('option');
            option.value = provinsi;
            option.textContent = provinsi;
            provinsiSelect.appendChild(option);
        });

        //Chain combo: provinsi -> kota
        provinsiSelect.addEventListener('change', function() {
            const selectedProvinsi = this.value;
            kotaSelect.innerHTML = '<option value="">Pilih Kota</option>';
            
            if(selectedProvinsi) {
                kotaSelect.disabled = false;
                wilayahData[selectedProvinsi].forEach(kota => {
                    const option = document.createElement('option');
                    option.value = kota;
                    option.textContent = kota;
                    kotaSelect.appendChild(option);
                });
            } else {
                kotaSelect.disabled = true;
            }
        });

        //Signature Pad
        const canvas = document.getElementById('signature-pad');
        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)'
        });

        function clearSignature() {
            signaturePad.clear();
        }

        //Form validation
        const form = document.getElementById('registerForm');
        
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            event.stopPropagation();
            
            let isValid = true;

            //Bootstrap validation
            if (!form.checkValidity()) {
                isValid = false;
            }

            //Check signature
            const signatureError = document.getElementById('signature-error');
            if (signaturePad.isEmpty()) {
                signatureError.style.display = 'block';
                isValid = false;
            } else {
                signatureError.style.display = 'none';
                document.getElementById('signature').value = signaturePad.toDataURL();
            }

            form.classList.add('was-validated');

            if (isValid) {
                form.submit();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian!',
                    text: 'Mohon lengkapi atau sesuaikan semua field yang wajib diisi',
                    confirmButtonColor: '#ffc107'
                });
            }
        });
    </script>
</body>
</html>
