
<?php require_once 'views/layout/header.php'; ?>

<?php require_once 'views/layout/menu.php'; ?>

<main>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="shop.html">Sản phẩm</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Chi tiết sản phẩm</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- page main wrapper start -->
    <div class="shop-main-wrapper section-padding pb-0">
        <div class="container">
            <div class="row">
                <!-- product details wrapper start -->
                <div class="col-lg-12 order-1 order-lg-2">
                    <!-- product details inner end -->
                    <div class="product-details-inner">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="product-large-slider">
                                    <?php foreach ($listSanpham as $key => $anhSanPham): ?>
                                        <div class="pro-large-img img-zoom">
                                            <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id=' . $Sanpham['id'] ?>">
                                                <img class="pri-img" src="<?= BASE_URL_IMG . $Sanpham['hinh_anh'] ?>" alt="product">
                                            </a>
                                            
                                        </div>
                                    <?php endforeach ?>
                                </div>
                                <div class="pro-nav slick-row-10 slick-arrow-style">
                                    <?php foreach ($listSanpham as $key => $anhSanPham): ?>
                                        <div class="pro-nav-thumb">
                                        
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="product-details-des">
                                    <div class="manufacturer-name">
                                        <a href="#"><?= $Sanpham['ten_danh_muc'] ?></a>
                                    </div>
                                    <h3 class="product-name"><?= $Sanpham['ten_san_pham'] ?></h3>
                                    <div class="ratings d-flex">
                                        <div class="pro-review">
                                            <?php $countComment = count($binhLuans); ?>
                                            <span><?= $countComment . ' bình luận' ?></span>
                                        </div>
                                    </div>
                                    <div class="price-box">
                                        <?php if ($Sanpham['gia_khuyen_mai']) { ?>
                                            <span class="price-regular"><?= ($Sanpham['gia_khuyen_mai']) . 'đ'; ?></span>
                                            <span class="price-old"><del><?= ($Sanpham['gia_ban']) . 'đ'; ?></del></span>
                                        <?php } else { ?>
                                            <span class="price-regular"><?= ($Sanpham['gia_ban']) . 'đ'; ?></span>
                                        <?php } ?>
                                        <!-- <span class="price-regular">$70.00</span>
                                        <span class="price-old"><del>$90.00</del></span> -->
                                    </div>

                                    <div class="availability">
                                        <i class="fa fa-check-circle"></i>
                                        <span><?= $Sanpham['so_luong'] . ' trong kho' ?></span>
                                    </div>
                                    <p class="pro-desc"><?= $Sanpham['mo_ta_chi_tiet'] ?></p>
                                    <div class="quantity-cart-box d-flex align-items-center">
                                        <h6 class="option-title">Số lượng:</h6>
                                        <div class="quantity">
                                            <div class="pro-qty"><input type="text" value="1"></div>
                                        </div>
                                        <div class="action_link">
                                            <a class="btn btn-cart2" href="#">Thêm giỏ hàng</a>
                                        </div>
                                    </div>
                                    
                                   

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product details inner end -->

                                        <!-- product details reviews start -->
                                        <div class="product-details-reviews section-padding pb-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="product-review-info">
                                    <ul class="nav review-tab">
                                        <li>
                                            <a class="active" data-bs-toggle="tab" href="#tab_three">Bình luận
                                                (<?= $countComment ?>)</a>
                                        </li>
                                        
                                    </ul>
                                    
                                    <div class="tab-content reviews-tab">
                                    <div class="card">
                                            <div class="card-body">
                                                <?php if (!empty($binhLuans)) : ?>
                                                <ul class="list-group list-group-flush">
                                                    <?php foreach ($binhLuans as $binhLuan) : ?>
                                                    <li class="list-group-item">
                                                        <strong><?= ($binhLuan['nguoi_binh_luan']) ?>:</strong>
                                                        <?= ($binhLuan['noi_dung']) ?>
                                                    </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                                <?php else : ?>
                                                <p class="text-muted">Chưa có bình luận nào.</p>
                                                <?php endif; ?>
                                            </div>

                                            <?php if (isset($_SESSION['nguoidungs_client'])): ?>
                                            <!-- Form bình luận cho người dùng đã đăng nhập -->
                                            <form action="index.php?act=add-binhluan" method="POST" class="review-form">
                                                <input type="hidden" name="san_pham_id" value="<?= $Sanpham['id'] ?>">
                                                <!-- ID sản phẩm -->
                                                <div class="form-group">
                                                    <label for="noi_dung">Nội dung bình luận:</label>
                                                    <textarea id="noi_dung" name="noi_dung" class="form-control"
                                                        required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                                            </form>
                                            <?php else: ?>
                                            <!-- Thông báo khi chưa đăng nhập -->
                                            <p class="text-muted">Bạn cần <a href="index.php?act=login">đăng
                                                    nhập</a> để thêm bình luận.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- product details reviews end -->
            </div>
            <!-- product details wrapper end -->
        </div>
    </div>
    </div>
    <!-- page main wrapper end -->

    <!-- related products area start -->
    <section class="related-products section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section title start -->
                    <div class="section-title text-center">
                        <h2 class="title">Sản phẩm liên quan</h2>
                        
                    </div>
                    <!-- section title start -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-carousel-4 slick-row-10 slick-arrow-style">
                        <!-- product item start -->
                        <?php foreach ($listSanphamCungDanhMuc as $key => $Sanpham): ?>
                            <!-- product item start -->
                            <div class="product-item">
                                <figure class="product-thumb">
                                    <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id=' . $Sanpham['id'] ?>">
                                        <img class="pri-img" src="<?= BASE_URL_IMG . $Sanpham['hinh_anh'] ?>" alt="product">
                                        <img class="sec-img" src="<?= BASE_URL_IMG . $Sanpham['hinh_anh'] ?>" alt="product">
                                    </a>
                                    <div class="product-badge">
                                        <?php
                                        $ngayNhap = new DateTime($Sanpham['ngay_nhap']);
                                        $ngayHienTai = new DateTime();
                                        $tinhNgay = $ngayHienTai->diff($ngayNhap);

                                        if ($tinhNgay->days <= 7) { ?>
                                            <div class="product-label new">
                                                <span>Mới</span>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <?php if ($Sanpham['gia_khuyen_mai']) { ?>

                                            <div class="product-label discount">
                                                <span>Giảm giá</span>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <div class="cart-hover">
                                        <button class="btn btn-cart">Xem chi tiết</button>
                                    </div>
                                </figure>
                                <div class="product-caption text-center">

                                    <h6 class="product-name">
                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id=' . $Sanpham['id'] ?>"><?= $Sanpham['ten_san_pham'] ?></a>
                                    </h6>
                                    <div class="price-box">
                                        <?php if ($Sanpham['gia_khuyen_mai']) { ?>
                                            <span class="price-regular"><?= ($Sanpham['gia_khuyen_mai']) . 'đ'; ?></span>
                                            <span class="price-old"><del><?= ($Sanpham['gia_ban']) . 'đ'; ?></del></span>
                                        <?php } else { ?>
                                            <span class="price-regular"><?= ($Sanpham['gia_ban']) . 'đ'; ?></span>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                            <!-- product item end -->
                        <?php endforeach ?>
                        <!-- product item end -->



                    </div>

                
                </div>
            </div>
        </div>
    </section>
    <!-- related products area end -->
</main>



<!-- offcanvas mini cart start -->
<div class="offcanvas-minicart-wrapper">
    <div class="minicart-inner">
        <div class="offcanvas-overlay"></div>
        <div class="minicart-inner-content">
            <div class="minicart-close">
                <i class="pe-7s-close"></i>
            </div>
            <div class="minicart-content-box">
                <div class="minicart-item-wrapper">
                    <ul>
                        <li class="minicart-item">
                            <div class="minicart-thumb">
                                <a href="product-details.html">
                                    <img src="assets/img/cart/cart-1.jpg" alt="product">
                                </a>
                            </div>
                            <div class="minicart-content">
                                <h3 class="product-name">
                                    <a href="product-details.html">Dozen White Botanical Linen Dinner Napkins</a>
                                </h3>
                                <p>
                                    <span class="cart-quantity">1 <strong>&times;</strong></span>
                                    <span class="cart-price">$100.00</span>
                                </p>
                            </div>
                            <button class="minicart-remove"><i class="pe-7s-close"></i></button>
                        </li>
                        <li class="minicart-item">
                            <div class="minicart-thumb">
                                <a href="product-details.html">
                                    <img src="assets/img/cart/cart-2.jpg" alt="product">
                                </a>
                            </div>
                            <div class="minicart-content">
                                <h3 class="product-name">
                                    <a href="product-details.html">Dozen White Botanical Linen Dinner Napkins</a>
                                </h3>
                                <p>
                                    <span class="cart-quantity">1 <strong>&times;</strong></span>
                                    <span class="cart-price">$80.00</span>
                                </p>
                            </div>
                            <button class="minicart-remove"><i class="pe-7s-close"></i></button>
                        </li>
                    </ul>
                </div>

                <div class="minicart-pricing-box">
                    <ul>
                        <li>
                            <span>sub-total</span>
                            <span><strong>$300.00</strong></span>
                        </li>
                        <li>
                            <span>Eco Tax (-2.00)</span>
                            <span><strong>$10.00</strong></span>
                        </li>
                        <li>
                            <span>VAT (20%)</span>
                            <span><strong>$60.00</strong></span>
                        </li>
                        <li class="total">
                            <span>total</span>
                            <span><strong>$370.00</strong></span>
                        </li>
                    </ul>
                </div>

                <div class="minicart-button">
                    <a href="cart.html"><i class="fa fa-shopping-cart"></i> View Cart</a>
                    <a href="cart.html"><i class="fa fa-share"></i> Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- offcanvas mini cart end -->

<?php require_once 'views/layout/footer.php'; ?>
