<?php

namespace Validator\Rule;

/**
 * Minimum lenth validator
 *
 * Validates based on a minimum length
 *
 * $validator->addRule( 'password', new Rule\MinLength( 8 ), 'Your password must be at least 8 characters long' );
 *
 * @author Galen Grover <galenjr@gmail.com>
 * @package Validator
 */

class MinLength extends \Validator\Rule {

    /**
     * Minimum length
     *
     * Minimum length to validate against
     *
     * Can be equal to this length ( validates if >= $min_length )
     * 
     * @var int
     * @access protected
     */
    protected $min_length;

    /**
     * Constructor
     *
     * @param int $min_length Minimum length to validate against
     * @return \Validator\Rule\MinLength
     * @access public
     */
    public function __construct( $min_length ) {
        if ( $min_length != ( int ) $min_length || $min_length < 0 ) {
            $this->error_exception( 'InvalidArgumentException', 'Invalid length' );
        }
        $this->min_length = ( int ) $min_length;
    }

    /**
     * Validate
     * 
     * @param string $data Data to validate
     * @return boolean Returns true if the data validates, otherwise false
     * @access public
     */
    public function validate( $data ) {
        return strlen( $data ) >= $this->min_length;
    }

}