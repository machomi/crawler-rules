<?php
namespace OW\Rules\Rule;

class EvaluatedRule extends BasicRule
{

    /**
     *
     * @var Rule
     */
    private $rule;

    /**
     * @var string
     */
    private $evalution;

    public function __construct(Rule $rule, $evalution = '')
    {
        $this->rule = $rule;
        $this->evalution = $evalution;
    }

    public function getDefinition()
    {
        return $this->rule->getDefinition();
    }

    public function getType()
    {
        return $this->rule->getType();
    }

    public function getPostFilters()
    {
        return $this->rule->getPostFilters();
    }

    public function getPreFilters()
    {
        return $this->rule->getPreFilters();
    }

    public function getName()
    {
        return $this->rule->getName();
    }

    public function getAttribute()
    {
        return $this->rule->getAttribute();
    }

    public function getEvaluation()
    {
        return $this->evalution;
    }

    public function setEvaluation($evaluation)
    {
        $this->evalution = $evaluation;
    }
}