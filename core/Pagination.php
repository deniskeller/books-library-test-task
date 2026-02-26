<?php

namespace BOOKSLibraryCORE;

class Pagination
{
  private $limit; // элементов на странице
  private $totalCount; // всего элементов
  private $currentPage; // текущая страница
  private $countPages; // всего страниц
  private $offset; // отступ пагинации


  public function __construct(
    int $limit = 10,
    int $totalCount,
    int|null $currentPage = null,
    private int $midSize = 2, // кол-во страниц по бокам от текущей
    private int $maxPages = 8 // максимальное кол-во отображаемых страниц
  ) {
    $this->limit = $limit;
    $this->totalCount = $totalCount;
    $this->currentPage = $currentPage ?? $this->getCurrentPage();
    $this->offset = $this->getOffset();
    $this->countPages = $this->getCountPages();
    $this->midSize = $this->getMidSize();
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

  // првоеряем есть ли предыдущая страница
  public function hasPrev(): bool
  {
    return $this->currentPage > 1;
  }

  // проверяем есть ли следующая страница
  public function hasNext(): bool
  {
    return $this->currentPage < $this->countPages;
  }

  // предыдущая страница
  public function prevPageUrl(): ?string
  {
    if (!$this->hasPrev()) {
      return null;
    }

    return $this->setUrl($this->currentPage - 1);
  }

  // следующая страница
  public function nextPageUrl(): ?string
  {
    if (!$this->hasNext()) {
      return null;
    }

    return $this->setUrl($this->currentPage + 1);
  }

  // создаем URI с параметрами
  private function setUrl(int $page): string
  {
    // dump($page);
    $params = $_GET;
    // dump($params);
    $params['page'] = $page;

    return '?' . http_build_query($params);
  }

  private function getMidSize(): int
  {
    return $this->countPages <= $this->maxPages ? $this->countPages : $this->midSize;
  }

  public function getTotalCount(): int
  {
    return $this->limit;
  }
  public function getLimit(): int
  {
    return $this->limit;
  }
}
