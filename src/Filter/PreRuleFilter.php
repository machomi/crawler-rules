<?php
namespace OW\Rules\Filter;

use OW\Rules\Rule\Rule;

interface PreRuleFilter extends Filter
{
    public function filter(Rule $rule);
}