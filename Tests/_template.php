<?php

use Validator\Validator;
use Validator\Rule;

require( '../../autoload.php' );
require_once( 'BaseRuleTest.php' );

class 1Test extends BaseRuleTest {

    protected $data = array(
        'valid'         => '',
        'invalid'       => ''
    );

    public function testValid() {
        $this->validator->addRule( 'valid', new Rule\ );
        $this->assertTrue( $this->validator->validate( $this->data ) );
    }

    public function testInvalid() {
        $this->validator->addRule( 'invalid', new Rule\ ) );
        $this->assertFalse( $this->validator->validate( $this->data ) );
    }

    public function testEmptyGarbageNullDataDoesntValidate() {
        $rule = new Rule\;
        $this->_testEmptyDataDoesntValidate( $rule );
        $this->_testGarbageDataDoesntValidate( $rule );
        $this->_testNullDataDoesntValidate( $rule );
    }

}