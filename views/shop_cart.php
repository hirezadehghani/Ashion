<?php

use app\models\Cart_item;
use app\models\Product;
use app\models\Shopping_session;

if (isset($_SESSION['id'])) {
    $session_id = $_SESSION['id'];

    $shopping_session = new Shopping_session;
    $shopping_session = $shopping_session->fetchRow("shopping_session", $session_id, ['id', 'user_id'], 'user_id');
    $cart_item = new Cart_item;
    $cart = $cart_item->fetchWhere("cart_item", "session_id", $shopping_session['id']);
}
else if (isset($_SESSION['guest'])) {
    $session_id = $_SESSION['guest'];

    $shopping_session = new Shopping_session;
    $shopping_session = $shopping_session->fetchRow("shopping_session", "'$session_id'", ['id', 'guest_session_id'], 'guest_session_id');
    $cart_item = new Cart_item;
    $cart = $cart_item->fetchWhere("cart_item", "session_id", $shopping_session['id']);
}

//Update quantity of product
if(isset($_POST['quantity'])    )   {
    $product = new Product;
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    // $product = $product->update("product", ['quantity'], 'id', $productId);
}
?>
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="./"><i class="fa fa-home"></i> خانه</a>
                    <span>سبد خرید</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Shop Cart Section Begin -->
<section class="shop-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shop__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th>محصول</th>
                                <th>قیمت</th>
                                <th>تعداد</th>
                                <th>قیمت کل</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($cart as $cart_item)    {
                                $product = new Product;
                                $product = $product->getObject($cart_item['product_id']);
                                $pictures = [];
                                $pictures = json_decode($product->pictures, true);
                                ?>
                            <tr>
                                <td class="cart__product__item">
                                    <img width="90px" height="90px" src="<?= UPLOAD_DIR . $pictures[0] ?>" alt="<?= $pictures[0] ?>">
                                    <div class="cart__product__item__title">
                                        <h6><?= $product->title?></h6>
                                        <div class="rating">
                                        <?php for ($i = 0; $i < $product->ranking; $i++) { ?>
                                            <i class="fa fa-star"></i>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="cart__price"><?= $product->sale_price?></td>
                                <td class="cart__quantity">
                                    <div class="pro-qty">
                                        <input type="text" name="quantity" value="<?= $cart_item['quantity'] ?>">
                                    </div>
                                </td>
                                <td class="cart__total"><?= $product->sale_price * $cart_item['quantity'] ?></td>
                                <td class="cart__close"><span class="icon_close"></span></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="cart__btn">
                    <a href="/">ادامه خرید</a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="cart__btn update__btn">
                    <a href="#"><span class="icon_loading"></span> بروزرسانی سبد خرید</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="discount__content">
                    <h6>کد تخفیف</h6>
                    <form action="#">
                        <input type="text" placeholder="Enter your coupon code">
                        <button type="submit" class="site-btn">Apply</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-4 offset-lg-2">
                <div class="cart__total__procced">
                    <h6>Cart total</h6>
                    <ul>
                        <li>Subtotal <span>$ 750.0</span></li>
                        <li>Total <span>$ 750.0</span></li>
                    </ul>
                    <a href="#" class="primary-btn">Proceed to checkout</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shop Cart Section End -->