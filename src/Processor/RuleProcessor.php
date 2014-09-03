<?php
namespace OW\Rules\Processor;

use OW\Rules\Rule\Rule;

/**
 * 
 * @author Michal
 *
 */
interface RuleProcessor
{
    /**
     * 
     */
    public function evaluate(Rule $rule);
    
    /**
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    public function getCrawler();
}