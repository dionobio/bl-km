<?php
class TaiKhoanController
{
    // Kết nối với model
    public $modelNguoiDung;

    public function __construct()
    {
        $this->modelNguoiDung = new NguoiDung();
    }

    // Hiển thị thông tin tài khoản cá nhân
    public function taikhoan()
{
    // Lấy thông tin người dùng từ session
    if (isset($_SESSION['nguoidungs_client'])) {
        // Lấy email và id từ session
        $email = $_SESSION['nguoidungs_client']['email'];
        $id = $_SESSION['nguoidungs_client']['id'];

        // Lấy thông tin người dùng từ cơ sở dữ liệu
        $nguoiDung = $this->modelNguoiDung->getUserByEmail($email);
        
        // Hiển thị thông tin người dùng trong view
        require_once './views/taikhoan/taikhoan.php';
    } else {
        // Nếu chưa đăng nhập, chuyển hướng về trang login
        header("Location: http://localhost/PH49685-DuAn1/base_du_an_1/index.php?act=login");
        exit();
    }
}


    // Chỉnh sửa tài khoản cá nhân
    public function editTaiKhoan()
    {
        if (isset($_SESSION['nguoidungs_client'])) {
            $email = $_SESSION['nguoidungs_client'];
            $nguoiDung = $this->modelNguoiDung->getUserByEmail($email);
            
            require_once './views/taikhoan/editTaiKhoan.php';
        } else {
            header("Location: http://localhost/PH49685-DuAn1/base_du_an_1/index.php" . '?act=login');
            exit();
        }
    }

    public function updateTaiKhoan()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $ten_nguoi_dung = $_POST['ten_nguoi_dung'];
        $so_dien_thoai = $_POST['so_dien_thoai'];
        $dia_chi = $_POST['dia_chi'];
        $mat_khau = $_POST['mat_khau'];

        // Validate input
        $errors = [];
        if (empty($ten_nguoi_dung)) $errors['ten_nguoi_dung'] = 'Tên người dùng không được để trống';
        if (empty($email)) $errors['email'] = 'Email không được để trống';
        if (empty($so_dien_thoai)) $errors['so_dien_thoai'] = 'Số điện thoại không được để trống';
        if (empty($dia_chi)) $errors['dia_chi'] = 'Địa chỉ không được để trống';
        if (empty($mat_khau)) $errors['mat_khau'] = 'Mật khẩu không được để trống';

        if (empty($errors)) {
            // Mã hóa mật khẩu nếu thay đổi
            $mat_khau = password_hash($mat_khau, PASSWORD_DEFAULT);
            
            // Cập nhật thông tin vào CSDL
            $this->modelNguoiDung->updateDataByEmail($email, $ten_nguoi_dung, $so_dien_thoai, $dia_chi, $mat_khau);
            $_SESSION['success'] = "Cập nhật thông tin thành công!";
            header("Location: http://localhost/PH49685-DuAn1/base_du_an_1/index.php?act=taikhoan");
            exit();
        } else {
            // Lưu lỗi vào session để hiển thị trên view
            $_SESSION['errors'] = $errors;
            // Chuyển hướng trở lại trang thông tin tài khoản để hiển thị lỗi
            header("Location: http://localhost/PH49685-DuAn1/base_du_an_1/index.php?act=editTaiKhoan");
            exit();
        }
    }
}


}
