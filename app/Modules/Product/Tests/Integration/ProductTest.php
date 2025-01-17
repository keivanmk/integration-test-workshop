<?php

namespace App\Modules\Product\Tests\Integration;

use App\Modules\Product\Model\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    #[Test] public function adding_product(): void
    {
        //arrange
        $title = $this->faker->word();
        $price = 1_000_000;
        $category = $this->faker->word();
        $quantity =  100;

        //act
        $response = $this->post('products/add',[
            'title' => $title,
            'price' => $price,
            'category' => $category,
            'quantity' => $quantity
        ]);

        //assert
        $response->assertSuccessful();
        $this->assertDatabaseHas('products',[
            'title' => $title,
            'price' => $price,
            'category' => $category,
            'quantity' => $quantity
        ]);
    }

    #[Test] public function changing_product_quantity(): void
    {
        //arrange
        /** @var Product $product */
        $product = Product::factory()->withQuantity(50)->create();
        $newQuantity = 23;

        //act
        $response = $this->put(sprintf('/products/%d/quantity',$product->getKey()),[
            'quantity' => $newQuantity
        ]);

        //assert
        $response->assertSuccessful();
        $product->refresh();
        $this->assertEquals($newQuantity,$product->quantity);

    }

    #[Test] public function updating_product_details():void
    {
        //arrange
        /** @var Product $product */
        $product = Product::factory()->create();
        $newTitle = "New Product Title";
        $newPrice = 3_900_000;
        $newCategory = "New Product Category";

        //act
        $response = $this->put(sprintf('/products/%d/update',$product->getKey()),[
            'title' => $newTitle,
            'price' => $newPrice,
            'category' => $newCategory
        ]);

        //assert
        $response->assertSuccessful();
        $product->refresh();
        $this->assertEquals($newTitle,$product->title);
        $this->assertEquals($newPrice,$product->price);
        $this->assertEquals($newCategory,$product->category);

    }
}
