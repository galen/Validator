<?php

namespace Validator\Rule;

/**
 * If Not Empty Rule Decorator
 *
 * This decorates rules and only uses the rule to validate if the data is not empty
 * 
 * @author Galen Grover <galenjr@gmail.com>
 * @package Validator
 */

class IfNotEmpty extends \Validator\RuleDecorator {

    /**
     * Validate data
     *
     * If the data is empty validation "passes"
     * otherwise the decorated rule is used for validation
     * 
     * @param string $data Data to validate
     * @return boolean Returns true if the data validates, otherwise false
     * @access public
     */
    public function validate( $data ){
        if ( empty( $data ) ) {
            return true;
        }
        return $this->rule->validate( $data );
    }

}