<?php

namespace App\Modules\Product\Http\Controllers;

use App\Modules\Product\Model\Product;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\CommonMark\Util\ArrayCollection;

class FilterProductsController
{


    public function __construct(private readonly ResponseFactory $responseFactory)
    {
    }

    public function filter(Request $request):JsonResponse
    {
        if($request->has('keyword'))
        {
            $filteredProducts = Product::query()
                ->whereLike('title',$request->query('keyword'))
                ->get();
        }

        if($request->has('category'))
        {
            $filteredProducts = Product::query()
                ->where('category',$request->query('category'))
                ->get();
        }

        if($request->has('startPrice') || $request->has('endPrice'))
        {
            $filteredProducts = Product::query()
                ->whereBetween('price',[$request->get('startPrice'),$request->get('endPrice')])
                ->get();
        }

        return $this->responseFactory->json([
            'status' => 'success',
            'products' => $filteredProducts->map(fn(Product $product) => $product->toReadModel())
        ]);
    }
}
