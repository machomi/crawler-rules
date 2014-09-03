<?php
namespace OW\Rules\Filter;

class FilterChain implements Filter
{

    private $filters = [];

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }
    
    public function addFilter(Filter $filter)
    {
        $this->filters[] = $filter;
    }
    
    /*
     * (non-PHPdoc)
     * @see \OW\Rules\Filter\Filter::getParams()
     */
    public function getParams()
    {
        return [];
    }
    
    public function filter($value)
    {
        foreach ($this->filters as $filter) {
            $filter->filter($value);
        }
    }
}