<?php

namespace Validator\Rule;

/**
 * Equality validator
 *
 * Validates based on equality
 *
 * $validator->addRule( new Rule\Equals( $_POST['reenter_password'] ), 'password' );
 * 
 * @author Galen Grover <galenjr@gmail.com>
 * @package Validator
 */

class Equal extends \Validator\Rule {

    /**
     * Value
     * 
     * Valuethat the must must be equal to
     * 
     * @var mixed
     * @access protected
     */
    protected $value;

    /**
     * Strict
     *
     * Use == or ===
     * 
     * @var bool
     * @access protected
     */
    protected $strict;

    /**
     * Constructor
     *
     * @param mixed $value Value to validate against
     * @return \Validator\Rule\Equals
     * @access public
     */
    public function __construct( $value, $strict = false ) {
        $this->value = $value;
        $this->strict = ( bool ) $strict;
    }

    /**
     * Validate
     * 
     * @param string $data Data to validate
     * @return boolean Returns true if the data validates, otherwise false
     * @access public
     */
    public function validate( $data ) {
        return $this->strict ? $data === $this->value : $data == $this->value;
    }

}