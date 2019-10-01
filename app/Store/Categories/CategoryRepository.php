<?php


namespace App\Store\Categories;

use App\Store\Models\Category as CategoryModel;

use App\Store\Contracts\Repository\Category;

class CategoryRepository implements Category
{
    protected $category;

    public function __construct(CategoryModel $category)
    {
        $this->category = $category;
    }

    public function all()
    {
        return $this->category::get()->toTree();
    }

    public function create($parent, $params)
    {
        $parentNode = $this->get($parent);
        $node = new CategoryModel($params);
        return ($node->appendToNode($parentNode)->save()) ? $this->all() : false;
    }

    public function createRoot($params)
    {
        throw_if($this->category::whereNull('parent_id')->exists(), new \Exception('Root category already created.'));
        $node = new CategoryModel($params);
        return ($node->save()) ? $this->all() : false;
    }

    public function get($id) {
        return $this->category::find($id);
    }

    public function update($id, $params)
    {
        $this->category::where('id', $id)->update($params);
        return $this->all();
    }

    public function delete($id) {
        $this->category::where('id', $id)->delete();
        return $this->all();
    }

    public function leafs() {
        return $this->category->whereIsLeaf()->get();
    }
}
