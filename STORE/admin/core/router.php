<?php
// Triệu gọi đến file xử lý thông qua request

// Xây dựng đường dẫn đến file controller của module và controller hiện tại.
// Đường dẫn này được xác định bởi các hàm `get_module()`, `get_controller()`, và cấu trúc thư mục của hệ thống.
$request_path = MODULESPATH . DIRECTORY_SEPARATOR . get_module() . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . get_controller() . 'Controller.php';

// Kiểm tra nếu người dùng chưa đăng nhập và action hiện tại không phải là 'login',
// thì chuyển hướng (redirect) đến trang đăng nhập của module 'users'.
if (empty($_SESSION['is_login']) && $_GET['action'] != 'login')
    header('location:?modules=users&controller=index&action=login'); // Nếu không đăng nhập và không phải action 'login', chuyển hướng đến trang login.

// Kiểm tra nếu file controller tồn tại theo đường dẫn đã xây dựng trước đó.
// Nếu tồn tại, yêu cầu (require) file controller để thực thi các mã xử lý trong đó.
if (file_exists($request_path)) {
    require $request_path; // Nạp file controller nếu nó tồn tại.
} else {
    echo "Không tìm thấy:$request_path "; // Nếu không tìm thấy file controller, in thông báo lỗi.
}

// Lấy tên action từ tham số 'action' trong URL và thêm 'Action' vào sau để xác định tên hàm action trong controller.
// Ví dụ: nếu `$_GET['action'] = 'index'`, thì `$action_name` sẽ có giá trị 'indexAction'.
$action_name = get_action() . 'Action';

// Gọi đến các hàm đã được chỉ định trong mảng `call_function()`, ví dụ như 'construct' (hàm khởi tạo) và `$action_name` (hàm xử lý action hiện tại).
call_function(array('construct', $action_name));
