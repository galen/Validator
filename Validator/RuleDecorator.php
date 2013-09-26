<?php

namespace Validator;

/**
 * If Not Empty Rule Decorator
 *
 * This decorates rules and only uses the rule to validate if the data is not empty
 * 
 * @author Galen Grover <galenjr@gmail.com>
 * @package Validator
 */

Abstract class RuleDecorator implements RuleInterface {

    /**
     * Rule to use for validation
     * 
     * @var \Validator\Rule
     */
    protected $rule;

    /**
     * Constructor
     * 
     * @param Rule $rule Rule to use for validation
     */
    public function __construct( \Validator\RuleInterface $rule ) {
        $this->rule = $rule;
    }

}