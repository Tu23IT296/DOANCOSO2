<?php get_header(); ?>
<?php if (!empty($_SESSION['mess'])) {
    echo "<script type='text/javascript'> alert('Bạn cần đăng nhập trước khi mua hàng!!!');</script>";
    unset($_SESSION['mess']);
} ?>

<style>
    /* Form đăng nhập và đăng ký */
    .form-wrapper {
        display: none;
        /* Ẩn form mặc định */
        background-color: #f1f1f1;
        padding: 20px;
        border-radius: 10px;
        margin-top: 10px;
        color: #1e3a8a;
    }

    .section-title {
        font-size: 24px;
        color: #1e3a8a;
        cursor: pointer;
        /* Con trỏ pointer để người dùng biết có thể nhấn vào */
        margin-bottom: 10px;
    }

    .form-wrapper label {
        display: block;
        font-size: 14px;
        color: #333;
        margin-bottom: 5px;
    }

    .form-wrapper input[type="text"],
    .form-wrapper input[type="password"],
    .form-wrapper input[type="email"],
    .form-wrapper input[type="tel"],
    .form-wrapper textarea {
        display: block;
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .submit-btn {
        background-color: #48ad48;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .submit-btn:hover {
        background-color: #3a7e3a;
    }
</style>

<div id="main-content-wp" class="checkout-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li><a href="?page=home" title="">Trang chủ</a></li>
                    <li><a href="" title="">Tài khoản</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div id="wrapper" class="wp-inner clearfix">
        <!-- Tiêu đề và Form đăng nhập -->
        <div class="section" id="customer-info-wp">
            <div class="section-head">
                <h1 class="section-title" id="login-title">Đăng nhập tài khoản</h1>
            </div>
            <div id="login-form" class="form-wrapper">
                <form method="post" action="?modules=users&controllers=index&action=login">
                    <label for="username">Tên đăng nhập</label>
                    <input type="text" name="username" id="username">
                    <label for="password">Mật khẩu</label>
                    <input type="password" name="password" id="password">
                    <input type="submit" name="btn_submit" value="Đăng nhập" class="submit-btn">
                </form>
            </div>
        </div>

        <!-- Tiêu đề và Form đăng ký -->
        <div class="section" id="customer-info-wp">
            <div class="section-head">
                <h1 class="section-title" id="register-title">Đăng ký tài khoản</h1>
            </div>
            <div id="register-form" class="form-wrapper">
                <form method="POST" action="?modules=users&controllers=index&action=crateAcount">
                    <label for="username-reg">Tên đăng nhập</label>
                    <input type="text" name="username" id="username-reg">
                    <label for="password-reg">Mật khẩu</label>
                    <input type="password" name="password" id="password-reg">
                    <label for="email">Email</label>
                    <input type="email" name="mail" id="email">
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" name="phone" id="phone">
                    <label for="fullname">Họ và tên</label>
                    <input type="text" name="fullname" id="fullname">
                    <label for="address">Địa chỉ</label>
                    <textarea name="address" id="address"></textarea>
                    <input type="submit" name="btn_submit_crate" value="Tạo" class="submit-btn">
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // Lấy tham số 'form' từ URL
    const urlParams = new URLSearchParams(window.location.search);
    const formType = urlParams.get('form');

    // Hiển thị form tương ứng khi có tham số 'form'
    window.onload = function() {
        const loginForm = document.getElementById("login-form");
        const registerForm = document.getElementById("register-form");

        if (formType === 'login') {
            loginForm.style.display = "block";
            registerForm.style.display = "none";
        } else if (formType === 'register') {
            registerForm.style.display = "block";
            loginForm.style.display = "none";
        }
    };
</script>
<?php get_footer(); ?>