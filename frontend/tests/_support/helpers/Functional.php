<?php
namespace frontend\tests\helpers;

class Functional extends \Codeception\Module
{
    public function equals ($value, $expected, $messages = ""){
        $this->assertEquals($value, $expected, $messages);
    }
    public function equalsNot ($value, $expected, $messages = ""){
        $this->assertNotEquals($value, $expected, $messages);
    }
    public function equalsNot1 ($value, $expected, $messages = ""){
        $this->assertNotEquals($value, $expected, $messages);
    }
}