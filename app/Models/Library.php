<?php

namespace BOOKSLibraryMODELS;

class Library
{
    public function __construct(
        public array $books = []
    )
    {
    }

    public function addBook(Book $book): static
    {
        $this->books[] = $book;
        return $this;
    }

    public function getTotalPice(): int|float
    {
        $total = 0;
        /** @var Book $book */
        foreach ($this->books as $book) {
//            $total += $book['price'];
            $total += $book->price;
        }
        return $total;
    }

}