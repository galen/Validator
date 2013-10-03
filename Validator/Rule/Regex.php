<?php

namespace Validator\Rule;

/**
 * Regex validator
 *
 * Validates based on a regular expression
 *
 * $validator->addRule( new Rule\Regex( '~^\d{5}$~' ), 'postal_code' );
 * 
 * @author Galen Grover <galenjr@gmail.com>
 * @package Validator
 */

class Regex extends \Validator\Rule {

    /**
     * Pattern
     *
     * Pattern to match against
     * 
     * @var string
     * @access protected
     */
    protected $pattern;

    /**
     * Constructor
     *
     * @param string $pattern Pattern to match against
     * @return \Validator\Rule\Regex
     * @throws  \InvalidArgumentException If the pattern is in invalid
     * @access public
     */
    public function __construct( $pattern ) {
        if ( @preg_match( $pattern, null ) === false ) {
            $this->error_exception( 'InvalidArgumentException', 'Invalid pattern' );
        }
        $this->pattern = $pattern;
    }

    /**
     * Validate
     * 
     * @param string $data Data to validate
     * @return boolean Returns true if the data validates, otherwise false
     * @access public
     */
    public function validate( $data ) {
        return ( bool ) preg_match( $this->pattern, $data );
    }

}