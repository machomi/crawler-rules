<?php
namespace OW\Rules\Filter\Pre;

use OW\Rules\Filter\PreRuleFilter;
use OW\Rules\Rule\Rule;
use Symfony\Component\DomCrawler\Crawler;

class ModifyPreFilter implements PreRuleFilter
{
    
    /*
     * (non-PHPdoc)
     * @see \OW\Rules\Filter\PreRuleFilter::filter()
     */
    public function filter(Rule $rule, Crawler &$crawler)
    {
        // @todo: implement this
    }
    
    public function getParams()
    {
        return [];
    }
}