<?php


namespace App\Store\Contracts\Repository;


interface Category
{
    public function all();

    public function leafs();

    public function create($parent, $params);

    public function createRoot($params);

    public function update($id, $params);

    public function delete($id);
}
