<?php get_header(); ?>

<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Chỉnh sửa bài viết</h3>
                    <a href="?modules=blogs&controllers=index&action=list" title="" id="add-new" class="fl-left">Danh sách</a>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">

                    <form method="post" action="?modules=blogs&controllers=index&action=update&id=<?php echo $blog['id']; ?>" enctype="multipart/form-data">
                        <label for="title">Tiêu đề</label>
                        <input type="text" name="title" id="title" value="<?php echo $blog['title']; ?>">
                        <label for="title">Người viết</label>
                        <input type="text" name="user" id="title">
                        <div id="uploadFile" style="width: 400px;">
                            <label>Hình ảnh</label>
                            <input type="file" name="image" id="upload-thumb">
                            <!-- Hiển thị ảnh hiện tại nếu có -->
                            <?php if (!empty($blog['image'])): ?>
                                <img src="<?php echo $blog['image']; ?>" alt="Current Image" style="max-width: 100px; display: block; margin-top: 10px;">
                            <?php endif; ?>
                        </div>

                        <label for="desc">Mô tả ngắn</label>
                        <textarea name="description" id="desc"><?php echo $blog['description']; ?></textarea>

                        <label for="content">Nội dung</label>
                        <textarea name="content" id="desc" class="ckeditor"><?php echo $blog['content']; ?></textarea>

                        <input type="submit" name="btn_submit" id="btn-submit" value="Cập nhật" style="height: 40px;
                                                                                                border-radius: 60px;
                                                                                                width: 150px;
                                                                                                color: white;
                                                                                                background-color: #48ad48;">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>