<?php get_header(); ?>
<div id="main-content-wp" class="checkout-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="?page=home" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Liên hệ</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="wrapper" class="wp-inner clearfix">
        <?php
        require "PHPMailer-master/src/PHPMailer.php";
        require "PHPMailer-master/src/SMTP.php";
        require 'PHPMailer-master/src/Exception.php';

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_submit_crate'])) {
            $fullname = htmlspecialchars($_POST['fullname']);
            $user_email = htmlspecialchars($_POST['email']);
            $address = htmlspecialchars($_POST['address']);
            $phone = htmlspecialchars($_POST['phone']);
            $note = htmlspecialchars($_POST['note']);

            if (!empty($fullname) && !empty($user_email) && !empty($note)) {
                $mail = new PHPMailer(true);

                try {
                    // Cấu hình máy chủ SMTP
                    $mail->isSMTP();
                    $mail->CharSet  = "utf-8";
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'taitaongu65@gmail.com'; // Đặt email SMTP của bạn ở đây
                    $mail->Password = 'xfdl vqhz mjqb wluo'; // Đặt mật khẩu ứng dụng của bạn ở đây
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;

                    // Cấu hình người gửi và người nhận
                    $mail->setFrom($user_email, $fullname); // Đặt người gửi là email từ form
                    $mail->addAddress('tunt.23it@vku.udn.vn', 'nguyen thanh tu'); // Bạn là người nhận

                    // Cấu hình nội dung email
                    $mail->isHTML(true);
                    $mail->Subject = "Ý kiến đóng góp từ khách hàng - $fullname";
                    $mail->Body = "
                <b>Họ tên:</b> $fullname<br>
                <b>Email:</b> $user_email<br>
                <b>Địa chỉ:</b> $address<br>
                <b>Số điện thoại:</b> $phone<br>
                <b>Nội dung:</b><br>$note
            ";

                    // Gửi email
                    $mail->send();
                    echo "<script>alert('Cảm ơn bạn đã đóng góp ý kiến!');</script>";
                } catch (Exception $e) {
                    echo "<script>alert('Gửi email thất bại, vui lòng thử lại sau!');</script>";
                }
            } else {
                echo "<script>alert('Vui lòng điền đầy đủ thông tin!');</script>";
            }
        }
        ?>
        <div class="section" id="customer-info-wp">
            <div class="section-head">
                <h1 class="section-title">Đóng Góp ý kiến của khách hàng</h1>
            </div>
            <div class="section-detail">
                <form method="POST" action="" name="form-checkout">
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="fullname">Họ tên</label>
                            <input type="text" name="fullname" id="fullname">
                        </div>
                        <div class="form-col fl-right">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email">
                        </div>
                    </div>
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="address">Địa chỉ</label>
                            <input type="text" name="address" id="address">
                        </div>
                        <div class="form-col fl-right">
                            <label for="phone">Số điện thoại</label>
                            <input type="tel" name="phone" id="phone">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="notes">Nội dung</label>
                            <textarea name="note"></textarea>
                        </div>
                    </div>
                    <input type="submit" name="btn_submit_crate" id="btn-submit" value="Gửi" style="height: 40px;
                                                                                                border-radius: 60px;
                                                                                                width: 150px;
                                                                                                color: green;
                                                                                                border-color: white;
                                                                                                color: white;
                                                                                                background-color: #48ad48;">
                </form>
            </div>
        </div>
        <div class="section" id="order-review-wp">
            <div class="section-head">
                <h1 class="section-title">Thông tin liên hệ</h1>
            </div>

            <div class="map">
                <iframe width="600" height="350" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15342.936098874476!2d108.253227!3d15.9752603!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3142108997dc971f%3A0x1295cb3d313469c9!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBuZ2jhu4cgVGjDtG5nIHRpbiB2w6AgVHJ1eeG7gW4gdGjDtG5nIFZp4buHdCAtIEjDoG4sIMSQ4bqhaSBo4buNYyDEkMOgIE7hurVuZw!5e0!3m2!1svi!2s!4v1730562552534!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <div class="section-detail">
                <table class="shop-table">
                    <thead>
                        <tr>
                            <td>Trường Đại học Công nghệ Thông tin và Truyền thông Việt - Hàn</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="cart-item">
                            <td class="product-name">470 Đ. Trần Đại Nghĩa, Hoà Hải, Ngũ Hành Sơn, Đà Nẵng</strong></td>
                        </tr>
                        <tr class="cart-item">
                            <td class="product-name">Mobile: 0377584918<strong class="product-quantity"> A Tus</strong></td>
                        </tr>
                        <tr class="cart-item">
                            <td class="product-name">Mobile: 0899721336<strong class="product-quantity"> A Vux</strong></td>
                        </tr>
                        <tr class="order-total">
                            <td><strong class="total-price">Email: tunt.23it@vku.udn.vn</strong></td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr class="order-total">
                            <td><strong class="total-price">Mạng xã hội</strong></td>
                        </tr>
                        <tr class="order-total">
                            <td>
                                <strong class="total-price">
                                    <ul>
                                        <li style="display: inline-block; padding: 0px 20px; font-size: 50px;">
                                            <a style="color:gray;" href="https://www.facebook.com/p/nguy%E1%BB%85n-t%C3%BA-100034473188717/"><i class="fa fa-facebook"></i></a>
                                        </li>
                                        <li style="display: inline-block;padding: 0px 20px;font-size: 50px;">
                                            <a style="color:gray;" href="#"><i class="fa fa-twitter"></i></a>
                                        </li>
                                        <li style="display: inline-block;padding: 0px 20px;font-size: 50px;">
                                            <a style="color:gray;" href="#"><i class="fa fa-google-plus"></i></a>
                                        </li>
                                        <li style="display: inline-block;padding: 0px 20px;font-size: 50px;">
                                            <a style="color:gray;" href="#"><i class="fa fa-youtube"></i></a>
                                        </li>
                                    </ul>
                                </strong>
                            </td>

                        </tr>

                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>