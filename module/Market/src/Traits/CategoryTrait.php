<?php
namespace Market\Traits;

trait CategoryTrait
{
    protected $categories;
    public function setCategories(array $cat)
    {
        $this->categories = $cat;
        return $this;
    }
    public function getCategories()
    {
        return $this->categories;
    }
}
