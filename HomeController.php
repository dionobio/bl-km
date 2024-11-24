<?php 

class HomeController
{

    public $modelNguoiDung;
    public $modelSanPham;
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
        $this->modelNguoiDung = new NguoiDung();
        $this->modelSanPham = new SanPham();
    }

    public function home(){
        $listSanPham = $this->modelSanPham->getAllSanPham();
        require_once './views/home.php';
    }

    // Đăng nhập
    public function formLogin(){
        require_once './views/dangnhap/formLogin.php';
        
    }

    public function checkLogin(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
            $email = $_POST['email'];
            $mat_khau = $_POST['mat_khau'];
    
            // Kiểm tra đăng nhập
            $nguoiDungs = $this->modelNguoiDung->checkLogin2($email, $mat_khau);
    
            // Kiểm tra nếu $nguoiDungs là mảng (đăng nhập thành công)
            if (is_array($nguoiDungs)) {
                // Lưu thông tin người dùng vào session dưới dạng mảng
                $_SESSION['nguoidungs_client'] = [
                    'id' => $nguoiDungs['id'],
                    'ten_nguoi_dung' => $nguoiDungs['ten_nguoi_dung'],
                    'email' => $nguoiDungs['email'],
                    'so_dien_thoai' => $nguoiDungs['so_dien_thoai'],
                    'trang_thai' => $nguoiDungs['trang_thai'],
                    'vai_tro' => $nguoiDungs['vai_tro']
                ];
                header("Location: http://localhost/PH49685-DuAn1/base_du_an_1/index.php");
                exit();
            } else {
                // Nếu không phải mảng, tức là có lỗi xảy ra
                $_SESSION['error'] = $nguoiDungs; // Lưu thông báo lỗi vào session
                $_SESSION['flash'] = true;
                header("Location: http://localhost/PH49685-DuAn1/base_du_an_1/index.php?act=login");
                exit();
            }
        }
    }
    
    
    
    
    // Đăng ký
    public function formDangKy(){
        require_once './views/dangnhap/formDangKy.php';
    }
    
    public function checkDangKy(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Lấy dữ liệu từ form
            $ten_nguoi_dung = $_POST['ten_nguoi_dung'];
            $email = $_POST['email'];
            $so_dien_thoai = $_POST['so_dien_thoai'];
            $mat_khau = $_POST['mat_khau'];
            $confirm_mat_khau = $_POST['confirm_mat_khau'];
            $dia_chi = $_POST['dia_chi'];
    
            // Kiểm tra nếu mật khẩu xác nhận khớp
            if ($mat_khau !== $confirm_mat_khau) {
                $_SESSION['error'] = "Mật khẩu và xác nhận mật khẩu không khớp.";
                header("Location: http://localhost/PH49685-DuAn1/base_du_an_1/index.php" . '?act=dangky');
                exit();
            }
    
            // Gọi phương thức trong model để đăng ký người dùng
            $result = $this->modelNguoiDung->checkDangKy2($ten_nguoi_dung, $email, $so_dien_thoai, $mat_khau, $dia_chi);
    
            if ($result === true) {
                // Đăng ký thành công, chuyển hướng đến trang đăng nhập
                $_SESSION['success'] = "Đăng ký thành công! Bạn có thể đăng nhập ngay.";
                header("Location: http://localhost/PH49685-DuAn1/base_du_an_1/index.php" . '?act=login');
                exit();
            } else {
                // Nếu có lỗi (email đã tồn tại), hiển thị lỗi
                $_SESSION['error'] = $result;
                header("Location: http://localhost/PH49685-DuAn1/base_du_an_1/index.php" . '?act=dangky');
                exit();
            }
        }
    }
    
     // Đăng xuất
     public function logout() {
        session_start();
        unset($_SESSION['nguoidungs_client']); // Hủy phiên đăng nhập
        session_destroy(); // Xóa toàn bộ session
        header("Location: http://localhost/PH49685-DuAn1/base_du_an_1/index.php");
        exit();
    }

  
    public function danhSachSanPham()
    {
        $searchTerm = $_GET['search'] ?? ''; 
        if ($searchTerm) {
            $Sanphams = $this->modelSanPham->searchByName($searchTerm);
        } else {
            $Sanphams = $this->modelSanPham->getAll();
        }
    
        // Gửi dữ liệu đến view
        require_once './views/sanpham/listSanpham.php';
    }

    
    public function chiTietSanPham(){
        $danhMucs = $this->modelSanPham->getDanhMucs();
        $id = $_GET['id'] ?? null;
    
        if ($id && is_numeric($id)) {
            // Lấy thông tin sản phẩm theo ID
            $Sanpham = $this->modelSanPham->getSpById($id);
    
            // Lấy danh sách ảnh của sản phẩm
            $listSanpham = $this->modelSanPham->getlistAnh($id);
    
            // Lấy bình luận của sản phẩm
            $binhLuans = $this->modelSanPham->getBinhLuansBySanPhamId($id); 
    
            // Lấy đánh giá của sản phẩm
            $danhGias = $this->modelSanPham->getDanhGiasBySanPhamId($id);

            $listSanphamCungDanhMuc = $this->modelSanPham->getListSanPhamDanhMuc($Sanpham['danh_muc_id']);
            
            if ($Sanpham) {
                // Truyền dữ liệu vào view
                require "./views/sanpham/chitiet_sanpham.php";
            } else {
                header("Location: " . BASE_URL);
            }
        } else {
            echo "ID không hợp lệ!";
        }
    }
}