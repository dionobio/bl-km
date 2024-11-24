<?php require_once 'views/layout/header.php'; ?>
<?php require_once 'views/layout/menu.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky">
                <form class="p-3" id="searchForm" aria-label="Tìm kiếm khuyến mãi">
                    <h5 class="text-primary">Tìm Kiếm Khuyến Mãi</h5>
                    <div class="mb-3">
                        <label for="searchName" class="form-label">Tìm Theo Tên Khuyến Mãi</label>
                        <input type="text" class="form-control" id="searchName" placeholder="Nhập tên khuyến mãi"
                            oninput="searchTable()">
                    </div>
                    <div class="mb-3">
                        <label for="searchCode" class="form-label">Tìm Theo Mã Khuyến Mãi</label>
                        <input type="text" class="form-control" id="searchCode" placeholder="Nhập mã khuyến mãi"
                            oninput="searchTable()">
                    </div>
                </form>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <section class="khuyen-mai-section py-5">
                <div class="container">
                    <h1 class="text-center mb-5 section-title">🎁 Danh Sách Khuyến Mãi 🎄</h1>
                    <div class="row g-4">
                        <?php if (!empty($khuyenMaiList)): ?>
                        <?php foreach ($khuyenMaiList as $khuyenMai): ?>
                        <?php if ($khuyenMai['trang_thai'] == 'active'): ?>
                        <!-- Kiểm tra trạng thái khuyến mãi -->
                        <div class="col-md-6 col-lg-4 col-12">
                            <div class="promotion-banner christmas-theme" aria-label="Thông tin khuyến mãi">
                                <h2 class="text-truncate"><?= htmlspecialchars($khuyenMai['ten_khuyen_mai']); ?></h2>
                                <p class="text-truncate"><?= htmlspecialchars($khuyenMai['mo_ta']); ?></p>
                                <p class="discount" style="font-size:30px;">🎄 Ưu đãi lên đến
                                <p style="font-size:50px;">🎁<?= htmlspecialchars($khuyenMai['discount_value']); ?>%</p>
                                </p>
                                <p>Thời gian: Từ <?= htmlspecialchars($khuyenMai['ngay_bat_dau']); ?> đến
                                    <?= htmlspecialchars($khuyenMai['ngay_ket_thuc']); ?></p>
                                <p>Mã:
                                    <span id="code-<?= $khuyenMai['id']; ?>" class="badge text-white code-badge">
                                        <?= htmlspecialchars($khuyenMai['ma_khuyen_mai']); ?>
                                    </span>
                                    <button class="btn btn-outline-light btn-sm mt-2"
                                        onclick="copyToClipboard('code-<?= $khuyenMai['id']; ?>')">
                                        Sao chép mã
                                    </button>
                                </p>
                                <span class="badge 
                    <?= $khuyenMai['trang_thai'] == 'active' ? 'bg-success' : 
                    ($khuyenMai['trang_thai'] == 'suspended' ? 'bg-warning text-dark' : 'bg-danger'); ?>">
                                    <?= $khuyenMai['trang_thai'] == 'active' ? 'Đang hoạt động' : 
                    ($khuyenMai['trang_thai'] == 'suspended' ? 'Tạm dừng' : 'Đã hết hạn'); ?>
                                </span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <!-- Kết thúc kiểm tra trạng thái -->
                        <?php endforeach; ?>
                        <?php else: ?>
                        <div class="col-12 text-center text-muted">
                            Không có khuyến mãi nào.
                        </div>
                        <?php endif; ?>
                    </div>

                    <div id="noResult" class="text-center text-muted" style="display: none;">
                        Không có khuyến mãi nào phù hợp.
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>


<script>
function copyToClipboard(elementId) {
    const text = document.getElementById(elementId).innerText;
    navigator.clipboard.writeText(text).then(() => {
        alert('Đã sao chép: ' + text);
    }).catch(err => {
        console.error('Lỗi khi sao chép: ', err);
    });
}

function searchTable() {
    let inputName = document.getElementById('searchName').value.trim().toLowerCase();
    let inputCode = document.getElementById('searchCode').value.trim().toLowerCase();
    let promotions = document.querySelectorAll('.promotion-banner');
    let hasResult = false;

    promotions.forEach(promotion => {
        let name = promotion.querySelector('h2').innerText.toLowerCase();
        let code = promotion.querySelector('.code-badge').innerText.toLowerCase();

        if ((name.includes(inputName) || inputName === '') &&
            (code.includes(inputCode) || inputCode === '')) {
            promotion.parentElement.style.display = 'block';
            hasResult = true;
        } else {
            promotion.parentElement.style.display = 'none';
        }
    });

    // Hiển thị hoặc ẩn thông báo "không có kết quả"
    document.getElementById('noResult').style.display = hasResult ? 'none' : 'block';
}

function generateSnowflakesInBanner() {
    const banners = document.querySelectorAll('.promotion-banner'); // Lấy tất cả các banner
    banners.forEach(banner => {
        const snowflakesCount = 10; // Số lượng bông tuyết trong mỗi banner
        for (let i = 0; i < snowflakesCount; i++) {
            let snowflake = document.createElement('div');
            snowflake.classList.add('snowflake');
            snowflake.textContent = '❄'; // Bông tuyết
            snowflake.style.left = Math.random() * 100 + 'vw'; // Vị trí trong phạm vi 100vw
            snowflake.style.animationDuration = Math.random() * 5 + 5 + 's'; // Thời gian rơi ngẫu nhiên
            snowflake.style.animationDelay = Math.random() * 10 + 's'; // Trễ ngẫu nhiên

            banner.appendChild(snowflake);

            // Xoá bông tuyết khi kết thúc animation
            snowflake.addEventListener('animationend', () => {
                snowflake.remove();
            });
        }
    });
}

// Gọi hàm để tạo bông tuyết khi trang được tải
window.onload = generateSnowflakesInBanner;


// Gọi hàm để tạo bông tuyết khi trang được tải
window.onload = generateSnowflakes;
</script>

<style>
.promotion-banner {
    width: 100%;
    min-height: 250px;
    background: linear-gradient(135deg, #ff5f5f, #ffd1d1);
    color: white;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    padding: 15px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    /* Để đảm bảo các phần tử con nằm trong phạm vi banner */
    overflow: hidden;
    /* Chặn các phần tử con tràn ra ngoài */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.snowflake {
    position: absolute;
    color: white;
    font-size: 1.5rem;
    pointer-events: none;
    user-select: none;
    z-index: 9999;
    animation: fall 10s linear infinite;
}

@keyframes fall {
    0% {
        top: -10px;
        opacity: 1;
    }

    100% {
        top: 100%;
        opacity: 0;
    }
}

.container,
.row,
.col-md-6,
.col-lg-4,
.col-12 {
    max-width: 100%;
    /* Đảm bảo các cột không vượt kích thước của cha */
    box-sizing: border-box;
}

img,
table {
    max-width: 100%;
    /* Giới hạn kích thước các hình ảnh và bảng */
    height: auto;
}

.promotion-banner:hover {
    transform: translateY(-10px);
    /* Nâng lên khi hover */
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
    /* Thêm bóng khi hover */
}

.promotion-banner h2,
.promotion-banner p {
    margin-bottom: 10px;
}

.promotion-banner .discount {
    font-size: 1rem;
    font-weight: bold;
    color: #ffdfba;
}

.promotion-banner button {
    margin-top: 10px;
}

.promotion-banner .badge {
    margin-top: 10px;
}



.promotion-banner h2 {
    font-size: 1.5rem;
    font-weight: bold;
    text-transform: uppercase;
    /* Viết hoa tất cả các chữ cái */
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
    /* Đổ bóng cho tiêu đề */
    color: #ffffff;
    /* Đảm bảo chữ màu trắng */
    transition: all 0.3s ease-in-out;
    /* Hiệu ứng chuyển đổi khi hover */
}

.promotion-banner p {
    font-size: 1rem;
    color: #ffdfba;
    /* Màu chữ mô tả */
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
    /* Đổ bóng cho mô tả */
}

.promotion-banner .discount {
    font-size: 1.1rem;
    font-weight: bold;
    color: #ffdfba;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    /* Đổ bóng cho discount */
}

.promotion-banner .badge {
    font-size: 0.9rem;
    font-weight: bold;
    text-transform: uppercase;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    /* Đổ bóng cho badge */
}

.promotion-banner:hover h2 {
    color: #ff5f5f;
    /* Thay đổi màu tiêu đề khi hover */
    text-shadow: 2px 2px 8px rgba(255, 87, 34, 0.8);
    /* Tăng độ đổ bóng khi hover */
}

.promotion-banner:hover p {
    color: #fff7e6;
    /* Màu chữ mô tả thay đổi khi hover */
}

.promotion-banner:hover .discount {
    color: #ffdfba;
    text-shadow: 1px 1px 5px rgba(255, 87, 34, 0.8);
    /* Tăng độ đổ bóng khi hover */
}

.promotion-banner:hover .badge {
    background-color: #ff5f5f;
    /* Màu nền badge thay đổi khi hover */
    color: #fff;
    /* Đổi màu chữ badge */
    text-shadow: 2px 2px 5px rgba(255, 87, 34, 0.8);
    /* Tăng độ đổ bóng khi hover */
}
</style>