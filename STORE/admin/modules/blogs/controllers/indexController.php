<?php

function construct()
{
    load_model('index');
}

function addAction()
{

    $title;
    $user;
    $content;
    $create_date;
    $description;
    $image;
    $err = array();
    if (!empty($_POST['btn_submit'])) {

        if (!empty($_POST['title'])) {
            $title = $_POST['title'];
        } else {
            $err['title'] = "title không được rỗng";
        }

        if (!empty($_POST['user'])) {
            $user = $_POST['user'];
        } else {
            $err['user'] = "user không được rỗng";
        }

        if (!empty($_POST['content'])) {
            $content = $_POST['content'];
        } else {
            $err['content'] = "content không được rỗng";
        }

        if (!empty($_POST['description'])) {
            $description = $_POST['description'];
        } else {
            $err['description'] = "description không được rỗng";
        }

        // check ảnh
        $target_dir = "public/uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
        }

        if (file_exists($target_file)) {
            $uploadOk = 0;
        }

        if ($_FILES["image"]["size"] > 200000000) {
            $uploadOk = 0;
        }

        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = $target_dir . basename($_FILES["image"]["name"]);
            }
        }
        if (empty($image)) {
            $err['image'] = "image không được rỗng";
        }

        if (empty($err)) {
            $create_date = date("d/m/Y", time());
            $data = [
                'title' => $title,
                'content' => $content,
                'user' => $user,
                'create_date' => $create_date,
                'description' => $description,
                'image' => $image
            ];
            if (insert_blog($data)) {

                echo " <script type='text/javascript'> alert('Thêm mới bài viết thành công');</script>";
            } else {

                echo " <script type='text/javascript'> alert('Thêm mới bài viết thất bại');</script>";
            }
        } else {

            echo " <script type='text/javascript'> alert('Thêm mới bài viết thất bại haha');</script>";
        }
    }
    load_view('add');
}

function deleteAction()
{
    $id = $_GET['id'];
    delete_blog_by_id($id);
    header('location:?modules=blogs&controllers=index&action=list');
}

function updateAction()
{
    $id = $_GET['id'];
    $blog = get_blog_by_id($id);
    $err = array();

    if (!empty($_POST['btn_submit'])) {
        $title = $_POST['title'] ?? '';
        $user = $_POST['user'] ?? '';
        $content = $_POST['content'] ?? '';
        $description = $_POST['description'] ?? '';
        $image = $blog['image']; // Giữ lại ảnh cũ nếu không có ảnh mới

        if (empty($title)) {
            $err['title'] = "Title không được rỗng";
        }
        if (empty($user)) {
            $err['user'] = "User không được rỗng";
        }
        if (empty($content)) {
            $err['content'] = "Content không được rỗng";
        }
        if (empty($description)) {
            $err['description'] = "Description không được rỗng";
        }

        // Xử lý ảnh nếu có ảnh mới được tải lên
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
            $target_dir = "public/uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false && $_FILES["image"]["size"] <= 2000000 && in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image = $target_file; // Cập nhật đường dẫn ảnh mới
                } else {
                    $err['image'] = "Lỗi khi tải ảnh lên.";
                }
            } else {
                $err['image'] = "File không hợp lệ hoặc quá lớn.";
            }
        }

        // Nếu không có lỗi, cập nhật dữ liệu
        if (empty($err)) {
            $data = [
                'title' => $title,
                'content' => $content,
                'user' => $user,
                'description' => $description,
                'image' => $image
            ];

            if (update_blog($data, $id)) {
                echo "<script type='text/javascript'> alert('Cập nhật bài viết thành công');</script>";
                header('location:?modules=blogs&controllers=index&action=list');
                exit();
            } else {
                echo "<script type='text/javascript'> alert('Cập nhật bài viết thất bại');</script>";
            }
        } else {
            foreach ($err as $value) {
                echo "<script type='text/javascript'> alert('$value');</script>";
            }
        }
    }

    load_view('edit', ['blog' => $blog]);
}

function listAction()
{
    $data_tmp = getAll();

    // Phân trang
    $page = !empty($_GET['page']) ? $_GET['page'] : 1;
    $numProduct = count($data_tmp);
    $productOnPage = 5;
    $num = ceil($numProduct / $productOnPage);
    if (!empty($_GET['page']) && $_GET['page'] > $num) {
        $page = $num;
    }

    $start = ($page - 1) * $productOnPage;
    $res = array_slice($data_tmp, $start, $productOnPage);

    $data = [$res, $num, $page];
    load_view('list', $data);
}
