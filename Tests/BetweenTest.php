<?php

use Validator\Validator;
use Validator\Rule;

require( '../../autoload.php' );
require_once( 'BaseRuleTest.php' );

class BetweenTest extends BaseRuleTest {

    protected $data = array(
        'valid'             => 5,
        'invalid_before'    => 0,
        'invalid_after'     => 11,
        'equal_min'         => 1,
        'equal_max'         => 10
    );

    public function testValid() {
        $this->validator->addRule( 'valid', new Rule\Between( 1, 10 ) );
        $this->assertTrue( $this->validator->validate( $this->data ) );
    }

    public function testInvalidBefore() {
        $this->validator->addRule( 'invalid_before', new Rule\Between( 1, 10 ) );
        $this->assertFalse( $this->validator->validate( $this->data ) );
    }

    public function testInvalidAfter() {
        $this->validator->addRule( 'invalid_after', new Rule\Between( 1, 10 ) );
        $this->assertFalse( $this->validator->validate( $this->data ) );
    }

    public function testInvalidArgumentsEqual() {
        $this->setExpectedException( 'InvalidArgumentException' );
        $this->validator->addRule( 'invalid_equal_min', new Rule\Between( 1, 1 ) );
        $this->validator->validate( $this->data );
    }

    public function testInvalidArgumentsSwitched() {
        $this->setExpectedException('InvalidArgumentException');
        $this->validator->addRule( 'invalid_equal_min', new Rule\Between( 10, 1 ) );
        $this->validator->validate( $this->data );
    }

    public function testInvalidEqualToMin() {
        $this->validator->addRule( 'invalid_equal_min', new Rule\Between( 1, 10 ) );
        $this->assertFalse( $this->validator->validate( $this->data ) );
    }

    public function testInvalidEqualToMax() {
        $this->validator->addRule( 'invalid_equal_max', new Rule\Between( 1, 10 ) );
        $this->assertFalse( $this->validator->validate( $this->data ) );
    }

    public function testEmptyGarbageNullDataDoesntValidate() {
        $rule = new Rule\Between( 1, 10 );
        $this->_testEmptyDataDoesntValidate( $rule );
        $this->_testGarbageDataDoesntValidate( $rule );
        $this->_testNullDataDoesntValidate( $rule );
    }

}