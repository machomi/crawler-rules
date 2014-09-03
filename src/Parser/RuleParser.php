<?php
namespace OW\Rules\Parser;

/**
 * 
 * @author Michal
 *
 */
interface RuleParser
{
    /**
     * 
     * @param string $input
     * @return \ssm\Crawler\Rule\Rule;
     */
    public function parse($input);
    
    /**
     * 
     * @param \ssm\Crawler\Rule\Rule $rule
     * @return string
     */
    public function serialize(\OW\Rules\Rule\Rule $rule);
}