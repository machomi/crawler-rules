<?php
namespace OW\Rules\Processor;

use Symfony\Component\DomCrawler\Crawler;
use OW\Rules\Rule\Rule;
use OW\Rules\Rule\EvaluatedRule;

abstract class BaseRuleProcessor implements RuleProcessor
{

    private $crawler;
    
    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    public function getCrawler()
    {
        return $this->crawler;
    }
    
        /*
     * (non-PHPdoc)
     * @see \ssm\Crawler\Rule\Processor\RuleProcessor::evaluate()
     */
    public function evaluate(Rule $rule)
    {
       
       foreach($rule->getPreFilters() as $preFilter) {
           $preFilter->filter($rule);
       }
       
       $result = $this->doEvalute($rule->getDefinition());
       $rule = new EvaluatedRule($rule, $result);
       
       foreach($rule->getPostFilters() as $postFilter) {
            $postFilter->filter($rule);    
       }
       return $result;
    }
    
    public abstract function doEvalute($definition);
}