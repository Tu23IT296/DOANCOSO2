<div class="sidebar fl-left">
    <div class="section" id="category-product-wp">
        <div class="section-head">
            <h3 class="section-title">Danh mục sản phẩm</h3>
        </div>
        <div class="secion-detail">
             <ul class="list-item">
                <li>
                    <a href="?modules=products&controllers=index&action=show&id_cat=13" title="">Điện Thoại</a>
                </li>
                <li>
                    <a href="?modules=products&controllers=index&action=show&id_cat=14" title="">Máy Tính Bảng</a>
                </li>
                <li>
                    <a href="?modules=products&controllers=index&action=show&id_cat=12" title="">Lap Top</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="section" id="filter-product-wp">
        <div class="section-head">
            <h3 class="section-title">Bộ lọc</h3>
        </div>
        <div class="section-detail">
            <form method="POST" action="?modules=search&controllers=index&action=filter">
                <table>
                    <thead>
                        <tr>
                            <td colspan="2">Giá</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="radio" name="r-price" id="r-price1" value="0,1000000000"></td>
                            <td><label for="r-price1">Thấp->Cao</label></td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="r-price" id="r-price1" value="1000000000,0"></td>
                            <td><label for="r-price1">Cao->Thấp</label></td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="r-price" id="r-price1" value="0,5000000"></td>
                            <td><label for="r-price1">Dưới 5.000.000đ</label></td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="r-price" id="r-price2" value="5000000,1000000"></td>
                            <td><label for="r-price2">5.000.000đ - 10.000.000đ</label></td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="r-price" id="3" value="10000000,30000000"></td>
                            <td><label for="3">10.000.000đ - 30.000.000đ</label></td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="r-price" id="5" value="30000000,300000000"></td>
                            <td><label for="5">Trên 30.000.000đ</label></td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr>
                            <td colspan="2">Hãng</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="radio" name="r-brand" id="i1" value="2"></td>
                            <td><label for="i1">Apple</label></td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="r-brand" id="i2" value="1"></td>
                            <td><label for="i2">SamSung</label></td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="r-brand" id="i3" value="3"></td>
                            <td><label for="i3">Oppo</label></td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="r-brand" id="i4" value="4"></td>
                            <td><label for="i4">Redmi</label></td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr>
                            <td colspan="2">Loại</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="radio" name="r-category" id="a1" value="13"></td>
                            <td><label for="a1">Điện thoại</label></td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="r-category" id="a2" value="14"></td>
                            <td><label for="a2">Máy tính bảng</label></td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="r-category" id="a3" value="12"></td>
                            <td><label for="a3">Laptop</label></td>
                        </tr>
                    </tbody>
                </table>
                <input style="width: 100%;color: white; background-color: #95d895;border-radius: 5px; border: none; " type="submit" name="btn_filter" value="Áp dụng">
            </form>
        </div>
    </div>
    <div class="section" id="banner-wp">
        <div class="section-detail">
            <a href="?page=detail_product" title="" class="thumb">
                <img src="public/images/banner.png" alt="">
            </a>
        </div>
    </div>
</div>