<?php

// Hàm khởi tạo, load model 'index'
function construct()
{
    load_model('index');
}

// Hàm xử lý hành động "index" - Trang chủ (hoặc trang mặc định)
function indexAction() {}

// Hàm xử lý thêm mới sản phẩm
function addAction()
{
    // Lấy danh sách danh mục và thương hiệu từ cơ sở dữ liệu
    $categorys = getAllCategory();
    $brands = getAllBrand();
    $data = [$categorys, $brands];
    $err = array(); // Mảng lưu lỗi khi thêm sản phẩm

    // Kiểm tra nếu người dùng gửi form
    if (!empty($_POST['btn_submit'])) {
        // Lấy dữ liệu từ form
        $res = [
            'id_category' => $_POST['id_category'] ?? null,
            'id_brand' => $_POST['id_brand'] ?? null,
            'name' => $_POST['name'] ?? null,
            'code' => $_POST['code'] ?? null,
            'price' => $_POST['price'] ?? null,
            'promotional_price' => $_POST['promotional_price'] ?? '',
            'quantity' => $_POST['quantity'] ?? null,
            'status' => $_POST['status'] ?? null,
            'description' => $_POST['description'] ?? null,
            'screen' => $_POST['screen'] ?? null,
            'ram' => $_POST['ram'] ?? null,
            'cpu' => $_POST['cpu'] ?? null,
            'memory' => $_POST['memory'] ?? null,
            'operating_system' => $_POST['operating_system'] ?? null,
            'front_camera' => $_POST['front_camera'] ?? null,
            'rear_camera' => $_POST['rear_camera'] ?? null,
            'user' => $_POST['user'] ?? null,
            'level' => $_POST['level'] ?? null,
            'create_date' => date("d/m/Y", time()) // Thời gian tạo sản phẩm
        ];

        // Xử lý upload ảnh
        $upload_result = uploadImage($_FILES['image']);
        if ($upload_result['status']) {
            $res['image'] = $upload_result['path'];
        } else {
            $err['image'] = $upload_result['message'];
        }

        // Nếu không có lỗi, thêm sản phẩm vào cơ sở dữ liệu
        if (empty($err)) {
            if (insert_product($res)) {
                echo "<script type='text/javascript'> alert('Thêm mới thành công');</script>";
            } else {
                echo "<script type='text/javascript'> alert('Thêm mới thất bại');</script>";
            }
        }
    }

    // Gọi view 'add' và truyền vào dữ liệu danh mục, thương hiệu
    load_view('add', $data);
}

// Hàm xử lý danh sách sản phẩm
function listAction()
{
    // Lấy tất cả sản phẩm
    $data_tmp = getAllProduct();

    // Lấy thêm thông tin danh mục và thương hiệu cho mỗi sản phẩm
    foreach ($data_tmp as &$product) {
        $product['category'] = get_category_by_id($product['id_category']);
        $product['brand'] = get_brand_by_id($product['id_brand']);
    }

    // Phân trang: Lấy số trang hiện tại và số sản phẩm trên mỗi trang
    $page = $_GET['page'] ?? 1;
    $productOnPage = 20;
    $numProduct = count($data_tmp);
    $num = ceil($numProduct / $productOnPage);

    $start = ($page - 1) * $productOnPage;
    $res = array_slice($data_tmp, $start, $productOnPage);

    // Gọi view 'list' với dữ liệu sản phẩm và phân trang
    $data = [$res, $num, $page];
    load_view('list', $data);
}

// Hàm xử lý xóa sản phẩm
function deleteAction()
{
    // Lấy id sản phẩm từ URL
    $id = $_GET['id'];

    // Gọi hàm xóa sản phẩm
    delete_product_by_id($id);

    // Sau khi xóa, chuyển hướng về danh sách sản phẩm
    header('Location: ?modules=products&controllers=index&action=list');
}

// Hàm xử lý cập nhật sản phẩm
function updateAction()
{
    // Lấy id sản phẩm từ URL và thông tin sản phẩm
    $id = $_GET['id'];
    $product = get_product_by_id($id);
    $categories = getAllCategory();
    $brands = getAllBrand();

    // Dữ liệu cho view
    $data = [
        'product' => $product,
        'categories' => $categories,
        'brands' => $brands
    ];

    // Kiểm tra nếu người dùng gửi form
    if (!empty($_POST['btn_submit'])) {
        // Lấy dữ liệu từ form cập nhật sản phẩm
        $product_data = [
            'name' => $_POST['name'],
            'code' => $_POST['code'],
            'price' => $_POST['price'],
            'promotional_price' => $_POST['promotional_price'],
            'quantity' => $_POST['quantity'],
            'status' => $_POST['status'],
            'level' => $_POST['level'],
            'id_category' => $_POST['id_category'],
            'id_brand' => $_POST['id_brand'],
            'description' => $_POST['description'],
            'screen' => $_POST['screen'],
            'ram' => $_POST['ram'],
            'cpu' => $_POST['cpu'],
            'memory' => $_POST['memory'],
            'operating_system' => $_POST['operating_system'],
            'front_camera' => $_POST['front_camera'],
            'rear_camera' => $_POST['rear_camera'],
            'user' => $_POST['user']
        ];

        // Nếu có ảnh mới, xử lý tải lên ảnh
        if (!empty($_FILES['image']['name'])) {
            $upload_result = uploadImage($_FILES['image']);
            if ($upload_result['status']) {
                $product_data['image'] = $upload_result['path'];
            } else {
                echo "<script>alert('{$upload_result['message']}');</script>";
            }
        }

        // Cập nhật sản phẩm vào cơ sở dữ liệu
        update_product_by_id($id, $product_data);

        // Sau khi cập nhật, chuyển hướng về trang danh sách sản phẩm
        header("Location: ?modules=products&controllers=index&action=list");
        exit;
    }

    // Gọi view 'update' để hiển thị form cập nhật sản phẩm
    load_view('update', $data);
}

function uploadImage($file)
{
    // Kiểm tra lỗi khi tải lên
    if ($file['error'] != UPLOAD_ERR_OK) {
        return [
            'status' => false,
            'message' => 'Lỗi tải lên tệp tin!'
        ];
    }

    // Định nghĩa thư mục chứa ảnh
    $upload_dir = 'public/uploads/';

    // Kiểm tra nếu thư mục không tồn tại thì tạo mới
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Lấy tên tệp và phần mở rộng
    $file_name = basename($file['name']);
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Kiểm tra xem tệp có phải là ảnh hợp lệ không (jpg, jpeg, png)
    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    if (!in_array($file_extension, $allowed_extensions)) {
        return [
            'status' => false,
            'message' => 'Chỉ chấp nhận các tệp ảnh JPG, JPEG, PNG!'
        ];
    }

    // Đường dẫn tệp ảnh sẽ được lưu
    $file_path = $upload_dir . $file_name;

    // Di chuyển tệp tin từ thư mục tạm sang thư mục đích (Ghi đè nếu tệp đã tồn tại)
    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        return [
            'status' => true,
            'path' => $file_path // Đường dẫn tệp ảnh sau khi upload thành công
        ];
    } else {
        return [
            'status' => false,
            'message' => 'Không thể lưu tệp!'
        ];
    }
}
