<?php

use Validator\Validator;
use Validator\Rule;

require( '../../autoload.php' );
require_once( 'BaseRuleTest.php' );

class LengthTest extends BaseRuleTest {

    protected $data = array(
        'valid'         => 'three',
        'valid_empty'   => '',
        'invalid'       => 'four',
    );

    public function testValid() {
        $this->validator->addRule( 'valid', new Rule\Length( 5 ) );
        $this->validator->addRule( 'valid_empty', new Rule\Length( 0 ) );
        $this->assertTrue( $this->validator->validate( $this->data ) );
    }

    public function testInvalid() {
        $this->validator->addRule( 'invalid', new Rule\Length( 3 ) );
        $this->assertFalse( $this->validator->validate( $this->data ) );
    }

    public function testNonNumber() {
        $this->setExpectedException( 'InvalidArgumentException' );
        $rule = new Rule\Length( array( 1 ) );
    }

    public function testNegativeNumber() {
        $this->setExpectedException( 'InvalidArgumentException' );
        $rule = new Rule\MaxLength( -1 );
    }

    public function testEmptyGarbageNullDataDoesntValidate() {
        $rule = new Rule\Length( 23 );
        $this->_testEmptyDataDoesntValidate( $rule );
        $this->_testGarbageDataDoesntValidate( $rule );
        $this->_testNullDataDoesntValidate( $rule );
    }

}