<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\Category;

class CategoryManager
{
    /**
     * Search the categories for the sort
     * @return array
     */
    public static function getAllCategories(): array
    {
        $stmt = DB::getPDO()->query("SELECT * FROM category ORDER BY id");
        $categories = [];
        foreach ($stmt->fetchAll() as $data) {
            $categories[] = (new Category())
                ->setId($data['id'])
                ->setCategoryName($data['category_name'])
            ;
        }
        return $categories;
    }
}