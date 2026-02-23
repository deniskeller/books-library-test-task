<?php

namespace BOOKSLibraryCORE;

class Pagination
{
  private $currentPage; // текущая страница
  private $limit; // элементво на странице
  private $totalCount; // всего элементов
  private $countPages; // всего страниц
  private $offset; // отступ пагинации

  public function __construct(int $limit = 10, int $totalCount, int|null $currentPage = null)
  {
    $this->limit = $limit;
    $this->currentPage = $currentPage ?? $this->getCurrentPage();
    $this->totalCount = $totalCount;
    $this->offset = $this->getOffset();
    $this->countPages = $this->getCountPages();
  }

  // текущая страница
  public function getCurrentPage(): int
  {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    if ($page > $this->getCountPages()) $page = $this->getCountPages();
    return $page;
  }

  // отступ пагинации
  public function getOffset(): int
  {
    return ($this->getCurrentPage() - 1) * $this->limit;
  }

  // общее кол-во страниц
  public function getCountPages(): int
  {
    return ceil($this->totalCount / $this->limit);
  }
  public function getLimit(): int
  {
    return $this->limit;
  }
}
