<?php


namespace App\Store\Products;


use App\Store\Contracts\Services\Product;
use App\Store\Contracts\Repository\Product as ProductRepository;

class ProductService implements Product
{
    protected $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function all($params)
    {
        return $this->productRepository->all($params);
    }

    public function create($params)
    {
        // Product
        $product = $this->productRepository->create([
           'name' => $params['name'],
            'price' => $params['price'],
            'description' => $params['description'],
        ]);
        // Categories
        $this->addProductCategories($product, $params['categories']);
        //Images
        $this->addProductImages($product->id, $params['images']);
        return $product;
    }

    // SOLID Better separate to another service ex: storage service
    private function addProductImages($id, $images) {
        $this->productRepository->addProductImages($id, $images);
    }

    private function addProductCategories($product, $categores) {
        $this->productRepository->addProductCategories($product, $categores);
    }


    public function get($id)
    {
        return $this->productRepository->get($id);
    }

    public function delete($id)
    {
        return $this->productRepository->delete($id);
    }
}
