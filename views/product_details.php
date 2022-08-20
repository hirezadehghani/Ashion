<?php

use app\models\Category;
use app\models\Product;
use app\models\Product_stock;

$product = new Product;
$category = new Category;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $productId = $_GET['id'];
    $productId = htmlentities($productId);
}
$product = $product->getObject($productId);
$categoryTitle = $category->getCategoryTitle($product->category_id);
$pictures = json_decode($product->pictures, true);
$priceSign = $product->getPriceSign();
$stockTitle = new Product_stock;
$stockTitle = $stockTitle->getStockName($product->stock_id);
?>
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="/"><i class="fa fa-home"></i>صفحه اصلی</a>
                    <a href="#"><?= $categoryTitle ?></a>
                    <span><?= $product->title ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Product Details Section Begin -->
<section class="product-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="product__details__pic">
                    <div class="product__details__pic__left product__thumb nice-scroll">
                        <!-- <a class="pt active" href="#2022081614562732product-3.jpg">
                            <img src="/upload/2022081614562736thumb-2.jpg" alt="">
                        </a> -->
                        <?php foreach ($pictures as $picture) {
                        ?>
                            <a class="pt" href="<?= '#' . $picture ?>">
                                <img src="<?= UPLOAD_DIR . $picture ?>" alt="">
                            </a>
                        <?php } ?>
                    </div>
                    <div class="product__details__slider__content">
                        <div class="product__details__pic__slider owl-carousel">
                            <?php foreach ($pictures as $picture) {
                            ?>
                                <img data-hash="<?= $picture ?>" class="product__big__img" src="<?= UPLOAD_DIR . $picture ?>" alt="">
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="product__details__text">
                    <h3><?= $product->title ?><span>Brand: SKMEIMore Men Watches from SKMEI</span></h3>
                    <div class="rating">
                        <?php for ($i = 0; $i < $product->ranking; $i++) { ?>
                            <i class="fa fa-star"></i>
                        <?php } ?>
                        <span>( 138 reviews )</span>
                    </div>
                        <?php $form = \app\core\form\Form::begin('', 'post'); ?>
                        <div class="product__details__price"><?= $product->sale_price . $priceSign ?><span><?= $product->regular_price . $priceSign ?></span></div>
                        <p><?= substr($product->detail, 0, 210) ?></p>
                        <div class="product__details__button">
                            <div class="quantity">
                                <span>تعداد:</span>
                                <div class="pro-qty">
                                    <input type="text" value="1" name="quantity">
                                </div>
                            </div>
                            <button type="submit" name="product_id" value="<?= $product->id?>" class="cart-btn">
                                    <span class="icon_bag_alt"></span> خرید
                            </button>
                            <ul>
                                <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                <li><a href="#"><span class="icon_adjust-horiz"></span></a></li>
                            </ul>
                        </div>
                        <div class="product__details__widget">
                            <ul>
                                <li>
                                    <span>وضعیت موجودی:</span>
                                    <div class="stock__checkbox">
                                        <label for="stockin">
                                            <?= $stockTitle['stock_name'] ?>
                                            </span>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <span>Available color:</span>
                                    <div class="color__checkbox">
                                        <label for="red">
                                            <input type="radio" name="color__radio" id="red" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label for="black">
                                            <input type="radio" name="color__radio" id="black">
                                            <span class="checkmark black-bg"></span>
                                        </label>
                                        <label for="grey">
                                            <input type="radio" name="color__radio" id="grey">
                                            <span class="checkmark grey-bg"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <span>Available size:</span>
                                    <div class="size__btn">
                                        <label for="xs-btn" class="active">
                                            <input type="radio" id="xs-btn">
                                            xs
                                        </label>
                                        <label for="s-btn">
                                            <input type="radio" id="s-btn">
                                            s
                                        </label>
                                        <label for="m-btn">
                                            <input type="radio" id="m-btn">
                                            m
                                        </label>
                                        <label for="l-btn">
                                            <input type="radio" id="l-btn">
                                            l
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <span>Promotions:</span>
                                    <p><?= $product->promotions ?></p>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Specification</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Reviews ( 2 )</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <h6>توضیحات</h6>
                            <p> <?php echo strval($product->detail) ?> </p>
                        </div>
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <h6>Specification</h6>
                            <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed
                                quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt loret.
                                Neque porro lorem quisquam est, qui dolorem ipsum quia dolor si. Nemo enim ipsam
                                voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed quia ipsu
                                consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Nulla
                                consequat massa quis enim.</p>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                                dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                                nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                                quis, sem.</p>
                        </div>
                        <div class="tab-pane" id="tabs-3" role="tabpanel">
                            <h6>Reviews ( 2 )</h6>
                            <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed
                                quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt loret.
                                Neque porro lorem quisquam est, qui dolorem ipsum quia dolor si. Nemo enim ipsam
                                voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed quia ipsu
                                consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Nulla
                                consequat massa quis enim.</p>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                                dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                                nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                                quis, sem.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="related__title">
                    <h5>محصولات مرتبط</h5>
                </div>
            </div>
            <?php
            $relatedProducts = $product->findRelatedProducts();
            foreach ($relatedProducts as $relatedProduct) {
                $singleProduct = $product->fetchRow("product", $relatedProduct, ['id', 'title', 'regular_price', 'sale_price', 'ranking', 'stock_id', 'pictures']);
                $picture = $product->getPictureAddr(0, $singleProduct['pictures']);
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="<?= $picture ?>">
                            <div class="label new">New</div>
                            <ul class="product__hover">
                                <li><a href="<?= $picture ?>" class="image-popup"><span class="arrow_expand"></span></a></li>
                                <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                <li><a href="<?= '/products?id=' . $singleProduct['id'] ?>"><span class="icon_bag_alt"></span></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="<?= '/products?id=' . $singleProduct['id'] ?>"><?= $singleProduct['title'] ?></a></h6>
                            <div class="rating">
                                <?php for ($i = 0; $i < $singleProduct['ranking']; $i++) { ?>
                                    <i class="fa fa-star"></i>
                                <?php } ?>
                            </div>
                            <div class="product__price"><?= $singleProduct['sale_price'] . $priceSign ?><span><?php if ($singleProduct['regular_price'] > 0) echo $singleProduct['regular_price'] . $priceSign ?></span></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- Product Details Section End -->