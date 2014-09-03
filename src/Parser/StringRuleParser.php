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
            } elseif ($rule->getName()) {
                $preDefintion .= self::$NAME_SEPARATOR;
            }
            $preDefintion .= $this->serializeFilters($rule->getPreFilters());
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
            if (strpos(self::$NAME_SEPARATOR, $beforeDefinition)) {
                
                list($nameAndType, $preFilters) = explode(self::$NAME_SEPARATOR, $beforeDefinition);
                $this->processPreFilters($rule, $preFilters);

                // check for types
                if (strpos($nameAndType, self::$TYPE_SEPARATOR)) {
                    list($type, $name) = explode(self::$TYPE_SEPARATOR, $nameAndType);
                    $rule->setType($type);
                    $rule->setName($name);
                } else {
                    $rule->setName($nameAndType);
                }
                
            } elseif (strpos(self::$TYPE_SEPARATOR, $beforeDefinition)) {
                
                list($nameAndType, $preFilters) = explode(self::$TYPE_SEPARATOR, $beforeDefinition);
                $this->processPreFilters($rule, $preFilters);
                
                // check for types
                if (strpos($nameAndType, self::$TYPE_SEPARATOR)) {
                    list($type, $name) = explode(self::$TYPE_SEPARATOR, $nameAndType);
                    $rule->setType($type);
                    $rule->setName($name);
                } else {
                    $rule->setType($nameAndType);
                }
                
            } else {
                $rule->setName($beforeDefinition);
            }
            
            // analyze post definition fragment
            if (strpos($afterDefinition, self::$POST_DEFINITION_SEPERATOR)) {
                
                list($definition, $filters) = explode(self::$POST_DEFINITION_SEPERATOR, $afterDefinition);
                $rule->setDefinition($definition);
                
                // check for post filters
                if (strpos($filters, self::$FILTER_SEPARATOR)) {
                    $filters = explode(self::$FILTER_SEPARATOR, $filters);
                    $this->processPostFilters($rule, $filters);
                } else {
                    $this->processPostFilters($rule, (array)$filters);
                }
                
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
    
    private function processPreFilters($rule, $filters)
    {
        
    }
    
    private function processPostFilters($rule, $filters)
    {
    
    }
    
}