<?php

namespace App\Modules\Product\Http\Controllers;

use App\Modules\Product\Model\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;

class ProductController
{


    public function __construct(
        private ResponseFactory $responseFactory
    )
    {
    }

    public function add(Request $request): JsonResponse
    {

        $product = Product::add(
            $request->get('title'),
            $request->get('price'),
            $request->get('category'),
            $request->get('quantity')
        );
        $product->save();

        return $this->responseFactory->json([
            'success' => true
        ]);
    }

    public function changeQuantity(Request $request, int $productId): Response
    {
        $product = Product::find($productId);
        $product->changeQuantityTo($request->get('quantity'));
        $product->save();

        return $this->responseFactory->noContent();
    }

    public function update(Request $request, int $productId): Response
    {
        $product = Product::find($productId);

        $product->changeDetails(
            $request->get('title'),
            $request->get('price'),
            $request->get('category')
            );
        $product->save();

        return $this->responseFactory->noContent();
    }
}
