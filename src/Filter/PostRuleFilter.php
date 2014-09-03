<?php
namespace OW\Rules\Filter;

use OW\Rules\Rule\EvaluatedRule;

interface PostRuleFilter extends Filter
{
    public function filter(EvaluatedRule $rule);
}