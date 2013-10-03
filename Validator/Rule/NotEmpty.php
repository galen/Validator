<?php

namespace Validator\Rule;

/**
 * Validates that a value is not empty
 *
 * $validator->validate( new Rule\NotEmpty, 'phone_number', 'Please enter your phone number' );
 * 
 * @author Galen Grover <galenjr@gmail.com>
 * @package Validator
 */

class NotEmpty extends \Validator\Rule {

    /**
     * Validate
     * 
     * @param string $data Data to validate
     * @return boolean Returns true if the data validates, otherwise false
     * @access public
     */
    public function validate( $data ) {
        return !empty( $data );
    }

}