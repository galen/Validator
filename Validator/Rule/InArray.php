<?php

namespace Validator\Rule;

/**
 * Validates that a value is in an array
 *
 * $validator->validate( 'state', new Rule\InArray( $states ), 'Please enter your state' );
 * 
 * @author Galen Grover <galenjr@gmail.com>
 * @package Validator
 */

class InArray extends \Validator\Rule {

    /**
     * Array 
     *
     * Array to search
     * 
     * @var array
     * @access  protected
     */
    protected $array;

    /**
     * Constructor
     *
     * @param array $array Array to search in
     * @return \Validator\Rule\InArray
     * @access public
     */
    public function __construct( array $array ) {
        if ( count( $array ) === 0 ) {
            $this->error_exception( 'InvalidArgumentException', 'Empty array passed' );
        }
        $this->array = $array;
    }

    /**
     * Validate
     * 
     * @param string $data Data to validate
     * @return boolean Returns true if the data validates, otherwise false
     * @access public
     */
    public function validate( $data ) {
        return in_array( $data, $this->array );
    }

}