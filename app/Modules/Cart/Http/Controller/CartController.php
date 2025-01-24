<?php

namespace App\Modules\Cart\Http\Controller;

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
        return  $this->responseFactory->json([]);
    }

}
