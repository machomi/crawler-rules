<?php
namespace OW\Rules\Filter\Post;

use OW\Rules\Filter\PostRuleFilter;
use OW\Rules\Rule\EvaluatedRule;
use Symfony\Component\DomCrawler\Crawler;


class AttributePostFilter implements PostRuleFilter
{

    private $name;
    
    public function __construct($name)
    {
        $this->name = $name;    
    }
    
    public function getParams()
    {
        return [$this->name];
    }

    public function filter(EvaluatedRule $rule)
    {
        $evalution = $rule->getEvaluation();
        if ($evalution instanceof Crawler) {
            $rule->setEvaluation($evalution->attr($this->name));
        }
    }
}