<?php
namespace OW\Rules\Filter\Post;

use OW\Rules\Filter\PostRuleFilter;
use OW\Rules\Rule\EvaluatedRule;
use Symfony\Component\DomCrawler\Crawler;

class TextPostFilter implements PostRuleFilter
{
    
    /*
     * (non-PHPdoc)
     * @see \OW\Rules\Filter\PostRuleFilter::filter()
     */
    public function filter(EvaluatedRule $rule)
    {
        $evalution = $rule->getEvaluation();
        if ($evalution instanceof Crawler) {
            $rule->setEvaluation($evalution->text());
        }
    }
    
    public function getParams()
    {
        return [];
    }
}