<?php

namespace EricksonReyes\Pagination;

/**
 * Interface PaginationInterface
 * @package Everyday\Utility
 */
interface PaginationInterface
{
    /**
     * @return int
     */
    public function numberOfPages(): int;

    /**
     * @return int
     */
    public function recordsFound(): int;

    /**
     * @return int
     */
    public function numberOfVisiblePages(): int;

    /**
     * @return int
     */
    public function recordsPerPage(): int;

    /**
     * @return int
     */
    public function currentPage(): int;

    /**
     * @return int
     */
    public function firstPage(): int;

    /**
     * @return bool
     */
    public function hasFirstPage(): bool;

    /**
     * @return int
     */
    public function previousPage(): int;

    /**
     * @return bool
     */
    public function hasPreviousPage(): bool;

    /**
     * @return int[]
     */
    public function pages(): array;

    /**
     * @return bool
     */
    public function hasPages(): bool;

    /**
     * @return int
     */
    public function nextPage(): int;

    /**
     * @return bool
     */
    public function hasNextPage(): bool;

    /**
     * @return int
     */
    public function lastPage(): int;

    /**
     * @return bool
     */
    public function hasLastPage(): bool;
}
