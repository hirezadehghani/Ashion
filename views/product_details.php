<?php

use app\models\Category;
use app\models\Product;
use app\models\product_attributes;
use app\models\Product_stock;
use app\models\ProductSkus;
use app\models\sku_values;

$product = new Product;
$category = new Category;
$product_skus = new ProductSkus;
$sku_values = new sku_values;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $productId = $_GET['id'];
    $productId = htmlentities($productId);
}

$product = $product->getObject($productId);
$categoryTitle = $category->getCategoryTitle($product->category_id);
$sku_values = $sku_values->fetchWhere("sku_values", "product_id", $productId); // fetch all SKUs of product
$sku_id = $sku_values[0]['sku_id']; // fetch one of the sku_id of product
$skus = $sku_values;
$sku_values = new sku_values;
$sku_values = $sku_values->getObject($productId, $sku_id);
$product_skus = $product_skus->getAllObjects($productId, $sku_id); // fetch one of the product varients 
$pictures = json_decode($product->pictures, true);
$priceSign = $product->getPriceSign();

$stockTitle = new Product_stock;
$stockTitle = $stockTitle->getStockName($product_skus->stock_id);
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
                    <div class="product__details__price"><?= $product_skus->sale_price . $priceSign ?><span><?= $product_skus->regular_price . $priceSign ?></span></div>
                    <p><?= substr($product->detail, 0, 210) ?></p>
                    <div class="product__details__button">
                        <div class="quantity">
                            <span>تعداد:</span>
                            <div class="pro-qty">
                                <input type="text" value="1" name="quantity">
                            </div>
                        </div>
                        <button type="submit" name="product_id" value="<?= $product->id ?>" class="cart-btn">
                            <span class="icon_bag_alt"></span> خرید
                        </button>
                        <ul>
                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                            <li><a href="#"><span class="icon_adjust-horiz"></span></a></li>
                        </ul>
                    </div>
                    </form>
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
                                <span>اندازه های موجود :</span>
                                <div class="size__btn">
                                    <!-- show every varient of product -->
                                    <form action="/products" method="get" id="sizeForm">
                                        <input name="id" type="number" hidden value="<?= $productId ?>">
                                        <?php
                                        foreach ($skus as $sku) {
                                            $singleVarient = $product_skus->getAllObjects($productId, $sku['sku_id']);
                                            $product_attrs = new product_attributes;
                                            $product_parent_values = $product_attrs->getValueName($sku['parent_value_id']);
                                        ?>
                                            <label for="<?= $product_parent_values['value_name'] ?>-btn" <?php
                                                                                                            if (isset($_GET['parent_value_id'])) {
                                                                                                                if ($_GET['parent_value_id'] == $sku['parent_value_id']) {
                                                                                                                    echo 'class="active"';
                                                                                                                }
                                                                                                            } ?>>
                                                <input name="parent_value_id" type="radio" id="<?= $product_parent_values['value_name'] ?>-btn" value="<?= $sku['parent_value_id'] ?>">
                                                <?= $product_parent_values['value_name'] ?>
                                            </label>
                                        <?php } ?>
                                    </form>
                                </div>
                            </li>
                            <script>
                                let size_radio = document.getElementsByName("parent_value_id");
                                var sizeForm = document.getElementById("sizeForm");
                                for (let index = 0; index < size_radio.length; index++) {
                                    const element = size_radio[index];
                                    element.addEventListener("click", function() {
                                        sizeForm.submit();
                                    });
                                }
                                // let buy_button = document.getElementById("buy_button");
                                // buy_button.addEventListener("click", function(){
                                //     var colors= document.getElementsByName("child_value_id");
                                //     var child_value_id = colors[0].value;

                                // })
                            </script>
                            <li>
                                <span>رنگ های موجود: </span>
                                <div class="color__checkbox">
                                    <?php
                                    if (isset($_GET['parent_value_id'])) {
                                        $firstIndex = 1;
                                        foreach ($skus as $sku) {
                                            $singleVarient = $product_skus->getAllObjects($productId, $sku['sku_id']);
                                            $product_attrs = new product_attributes;
                                            if ($sku['parent_value_id'] == $_GET['parent_value_id']) {
                                                $product_child_values = $product_attrs->getValueName($sku['child_value_id']);
                                    ?>
                                                <label for="color<?= $product_child_values['value_name'] ?>">
                                                    <input type="radio" name="child_value_id" value="<?= $sku['child_value_id'] ?>" id="color<?= $product_child_values['value_name'] ?>" <?php if ($firstIndex) echo 'checked'; ?>>
                                                    <span class="checkmark" style="background: <?= $product_child_values['value_name'] ?>;"></span>
                                                </label>
                                        <?php
                                            }
                                        }
                                    } else { ?>
                                        <p>لطفا ابتدا اندازه را انتخاب کنید</p>
                                    <?php } ?>

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
                $singleProduct = $product->fetchRow("product", $relatedProduct, ['id', 'title', 'ranking', 'pictures']);
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
                            <!-- <div class="product__price"><?= $singleProduct['sale_price'] . $priceSign ?><span><?php if ($singleProduct['regular_price'] > 0) echo $singleProduct['regular_price'] . $priceSign ?></span></div> -->
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- Product Details Section End -->