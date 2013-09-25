<?php

namespace Validator;

/**
 * Rule Interface
 * 
 * @author Galen Grover <galenjr@gmail.com>
 * @package Validator
 */

Interface RuleInterface {

    /**
     * Validate
     *
     * Rules must implement this
     * 
     * @param array $data Data to validate
     * @return bool Returns true if the rule validates, otherwise false
     */
    public function validate( $data );

}