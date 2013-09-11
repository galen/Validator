<?php

namespace Validator\Rule;

/**
 * Email validator
 *
 * Validates an email address
 * 
 * $validator->addRule( 'email', new Rule\Email, 'Enter a valid email address' );
 *
 * @author Galen Grover <galenjr@gmail.com>
 * @package Validator
 */

class Email extends \Validator\Rule {

    /**
     * Validate
     * 
     * @param string $data Data to validate
     * @return boolean Returns true if the data validates, otherwise false
     * @access public
     */
    public function validate( $data ) {
        return ( bool )filter_var( $data, FILTER_VALIDATE_EMAIL );
    }

}