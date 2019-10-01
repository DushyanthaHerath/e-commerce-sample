<?php


namespace App\Store\Categories;


use App\Store\Contracts\Services\Category;
use App\Store\Contracts\Repository\Category as CategoryRepository;

class CategoryService implements Category
{
    protected $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function all()
    {
        return $this->categoryRepository->all();
    }

    public function create($parent, $params)
    {
        return $this->categoryRepository->create($parent, $params);
    }

    public function createRoot($params)
    {
        return $this->categoryRepository->createRoot($params);
    }

    public function update($id, $params)
    {
        return $this->categoryRepository->update($id, $params);
    }

    public function delete($id) {
        return $this->categoryRepository->delete($id);
    }

    public function leafs()
    {
        return $this->categoryRepository->leafs();
    }
}
