<?php

namespace App\Modules\Cart\Http\Controller;

use App\Modules\Cart\Model\Cart;
use App\Modules\Product\Model\Product;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

readonly class CartController
{


    public function __construct(
        private ResponseFactory $responseFactory
    )
    {
    }

    public function add(Request $request,int $productId):JsonResponse
    {
        $product = Product::find($productId);
        $guestId = $request->header('token');
        $cart = Cart::query()->where('guest_id',$guestId)->first();
        if(!$cart)
        {
            $cart = Cart::forGuest($guestId);
            $cart->save();
        }

        $cart->addProduct($product);

        return  $this->responseFactory->json([
            'success' => true,
            'message' => 'محصول با موفقیت به سبد خرید اضافه شد'
        ]);
    }

}
