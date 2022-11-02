<?php

namespace App\Model\Entity;

class Category extends AbstractEntity
{
    private string $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Category
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }


}