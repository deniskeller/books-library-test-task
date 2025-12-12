<?php

namespace BOOKSLibraryMODELS;

class Book
{


    public function __construct(
        public string  $title = 'Some text',
        public int     $price = 0,
        private string $private = 'private'
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


    public function getInfo(): string
    {
        return 'info about book: ' . PHP_EOL . 'title: ' . $this->title . PHP_EOL . 'price: ' . $this->price;
    }

    public function getPrivate(): string
    {
//        dump($this);
        return $this->private;
    }

    public function setPrivate(string $private): void
    {
        $this->private = $private;
    }
}
