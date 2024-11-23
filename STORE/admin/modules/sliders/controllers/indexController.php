<?php

function construct()
{
    // Hàm khởi tạo, dùng để tải các model cần thiết
    load_model('index');
}

function indexAction()
{
    // Hàm hiển thị nội dung chính của trang
}

function addAction() {
    // Khai báo các biến
    $user = ''; // Người tạo
    $type = ''; // Loại
    $image = ''; // Đường dẫn ảnh
    $err = array(); // Mảng lưu trữ các lỗi

    // Kiểm tra xem form có được gửi hay không
    if (!empty($_POST['btn_submit'])) {
        // Kiểm tra giá trị user (người tạo)
        if (!empty($_POST['user'])) {
            $user = $_POST['user'];
        } else {
            $err['user'] = 'Vui lòng nhập người tạo';
        }

        // Kiểm tra giá trị type (kiểu)
        if (!empty($_POST['type'])) {
            $type = $_POST['type'];
        } else {
            $err['type'] = 'Vui lòng chọn kiểu';
        }

        // Xử lý upload ảnh
        $target_dir = "public/uploads/"; // Thư mục lưu trữ ảnh
        $target_file = $target_dir . basename($_FILES["image"]["name"]); // Đường dẫn đầy đủ của file
        $uploadOk = 1; // Biến kiểm tra trạng thái upload
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Lấy định dạng file

        // Kiểm tra file ảnh
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1; // File là ảnh hợp lệ
            } else {
                $err['image'] = 'File không phải là ảnh.';
                $uploadOk = 0;
            }

            // Giới hạn dung lượng file ảnh là 2MB
            if ($_FILES["image"]["size"] > 2000000) {
                $err['image'] = 'File quá lớn.';
                $uploadOk = 0;
            }

            // Chỉ chấp nhận các định dạng JPG, JPEG, PNG, GIF
            if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                $err['image'] = 'Chỉ chấp nhận các định dạng JPG, JPEG, PNG & GIF.';
                $uploadOk = 0;
            }

            // Nếu không có lỗi và file được upload thành công
            if ($uploadOk && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = $target_file; // Lưu đường dẫn ảnh
            } else {
                $err['image'] = 'Lỗi khi tải ảnh lên.';
            }
        } else {
            $err['image'] = 'Vui lòng chọn một file ảnh.';
        }

        // Nếu không có lỗi, thêm dữ liệu vào cơ sở dữ liệu
        if (empty($err)) {
            $create_date = date("d/m/Y", time()); // Lấy ngày hiện tại
            $res = [
                'image' => $image,
                'user' => $user,
                'create_date' => $create_date,
                'type' => $type
            ];

            // Gọi hàm thêm dữ liệu vào database
            if (insert_slider($res)) {
                echo "<script type='text/javascript'>alert('Thêm mới thành công');</script>";
            } else {
                echo "<script type='text/javascript'>alert('Thêm mới danh mục sản phẩm thất bại');</script>";
            }
        } else {
            // Hiển thị các lỗi cụ thể cho người dùng
            foreach ($err as $key => $error) {
                echo "<script type='text/javascript'>alert('$key: $error');</script>";
            }
        }
    }

    // Tải view để hiển thị form thêm dữ liệu
    load_view('add');
}

function deleteAction()
{
    // Lấy ID từ URL để xóa slider
    $id = $_GET['id'];
    delete_slider_by_id($id);
    // Chuyển hướng về danh sách slider sau khi xóa
    header('location:?modules=sliders&controllers=index&action=list');
}

function listAction()
{
    // Lấy toàn bộ slider từ cơ sở dữ liệu
    $data_tmp = getAllSlider();
    $page = !empty($_GET['page']) ? $_GET['page'] : 1; // Lấy trang hiện tại, mặc định là trang 1

    $numProduct = count($data_tmp); // Tổng số sản phẩm
    $productOnPage = 5; // Số sản phẩm trên mỗi trang
    $num = ceil($numProduct / $productOnPage); // Tính tổng số trang

    if ($page > $num) {
        $page = $num; // Nếu trang vượt quá số trang, đặt về trang cuối cùng
    }

    // Xác định vị trí bắt đầu và kết thúc của dữ liệu hiển thị trên trang hiện tại
    $start = ($page - 1) * $productOnPage;
    $res = array_slice($data_tmp, $start, $productOnPage);

    // Truyền dữ liệu cần thiết vào view
    $data = [$res, $num, $page];
    load_view('list', $data);
}
