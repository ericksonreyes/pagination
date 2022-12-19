<?php

namespace spec\EricksonReyes\Pagination;

use EricksonReyes\Pagination\Pagination;
use EricksonReyes\Pagination\PaginationInterface;
use Faker\Factory;
use Faker\Generator;
use PhpSpec\ObjectBehavior;

/**
 * Class PaginationSpec
 * @package spec\EricksonReyes\Pagination
 */
class PaginationSpec extends ObjectBehavior
{

    /**
     * @var \Faker\Generator
     */
    private Generator $generator;

    public function __construct()
    {
        $this->generator = Factory::create('EN_PH');
    }

    public function let()
    {
        $recordsFound = 100;
        $recordsPerPage = 10;
        $currentPage = 1;
        $numberOfVisiblePages = 10;

        $this->beConstructedWith(
            $recordsFound,
            $recordsPerPage,
            $currentPage,
            $numberOfVisiblePages
        );
    }

    public function it_has_a_factory_method()
    {
        $recordsFound = $this->generator->numberBetween(0, 100);
        $recordsPerPage = $this->generator->numberBetween(5, 50);
        $currentPage = $this->generator->numberBetween(1, 10);
        $numberOfVisiblePages = $this->generator->numberBetween(10, 25);

        $this::create(
            $recordsFound,
            $recordsPerPage,
            $currentPage,
            $numberOfVisiblePages
        )->shouldReturnAnInstanceOf(Pagination::class);
    }

    /**
     * @return void
     */
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Pagination::class);
        $this->shouldImplement(PaginationInterface::class);
    }

    /**
     * @return void
     */
    public function it_has_number_of_records_found(): void
    {
        $this->recordsFound()->shouldBeInt();
    }

    /**
     * @return void
     */
    public function it_has_number_of_records_per_page(): void
    {
        $this->recordsPerPage()->shouldBeInt();
    }

    /**
     * @return void
     */
    public function it_can_have_zero_number_of_records_per_page(): void
    {
        $recordsFound = $this->generator->numberBetween(0, 100);
        $recordsPerPage = 0;
        $currentPage = $this->generator->numberBetween(1, 10);
        $numberOfVisiblePages = $this->generator->numberBetween(10, 25);

        $this->beConstructedWith(
            $recordsFound,
            $recordsPerPage,
            $currentPage,
            $numberOfVisiblePages
        );

        $this->recordsPerPage()->shouldReturn(0);
    }

    /**
     * @return void
     */
    public function it_has_number_of_pages(): void
    {
        $this->numberOfPages()->shouldBeInt();
    }

    /**
     * @return void
     */
    public function it_can_have_zero_number_of_pages(): void
    {
        $recordsFound = 0;
        $recordsPerPage = 0;
        $currentPage = $this->generator->numberBetween(1, 10);
        $numberOfVisiblePages = $this->generator->numberBetween(10, 25);

        $this->beConstructedWith(
            $recordsFound,
            $recordsPerPage,
            $currentPage,
            $numberOfVisiblePages
        );

        $this->numberOfPages()->shouldReturn(0);
    }

    /**
     * @return void
     */
    public function it_has_current_page_number(): void
    {
        $this->currentPage()->shouldBeInt();
    }

    /**
     * @return void
     */
    public function it_has_number_of_pages_visible(): void
    {
        $this->numberOfVisiblePages()->shouldBeInt();
    }


    /**
     * @return void
     */
    public function it_checks_if_it_has_a_collection_of_page_numbers(): void
    {
        $this->hasPages()->shouldBeBool();
    }

    /**
     * @return void
     */
    public function it_has_an_array_of_page_numbers(): void
    {
        $recordsFound = 50;
        $recordsPerPage = 10;
        $currentPage = 1;
        $numberOfVisiblePages = 10;

        $this->beConstructedWith(
            $recordsFound,
            $recordsPerPage,
            $currentPage,
            $numberOfVisiblePages
        );
        $this->pages()->shouldReturn([1, 2, 3, 4, 5]);
    }

    /**
     * @return void
     */
    public function it_checks_if_there_is_a_first_page(): void
    {
        $this->hasFirstPage()->shouldBeBool();
    }

    /**
     * @return void
     */
    public function it_has_first_page_number(): void
    {
        $this->firstPage()->shouldBeInt();
    }

    /**
     * @return void
     */
    public function it_can_have_zero_first_page(): void
    {
        $recordsFound = 0;
        $recordsPerPage = 0;
        $currentPage = $this->generator->numberBetween(1, 10);
        $numberOfVisiblePages = $this->generator->numberBetween(10, 25);

        $this->beConstructedWith(
            $recordsFound,
            $recordsPerPage,
            $currentPage,
            $numberOfVisiblePages
        );

        $this->firstPage()->shouldReturn(0);
    }

    /**
     * @return void
     */
    public function it_checks_if_there_is_a_previous_page(): void
    {
        $this->hasPreviousPage()->shouldBeBool();
    }

    /**
     * @return void
     */
    public function it_has_previous_page_number(): void
    {
        $recordsFound = 50;
        $recordsPerPage = 10;
        $currentPage = 2;
        $numberOfVisiblePages = 10;

        $this->beConstructedWith(
            $recordsFound,
            $recordsPerPage,
            $currentPage,
            $numberOfVisiblePages
        );

        $this->previousPage()->shouldReturn(1);
    }

    /**
     * @return void
     */
    public function it_can_have_zero_previous_page(): void
    {
        $recordsFound = 0;
        $recordsPerPage = 0;
        $currentPage = $this->generator->numberBetween(1, 10);
        $numberOfVisiblePages = $this->generator->numberBetween(10, 25);

        $this->beConstructedWith(
            $recordsFound,
            $recordsPerPage,
            $currentPage,
            $numberOfVisiblePages
        );

        $this->previousPage()->shouldReturn(0);
    }

    /**
     * @return void
     */
    public function it_checks_if_there_is_a_next_page(): void
    {
        $this->hasNextPage()->shouldBeBool();
    }

    /**
     * @return void
     */
    public function it_has_next_page_number(): void
    {
        $this->nextPage()->shouldBeInt();
    }


    /**
     * @return void
     */
    public function it_can_have_zero_next_page(): void
    {
        $recordsFound = 10;
        $recordsPerPage = 10;
        $currentPage = 1;
        $numberOfVisiblePages = 10;

        $this->beConstructedWith(
            $recordsFound,
            $recordsPerPage,
            $currentPage,
            $numberOfVisiblePages
        );

        $this->nextPage()->shouldReturn(0);
    }

    /**
     * @return void
     */
    public function it_checks_if_there_is_a_last_page(): void
    {
        $this->hasLastPage()->shouldBeBool();
    }

    /**
     * @return void
     */
    public function it_has_last_page_number(): void
    {
        $this->lastPage()->shouldBeInt();
    }

    public function it_can_return_zero_last_page(): void
    {
        $recordsFound = 0;
        $recordsPerPage = 10;
        $currentPage = 1;
        $numberOfVisiblePages = 10;

        $this->beConstructedWith(
            $recordsFound,
            $recordsPerPage,
            $currentPage,
            $numberOfVisiblePages
        );

        $this->lastPage()->shouldReturn(0);
    }

    /**
     * @return void
     */
    public function it_ignores_the_calculated_last_page_if_its_lesser_than_the_defined_number_of_visible_pages(): void
    {
        $recordsFound = 50;
        $recordsPerPage = 10;
        $currentPage = 1;
        $numberOfVisiblePages = 4;

        $this->beConstructedWith(
            $recordsFound,
            $recordsPerPage,
            $currentPage,
            $numberOfVisiblePages
        );
        $this->pages()->shouldBeArray();
    }

    /**
     * @return void
     */
    public function it_bases_the_range_of_pages_on_the_current_page_when_it_exceeds_the_defined_number_of_pages(): void
    {
        $recordsFound = 100;
        $recordsPerPage = 10;
        $currentPage = 7;
        $numberOfVisiblePages = 5;

        $this->beConstructedWith(
            $recordsFound,
            $recordsPerPage,
            $currentPage,
            $numberOfVisiblePages
        );
        $this->pages()->shouldBeArray();
    }

    /**
     * @return void
     */
    public function it_ignores_the_starting_range_of_the_pages_when_it_exceeds_the_ending_range(): void
    {
        $recordsFound = 7;
        $recordsPerPage = 10;
        $currentPage = 1;
        $numberOfVisiblePages = -5;

        $this->beConstructedWith(
            $recordsFound,
            $recordsPerPage,
            $currentPage,
            $numberOfVisiblePages
        );
        $this->pages()->shouldBeArray();
    }
}
