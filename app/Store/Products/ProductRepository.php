<?php


namespace App\Store\Products;


use App\Store\Contracts\Repository\Product;
use App\Store\Models\Product as ProductModel;
use App\Store\Models\ProductImage;

class ProductRepository implements Product
{
    protected $product;
    public function __construct(ProductModel $product)
    {
        $this->product = $product;
    }

    public function all($params)
    {
        $products = $this->product::with(['images','categories']);
        if(isset($params['sort']) && !empty($params['sort'])) $products = $this->product->orderBy($params['sort'], $params['order']);
        return $products->paginate();
    }

    public function create($params)
    {
        return $this->product::create($params);
    }

    public function addProductImages($id, $images) {
        foreach ($images as $img)
            (new ProductImage())->create(['product_id'=>$id, 'image'=>$img]);
    }

    public function addProductCategories($product, $categores) {
        foreach ($categores as $cat)
            $product->categories()->attach($cat);
    }

    public function get($id)
    {
        return $this->product::with(['categories', 'images'])->find($id);
    }

    public function delete($id)
    {
        return $this->product::find($id)->delete();
    }
}
