<?php

namespace App\Modules\Product\Tests\Unit;

use App\Modules\Product\Model\Product;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use WithFaker;

    #[Test] public function adding_product(): void
    {
        //arrange
        $title = $this->faker->word();
        $price = 1_000_000;
        $category = $this->faker->word();
        $quantity =  100;

        //act
        $sut = Product::add($title,$price,$category,$quantity);

        //assert
        $this->assertInstanceOf(Product::class,$sut);
        $this->assertEquals($title,$sut->title);
        $this->assertEquals($price,$sut->price);
    }

    #[Test] public function can_not_add_product_with_negative_price(): void
    {
        //arrange
        $title = $this->faker->word();
        $price = -1_000_000;
        $category = $this->faker->word();
        $quantity =  100;

        //assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("قیمت محصول نمی تواند منفی باشد.");

        //act
        $sut = Product::add($title,$price,$category,$quantity);
    }

    #[Test] public function can_not_add_product_with_negative_quantity(): void
    {
        //arrange
        $title = $this->faker->word();
        $price = 1_000_000;
        $category = $this->faker->word();
        $quantity =  -100;

        //assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Product::INVALID_QUANTITY_ERROR_MESSAGE);

        //act
        $sut = Product::add($title,$price,$category,$quantity);
    }

    #[Test] public function changing_product_quantity(): void
    {
        //arrange
        /** @var Product $sut */
        $sut = Product::factory()->withQuantity(13)->make();
        $newQuantity = 25;

        //act
        $sut->changeQuantityTo($newQuantity);

        //assert
        $this->assertEquals($newQuantity,$sut->quantity);

    }

    #[Test] public function can_not_set_quantity_to_negative_value_when_changing_product_quantity(): void
    {
        //arrange
        /** @var Product $sut */
        $sut = Product::factory()->withQuantity(13)->make();
        $newQuantity = -25;

        //act
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Product::INVALID_QUANTITY_ERROR_MESSAGE);

        //assert
        $sut->changeQuantityTo($newQuantity);
    }

    #[Test] public function changing_product_details():void
    {
        //arrange
        /** @var Product $sut */
        $sut = Product::factory()->make();
        $newTitle = "New Product Title";
        $newPrice = 3_900_000;
        $newCategory = "New Product Category";

        //act
        $sut->changeDetails($newTitle,$newPrice,$newCategory);

        //assert
        $this->assertEquals($newTitle,$sut->title);
        $this->assertEquals($newPrice,$sut->price);
        $this->assertEquals($newCategory,$sut->category);
    }

    #[Test] public function can_not_set_price_to_negative_value_when_changing_product_details():void
    {
        //arrange
        /** @var Product $sut */
        $sut = Product::factory()->make();
        $newPrice = -25_000;

        //act
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Product::INVALID_PRICE_ERROR_MESSAGE);

        //assert
        $sut->changeDetails("new Title",$newPrice,"new Category");
    }

}
