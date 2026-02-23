<?php

namespace BOOKSLibraryCORE;

class Pagination
{
  private $limit;
  private $currentPage;

  public function __construct(int $limit = 3, int $currentPage)
  {
    $this->limit = $limit;
    $this->currentPage = $currentPage;
  }

  public function getCurrentPage(): int
  {
    return $this->currentPage;
  }
  public function getLimit(): int
  {
    return $this->limit;
  }
}
