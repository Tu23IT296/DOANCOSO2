<?php

// Đảm bảo rằng chỉ có thể truy cập file này từ các phần khác trong hệ thống, không được truy cập trực tiếp.
defined('APPPATH') or exit('Không được quyền truy cập phần này');

// Lấy tên của Controller từ tham số 'controller' trong URL. Nếu không có, lấy tên mặc định từ cấu hình.
function get_controller()
{
    global $config;
    $controller = isset($_GET['controller']) ? $_GET['controller'] : $config['default_controller']; // Kiểm tra tham số 'controller' trong URL.
    return $controller; // Trả về tên controller.
}

// Lấy tên của Module từ tham số 'modules' trong URL. Nếu không có, lấy tên mặc định từ cấu hình.
function get_module()
{
    global $config;
    $module = isset($_GET['modules']) ? $_GET['modules'] : $config['default_module']; // Kiểm tra tham số 'modules' trong URL.
    return $module; // Trả về tên module.
}

// Lấy tên của Action từ tham số 'action' trong URL. Nếu không có, lấy tên mặc định từ cấu hình.
function get_action()
{
    global $config;
    $action = isset($_GET['action']) ? $_GET['action'] : $config['default_action']; // Kiểm tra tham số 'action' trong URL.
    return $action; // Trả về tên action.
}

/*
 * -------------------------------
 * Load
 * ------------------------------------------------------------------------------------
 * Hàm này giúp nạp các file từ các phân vùng vào hệ thống để xử lý.
 * Ví dụ: load('lib','database');
 * ------------------------------------------------------------------------------------
 * Giải thích:
 * Đầu vào:
 * - $type: Loại phân vùng hệ thống: lib, helper...
 * - $name: Tên chức năng được load: database, string...
 * ------------------------------------------------------------------------------------
 */

// Hàm load() dùng để nạp các file vào từ thư mục phân vùng tương ứng.
function load($type, $name)
{
    // Nếu $type là 'lib', tìm file trong thư mục LIBPATH
    if ($type == 'lib')
        $path = LIBPATH . DIRECTORY_SEPARATOR . "{$name}.php";
    // Nếu $type là 'helper', tìm file trong thư mục HELPERPATH
    if ($type == 'helper')
        $path = HELPERPATH . DIRECTORY_SEPARATOR . "{$name}.php";

    // Kiểm tra xem file có tồn tại không
    if (file_exists($path)) {
        require "$path"; // Nạp file nếu tồn tại.
    } else {
        echo "{$type}:{$name} không tồn tại"; // In thông báo nếu file không tồn tại.
    }
}

// Hàm này dùng để gọi các hàm được cung cấp trong mảng $list_function.
function call_function($list_function = array())
{
    // Kiểm tra nếu $list_function là mảng
    if (is_array($list_function)) {
        // Lặp qua từng hàm trong mảng
        foreach ($list_function as $f) {
            // Kiểm tra xem hàm có tồn tại không
            if (function_exists($f())) {
                $f(); // Gọi hàm nếu tồn tại.
            }
        }
    }
}

// Hàm load_view() dùng để nạp các file view từ thư mục 'views' của module hiện tại.
function load_view($name, $data_send = array())
{
    global $data;
    $data = $data_send; // Gán dữ liệu gửi vào cho biến toàn cục $data.
    // Xây dựng đường dẫn đến file view theo tên module và tên view
    $path = MODULESPATH . DIRECTORY_SEPARATOR . get_module() . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $name . 'View.php';

    // Kiểm tra xem file view có tồn tại không
    if (file_exists($path)) {
        // Nếu dữ liệu là mảng, gán từng giá trị vào các biến với tên tương ứng
        if (is_array($data)) {
            foreach ($data as $key_data => $v_data) {
                $$key_data = $v_data; // Gán các giá trị của mảng vào các biến.
            }
        }
        require $path; // Nạp file view.
    } else {
        echo "Không tìm thấy {$path}"; // In thông báo nếu không tìm thấy file.
    }
}

// Hàm load_model() dùng để nạp model từ thư mục 'models' của module hiện tại.
function load_model($name)
{
    // Xây dựng đường dẫn đến file model
    $path = MODULESPATH . DIRECTORY_SEPARATOR . get_module() . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $name . 'Model.php';

    // Kiểm tra xem file model có tồn tại không
    if (file_exists($path)) {
        require $path; // Nạp file model nếu tồn tại.
    } else {
        echo "Không tìm thấy {$path}"; // In thông báo nếu không tìm thấy file.
    }
}

// Hàm này nạp file header từ thư mục LAYOUTPATH.
function get_header($name = '')
{
    global $data;
    if (empty($name)) {
        $name = 'header'; // Nếu không có tên, mặc định là 'header'.
    } else {
        $name = "header-{$name}"; // Nếu có tên, tạo tên riêng như 'header-<name>'.
    }
    // Xây dựng đường dẫn đến file header
    $path = LAYOUTPATH . DIRECTORY_SEPARATOR . $name . '.php';

    // Kiểm tra xem file header có tồn tại không
    if (file_exists($path)) {
        // Nếu dữ liệu là mảng, gán các giá trị vào các biến.
        if (is_array($data)) {
            foreach ($data as $key => $a) {
                $$key = $a; // Gán giá trị của mảng vào các biến.
            }
        }
        require $path; // Nạp file header.
    } else {
        echo "Không tìm thấy {$path}"; // In thông báo nếu không tìm thấy file.
    }
}

// Hàm này nạp file footer từ thư mục LAYOUTPATH.
function get_footer($name = '')
{
    global $data;
    if (empty($name)) {
        $name = 'footer'; // Nếu không có tên, mặc định là 'footer'.
    } else {
        $name = "footer-{$name}"; // Nếu có tên, tạo tên riêng như 'footer-<name>'.
    }
    // Xây dựng đường dẫn đến file footer
    $path = LAYOUTPATH . DIRECTORY_SEPARATOR . $name . '.php';

    // Kiểm tra xem file footer có tồn tại không
    if (file_exists($path)) {
        // Nếu dữ liệu là mảng, gán các giá trị vào các biến.
        if (is_array($data)) {
            foreach ($data as $key => $a) {
                $$key = $a; // Gán giá trị của mảng vào các biến.
            }
        }
        require $path; // Nạp file footer.
    } else {
        echo "Không tìm thấy {$path}"; // In thông báo nếu không tìm thấy file.
    }
}

// Hàm này nạp file sidebar từ thư mục LAYOUTPATH.
function get_sidebar($name = '')
{
    global $data;
    if (empty($name)) {
        $name = 'sidebar'; // Nếu không có tên, mặc định là 'sidebar'.
    } else {
        $name = "sidebar-{$name}"; // Nếu có tên, tạo tên riêng như 'sidebar-<name>'.
    }
    // Xây dựng đường dẫn đến file sidebar
    $path = LAYOUTPATH . DIRECTORY_SEPARATOR . $name . '.php';

    // Kiểm tra xem file sidebar có tồn tại không
    if (file_exists($path)) {
        // Nếu dữ liệu là mảng, gán các giá trị vào các biến.
        if (is_array($data)) {
            foreach ($data as $key => $a) {
                $$key = $a; // Gán giá trị của mảng vào các biến.
            }
        }
        require $path; // Nạp file sidebar.
    } else {
        echo "Không tìm thấy {$path}"; // In thông báo nếu không tìm thấy file.
    }
}

// Hàm này nạp các template phần tử từ thư mục LAYOUTPATH.
function get_template_part($name)
{
    global $data;
    if (empty($name))
        return FALSE; // Trả về FALSE nếu không có tên.
    // Xây dựng đường dẫn đến template
    $path = LAYOUTPATH . DIRECTORY_SEPARATOR . "template-{$name}.php";

    // Kiểm tra xem file template có tồn tại không
    if (file_exists($path)) {
        // Gán giá trị của mảng vào các biến.
        foreach ($data as $key => $a) {
            $$key = $a;
        }
        require $path; // Nạp file template.
    } else {
        echo "Không tìm thấy {$path}"; // In thông báo nếu không tìm thấy file.
    }
}
