<?php

use Validator\Validator;
use Validator\Rule;

require( '../../autoload.php' );
require_once( 'BaseRuleTest.php' );

class ValidatorTest extends BaseRuleTest {

    protected $validator;

    protected function setUp() {
        $this->validator = new Validator;
    }

    public function testAddRule() {
        $this->validator->addRule( 'email', new Rule\Email );
    }

    public function testAddRuleInvalidLabel() {
        $this->setExpectedException( 'InvalidArgumentException' );
        $this->validator->addRule( '', new Rule\Email );
    }

}