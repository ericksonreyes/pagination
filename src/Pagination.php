<?php
/**
 * MIT License
 *
 * Copyright (c) [year] [fullname]
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

namespace EricksonReyes\Pagination;

/**
 * Class Pagination
 * @package EricksonReyes\Pagination
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * No need to break into multiple classes since there are no methods that similar to other classes.
 */
class Pagination implements PaginationInterface
{

    /**
     * @var array
     */
    private array $pages = [];

    /**
     * @param int $recordsFound
     * @param int $recordsPerPage
     * @param int $currentPage
     * @param int $numberOfVisiblePages
     */
    public function __construct(
        private readonly int $recordsFound,
        private readonly int $recordsPerPage,
        private readonly int $currentPage,
        private readonly int $numberOfVisiblePages = 10
    )
    {
        $this->calculatePages();
    }

    /**
     * @param int $recordsFound
     * @param int $recordsPerPage
     * @param int $currentPage
     * @param int $numberOfVisiblePages
     * @return \EricksonReyes\Pagination\PaginationInterface
     */
    public static function create(
        int $recordsFound,
        int $recordsPerPage,
        int $currentPage,
        int $numberOfVisiblePages = 10
    ): PaginationInterface
    {
        return new self($recordsFound, $recordsPerPage, $currentPage, $numberOfVisiblePages);
    }

    /**
     * @return int
     */
    public function numberOfPages(): int
    {
        if ($this->recordsFoundOrPerPageIsZero()) {
            return 0;
        }
        return ceil($this->recordsFound() / $this->recordsPerPage());
    }

    /**
     * @return int
     */
    public function numberOfVisiblePages(): int
    {
        return max($this->numberOfVisiblePages, 0);
    }

    /**
     * @return int
     */
    public function recordsFound(): int
    {
        return max($this->recordsFound, 0);
    }

    /**
     * @return int
     */
    public function recordsPerPage(): int
    {
        return max($this->recordsPerPage, 0);
    }

    /**
     * @return int
     */
    public function currentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return bool
     */
    public function hasFirstPage(): bool
    {
        return $this->firstPage() > 0;
    }

    /**
     * @return int
     */
    public function firstPage(): int
    {
        if ($this->recordsFoundOrPerPageIsZero() ||
            $this->recordsFound() <= $this->recordsPerPage() ||
            $this->currentPage() < 1
        ) {
            return 0;
        }

        return 1;
    }

    /**
     * @return bool
     */
    public function hasPreviousPage(): bool
    {
        return $this->previousPage() > 0;
    }

    /**
     * @return int
     */
    public function previousPage(): int
    {
        if ($this->recordsFoundOrPerPageIsZero() ||
            $this->recordsFound() <= $this->recordsPerPage() ||
            $this->currentPage() <= 1
        ) {
            return 0;
        }

        return $this->currentPage() - 1;
    }

    /**
     * @return bool
     */
    public function hasPages(): bool
    {
        return count($this->pages()) > 0;
    }

    /**
     * @return int[]
     */
    public function pages(): array
    {
        return $this->pages;
    }


    /**
     * @return int
     */
    public function nextPage(): int
    {
        if ($this->recordsFoundOrPerPageIsZero() ||
            $this->recordsFound() <= $this->recordsPerPage() ||
            $this->currentPage() === $this->numberOfPages() ||
            $this->currentPage() < 1
        ) {
            return 0;
        }
        return $this->currentPage() + 1;
    }

    /**
     * @return bool
     */
    public function hasNextPage(): bool
    {
        return $this->nextPage() > 0;
    }


    /**
     * @return int
     */
    public function lastPage(): int
    {
        if ($this->recordsFoundOrPerPageIsZero() ||
            $this->recordsFound() <= $this->recordsPerPage() ||
            $this->currentPage() === $this->numberOfPages() ||
            $this->currentPageIsLessThanZero()
        ) {
            return 0;
        }

        return $this->numberOfPages();
    }

    /**
     * @return bool
     */
    private function currentPageIsLessThanZero(): bool
    {
        return $this->currentPage() < 0;
    }

    /**
     * @return bool
     */
    public function hasLastPage(): bool
    {
        return $this->lastPage() > 0;
    }

    /**
     * @return void
     *
     */
    private function calculatePages(): void
    {
        if ($this->recordsFoundOrPerPageIsZero() === false && $this->numberOfPages() > 0) {
            $lastPage = $this->lastPage();
            $margin = floor($this->numberOfVisiblePages() / 2);
            $start = 1;
            $end = $this->numberOfPages();

            if ($lastPage > $this->numberOfVisiblePages()) {
                $end = $this->numberOfVisiblePages();
            }

            if ($this->currentPage() > $this->numberOfVisiblePages()) {
                $start = $this->currentPage() - $margin;
                $end = $this->currentPage() + $margin;
            }

            $projectedStart = $this->numberOfPages() - ($this->numberOfVisiblePages() - 1);
            if ($end >= $lastPage && $projectedStart > 0) {
                $start = $projectedStart;
                $end = $this->numberOfPages();
            }

            if ($start > $end) {
                $start = $end;
            }

            $this->pages = range($start, $end);
        }
    }


    /**
     * @return bool
     */
    private function recordsFoundOrPerPageIsZero(): bool
    {
        if ($this->recordsFound() === 0) {
            return true;
        }

        if ($this->recordsPerPage() === 0) {
            return true;
        }
        return false;
    }
}
