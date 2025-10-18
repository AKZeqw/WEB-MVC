<?php
class AuthController extends Controller {
    
    public function register() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validasi semua field harus diisi
            if(empty($_POST['nama_lengkap']) || empty($_POST['email']) || empty($_POST['password']) || 
               empty($_POST['nomor_telepon']) || empty($_POST['provinsi']) || empty($_POST['kota']) ||
               empty($_FILES['foto_profil']['name']) || empty($_POST['signature'])) {
                $_SESSION['error'] = 'Semua field harus diisi!';
                $this->redirect('auth/register');
                return;
            }

            // Validasi email format
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Format email tidak valid!';
                $this->redirect('auth/register');
                return;
            }

            // Validasi nomor telepon
            $nomor_telepon = $_POST['nomor_telepon'];
            if(!is_numeric($nomor_telepon) || strlen($nomor_telepon) < 11 || strlen($nomor_telepon) > 20) {
                $_SESSION['error'] = 'Nomor telepon harus angka dengan panjang 11-20 digit!';
                $this->redirect('auth/register');
                return;
            }

            // Cek email sudah terdaftar
            $userModel = $this->model('User');
            if($userModel->checkEmailExists($_POST['email'])) {
                $_SESSION['error'] = 'Email sudah terdaftar!';
                $this->redirect('auth/register');
                return;
            }

            // Upload foto profil
            $foto_profil = $this->uploadFile($_FILES['foto_profil'], '../uploads/fotoprofil/');
            if(!$foto_profil) {
                $_SESSION['error'] = 'Gagal upload foto profil!';
                $this->redirect('auth/register');
                return;
            }

            // Save signature (canvas to image)
            $tanda_tangan = $this->saveSignature($_POST['signature']);
            if(!$tanda_tangan) {
                $_SESSION['error'] = 'Gagal menyimpan tanda tangan!';
                $this->redirect('auth/register');
                return;
            }

            // Prepare data
            $data = [
                'nama_lengkap' => $_POST['nama_lengkap'],
                'email' => $_POST['email'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'nomor_telepon' => $nomor_telepon,
                'provinsi' => $_POST['provinsi'],
                'kota' => $_POST['kota'],
                'foto_profil' => $foto_profil,
                'tanda_tangan' => $tanda_tangan
            ];

            // Register user
            if($userModel->register($data)) {
                // Login otomatis setelah register
                $user = $userModel->login($_POST['email'], $_POST['password']);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['success'] = 'Registrasi berhasil!';
                
                // Redirect ke dashboard
                $this->redirect('dashboard/index');
                
                // ATAU jika ingin redirect ke login, ganti dengan:
                // $this->redirect('auth/login');
            } else {
                $_SESSION['error'] = 'Registrasi gagal!';
                $this->redirect('auth/register');
            }
        } else {
            $this->view('auth/register');
        }
    }

    public function login() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User');
            $user = $userModel->login($_POST['email'], $_POST['password']);
            
            if($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['success'] = 'Login berhasil!';
                $this->redirect('dashboard/index');
            } else {
                $_SESSION['error'] = 'Email atau password salah!';
                $this->redirect('auth/login');
            }
        } else {
            $this->view('auth/login');
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('auth/login');
    }

    public function uploadFile($file, $targetDir) {
        $fileName = time() . '_' . basename($file['name']);
        $targetFile = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
        // Check if image
        $check = getimagesize($file['tmp_name']);
        if($check === false) {
            return false;
        }
        
        // Check file size (max 5MB)
        if($file['size'] > 5000000) {
            return false;
        }
        
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            return false;
        }
        
        if(move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $fileName;
        }
        return false;
    }

    public function saveSignature($base64String) {
        // Remove data:image/png;base64, prefix
        $image = str_replace('data:image/png;base64,', '', $base64String);
        $image = str_replace(' ', '+', $image);
        $data = base64_decode($image);
        
        $fileName = time() . '_signature.png';
        $filePath = '../uploads/tandatangan/' . $fileName;
        
        if(file_put_contents($filePath, $data)) {
            return $fileName;
        }
        return false;
    }
}
?>
