<?php

namespace App\Model\Entity;

class Category extends AbstractEntity
{
    private string $categoryName;

    /**
     * @return string
     */
    public function getCategoryName(): string
    {
        return $this->categoryName;
    }

    /**
     * @param string $categoryName
     * @return Category
     */
    public function setCategoryName(string $categoryName): self
    {
        $this->categoryName = $categoryName;
        return $this;
    }




}