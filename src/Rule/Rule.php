<?php
namespace OW\Rules\Rule;

/**
 * 
 */
interface Rule
{
    /**
     * @return string Rule name or identificator.
     */
    public function getName();
    
    /**
     * @return string Rule type name. It should be one of css, xpath or php.
     */
    public function getType();
    
    /**
     * @return string Rule definition.
     */
    public function getDefinition();
    
    /**
     * @return string Attribute name if needed.
     */
    public function getAttribute();
    
    /**
     * @return PreFilter[] Pre evalution filters array.
     */
    public function getPreFilters();
    
    /**
     * @return PostFilter[] Post evalution filters array.
     */
    public function getPostFilters();
    
}