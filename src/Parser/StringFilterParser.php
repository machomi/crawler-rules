<?php
namespace OW\Rules\Parser;

use OW\Rules\Filter\Filter;
use OW\Rules\Filter\FilterManager;

class StringFilterParser implements FilterParser
{

    public static $FILTER_PARAM_SEPARATOR = ',';
    
    /*
     * (non-PHPdoc)
     * @see \OW\Rules\Parser\FilterParser::parse()
     */
    public function parse($text)
    {
        $params = [];
        $text = str_replace(')', '', $text);
        if (strpos($text, '(')) {
            list($filterName, $combinedParams) = explode('(', $text);
            $params = $this->parseParams($combinedParams);
        } else {
            $filterName = $text;
        }
        $className = FilterManager::clazz($filterName);
        return $this->createFilter($className, $params); 
    }
    
    protected function parseParams($combinedParams)
    {
        $params = explode(self::$FILTER_PARAM_SEPARATOR, $combinedParams);
        return array_map(function($param) {
            return str_replace(["'",'"'], '', $param);
        }, $params);
    }
    
    protected function createFilter($className, $params)
    {
        $refl = new \ReflectionClass($className);
        return $refl->newInstanceArgs($params);
    }
    
    /*
     * (non-PHPdoc)
     * @see \OW\Rules\Parser\FilterParser::serialize()
     */
    public function serialize(Filter $filter)
    {
        $filterName = FilterManager::alias(get_class($filter));
        $filterParams = implode(self::$FILTER_PARAM_SEPARATOR, $filter->getParams());
        return empty($filterParams) ? $filterName : $filterName .'('.$filterParams.')';
    }
}