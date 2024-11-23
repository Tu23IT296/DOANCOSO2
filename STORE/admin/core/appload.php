<?php
// Đảm bảo rằng file này chỉ có thể được truy cập từ các phần của hệ thống, không được truy cập trực tiếp.
defined('APPPATH') or exit('Không được quyền truy cập phần này');

// Bao gồm (include) các file cấu hình cần thiết từ thư mục cấu hình (config)
require CONFIGPATH . DIRECTORY_SEPARATOR . 'database.php';  // Bao gồm file cấu hình cơ sở dữ liệu
require CONFIGPATH . DIRECTORY_SEPARATOR . 'config.php';  // Bao gồm file cấu hình chung của hệ thống
require CONFIGPATH . DIRECTORY_SEPARATOR . 'email.php';  // Bao gồm file cấu hình email
require CONFIGPATH . DIRECTORY_SEPARATOR . 'autoload.php';  // Bao gồm file cấu hình tự động tải các thư viện, helper, v.v.

// Bao gồm các thư viện cốt lõi của hệ thống
require LIBPATH . DIRECTORY_SEPARATOR . 'database.php';  // Bao gồm thư viện xử lý cơ sở dữ liệu
require COREPATH . DIRECTORY_SEPARATOR . 'base.php';  // Bao gồm thư viện cơ sở của hệ thống (có thể là các lớp và hàm cơ bản)

// Kiểm tra nếu mảng $autoload có giá trị và thực hiện nạp tự động các thư viện, helper, hoặc các thành phần khác theo cấu hình
if (is_array($autoload)) {
    foreach ($autoload as $type => $list_auto) {  // Duyệt qua từng loại phần tử cần nạp (helper, library, ...)
        if (!empty($list_auto)) {
            foreach ($list_auto as $name) {  // Duyệt qua từng tên cần nạp trong loại đã chỉ định
                load($type, $name);  // Gọi hàm load() để nạp từng thành phần tương ứng.
            }
        }
    }
}

// Kết nối cơ sở dữ liệu thông qua hàm db_connect()
// Dữ liệu cấu hình cơ sở dữ liệu được lấy từ biến $db (thường là được cấu hình trong file database.php)
db_connect($db);

// Bao gồm file router.php từ thư mục cốt lõi. File này thường sẽ xử lý việc định tuyến (routing) trong hệ thống.
require COREPATH . DIRECTORY_SEPARATOR . 'router.php';
