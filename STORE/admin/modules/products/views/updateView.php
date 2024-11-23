<?php get_header(); ?>

<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Cập nhật sản phẩm</h3>
                    <a href="?modules=products&controllers=index&action=list" title="" id="add-new" class="fl-left">Danh sách</a>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">

                    <form method="POST" action="?modules=products&controllers=index&action=update&id=<?php echo $product['id']; ?>" enctype="multipart/form-data">

                        <div style="display: flex;">
                            <div style="width: 400px;">
                                <label for="product-name">Tên sản phẩm</label>
                                <input type="text" name="name" id="product-name" style="display: block;width: 300px;" value="<?php echo $product['name']; ?>">
                                <label for="product-code">Mã sản phẩm</label>
                                <input type="text" name="code" id="product-code" style="display: block;width: 300px;" value="<?php echo $product['code']; ?>">
                                <label for="price">Giá sản phẩm</label>
                                <input type="text" name="price" id="price" style="display: block;width: 300px;" value="<?php echo $product['price']; ?>">
                                <label for="price">Giá khuyến mãi</label>
                                <input type="text" name="promotional_price" id="price" style="display: block;width: 300px;" value="<?php echo $product['promotional_price']; ?>">
                                <label for="quantity">Số lượng</label>
                                <input type="text" name="quantity" id="quantity" style="display: block;width: 300px;" value="<?php echo $product['quantity']; ?>">
                                <label for="user">Người tạo</label>
                                <input type="text" name="user" id="user" style="display: block;width: 300px;" value="<?php echo $product['user']; ?>">
                            </div>
                            <div style="width: 400px;">
                                <label for="screen">Màn hình</label>
                                <input type="text" name="screen" id="screen" style="display: block;width: 300px;" value="<?php echo $product['screen']; ?>">
                                <label for="ram">Ram</label>
                                <input type="text" name="ram" id="ram" style="display: block;width: 300px;" value="<?php echo $product['ram']; ?>">
                                <label for="cpu">Cpu</label>
                                <input type="text" name="cpu" id="cpu" style="display: block;width: 300px;" value="<?php echo $product['cpu']; ?>">
                                <label for="memory">Bộ nhớ</label>
                                <input type="text" name="memory" id="memory" style="display: block;width: 300px;" value="<?php echo $product['memory']; ?>">
                                <label for="operating_system">Hệ điều hành</label>
                                <input type="text" name="operating_system" id="operating_system" style="display: block;width: 300px;" value="<?php echo $product['operating_system']; ?>">
                                <label for="front_camera">Camera trước</label>
                                <input type="text" name="front_camera" id="front_camera" style="display: block;width: 300px;" value="<?php echo $product['front_camera']; ?>">
                                <label for="rear_camera">Camera sau</label>
                                <input type="text" name="rear_camera" id="rear_camera" style="display: block;width: 300px;" value="<?php echo $product['rear_camera']; ?>">
                            </div>
                            <div style="width: 400px;">
                                <label for="level">Độ hot sản phẩm</label>
                                <select name="level" style="display: block;width: 300px;">
                                    <option value="hot" <?php if($product['level'] == 'hot') echo 'selected'; ?>>Sản phẩm hot</option>
                                    <option value="normal" <?php if($product['level'] == 'normal') echo 'selected'; ?>>Sản phẩm bình thường</option>
                                    <option value="discount" <?php if($product['level'] == 'discount') echo 'selected'; ?>>Sản phẩm giảm giá</option>
                                </select>
                                <label for="status">Trạng thái</label>
                                <select name="status" style="display: block;width: 300px;">
                                    <option value="còn hàng" <?php if($product['status'] == 'còn hàng') echo 'selected'; ?>>Còn hàng</option>
                                    <option value="hết hàng" <?php if($product['status'] == 'hết hàng') echo 'selected'; ?>>Hết hàng</option>
                                    <option value="hàng sắp về" <?php if($product['status'] == 'hàng sắp về') echo 'selected'; ?>>Hàng sắp về</option>
                                </select>
                                <label for="category">Danh mục sản phẩm</label>
                                <select name="id_category" style="display: block;width: 300px;">
                                    <?php if (!empty($categories)) foreach ($categories as $value) { ?>
                                    <option value="<?php echo $value['id']; ?>" <?php if($product['id_category'] == $value['id']) echo 'selected'; ?>><?php echo $value['name']; ?></option>
                                    <?php }; ?>
                                </select>
                                <label for="brand">Thương hiệu sản phẩm</label>
                                <select name="id_brand" style="display: block;width: 300px;">
                                    <?php if (!empty($brands)) foreach ($brands as $value) { ?>
                                    <option value="<?php echo $value['id']; ?>" <?php if($product['id_brand'] == $value['id']) echo 'selected'; ?>><?php echo $value['name']; ?></option>
                                    <?php }; ?>
                                </select>
                                <label>Hình ảnh</label>
                                <div id="uploadFile">
                                    <input type="file" name="image" id="upload-thumb">
                                    <img src="<?php echo $product['image']; ?>">
                                </div>
                            </div>
                        </div>
                        <label for="desc">Mô tả sản phẩm</label>
                        <textarea name="description" id="desc" class="ckeditor"><?php echo $product['description']; ?></textarea>

                        <input type="submit" name="btn_submit" id="btn-submit" value="Cập nhật" style="height: 40px;
                                                                                                border-radius: 60px;
                                                                                                width: 150px;
                                                                                                color: green;
                                                                                                border-color: white;
                                                                                                color: white;
                                                                                                background-color: #48ad48;">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
