<?php

use Validator\Validator;
use Validator\Rule;

require( '../../autoload.php' );
require_once( 'BaseRuleTest.php' );

class DateBeforeTest extends BaseRuleTest {

    protected $data = array(
        'valid'             => '1/1/11',
        'invalid_after'     => '1/1/13',
        'invalid_equal'     => '1/1/13'
    );

    public function testValid() {
        $this->validator->addRule( 'valid', new Rule\DateBefore( '1/1/12', 'm/d/y' ) );
        $this->assertTrue( $this->validator->validate( $this->data ) );
    }

    public function testInvalidBefore() {
        $this->validator->addRule( 'invalid', new Rule\DateBefore( '1/1/12', 'm/d/y' ) );
        $this->assertFalse( $this->validator->validate( $this->data ) );
    }

    public function testInvalidEqual() {
        $this->validator->addRule( 'invalid', new Rule\DateBefore( '1/1/13', 'm/d/y' ) );
        $this->assertFalse( $this->validator->validate( $this->data ) );
    }

    public function testInvalidTimezone() {
        $this->setExpectedException( 'InvalidArgumentException' );
        $this->validator->addRule( 'invalid', new Rule\DateBefore( '1/1/13', 'm/d/y', 'this isnt a valid timezone' ) );
        $this->assertFalse( $this->validator->validate( $this->data ) );
    }

    public function testEmptyGarbageNullDataDoesntValidate() {
        $rule = new Rule\DateBefore( '1/1/13', 'm/d/y' );
        $this->_testEmptyDataDoesntValidate( $rule );
        $this->_testGarbageDataDoesntValidate( $rule );
        $this->_testNullDataDoesntValidate( $rule );
    }

}