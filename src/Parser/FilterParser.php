<?php
namespace OW\Rules\Parser;

use OW\Rules\Filter\Filter;

interface FilterParser
{
    public function parse($text);
    
    public function serialize(Filter $filter);
}