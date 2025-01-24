<?php

namespace App\Modules\Product\Tests\Integration;

use App\Modules\Product\Model\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class WhenFilterProductsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_returns_products_with_matched_title(): void
    {

        //arrange
        $products = Product::factory()
            ->count(10)
            ->sequence(fn(Sequence $sequence) => ['title' => sprintf('محصول %d',$sequence->index+1)])
            ->create();
        $filterKeyword = 'محصول 1';
        /** @var Product $matchedProduct */
        $matchedProduct = $products->first();


        //act
        $response = $this->get(sprintf('/products/filter?keyword=%s',$filterKeyword));

        //assert
        $response->assertSuccessful();
        $response->assertJson(function(AssertableJson $json)use($matchedProduct){
            $json->has('status')
                ->has('products',1)
                ->has('products.0',function(AssertableJson $json)use($matchedProduct){
                    $json->where('title',$matchedProduct->title)
                        ->where('price',$matchedProduct->price)
                        ->where('category',$matchedProduct->category)
                        ->where('quantity',$matchedProduct->quantity);
                });
        });


    }

    /** @test */
    public function it_returns_products_with_matched_price(): void
    {
        //arrange
        $products = Product::factory()
            ->count(10)
            ->sequence(fn(Sequence $sequence) => ['price' => ($sequence->index + 1) * 100_000] )
            ->create();

        //act
        $response = $this->get(sprintf('/products/filter?startPrice=%d&endPrice=%d',200_000,500_000));

        //assert
        $response->assertSuccessful();
        $response->assertJson(function (AssertableJson $json){
            $json->has('status')
                ->has('products',4)
                ->has('products.0',function (AssertableJson $json){
                    $json->where('price',200_000)
                        ->etc();
                })
                ->has('products.3',function(AssertableJson $json){
                    $json->where('price',500_000)
                        ->etc();
                });
        });
    }

    /** @test */
    public function it_returns_products_with_matched_category(): void
    {
        //arrange
        $products = Product::factory()
            ->count(10)
            ->state(new Sequence(
                ['category' => 'Mobile'],
                ['category' => 'Car'],
                ['category' => 'Toy'],
            ))
            ->create();
        $filterCategoryKeyword = 'Mobile';

        //act
        $response = $this->get(sprintf('/products/filter?category=%s',$filterCategoryKeyword));

        //assert
        $response->assertSuccessful();
        $response->assertJson(function(AssertableJson $json)use($filterCategoryKeyword){
            $json->has('status')
                ->has('products',4)
                ->has('products.0',function (AssertableJson $json)use($filterCategoryKeyword){
                    $json->where('category',$filterCategoryKeyword)
                        ->etc();
                })
                ->has('products.3',function(AssertableJson $json)use($filterCategoryKeyword){
                    $json->where('category',$filterCategoryKeyword)
                        ->etc();
                });
        });
    }
}
