<?php

function construct()
{

    load_model('index');
}

function indexAction() {}

function addAction()
{
    $name = '';
    $code = '';
    $image = '';
    $description = '';
    $user = '';
    $err = [];
    $successMessage = '';

    if (!empty($_POST['btn_submit'])) {
        $name = !empty($_POST['name']) ? $_POST['name'] : $err['name'] = "Tên không được rỗng";
        $user = !empty($_POST['user']) ? $_POST['user'] : $err['user'] = "Người tạo không được rỗng";
        $code = !empty($_POST['code']) ? $_POST['code'] : $err['code'] = "Mã không được rỗng";
        $description = !empty($_POST['description']) ? $_POST['description'] : $err['description'] = "Mô tả không được rỗng";

        // Kiểm tra ảnh
        $image_result = upload_image($_FILES['image']);
        if (isset($image_result['errors'])) {
            $err['image'] = implode(', ', $image_result['errors']);
        } else {
            $image = $image_result['path'];
        }

        // Nếu không có lỗi
        if (empty($err)) {
            // Lưu ngày tháng hiện tại theo định dạng Y-m-d
            $create_date = date("Y-m-d");  // Lấy ngày tháng năm mà không có thời gian

            // Dữ liệu để thêm vào DB
            $data = [
                'name' => $name,
                'code' => $code,
                'image' => $image,
                'description' => $description,
                'create_date' => $create_date,  // Sử dụng ngày tháng không có giờ
                'user' => $user,
            ];

            // Thêm dữ liệu vào cơ sở dữ liệu
            if (insert_category($data)) {
                echo '<script type="text/javascript">
                        alert("Thêm mới thương hiệu thành công!");
                        window.location.href = "?modules=brand&controllers=index&action=list";
                      </script>';
                exit;
            } else {
                $err['general'] = "Thêm mới thương hiệu thất bại!";
            }
        }
    }

    // Gửi dữ liệu và lỗi về view
    load_view('add', ['err' => $err, 'successMessage' => $successMessage]);
}

function upload_image($file, $target_dir = "public/uploads/", $max_size = 2000000, $allowed_types = ['jpg', 'png', 'jpeg', 'gif'])
{
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $errors = [];

    if (!getimagesize($file["tmp_name"])) {
        $errors[] = "File không phải là ảnh hợp lệ.";
    }
    if ($file["size"] > $max_size) {
        $errors[] = "File quá lớn.";
    }
    if (!in_array($imageFileType, $allowed_types)) {
        $errors[] = "Định dạng file không được hỗ trợ.";
    }
    if (empty($errors)) {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return ['path' => $target_file];
        } else {
            $errors[] = "Không thể tải lên file.";
        }
    }
    return ['errors' => $errors];
}

function listAction()
{
    $data_tmp = getAll();
    // phaan trang
    $page;
    if (!empty($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    $numProduct = count($data_tmp);
    $productOnPage = 7;
    $num = ceil($numProduct / $productOnPage);
    if (!empty($_GET['page']) && $_GET['page'] > $num) {
        $page = $num;
    }
    $start = ($page - 1) * $productOnPage;
    $res = [];
    for ($i = $start; $i < $start + $productOnPage; $i++) {
        if (isset($data_tmp[$i]))
            $res[] = $data_tmp[$i];
    };

    $data = [$res, $num, $page];
    load_view('list', $data);
}

function deleteAction()
{

    $id = $_GET['id'];
    delete_category_by_id($id);
    header('location:?modules=brands&controllers=index&action=list');
}

function editAction()
{

    $id = $_GET['id'];
    $data = get_category_by_id($id);
    load_view('show', $data);
}

function updateAction()
{
    // Lấy ID từ URL
    $id = $_GET['id'];

    // Lấy dữ liệu hiện tại của bản ghi
    $currentData = get_category_by_id($id);

    // Nếu không tìm thấy bản ghi, thông báo lỗi
    if (empty($currentData)) {
        echo "<script>alert('Không tìm thấy thương hiệu!'); window.location.href='?modules=brands&controllers=index&action=list';</script>";
        exit();
    }

    // Khởi tạo mảng lưu dữ liệu cập nhật
    $data = [];

    // Kiểm tra nếu người dùng nhấn nút cập nhật
    if (!empty($_POST['btn_submit'])) {

        // Kiểm tra và gán giá trị từ form
        $data['name'] = !empty($_POST['name']) ? $_POST['name'] : $currentData[0]['name'];
        $data['code'] = !empty($_POST['code']) ? $_POST['code'] : $currentData[0]['code'];
        $data['user'] = !empty($_POST['user']) ? $_POST['user'] : $currentData[0]['user'];
        $data['description'] = !empty($_POST['description']) ? $_POST['description'] : $currentData[0]['description'];

        // Xử lý upload ảnh
        $target_dir = "public/uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra file ảnh (nếu có)
        if (!empty($_FILES["image"]["tmp_name"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                if (
                    $_FILES["image"]["size"] <= 2000000 &&
                    in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])
                ) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        $data['image'] = $target_dir . basename($_FILES["image"]["name"]);
                    } else {
                        echo "<script>alert('Lỗi khi tải ảnh lên!');</script>";
                    }
                } else {
                    echo "<script>alert('File ảnh không hợp lệ hoặc vượt quá kích thước cho phép!');</script>";
                }
            }
        } else {
            $data['image'] = $currentData[0]['image']; // Giữ nguyên ảnh cũ nếu không thay đổi
        }

        // Cập nhật dữ liệu
        if (update_category_by_id($id, $data)) {
            echo "<script>alert('Cập nhật thành công!'); window.location.href='?modules=brands&controllers=index&action=list';</script>";
            exit();
        } else {
            echo "<script>alert('Cập nhật thất bại!');</script>";
        }
    }

    // Load lại view hiển thị dữ liệu hiện tại
    load_view('edit', $currentData[0]);
}
