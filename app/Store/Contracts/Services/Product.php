<?php


namespace App\Store\Contracts\Services;


interface Product
{
    public function all($params);

    public function create($params);

    public function get($id);

    public function delete($id);
}
