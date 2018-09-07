<?php

namespace App\Http\Transformers;


use App\Models\Clients\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['images'];

    public function transform(Product $product)
    {
        return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
        ];
    }

    public function includeImages(Product $product)
    {
        return $this->collection($product->images, new ImageTransformer());
    }

}