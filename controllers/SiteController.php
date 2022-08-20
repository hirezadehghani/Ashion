<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Session;
use app\models\Cart_item;
use app\models\Product;
use app\models\Shopping_session;
use app\models\User;

class SiteController extends Controller
{
    public function home()
    {
        $params = [];

        return $this->render('home', $params);
    }

    public function products(Request $request)
    {
        $shopping_session = new Shopping_session;
        $cart = new Cart_item;

        $params = [
            'model' => $cart,
            'message' => 'کالا با موفقیت به سبد خرید اضافه شد'
        ];
        if ($request->isPost()) {
            $cart->loadData($request->getBody());
            if ($cart->validate()) {
                //IF user want to add to card
                if ($_SESSION['id']) {
                    $session_id = $_SESSION['id'];
                    $shopping_session->add(null, $session_id, 0);
                    $session_id_table = $shopping_session->fetchRow("shopping_session", $session_id, ['id', 'user_id'], 'user_id');
                }
                //IF guest want to add to card
                else {
                    $session = new Session;
                    $session_id = $session->getSessionId();
                    $_SESSION['guest'] = $session_id;
                    $shopping_session->add($session_id, null, 0);
                    $session_id_table = $shopping_session->fetchRow("shopping_session", "'$session_id'", ['id', 'guest_session_id'], 'guest_session_id');
                }
                //search sutible shopping_session row for storing in cart_item model
                $session_id_table = $session_id_table['id'];
                //add to Cart to cart_item model
                $cart->addItem($session_id_table);
            }
        }

        return $this->render('product_details', $params);
    }
    public function shopCart()
    {
        $params = [];

        return $this->render('shop_cart', $params);
    }

    public function contact()
    {
        return $this->render('contact');
    }
    public function handleContact(Request $request)
    {
        $body = $request->getBody();
        var_dump($body);
        exit;
        return 'handle data';
    }
}
