<?php

use Validator\Validator;
use Validator\Rule;

require( '../../autoload.php' );
require_once( 'BaseRuleTest.php' );

class NotEmptyTest extends BaseRuleTest {

    protected $data = array(
        'valid'         => 'not asd',
        'invalid_array'   => array(),
        'invalid_null'    => null,
        'invalid'       => ''
    );

    public function testValid() {
        $this->validator->addRule( 'valid', new Rule\NotEmpty );
        $this->assertTrue( $this->validator->validate( $this->data ) );
    }

    public function testInvalid() {
        $this->validator->addRule( 'invalid', new Rule\NotEmpty );
        $this->validator->addRule( 'invalid_array', new Rule\NotEmpty );
        $this->validator->addRule( 'invalid_null', new Rule\NotEmpty );
        $this->assertFalse( $this->validator->validate( $this->data ) );
    }

}