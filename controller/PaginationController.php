<?php

namespace Controller;

class PaginationController
{
  public function generatePaginationLinks($currentPage, $totalPages, $queryParams)
  {
    $links = '';

    // Generate the base URL with the query string parameters
    $baseUrl = 'manwatchmanage.php?' . http_build_query($queryParams);

    // Generate the "Previous" link
    $prevDisabled = ($currentPage == 1) ? 'disabled' : '';
    $prevLink = '<li class="page-item ' . $prevDisabled . '"><a class="page-link rounded" href="' . $baseUrl . '&page=' . ($currentPage - 1) . '">Previous</a></li>';

    // Generate the page number links
    for ($i = 1; $i <= $totalPages; $i++) {
      $activeClass = ($i == $currentPage) ? 'active' : '';
      $links .= '<li class="page-item' . $activeClass . '"><a class="page-link rounded" href="' . $baseUrl . '&page=' . $i . '">' . $i . '</a></li>';
    }

    // Generate the "Next" link
    $nextDisabled = ($currentPage == $totalPages) ? 'disabled' : '';
    $nextLink = '<li class="page-item ' . $nextDisabled . '"><a class="page-link rounded" href="' . $baseUrl . '&page=' . ($currentPage + 1) . '">Next</a></li>';

    // Combine the links
    $pagination = '<ul class="pagination">' . $prevLink . $links . $nextLink . '</ul>';

    return $pagination;
  }
}
