<?php

use Behat\Behat\Context\Context;
use EricksonReyes\Pagination\Pagination;

/**
 * Class FeatureContext
 */
class FeatureContext implements Context
{

    /**
     * @var array
     */
    private array $paginationParams;

    /**
     * @var \EricksonReyes\Pagination\Pagination
     */
    private Pagination $pagination;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->paginationParams = [];
    }

    /**
     * @Transform /^$/i
     */
    public function transform()
    {
        return 0;
    }


    /**
     * @Given there are :arg1 records found
     */
    public function thereAreRecordsFound(int $recordsFound): void
    {
        $this->paginationParams['recordsFound'] = $recordsFound;
    }

    /**
     * @Given I am currently in page :arg1
     */
    public function iAmCurrentlyInPage(int $currentPage): void
    {
        $this->paginationParams['currentPage'] = $currentPage;
    }

    /**
     * @Given I want to limit pages to :arg1 records
     */
    public function iWantToLimitPagesToRecords(int $recordsPerPage)
    {
        $this->paginationParams['recordsPerPage'] = $recordsPerPage;
    }

    /**
     * @Given I want to limit the pagination to :arg1 pages
     */
    public function iWantToLimitThePaginationToPages(int $pagesVisible)
    {
        $this->paginationParams['pagesVisible'] = $pagesVisible;
    }

    /**
     * @When I paginate the records found
     */
    public function iPaginateTheRecordsFound()
    {
        $this->pagination = new Pagination(
            $this->paginationParams['recordsFound'],
            $this->paginationParams['recordsPerPage'],
            $this->paginationParams['currentPage'],
            $this->paginationParams['pagesVisible']
        );
    }

    /**
     * @Then there will be :arg1 records in the page
     */
    public function thereWillBeRecordsInThePage(int $recordsPerPage)
    {
        assert(
            $this->pagination->recordsPerPage() === $recordsPerPage,
            "{$this->pagination->recordsPerPage()} did not match expected {$recordsPerPage} records per page."
        );
    }

    /**
     * @Then there will be a total of :arg1 pages
     */
    public function thereWillBeATotalOfPages(int $numberOfPages)
    {
        assert(
            $this->pagination->numberOfPages() === $numberOfPages,
            "{$this->pagination->numberOfPages()} did not match expected {$numberOfPages} number of pages."
        );
    }

    /**
     * @Then the current page should be :arg1
     */
    public function theCurrentPageShouldBe(int $currentPage)
    {
        assert(
            $this->pagination->currentPage() === $currentPage,
            "{$this->pagination->currentPage()} did not match expected {$currentPage} current page."
        );
    }


    /**
     * @Then the first page will be :arg1
     */
    public function theFirstPageWillBe(?int $firstPage)
    {
        assert(
            $this->pagination->firstPage() === $firstPage,
            "{$this->pagination->firstPage()} did not match expected {$firstPage} first page."
        );
    }

    /**
     * @Then the previous will be :arg1
     */
    public function thePreviousWillBe(?int $previousPage)
    {
        assert(
            $this->pagination->previousPage() === $previousPage,
            "{$this->pagination->previousPage()} did not match expected {$previousPage} previous page."
        );
    }

    /**
     * @Then the pages will be :arg1
     */
    public function thePagesWillBe(?string $expectedPages)
    {
        if ($expectedPages === "0") {
            $expectedPages = '';
        }

        if (is_null($expectedPages)) {
            $expectedPages = '';
        }
        $actualPages = implode(',', $this->pagination->pages());

        assert(
            $actualPages === $expectedPages,
            "[{$actualPages}] did not match expected [{$expectedPages}] pages."
        );
    }


    /**
     * @Then the next page will be :arg1
     */
    public function theNextPageWillBe(?int $nextPage)
    {
        assert(
            $this->pagination->nextPage() === $nextPage,
            "{$this->pagination->nextPage()} did not match expected {$nextPage} next page."
        );
    }

    /**
     * @Then the last page will be :arg1
     */
    public function theLastPageWillBe(?int $lastPage)
    {
        assert(
            $this->pagination->lastPage() === $lastPage,
            "{$this->pagination->lastPage()} did not match expected {$lastPage} last page."
        );
    }
}
