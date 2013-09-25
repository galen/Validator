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

Abstract class Rule implements RuleInterface {

    /**
     * Error exception
     *
     * Throw a rule error exception
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