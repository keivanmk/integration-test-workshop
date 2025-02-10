<?php

namespace App\Modules\Order\Http\Controllers;

use App\Modules\Cart\Model\Cart;
use App\Modules\Order\UseCases\PlaceOrderUseCase;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

readonly class PlaceOrderController
{


    public function __construct(
        private ResponseFactory $responseFactory,
        private PlaceOrderUseCase $placeOrderUseCase
    )
    {
    }

    public function __invoke(Request $request):JsonResponse
    {

        $cart = Cart::query()->where('guest_id',$request->header('token'))->first();

        $this->placeOrderUseCase->execute($cart);

        return $this->responseFactory->json([
            'success' => true,
            'message' => 'سفارش با موفقیت ثبت گردید'
        ]);
    }

}
