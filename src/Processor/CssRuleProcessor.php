<?php

namespace OW\Rules\Processor;

class CssRuleProcessor extends BaseRuleProcessor {

    public function doEvalute($definition) {
        return $this->getCrawler()->filter($definition);
    }

}
