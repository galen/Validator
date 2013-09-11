<?php

use Validator\Validator;
use Validator\Rule;

require( '../../autoload.php' );
require_once( 'BaseRuleTest.php' );

class RegexTest extends BaseRuleTest {

    protected $data = array(
        'valid'         => '23',
        'invalid'       => 'hello'
    );

    public function testValid() {
        $this->validator->addRule( 'valid', new Rule\Regex( '~\d+~' ) );
        $this->assertTrue( $this->validator->validate( $this->data ) );
    }

    public function testInvalid() {
        $this->validator->addRule( 'invalid', new Rule\Regex( '~\d+~' ) );
        $this->assertFalse( $this->validator->validate( $this->data ) );
    }

    public function testInvalidPattern() {
        $this->setExpectedException( 'InvalidArgumentException' );
        $rule = new Rule\Regex( '~invalid' );
    }

}