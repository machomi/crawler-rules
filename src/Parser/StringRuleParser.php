<?php
namespace OW\Rules\Parser;

use OW\Rules\Rule\Rule;
use OW\Rules\Rule\BasicRule;

/**
 * 
 * @author Michal
 *
 */
class StringRuleParser implements RuleParser
{
    public static $TYPE_SEPARATOR = '://';
    
    public static $NAME_SEPARATOR = '::';
    
    public static $PRE_DEFINITION_SEPERATOR = '@:';
    
    public static $POST_DEFINITION_SEPERATOR = ':@';
    
    public static $FILTER_SEPARATOR = '|';
    
    public static $DEFAULT_TYPE = 'css';

    /**
     * (non-PHPdoc)
     * @see \OW\Rules\Parser\RuleParser::serialize()
     */
    public function serialize(Rule $rule)
    {
        $ruleString = '';
        $preDefintion = $rule->getType();

        if ($rule->getName()) {
            $preDefintion .= ($preDefintion != '' ? self::$TYPE_SEPARATOR : '') . $rule->getName();
        } 
        if (!empty($rule->getPreFilters())) {
            if ($rule->getType() && !$rule->getName()) {
                $preDefintion .= self::$TYPE_SEPARATOR;
            } 
            $preDefintion .= self::$NAME_SEPARATOR . $this->serializeFilters($rule->getPreFilters());
        }
        
        if ($preDefintion) {
            $ruleString .= $preDefintion . self::$PRE_DEFINITION_SEPERATOR . $rule->getDefinition();
        } else {
            $ruleString .= $rule->getDefinition();
        }
        
        if (!empty($rule->getPostFilters())) {
            $ruleString .= self::$POST_DEFINITION_SEPERATOR . $this->serializeFilters($rule->getPostFilters());
        }
        
        return $ruleString;
    }


    /**
     * (non-PHPdoc)
     * @see \OW\Rules\Parser\RuleParser::parse()
     */
    public function parse($input)
    {
        // parse rule with format
        // type://name::prefilter1|prefilter2(param1, param2)@:definiotion:@postfilter(param)
        
        $rule = new BasicRule();
        
        // first and only required element is a definition
        if (strpos($input, self::$PRE_DEFINITION_SEPERATOR)) {
            // split string into 2 pieces
            list($beforeDefinition, $afterDefinition) = explode(self::$PRE_DEFINITION_SEPERATOR, $input);
            
            // analyze before definition fragment
            // if has name separatory mean that we propably have pre filters to parse
            if (strpos($beforeDefinition, self::$NAME_SEPARATOR)) {
                
                list($nameAndType, $preFilters) = explode(self::$NAME_SEPARATOR, $beforeDefinition);
                if (trim($preFilters) != '') {
                    $this->parsePreFilters($rule, $preFilters);
                }

                // check for types
                if (strpos($nameAndType, self::$TYPE_SEPARATOR)) {
                    list($type, $name) = explode(self::$TYPE_SEPARATOR, $nameAndType);
                    $rule->setType($type);
                    $rule->setName($name);
                } else {
                    $rule->setName($nameAndType);
                }
                
            } elseif (strpos($beforeDefinition, self::$TYPE_SEPARATOR)) {
                
                list($type, $name) = explode(self::$TYPE_SEPARATOR, $beforeDefinition);
                //$this->parsePreFilters($rule, $preFilters);
                $rule->setName($name);
                $rule->setType($type);
                
            } else {
                $rule->setName($beforeDefinition);
            }
            
            // analyze post definition fragment
            if (strpos($afterDefinition, self::$POST_DEFINITION_SEPERATOR)) {
                
                list($definition, $filters) = explode(self::$POST_DEFINITION_SEPERATOR, $afterDefinition);
                $rule->setDefinition($definition);
                
                // check for post filters
                $this->parsePostFilters($rule, $filters);
                
            } else {
                $rule->setDefinition($afterDefinition);
            }
            
        } else {
            // string contains only definition
            $rule->setDefinition($input);
        }
        if (!$rule->getType()) {
            $rule->setType(self::$DEFAULT_TYPE);
        }
        return $rule;
    }
    
    private function serializeFilters($filters)
    {
        $filterParser = new StringFilterParser();
        $serialized = [];
        foreach ($filters as $filter) {
            $serialized[] = $filterParser->serialize($filter);
        }
        return implode(self::$FILTER_SEPARATOR, $serialized);
    }
    
    private function parseFilters($filters)
    {
        $filtersDefintions = explode(self::$FILTER_SEPARATOR, $filters);
        $filters = [];
        $parser = new StringFilterParser();
        foreach ($filtersDefintions as $filterDefinition) {
            $filters[] = $parser->parse($filterDefinition);
        }
        return $filters;
    }
    
    private function parsePreFilters($rule, $filters)
    {
        if ($rule instanceof BasicRule) {
            $rule->setPreFilters($this->parseFilters($filters));
        }
    }
    
    private function parsePostFilters($rule, $filters)
    {
        if ($rule instanceof BasicRule) {
            $rule->setPostFilters($this->parseFilters($filters));
        }
    }
    
}