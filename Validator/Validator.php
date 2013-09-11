<?php

namespace Validator;

/**
 * Validator
 *
 * Validates data when given a set of rules
 * 
 * @author Galen Grover <galenjr@gmail.com>
 * @package Validator
 */

class Validator {

    /**
     * Rules
     * 
     * @var array
     * @access protected
     */
    protected $rules = array();

    /**
     * Filters
     * 
     * @var array
     * @access protected
     */
    protected $filters = array();

    /**
     * Unfiltered Data
     * 
     * @var array
     * @access protected
     */
    protected $unfiltered_data = array();

    /**
     * Data
     * 
     * @var array
     * @access protected
     */
    protected $data = array();

    /**
     * Return all errors
     *
     * If this is true all rules will be run
     * If this is false the validator will stop on the first error
     * 
     * @var boolean
     * @access protected
     */
    protected $return_all_errors = false;

    /**
     * Invalid errors
     * 
     * @var array
     * @access protected
     */
    protected $invalid_errors = array();

    /**
     * Empty errors
     * 
     * @var array
     * @access protected
     */
    protected $empty_errors = array();

    /**
     * Validation errors
     *
     * These are the actual errors returned from rules not validating
     * 
     * @var array
     * @access protected
     */
    protected $validation_errors = array();

    /**
     * Global Filters
     * 
     * @var array
     * @access protected
     */
    protected $global_filters = array();

    /**
     * Global empty error
     *
     * Error for empty values
     * 
     * @var string
     * @access protected
     */
    protected $global_empty_error;

    /**
     * Add a validation rule
     *
     * $validator->addRule( 'email', new \Rule\Email( 'Enter a valid email' ) );
     * 
     * @param $label Label of the item to add a rule to
     * @param \Validator\Rule $rule Rule to validate against
     * @param string $invalid_error Invalid error
     * @param string $empty_error Empty error
     * @return void
     * @access public
     */
    public function addRule( $label, \Validator\Rule $rule, $invalid_error = null, $empty_error = null ) {
        if ( $label === '' ) {
            throw new InvalidArgumentException( 'Invalid label passed to addRule' );
        }
        $this->rules[$label][] = $rule;
        if ( $invalid_error ) {
            $this->invalid_errors[$label][ get_class( $rule ) ] = ( string ) $invalid_error;
        }
        if ( $empty_error ) {
            $this->empty_errors[$label][ get_class( $rule ) ] = ( string ) $empty_error;
        }
    }

    /**
     * Return all errors
     *
     * Return all errors instead of just the first one
     * 
     * @return void
     * @access public
     */
    public function returnAllErrors() {
        $this->return_all_errors = TRUE;
    }

    /**
     * Get first error
     *
     * Get the first error
     * 
     * @return string|null Returns the first error or null
     * @access public
     */
    public function getFirstError() {
        return isset( $this->validation_errors[0] ) ? $this->validation_errors[0] : null;
    }

    /**
     * Get error
     *
     * Get the error
     * 
     * @return string|null Returns the first error or null
     * @access public
     */
    public function getError() {
        return $this->getFirstError();
    }

    /**
     * Get errors
     *
     * Get the array of errors
     * 
     * @return array|null Returns the array of errors or null
     * @access public
     */
    public function getErrors() {
        return count( $this->validation_errors ) ? $this->validation_errors : null;
    }

    /**
     * Add filter
     *
     * Add a filter to an item
     * 
     * @param string $label Label of the item to add the filter to
     * @param Callable $callable Callable
     * @return void
     * @access public
     */
    public function addFilter( $label, Callable $callable ) {
        $this->filters[$label][] = $callable;
    }

    /**
     * Add global filter
     *
     * Add a filter to all labels
     * 
     * @param Callable $callable Callable
     * @return void
     * @access public
     */
    public function addGlobalFilter( Callable $callable ) {
        $this->global_filters[] = $callable;
    }

    /**
     * Get data
     *
     * Get the validator data after the filters have been applied
     * 
     * @return array Returns the array of data
     * @access public
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Get data
     *
     * Get the validator data before the filters have been applied
     * 
     * @return array Returns the array of unfiltered data
     * @access public
     */
    public function getUnfilteredData() {
        return $this->unfiltered_data;
    }

    /**
     * Apply filters
     *
     * Apply filters to the label
     * Global filters first, then local filters
     * 
     * @param string $data_label Label to apply filters to
     * @return void
     * @access protected
     */
    protected function applyFilters( $data_label ) {
        $filters = array_merge( $this->global_filters, isset( $this->filters[$data_label] ) ? $this->filters[$data_label] : array() );
        foreach( $filters as $filter ) {
            $this->data[$data_label] = call_user_func( $filter, $this->data[$data_label] );
        }
    }

    /**
     * Enable global empty error
     *
     * This will be the error for all empty fields
     * 
     * @param string $msg Error message
     * @return void
     * @access public
     */
    public function enableGlobalEmptyError( $msg ) {
        $this->global_empty_error = $msg;
    }

    /**
     * Cleanup validation errors
     *
     * Removes empty validation errors
     * 
     * @return void
     * @access protected
     */
    protected function cleanupValidationErrors() {
        foreach( $this->validation_errors as $data_label => $errors ) {
            $filtered = array_filter( $errors );
        }
    }

    /**
     * Validate
     *
     * Validates the data
     * 
     * @param array $data [description]
     * @return boolean Returns true if the data validates, otherwise false
     * @access public
     */
    public function validate( array $data ) {
        $this->data = $this->unfiltered_data = $data;
        foreach( $this->rules as $data_label => $rules ) {
            $this->applyFilters( $data_label );
            foreach( $rules as $rule ) {
                $result = $rule->validate( $this->data[$data_label] );
                if ( !$result ) {
                    if ( empty( $this->data[$data_label] ) ) {
                        if ( isset( $this->empty_errors[$data_label][ get_class( $rule ) ] ) ) {
                            $this->validation_errors[$data_label][] = $this->empty_errors[$data_label][ get_class( $rule ) ];
                        }
                        elseif( $this->global_empty_error ) {
                            if ( !isset( $labels_with_global_empty_error[$data_label] ) ) {
                                $this->validation_errors[$data_label][] = $this->global_empty_error;
                                $labels_with_global_empty_error[$data_label] = true;
                            }
                        }
                        else {
                            if ( isset( $this->invalid_errors[$data_label][ get_class( $rule ) ] ) ) {
                                $this->validation_errors[$data_label][] = $this->invalid_errors[$data_label][ get_class( $rule ) ];
                            }
                            else {
                                $this->validation_errors[$data_label][] = true;
                            }
                        }
                    }
                    elseif( isset( $this->invalid_errors[$data_label][ get_class( $rule ) ] ) ) {
                        $this->validation_errors[$data_label][] = $this->invalid_errors[$data_label][ get_class( $rule ) ];
                    }
                    else {
                        $this->validation_errors[$data_label][] = true;
                    }
                    if ( !$this->return_all_errors ) {
                        $this->cleanupValidationErrors();
                        return FALSE;
                    }
                }
            }
        }
        $this->cleanupValidationErrors();
        return count( $this->validation_errors ) === 0;
    }

}