<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Category;

class CategoryManager
{
    /**
     * Search the categories for the sort
     * @param string $categoryName
     * @return Category
     */
    public static function getAllCategoriesByName(string $categoryName): Category
    {
        $category = new Category();

        $stmt = DB::getPDO()->query("SELECT * FROM category WHERE category_name = '".$categoryName."'
        ");
        if ($stmt && $categoryData = $stmt->fetch()) {
            $category->setId($categoryData['id']);
            $category->setCategoryName($categoryData['category_name']);
        }

        return $category;
    }
}