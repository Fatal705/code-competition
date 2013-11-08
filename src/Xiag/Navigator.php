<?php
namespace Xiag;
class Navigator
{
    protected $perPage;
    protected $offset;
    protected $total;
    protected $currentPage = 1;

    private $maxNavigatorSize;

    public function __construct($perPage = 10, $maxNavigatorSize = 5)
    {
        $this->perPage = $perPage;
        $this->maxNavigatorSize = $maxNavigatorSize;

    }

    public function printAsString($totalItems, $offset)
    {
        $maxShownPages = $this->maxNavigatorSize;
        $itemsPerPage = $this->perPage;

        $totalItems = $totalItems ?: 1;

        $currentPage = ceil(($offset + 1) / $itemsPerPage); 
        $lastPage = ceil($totalItems / $itemsPerPage);

        if($lastPage < $maxShownPages){
            $maxShownPages = $lastPage;
        }
        $pagesToStart = $currentPage - 1;
        $pagesToEnd = $lastPage - $currentPage;
        $pagesBefore = floor(($maxShownPages - 1) / 2); //show less pages before then after if not even number
        $pagesAfter = ceil(($maxShownPages - 1) / 2);

        $overflowBefore = 0;
        if($pagesToStart < $pagesBefore){
            $overflowBefore = $pagesBefore - $pagesToStart;
            $pagesBefore = $pagesToStart;
        }
        $pagesAfter += $overflowBefore;

        $overflowAfter = 0;
        if($pagesAfter > $pagesToEnd){
            $overflowAfter = $pagesAfter - $pagesToEnd;
            $pagesAfter = $pagesToEnd;
        }

        $pagesBefore += $overflowAfter; 
        $output = "";

        for ($i = $currentPage - $pagesBefore; $i <= ($currentPage - 1); $i++) { 
            $output .= $i." ";
        }
        $output .= "[".$currentPage."]";

        for ($i = $currentPage + 1; $i <= ($currentPage + $pagesAfter); $i++) { 
            $output .= " ".$i;
        }
        return $output;

    }


}