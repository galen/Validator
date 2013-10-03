<?php

namespace Validator\Rule;

/**
 * Maximum length validator
 *
 * Validates based on a maximum length
 *
 * $validator->addRule( new Rule\MaxLength( 12 ), 'password', 'Your password must be under 12 characters long' );
 * 
 * @author Galen Grover <galenjr@gmail.com>
 * @package Validator
 */

class MaxLength extends \Validator\Rule {

    /**
     * Max length
     *
     * Maximum length to validate against
     *
     * Can be equal to this length ( validates if <= $max_length )
     * 
     * @var int
     * @access protected
     */
    protected $max_length;

    /**
     * Constructor
     *
     * @param int $max_length Maximum length to validate against
     * @return \Validator\Rule\MaxLength
     * @access public
     */
    public function __construct( $max_length ) {
        if ( $max_length != ( int ) $max_length  || $max_length < 0 ) {
            $this->error_exception( 'InvalidArgumentException', 'Invalid length' );
        }
        $this->max_length = ( int ) $max_length;
    }

    /**
     * Validate
     * 
     * @param string $data Data to validate
     * @return boolean Returns true if the data validates, otherwise false
     * @access public
     */
    public function validate( $data ) {
        return strlen( $data ) <= $this->max_length;
    }

}