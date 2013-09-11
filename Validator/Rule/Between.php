<?php

namespace Validator\Rule;

/**
 * Validates that a number is between two values
 *
 * $validator->validate( 'age', new Rule\Between( 18, 40 ), 'You must be between 18 and 40' );
 * 
 * @author Galen Grover <galenjr@gmail.com>
 * @package Validator
 */

class Between extends \Validator\Rule {

    /**
     * Minimum value
     *
     * Minimum value for the range
     * 
     * @var mixed
     * @access protected
     */
    protected $min_value;

    /**
     * Maximum value
     *
     * Maximum value for the range
     * 
     * @var mixed
     * @access protected
     */
    protected $max_value;

    /**
     * Constructor
     *
     * @param mixed $min_value Minimum value
     * @param mixed $max_value Maximum value
     * @return \Validator\Rule\between
     * @throws  \InvalidArgumentExcpetion If $min_value >= $max_value
     * @access public
     */
    public function __construct( $min_value, $max_value ) {
        if ( $min_value >= $max_value ) {
            $this->error_exception( 'InvalidArgumentException', sprintf( 'minimum value must be less than maximum value (%s, %s)', $min_value, $max_value ) );
        }
        $this->min_value = $min_value;
        $this->max_value = $max_value;
    }

    /**
     * Validate
     * 
     * @param string $data Data to validate
     * @return boolean Returns true if the data validates, otherwise false
     * @access public
     */
    public function validate( $data ) {
        return ( $data > $this->min_value && $data < $this->max_value );
    }

}