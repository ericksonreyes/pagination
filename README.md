# Pagination Class

![Code Coverage](https://github.com/ericksonreyes/pagination/raw/master/coverage_badge.svg)
[![Build](https://github.com/ericksonreyes/pagination/actions/workflows/merge.yaml/badge.svg?branch=master)](https://github.com/ericksonreyes/pagination/actions/workflows/merge.yaml)

Nothing fancy. I just created a pagination class that I've been copy-pasting over and over again.

## Installation

```shell
composer require ericksonreyes/pagination
```

### Example (Laravel)

Controller

```php
namespace App\Http\Controllers;

use App\Repository\UserRepository;use Illuminate\Http\Request;use Illuminate\Http\Response;use Illuminate\Routing\Controller as BaseController;

class Users extends BaseController {

    private const DEFAULT_PAGE_SIZE = 35;

    public function index(Request $request, UserRepository $repository): Response {
        $page = (int) $request->get('page', 1);
        $size = (int) $request->get('size', self::DEFAULT_PAGE_SIZE);
        
        if ($page < 1) {
            $page = 1;
        }
        
        if ($size < 1) {
            $size = self::DEFAULT_PAGE_SIZE;
        }
        
        $offset = $page - 1;
        $limit = $size;
        $count = $repository->countUsers();
        $data['users'] = $repository->getUsers($offset, $limit);  
        
        $data['pagination'] = new Pagination(
            recordsFound: $count,
            recordsPerPage: 10,
            currentPage: $page
        );
        
        return response()->view('list', $data);
    }
    
}
```

View (Blade Templating)

```php
@if(isset($pagination) && $pagination->hasPages())
    <ul class="pagination">
    
        @if($pagination->hasPreviousPage())
            <li>
                <a href="{{ route('records.list', ['page' => $pagination->previousPage()]) }}">
                    Previous
                </a>
            </li>
        @endif
                        
        @if($pagination->hasFirstPage())
            <li>
                <a href="{{ route('records.list', ['page' => $pagination->firstPage()]) }}">
                    {{ $pagination->firstPage() }}
                </a>
            </li>
            <li>...</li>
        @endif                    
        
        @foreach($pagination->pages() as $page)
            @if($pagination->currentPage() === $page)
                <li><span class="span--strong">{{ $page }}</span></li>
            @else
                <li>
                    <a href="{{ route('records.list', ['page' => $page]) }}">
                        {{ $page }}
                    </a>
                </li>
            @endif
        @endforeach
        
        @if($pagination->hasLastPage())
            <li>...</li>
            <li>
                <a href="{{ route('records.list', ['page' => $pagination->lastPage()]) }}">
                    {{ $pagination->lastPage() }}
                </a>
            </li>
        @endif   
        
        @if($pagination->hasNextPage())
            <li>
                <a href="{{ route('records.list', ['page' => $pagination->hasNextPage()]) }}">                
                    Next
                </a>
            </li>
        @endif             
    </ul>
@endif
```

View (Vanilla PHP)

```php
<?php 
    if(isset($pagination) && $pagination->hasPages()) {
        
        ?><ul class="pagination"><?php
        
        
        if($pagination->hasPreviousPage()) {
          ?>
            <li>
                <a href="<?php echo route('records.list', ['page' => $pagination->previousPage()]) ?>">
                    Previous
                </a>
            </li>
          <?php
        }


        if ($pagination->hasFirstPage()) {
          ?>
            <li>
                <a href="<?php echo route('records.list', ['page' => $pagination->firstPage()]) ?>">
                    <?php echo $pagination->firstPage() ?>
                </a>
            </li>
            <li>...</li>
          <?php
        }
        
        
        foreach($pagination->pages() as $page) {
          if($pagination->currentPage() === $page) { 
            ?>
              <li>
                <span class="span--strong"><?php echo $page; ?></span>
              </li>
            <?php 
          } 
          else { 
            ?>
              <li>
                <a href="<?php echo route('records.list', ['page' => $page]) ?>">
                  <?php echo $page ?>
                </a>
              </li>
            <?php
          } 
        } 
        
        
      if($pagination->hasLastPage()) {
        ?>
          <li>...</li>
          <li>
              <a href="<?php echo route('records.list', ['page' => $pagination->lastPage()]) ?>">
                  <?php echo $pagination->lastPage() ?>
              </a>
          </li>
        <?php
      } 
      
      
      if($pagination->hasNextPage()) { 
        ?>
          <li>
            <a href="<?php echo route('records.list', ['page' => $pagination->hasNextPage()]) ?>">                
                Next
            </a>
          </li>
        <?php 
      }
           
      ?></ul><?php 
    } 
  ?>
```

### Author

* Erickson Reyes ([GitHub](https://github.com/ericksonreyes), [LinkedIn](https://www.linkedin.com/in/ericksonreyes/)
  and [Packagist](http://packagist.org/users/ericksonreyes/)).

### License

See [MIT LICENSE.md](LICENSE.md)