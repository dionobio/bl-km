<?php
    class BinhLuanController {
        public $modelBinhLuan;

        public function __construct() {
            $this->modelBinhLuan = new BinhLuan();
        }

        // Hiển thị danh sách bình luận
        public function ListBinhLuan() {
            $listBinhLuan = $this->modelBinhLuan->getAll();
            
            // Debug: kiểm tra dữ liệu trả về

            require_once 'views/sanpham/list_binhluan.php'; // Trỏ đến file view danh sách bình luận
        }
        public function addBinhLuan() {
    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (!isset($_SESSION['nguoidungs_client'])) {
        // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
        header("Location: " . BASE_URL . "?act=login");
        exit();
    }

    // Lấy danh sách sản phẩm để hiển thị trong form (nếu cần)
    $sanPhams = $this->modelBinhLuan->getSanPhams();

    // Kiểm tra phương thức gửi yêu cầu
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sanPhamId = (int)$_POST['san_pham_id'];
        $noiDung = trim($_POST['noi_dung']);
        $nguoiDungId = $_SESSION['nguoidungs_client']['id'];

        $result = $this->modelBinhLuan->add($sanPhamId, $noiDung, $nguoiDungId);
        if ($result) {
            header("Location: index.php?act=chi-tiet-san-pham&id=" . $sanPhamId);
            exit();
        } else {
            echo "Có lỗi xảy ra khi thêm bình luận.";
        }
    }

    // Tải view form bình luận (và chi tiết sản phẩm nếu cần)
    require_once 'views/sanpham/chitiet_sanpham.php';
}

        
        
        

        // Chuyển trạng thái bình luận giữa Hiện và Ẩn
        public function toggleStatus() {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $result = $this->modelBinhLuan->toggleStatus($id);
                
                if ($result) {
                    header('Location: index.php?act=binh-luan'); // Chuyển hướng lại danh sách bình luận
                } else {
                    echo "Có lỗi xảy ra khi cập nhật trạng thái.";
                }
            }
        }
    }
    ?>