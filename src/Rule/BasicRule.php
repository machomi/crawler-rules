<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace OW\Rules\Rule;

/**
 * Description of BasicRule
 *
 * @author Michal
 */
class BasicRule implements Rule
{

    private $name, $definition, $type, $attribute;

    private $preFilters = [], $postFilters = [];

    public function __construct($name = '', $defintion = '', $type = 'css', $attribute = null, $preFilters = [], $postFilters = [])
    {
        $this->name = $name;
        $this->definition = $defintion;
        $this->type = $type;
        $this->attribute = $attribute;
        $this->preFilters = $preFilters;
        $this->postFilters = $postFilters;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDefinition()
    {
        return $this->definition;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }

    public function getPreFilters()
    {
        return $this->preFilters;
    }

    public function getPostFilters()
    {
        return $this->postFilters;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setDefinition($definition)
    {
        $this->definition = $definition;
        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
        return $this;
    }

    public function setPreFilters($preFilters)
    {
        $this->preFilters = $preFilters;
        return $this;
    }

    public function setPostFilters($postFilters)
    {
        $this->postFilters = $postFilters;
        return $this;
    }
}
