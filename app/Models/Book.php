<?php

namespace BOOKSLibraryMODELS;

class Book
{
//    public ?string $title;
//    public ?int $price;
//
//    public function __construct(string $title = 'Some text', int $price = 0)
//    {
//        $this->title = $title;
//        $this->price = $price;
//    }

    public function __construct(
        public string $title = 'Some text', public int $price = 0
    )
    {
    }

    public function setCurrency($currency = "RUB"): string
    {
        return $this->getRealPrice() . "$currency";
    }

    public function getRealPrice(): int|float
    {
        return $this->price / 100;
    }
}
