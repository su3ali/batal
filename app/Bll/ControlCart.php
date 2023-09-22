<?php

namespace App\Bll;

use App\Models\Cart;
use App\Models\Product;
use function Symfony\Component\Translation\t;

class ControlCart
{
    public function makeAction($action, $cart, $product)
    {
        $response = '';

        //plus
        if ($action == 'plus') {
            $cart->quantity++;
            $cart->save();
            $response = ['success' => 'added successfully'];
        }

        //minus
        if ($action == 'minus') {
            if ($cart->quantity > 1) {
                $cart->quantity--;
                $cart->save();
                $response = ['success' => 'subtracted successfully'];
            } else {
                $response = ['error' => "It's already the minimum quantity"];
            }
        }

        //delete
        if ($action == 'delete') {
            $cart->delete();
            $response = ['success' => 'deleted successfully'];
        }
        return $response;
    }
}
