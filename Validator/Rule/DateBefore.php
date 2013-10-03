<?php

namespace Validator\Rule;

/**
 * Date before validator
 *
 * $validator->addRule(
 *     new Rule\DateBefore( '1/1/14', 'm/d/y' ),
 *     'bill_pay_date',
 *     'The bill is due before the new year'
 * );
 * 
 * @author Galen Grover <galenjr@gmail.com>
 * @package Validator
 */

class DateBefore extends \Validator\Rule {

    /**
     * Date
     *
     * Date the date must be before
     * 
     * @var int
     * @access protected
     */
    protected $date;

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
     * Timezone
     *
     * Time of the date
     * 
     * @var \DateTimeZone
     * @access protected
     */
    protected $timezone;

    /**
     * Constructor
     *
     * The date to be validated and the $date must be in the format $format
     * 
     * @param string $date Date the valdiated date must be before
     * @param string $format Format both dates must be in
     * @param string $timezone Optional timezone
     * @return \Validator\Rule\DateBefore
     * @throws \InvalidArgumentException If the timezone is invalid
     * @access public
     */
    public function __construct( $date, $format, $timezone = 'UTC' ) {
        if ( \DateTime::createFromFormat( $format, '1/1/12', new \DateTimeZone( 'UTC' ) ) === false ) {
            $this->error_exception( 'InvalidArgumentException', sprintf( 'Invalid date format (%s)', $format ) );
        }
        $this->date = $date;
        $this->format = $format;
        try {
            $this->timezone = new \DateTimeZone( $timezone );
        }
        catch( \Exception $e ) {
            throw new \InvalidArgumentException( $e );
        }
    }

    /**
     * Validate
     * 
     * @param string $data Date to validate
     * @return boolean Returns true if the data validates with the format and is before the given date, otherwise false
     * @access public
     */
    public function validate( $data ) {
        $parsed_date = date_parse_from_format( $this->format, $data );
        if ( ( int ) $parsed_date['error_count'] + ( int ) $parsed_date['warning_count'] > 0 ) {
            return false;
        }
        $data_dt = \DateTime::createFromFormat( $this->format, $data, $this->timezone );
        $date_after_dt = \DateTime::createFromFormat( $this->format, $this->date, $this->timezone );
        return $data_dt < $date_after_dt;
    }

}