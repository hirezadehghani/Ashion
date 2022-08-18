<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class SiteController extends Controller
{
    public function home()   {
        $params = [
            
        ];

        return $this->render('home', $params);
    }

    public function products()   {
        $params = [ 
        ];

        return $this->render('product_details', $params);
    }
    public function shopCart()   {
        $params = [ 
        ];

        return $this->render('shop_cart', $params);
    }


    public function contact()   {
        return $this->render('contact');
    }
    public function handleContact(Request $request) {
        $body = $request->getBody();
        var_dump($body);
        exit;
        return 'handle data';
    }

}