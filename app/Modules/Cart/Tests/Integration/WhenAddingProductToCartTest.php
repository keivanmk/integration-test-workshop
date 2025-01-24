<?php

namespace App\Modules\Cart\Tests\Integration;

use App\Modules\Product\Model\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class WhenAddingProductToCartTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function cart_contains_a_product(): void
    {
        //arrange
        $product = Product::factory()->create();

        //act
        $response = $this->post(sprintf('/cart/add/%d',$product->getKey()));

        //assert
        $response->assertSuccessful();
        $this->assertDatabaseCount('carts',1);
        $this->assertDatabaseHas('cart_items',[
            'product_id' => $product->getKey()
        ]);
    }
}
