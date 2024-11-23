<?php

function getAllCategory(){

	return db_fetch_array("SELECT * FROM `tbl_category`");
}

function getAllBrand(){

	return db_fetch_array("SELECT * FROM `tbl_brand`");
}

function insert_product($data){

	return db_insert("tbl_product", $data);
}

function getAllProduct(){

	return db_fetch_array("SELECT * FROM `tbl_product`");
}

function get_category_by_id($id){

	$data = db_fetch_array("SELECT * FROM `tbl_category` WHERE `id` = '$id'");
	return $data[0]['name'];
}

function get_brand_by_id($id){

	$data = db_fetch_array("SELECT * FROM `tbl_brand` WHERE `id` = '$id'");
	return $data[0]['name'];
}


function delete_product_by_id($id){

	return db_delete("tbl_product", "`id` = '$id'");
}

function get_product_by_id($id) {
    global $conn;
    $sql = "SELECT * FROM tbl_product WHERE id = {$id}";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function update_product_by_id($id, $data) {
    global $conn;
    $sql = "UPDATE tbl_product  SET 
                name = '{$data['name']}', 
                code = '{$data['code']}', 
                price = '{$data['price']}',
                promotional_price = '{$data['promotional_price']}',
                quantity = '{$data['quantity']}', 
                status = '{$data['status']}', 
                level = '{$data['level']}',
                id_category = '{$data['id_category']}',
                id_brand = '{$data['id_brand']}',
                description = '{$data['description']}', 
                screen = '{$data['screen']}',
                ram = '{$data['ram']}',
                cpu = '{$data['cpu']}',
                memory = '{$data['memory']}',
                operating_system = '{$data['operating_system']}',
                front_camera = '{$data['front_camera']}',
                rear_camera = '{$data['rear_camera']}',
                user = '{$data['user']}'";
    
    if (!empty($data['image'])) {
        $sql .= ", image = '{$data['image']}'";
    }
    
    $sql .= " WHERE id = {$id}";
    mysqli_query($conn, $sql);
}
