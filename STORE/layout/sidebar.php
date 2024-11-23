<?php
// Mảng chứa danh mục sản phẩm và các sub-menu (có thể lấy từ cơ sở dữ liệu)
$categories = [
    [
        'name' => 'Điện Thoại',
        'id_cat' => 13,
        'sub_categories' => ['Iphone', 'Samsung', 'Oppo', 'Redmi']
    ],
    [
        'name' => 'Máy Tính Bảng',
        'id_cat' => 14,
        'sub_categories' => ['Ipad', 'Samsung Galaxy Tab', 'Huawei', 'Lenovo']
    ],
    [
        'name' => 'Laptop',
        'id_cat' => 12,
        'sub_categories' => ['Macbook', 'Dell', 'Asus', 'HP']
    ]
];
?>

<div class="sidebar fl-left">
    <div class="section" id="category-product-wp">
        <div class="section-head">
            <h3 class="section-title">Danh mục sản phẩm</h3>
        </div>
        <div class="section-detail">
            <ul class="list-item">
                <?php foreach ($categories as $category): ?>
                    <li>
                        <a href="?modules=products&controllers=index&action=show&id_cat=<?php echo $category['id_cat']; ?>" title=""><?php echo $category['name']; ?></a>
                        <ul class="sub-menu">
                            <?php foreach ($category['sub_categories'] as $sub_category): ?>
                                <li>
                                    <a href="?page=category_product" title=""><?php echo $sub_category; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Phần sản phẩm bán chạy -->
    <div class="section" id="selling-wp">
        <div class="section-head">
            <h3 class="section-title">Sản phẩm bán chạy</h3>
        </div>
        <div class="section-detail">
            <ul class="list-item">
                <?php if (!empty($_SESSION['product_hot'])) {
                    $i = 0;
                    foreach ($_SESSION['product_hot'] as $value) {
                        $i++;
                        if ($i > 9) break; ?>
                        <li class="clearfix">
                            <a href="?modules=products&controllers=index&action=detail&id=<?php echo $value['id']; ?>" title="" class="thumb fl-left">
                                <img src="<?php echo $value['image']; ?>" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="?modules=products&controllers=index&action=detail&id=<?php echo $value['id']; ?>" title="" class="product-name"><?php echo $value['name']; ?></a>
                                <div class="price">
                                    <span class="new"><?php echo $value['promotional_price'] . ' VNĐ'; ?></span>
                                    <span class="old"><?php echo $value['price'] . ' VNĐ'; ?></span>
                                </div>
                                <a href="<?php echo (!empty($_SESSION['id_customer'])) ? "?modules=carts&controllers=index&action=addByNow&id={$value['id']}" : "?modules=users&controllers=index&action=index&report=1"; ?>" title="" class="buy-now">Mua ngay</a>
                            </div>
                        </li>
                    <?php }
                } ?>
            </ul>
        </div>
    </div>

    <!-- Phần banner -->
    <div class="section" id="banner-wp">
        <div class="section-detail">
            <a href="" title="" class="thumb">
                <!-- <img src="public/images/banner00.jpg" alt=""> -->
            </a>
            <a href="" title="" class="thumb" style="margin-top: 10px;">
                <!-- <img src="public/images/bigsale.jpg" alt=""> -->
            </a>
        </div>
    </div>
</div>
