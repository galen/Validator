<?php

namespace Validator\Rule;

/**
 * Length validator
 *
 * Validates based on an exact length
 *
 * $validator->addRule( 'postal_code', new Rule\Length( 5 ), 'Your postal code must be 5 characters long' );
 * 
 * @author Galen Grover <galenjr@gmail.com>
 * @package Validator
 */

class Length extends \Validator\Rule {

    /**
     * Length
     *
     * Length to validate against
     * 
     * @var int
     * @access protected
     */
    protected $length;

    /**
     * Constructor
     *
     * @param int $length Length to validate against
     * @return \Validator\Rule\Length
     * @access public
     */
    public function __construct( $length ) {
        if ( $length != ( int ) $length || $length < 0 ) {
            $this->error_exception( 'InvalidArgumentException', 'Invalid length' );
        }
        $this->length = ( int ) $length;
    }

    /**
     * Validate
     * 
     * @param string $data Data to validate
     * @return boolean Returns true if the data validates, otherwise false
     * @access public
     */
    public function validate( $data ) {
        return strlen( $data ) === $this->length;
    }

}