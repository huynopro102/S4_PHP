<?php include 'app/views/shares/headerAdmin.php'; ?>


<div class="container mt-5">
    <h1 class="text-center">Danh Sách Yêu Thích</h1>
    <?php if (!empty($favorites)): ?>
        <div class="row">
            <?php foreach ($favorites as $product): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="/s4_php/public/images/<?php echo !empty($product['image']) ? $product['image'] : '/path/to/default/image.jpg'; ?>" class="card-img-top img-fluid" 
                            style="height: 200px; width: 100%; object-fit: contain;" alt="<?php echo $product['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <p class="card-text"><?php echo number_format($product['price'], 0, ',', '.'); ?> đ</p>
                            <p class="card-text text-muted">Đã thêm: <?php echo $product['time_elapsed']; ?></p>
                            <!-- <p>Đã thêm: <span class="time-elapsed" data-time="<?php echo $product['created_at']; ?>"><?php echo $product['time_elapsed']; ?></span></p> -->

                            <a href="/s4_php/favorite/removeFromFavorites/<?php echo $product['id']; ?>" class="btn btn-danger">Xoá</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center">Chưa có sản phẩm nào trong danh sách yêu thích.</p>
    <?php endif; ?>
</div>



<?php include 'app/views/shares/footerAdmin.php'; ?>

