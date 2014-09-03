<?php
namespace OW\Rules\Filter\Post;

use OW\Rules\Filter\PostRuleFilter;
use OW\Rules\Rule\EvaluatedRule;

class StripTagsPostFilter implements PostRuleFilter
{

    private $allowebleTags;

    public function __construct($allowebleTags = '')
    {
        $this->allowebleTags = $allowebleTags;
    }
    
    /*
     * (non-PHPdoc)
     * @see \OW\Rules\Filter\PostRuleFilter::filter()
     */
    public function filter(EvaluatedRule $rule)
    {
        $value = (string)$rule->getEvaluation();
        $value = strip_tags($value, $this->allowebleTags);
        $rule->setEvaluation($value);
    }
    
    public function getParams()
    {
        return [$this->allowebleTags];
    }
}