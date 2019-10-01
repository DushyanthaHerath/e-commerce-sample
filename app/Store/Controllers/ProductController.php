<?php

namespace App\Store\Controllers;

use App\Store\Contracts\Services\Product as ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index() {
        return $this->sendResponse($this->productService->all(request()->all()));
    }

    public function create() {
        return $this->sendResponse($this->productService->create(request()->all()));
    }

    public function get($id) {
        return $this->sendResponse($this->productService->get($id));
    }

    public function delete($id) {
        return $this->sendResponse($this->productService->delete($id));
    }
}
