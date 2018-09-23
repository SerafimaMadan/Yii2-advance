<?php
namespace frontend\tests;

class FirstTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
          $a=2;
          $this->assertEquals($a, 2);
        $a=5;
        $this->assertEquals($a, 5);
        $a=2;
        $this->assertEquals($a, 6);
    }
}