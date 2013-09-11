<?php

use Validator\Validator;
use Validator\Rule;

require( '../../autoload.php' );
require_once( 'BaseRuleTest.php' );

class DateTest extends BaseRuleTest {

    protected $data = array(
        'valid'         => '1/1/13',
        'invalid'       => '2/31/13'
    );

    public function testValid() {
        $this->validator->addRule( 'valid', new Rule\Date( 'm/d/y' ) );
        $this->assertTrue( $this->validator->validate( $this->data ) );
    }

    public function testInvalid() {
        $this->validator->addRule( 'invalid', new Rule\Date( 'm/d/y' ) );
        $this->assertFalse( $this->validator->validate( $this->data ) );
    }

    public function testInvalidFormat() {
        $this->setExpectedException( 'InvalidArgumentException' );
        $this->validator->addRule( 'invalid', new Rule\Date( '' ) );
        $this->assertFalse( $this->validator->validate( $this->data ) );
    }

    public function testEmptyGarbageNullDataDoesntValidate() {
        $rule = new Rule\Date( 'm/d/y' );
        $this->_testEmptyDataDoesntValidate( $rule );
        $this->_testGarbageDataDoesntValidate( $rule );
        $this->_testNullDataDoesntValidate( $rule );
    }

}