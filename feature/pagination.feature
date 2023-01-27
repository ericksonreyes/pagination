Feature: Pagination utility
  As a lazy developer
  I want a pagination utility class
  So that I don't need to rewrite my pagination logic again and again.

  Scenario Outline: Pagination
    Given there are "<records found>" records found
    And I am currently in page "<current page>"
    And I want to limit the pagination to "<show pages>" pages
    And I want to limit pages to "<records per page>" records
    When I paginate the records found
    And there will be a total of "<number of pages>" pages
    And the first page will be "<first page>"
    And the previous will be "<previous page>"
    And the current page should be "<current page>"
    And the next page will be "<next page>"
    And the last page will be "<last page>"
    And the pages will be "<pages>"

    Examples:
      | show pages | records per page | records found | number of pages | pages       | first page | previous page | current page | next page | last page |
      | 5          | 0                | 10000         | 0               |             |            |               |              |           |           |
      | 5          | 10               | 0             | 0               |             |            |               | 1            |           |           |
      | 5          | 10               | 7             | 1               | 1           |            |               | 1            |           |           |
      | 5          | 10               | 10            | 1               | 1           |            |               | 1            |           |           |
      | 5          | 10               | 15            | 2               | 1,2         | 1          | 1             | 2            |           |           |
      | 5          | 10               | 25            | 3               | 1,2,3       | 1          | 1             | 2            | 3         | 3         |
      | 5          | 5                | 50            | 10              | 1,2,3,4,5   | 1          |               | 1            | 2         | 10        |
      | 5          | 5                | 50            | 10              | 4,5,6,7,8   | 1          | 5             | 6            | 7         | 10        |
      | 5          | 5                | 50            | 10              | 6,7,8,9,10  | 1          | 7             | 8            | 9         | 10        |
      | 5          | 5                | 50            | 10              | 6,7,8,9,10  | 1          | 8             | 9            | 10        | 10        |
      | 5          | 5                | 50            | 10              | 6,7,8,9,10  | 1          | 9             | 10           |           |           |
      | 5          | 5                | 54            | 11              | 7,8,9,10,11 | 1          | 9             | 10           | 11        | 11        |
      | 5          | -10              | 10000         | 0               |             |            |               |              |           |           |
      | -5         | 10               | 7             | 1               | 1           |            |               | 1            |           |           |
      | 5          | 10               | 15            | 2               | 1,2         |            |               | -2           |           |           |

