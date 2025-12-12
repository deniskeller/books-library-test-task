<?php

namespace BOOKSLibraryMODELS;

class BookExtends extends Book
{
    public function __construct(string $title = 'Some text', int $price = 0, public int $num_pages)
    {
        parent::__construct($title, $price);
    }

    public function getInfo(): string
    {
        $parentInfo = parent::getInfo();
        return $parentInfo . PHP_EOL . 'num_pages: ' . $this->num_pages;
    }

}