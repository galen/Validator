<?php

namespace Validator\Rule;

/**
 * Date validator
 *
 * $validator->addRule( 'birthdate', new Rule\Date( 'm/d/y' ), 'Please enter your birthdate (m/d/y)' ) );
 * 
 * @author Galen Grover <galenjr@gmail.com>
 * @package Validator
 */

class Date extends \Validator\Rule {

    /**
     * Date format
     *
     * The format that the date will be provided in
     * 
     * @var string
     * @access  protected
     */
    protected $format;

    /**
     * Constructor
     *
     * The date to be validated and the $date must be in the format $format
     * 
     * @param string $format Format both dates must be in
     * @return \Validator\Rule\Date
     * @throws \InvalidArgumentException If the timezone is invalid
     * @access public
     */
    public function __construct( $format ) {
        if ( \DateTime::createFromFormat( $format, '1/1/12', new \DateTimeZone( 'UTC' ) ) === false ) {
            $this->error_exception( 'InvalidArgumentException', sprintf( 'Invalid date format (%s)', $format ) );
        }
        $this->format = $format;
    }

    /**
     * Validate
     * 
     * @param string $data Date to validate
     * @return boolean Returns true if the data validates with the format, otherwise false
     * @access public
     */
    public function validate( $data ) {
        $parsed_date = date_parse_from_format( $this->format, $data );
        return ( int ) $parsed_date['error_count'] + ( int ) $parsed_date['warning_count'] === 0;
    }

}