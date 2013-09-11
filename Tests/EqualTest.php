<?php

use Validator\Validator;
use Validator\Rule;

require( '../../autoload.php' );
require_once( 'BaseRuleTest.php' );

class EqualTest extends BaseRuleTest {

    protected $data = array(
        'valid_int'         => 3,
        'valid_float'       => 3.23,
        'valid_int_float'   => 3.0,
        'valid_array'       => array( '1', 2, 'three' ),
        'valid_null'        => null,
        'valid_empty'       => '',
        'invalid'           => null,
        'invalid_int_float' => 3.0
    );

    public function testValid() {
        $this->validator->addRule( 'valid_int', new Rule\Equal( 3 ) );
        $this->validator->addRule( 'valid_float', new Rule\Equal( 3.23 ) );
        $this->validator->addRule( 'valid_int_float', new Rule\Equal( 3 ) );
        $this->validator->addRule( 'valid_array', new Rule\Equal( array( '1', 2, 'three' ) ) );
        $this->validator->addRule( 'valid_null', new Rule\Equal( null ) );
        $this->validator->addRule( 'valid_empty', new Rule\Equal( '' ) );
        $this->assertTrue( $this->validator->validate( $this->data ) );
        
    }

    public function testInvalid() {
        $this->validator->addRule( 'invalid', new Rule\Equal( 3 ) );
        $this->validator->addRule( 'invalid_int_float', new Rule\Equal( 3, true ) );
        $this->assertFalse( $this->validator->validate( $this->data ) );
    }

    public function testEmptyGarbageNullDataDoesntValidate() {
        $rule = new Rule\Equal( 3 );
        $this->_testEmptyDataDoesntValidate( $rule );
        $this->_testGarbageDataDoesntValidate( $rule );
        $this->_testNullDataDoesntValidate( $rule );
    }

}