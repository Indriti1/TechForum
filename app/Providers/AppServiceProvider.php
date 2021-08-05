<?php
 
//Laravel Include namespace 
namespace App\Providers;
   
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
    
class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        /**
         * Paginate a standard Laravel Collection.
         * www.pakainfo.com
         * @param int $perPage display row
         * @param int $total all records
         * @param int $page all pages
         * @param string $pageName your live page name
         * @return array
         */
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }
    public function boot()
    {
             
    }
}