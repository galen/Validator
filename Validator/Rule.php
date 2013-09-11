<?php

namespace Validator;

/**
 * Rule
 *
 * Abstract class that all rules must extend
 * 
 * @author Galen Grover <galenjr@gmail.com>
 * @package Validator
 */

Abstract class Rule {

    /**
     * Validate
     *
     * Rules must implement this
     * 
     * @param array $data Data to validate
     * @return bool Returns true if the rule validates, otherwise false
     */
    public abstract function validate( $data );

    /**
     * Error exception
     *
     * Throw an a rule error exception
     * 
     * @param string $exception_type Type of exception
     * @param string $error Error
     * @return void
     * @access public
     */
    public function error_exception( $exception_type, $error ) {
        $rule = basename( str_replace( '\\', '/', get_class( $this ) ) );
        throw new $exception_type( sprintf( 'Rule Error(%s): %s', $rule, $error ) );
    }

}