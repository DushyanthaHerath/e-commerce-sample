<?php

namespace App\Store\Controllers;

use App\Store\Contracts\Services\Category as CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index() {
        return $this->sendResponse($this->categoryService->all());
    }

    public function create($parent) {
        return $this->sendResponse($this->categoryService->create($parent, request()->all()));
    }

    public function createRoot() {
        return $this->sendResponse($this->categoryService->createRoot(request()->all()));
    }

    public function update($id) {
        return $this->sendResponse($this->categoryService->update($id, request()->all()));
    }

    public function delete($id) {
        return $this->sendResponse($this->categoryService->delete($id));
    }

    public function leafs() {
        return $this->sendResponse($this->categoryService->leafs());
    }
}
