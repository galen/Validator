<?php

use Validator\Validator;
use Validator\Rule;

require( '../../autoload.php' );
require_once( 'BaseRuleTest.php' );

class MinLengthTest extends BaseRuleTest {

    protected $data = array(
        'valid'         => 'three',
        'valid_empty'   => '',
        'invalid'       => 'four',
    );

    public function testValid() {
        $this->validator->addRule( 'valid', new Rule\MinLength( 3 ) );
        $this->validator->addRule( 'valid_empty', new Rule\MinLength( 0 ) );
        $this->assertTrue( $this->validator->validate( $this->data ) );
    }

    public function testInvalid() {
        $this->validator->addRule( 'invalid', new Rule\MinLength( 5 ) );
        $this->assertFalse( $this->validator->validate( $this->data ) );
    }

    public function testNonNumber() {
        $this->setExpectedException( 'InvalidArgumentException' );
        $rule = new Rule\MinLength( array( 1 ) );
    }

    public function testNegativeNumber() {
        $this->setExpectedException( 'InvalidArgumentException' );
        $rule = new Rule\MinLength( -1 );
    }

}