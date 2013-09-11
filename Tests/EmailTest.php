<?php

use Validator\Validator;
use Validator\Rule;

require( '../../autoload.php' );
require_once( 'BaseRuleTest.php' );

class EmailTest extends BaseRuleTest {

    protected $data = array(
        'valid'         => 'email@email.com',
        'valid_plus'    => 'email+plus@email.com',
        'invalid'       => 'email@email'
    );

    public function testValid() {
        $this->validator->addRule( 'valid', new Rule\Email );
        $this->assertTrue( $this->validator->validate( $this->data ) );
    }

    public function testValidWithPlus() {
        $this->validator->addRule( 'valid_plus', new Rule\Email );
        $this->assertTrue( $this->validator->validate( $this->data ) );
    }

    public function testInvalid() {
        $this->validator->addRule( 'invalid', new Rule\Email );
        $this->assertFalse( $this->validator->validate( $this->data ) );
    }

    public function testEmptyGarbageNullDataDoesntValidate() {
        $rule = new Rule\Email;
        $this->_testEmptyDataDoesntValidate( $rule );
        $this->_testGarbageDataDoesntValidate( $rule );
        $this->_testNullDataDoesntValidate( $rule );
    }

}