<?php


namespace App\Store\Contracts\Repository;


interface Product
{
    public function all($params);

    public function create($params);

    public function addProductImages($id, $images);

    public function addProductCategories($product, $categores);

    public function get($id);

    public function delete($id);
}
