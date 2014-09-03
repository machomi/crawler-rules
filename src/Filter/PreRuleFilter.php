<?php
namespace OW\Rules\Filter;

use OW\Rules\Rule\Rule;
use Symfony\Component\DomCrawler\Crawler;

interface PreRuleFilter extends Filter
{
    public function filter(Rule $rule, Crawler &$crawler);
}