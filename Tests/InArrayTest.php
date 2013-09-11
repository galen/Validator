<?php

use Validator\Validator;
use Validator\Rule;

require( '../../autoload.php' );
require_once( 'BaseRuleTest.php' );

class InArrayTest extends BaseRuleTest {

    protected $data = array(
        'valid'         => 'a',
        'valid_array'   => array( 1, 2, 3 ),
        'valid_null'    => null,
        'invalid'       => '1',
        ''
    );

    public function testValid() {
        $this->validator->addRule( 'valid', new Rule\InArray( array( 'a', 'b', 'c' ) ) );
        $this->validator->addRule( 'valid', new Rule\InArray( array( 'a', 'b', 'c', array( 1, 2, 3 ) ) ) );
        $this->validator->addRule( 'valid', new Rule\InArray( array( 'a', 'b', 'null' ) ) );
        $this->assertTrue( $this->validator->validate( $this->data ) );
    }

    public function testInvalid() {
        $this->validator->addRule( 'invalid', new Rule\InArray( array( 'a', 'b', 'c' ) ) );
        $this->assertFalse( $this->validator->validate( $this->data ) );
    }

    public function testEmptyArray() {
        $this->setExpectedException( 'InvalidArgumentException' );
        $this->validator->addRule( 'invalid', new Rule\InArray( array() ) );
        $this->assertFalse( $this->validator->validate( $this->data ) );
    }

    public function testEmptyGarbageNullDataDoesntValidate() {
        $rule = new Rule\Inarray( Array( '1', 2, '3' ) );
        $this->_testEmptyDataDoesntValidate( $rule );
        $this->_testGarbageDataDoesntValidate( $rule );
        $this->_testNullDataDoesntValidate( $rule );
    }

}