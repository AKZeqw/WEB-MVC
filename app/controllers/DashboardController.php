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

            // Update password jika diisi
            if(!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            // Update foto profil jika ada
            if(!empty($_FILES['foto_profil']['name'])) {
                $authController = new AuthController();
                $foto_profil = $authController->uploadFile($_FILES['foto_profil'], 'uploads/fotoprofil/');
                if($foto_profil) {
                    $data['foto_profil'] = $foto_profil;
                }
            }

            // Update tanda tangan jika ada
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
        
        if($userModel->deleteUser($id)) {
            $_SESSION['success'] = 'User berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus user!';
        }
        
        $this->redirect('dashboard/index');
    }
}
?>
