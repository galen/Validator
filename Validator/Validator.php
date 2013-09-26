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
     * Error messages from rules not validating
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
     * Single value mode
     *
     * True for single value validation
     * 
     * @var bool;
     */
    protected $single_value_mode = null;

    /**
     * Add a validation rule
     * 
     * @param \Validator\Rule $rule Rule to validate against
     * @param $key Key of the item to add a rule to
     * @param string $invalid_error Invalid error
     * @param string $empty_error Empty error
     * @return void
     * @access public
     */
    public function addRule( \Validator\RuleInterface $rule, $key = null, $invalid_error = null, $empty_error = null ) {
        if ( $this->single_value_mode === true && $key !== null ) {
            throw new \InvalidArgumentException( 'In single value mode' );
        }
        if ( $this->single_value_mode === false && $key === null ) {
            throw new \InvalidArgumentException( 'Not In single value mode' );
        }
        $this->single_value_mode = $key ? false : true;
        if ( $this->single_value_mode === false && ( !is_string( $key ) || empty( $key ) ) ) {
            throw new \InvalidArgumentException( 'Invalid key passed to addRule' );
        }
        if ( $this->single_value_mode === true ) {
            $key = 'single_value_mode';
        }
        $this->rules[$key][] = $rule;
        if ( $invalid_error ) {
            $this->invalid_errors[$key][ get_class( $rule ) ] = ( string ) $invalid_error;
        }
        if ( $empty_error ) {
            $this->empty_errors[$key][ get_class( $rule ) ] = ( string ) $empty_error;
        }
    }

    /**
     * Add a validation rule if the data is not empty
     *
     * Validation will only occur if email is not empty
     * 
     * @param \Validator\Rule $rule Rule to validate against
     * @param $key Key of the item to add a rule to
     * @param string $invalid_error Invalid error
     * @param string $empty_error Empty error
     * @return void
     * @access public
     */
    public function addRuleIfNotEmpty( \Validator\RuleInterface $rule, $key = null, $invalid_error = null, $empty_error = null ) {
        $this->addRule( new \Validator\Rule\IfNotEmpty( $rule ), $key, $invalid_error, $empty_error );
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
        if ( !count( $this->validation_errors ) ) {
            return null;
        }
        $error = array_shift( $this->validation_errors );
        return $error[0];
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
     * @param string $key Key of the item to add the filter to
     * @param Callable $callable Callable
     * @return void
     * @access public
     */
    public function addFilter( $key, Callable $callable ) {
        $this->filters[$key][] = $callable;
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
     * @param string $key Key to apply filters to
     * @return void
     * @access protected
     */
    protected function applyFilters( $key ) {
        $filters = array_merge( $this->global_filters, isset( $this->filters[$key] ) ? $this->filters[$key] : array() );
        foreach( $filters as $filter ) {
            $this->data[$key] = call_user_func( $filter, $this->data[$key] );
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
        foreach( $this->validation_errors as $key => $errors ) {
            $filtered = array_filter( $errors );
        }
    }

    /**
     * Validate
     *
     * Validates the data
     *
     * $data can be an array or object
     * 
     * @param mixed $data [description]
     * @return boolean Returns true if the data validates, otherwise false
     * @access public
     */
    public function validate( $data ) {
        if( $this->single_value_mode === true ) {
            $data = array( 'single_value_mode' => $data );
        }
        if ( is_object( $data ) ) {
            $data = get_object_vars( $data );
        }
        $this->data = $this->unfiltered_data = $data;
        foreach( $this->rules as $key => $rules ) {
            $this->applyFilters( $key );
            foreach( $rules as $rule ) {
                $result = $rule->validate( $this->data[$key] );
                if ( !$result ) {
                    if ( empty( $this->data[$key] ) ) {
                        if ( isset( $this->empty_errors[$key][ get_class( $rule ) ] ) ) {
                            $this->validation_errors[$key][] = $this->empty_errors[$key][ get_class( $rule ) ];
                        }
                        elseif( $this->global_empty_error ) {
                            if ( !isset( $labels_with_global_empty_error[$key] ) ) {
                                $this->validation_errors[$key][] = $this->global_empty_error;
                                $labels_with_global_empty_error[$key] = true;
                            }
                        }
                        else {
                            if ( isset( $this->invalid_errors[$key][ get_class( $rule ) ] ) ) {
                                $this->validation_errors[$key][] = $this->invalid_errors[$key][ get_class( $rule ) ];
                            }
                            else {
                                $this->validation_errors[$key][] = true;
                            }
                        }
                    }
                    elseif( isset( $this->invalid_errors[$key][ get_class( $rule ) ] ) ) {
                        $this->validation_errors[$key][] = $this->invalid_errors[$key][ get_class( $rule ) ];
                    }
                    else {
                        $this->validation_errors[$key][] = true;
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