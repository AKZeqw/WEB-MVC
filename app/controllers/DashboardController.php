<?php
require_once '../app/controllers/AuthController.php';
class DashboardController extends Controller {
    
    public function __construct() {
        if(!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }
    }

    public function index() {
        $userModel = $this->model('User');
        $users = $userModel->getAllUsers();
        
        $data = [
            'users' => $users
        ];
        
        $this->view('dashboard/index', $data);
    }

    public function profile() {
        $userModel = $this->model('User');
        $user = $userModel->getUserById($_SESSION['user_id']);
        
        $data = [
            'user' => $user
        ];
        
        $this->view('profile/index', $data);
    }

    public function edit($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User');
            
            $data = [
                'nama_lengkap' => $_POST['nama_lengkap'],
                'email' => $_POST['email'],
                'nomor_telepon' => $_POST['nomor_telepon'],
                'provinsi' => $_POST['provinsi'],
                'kota' => $_POST['kota']
            ];

            //Update password jika diisi
            if(!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            //Update foto profil jika ada
            if(!empty($_FILES['foto_profil']['name'])) {
                $authController = new AuthController();
                $foto_profil = $authController->uploadFile($_FILES['foto_profil'], 'uploads/fotoprofil/');
                if($foto_profil) {
                    $data['foto_profil'] = $foto_profil;
                }
            }

            //Update tanda tangan jika ada
            if(!empty($_POST['signature'])) {
                $authController = new AuthController();
                $tanda_tangan = $authController->saveSignature($_POST['signature']);
                if($tanda_tangan) {
                    $data['tanda_tangan'] = $tanda_tangan;
                }
            }

            if($userModel->updateUser($id, $data)) {
                $_SESSION['success'] = 'Data berhasil diupdate!';
            } else {
                $_SESSION['error'] = 'Gagal update data!';
            }
            
            $this->redirect('dashboard/index');
        }
    }

    public function delete($id) {
        $userModel = $this->model('User');
        
        //1. Ambil data user terlebih dahulu berdasarkan ID
        $user = $userModel->getUserById($id);

        if(!$user) {
            $_SESSION['error'] = 'User tidak ditemukan!';
            $this->redirect('dashboard/index');
            return;
        }

        //2. Simpan nama file sebelum data dihapus
        $foto_profil_file = $user['foto_profil'];
        $tanda_tangan_file = $user['tanda_tangan'];
        
        //3. Cek apakah ID yang akan dihapus sama dengan ID di session
        //(Ini adalah user yang sedang menghapus akunnya sendiri)
        $isDeletingSelf = ($id == $_SESSION['user_id']);

        //4. Hapus data user dari database
        if($userModel->deleteUser($id)) {
            
            //5. Tentukan path file
            $path_foto = 'uploads/fotoprofil/' . $foto_profil_file;
            $path_ttd = 'uploads/tandatangan/' . $tanda_tangan_file;

            //6. Hapus file foto profil jika ada
            if(file_exists($path_foto) && !empty($foto_profil_file)) {
                unlink($path_foto);
            }

            //7. Hapus file tanda tangan jika ada
            if(file_exists($path_ttd) && !empty($tanda_tangan_file)) {
                unlink($path_ttd);
            }

            //8. Logika baru: Cek apakah user menghapus dirinya sendiri
            if($isDeletingSelf) {
                //Hancurkan session lama
                session_unset();
                session_destroy();
                
                //Mulai session baru hanya untuk menyimpan pesan sukses (flash message)
                session_start();
                $_SESSION['success'] = 'Akun Anda telah berhasil dihapus.';
                
                //Redirect ke halaman login
                $this->redirect('auth/login');
            } else {
                //Jika menghapus user lain (seperti admin)
                $_SESSION['success'] = 'User berhasil dihapus beserta filenya!';
                $this->redirect('dashboard/index');
            }

        } else {
            $_SESSION['error'] = 'Gagal menghapus user!';
            $this->redirect('dashboard/index');
        }
    }
}
?>
