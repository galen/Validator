<?php

use Validator\Validator;
use Validator\Rule;

abstract class BaseRuleTest extends PHPUnit_Framework_TestCase {

    protected $validator;

    protected function setUp() {
        $this->validator = new Validator;
    }

    protected function _testEmptyDataDoesntValidate( \Validator\Rule $rule ) {
        $this->validator->addRule( 'empty', $rule );
        $this->assertFalse( $this->validator->validate( array( 'empty' => '' ) ) );
    }

    protected function _testGarbageDataDoesntValidate( \Validator\Rule $rule ) {
        $this->validator->addRule( 'garbage', $rule );
        $this->assertFalse( $this->validator->validate( array( 'garbage' => 'lkajsdflkasdjflk;adjslk;' ) ) );
    }

    protected function _testNullDataDoesntValidate( \Validator\Rule $rule ) {
        $this->validator->addRule( 'null', $rule );
        $this->assertFalse( $this->validator->validate( array( 'null' => null ) ) );
    }

}