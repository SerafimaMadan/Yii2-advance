<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class FirstCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }
/**
  * @example(url="site/about", h1="About")
 * @example(url="site/contact", h1="Contact")
 * @example(url="site/signup", h1="Signup")
 * @example(url="/", h1="Congratulations")
 * @dataProvider dataProvider
 */
    // tests
    public function tryToTest(FunctionalTester $I, \Codeception\Example $data)
    {
        $I->amOnPage($data['url']);
        $I->see($data['h1'],'h1');

    }

    protected function dataProvider() // alternatively, if you want the function to be public, be sure to prefix it with `_`
    {
        return [
            ['url'=>"site/about", 'h1'=>"About"],
            ['url'=>"site/contact", 'h1'=>"Contact"],
            ['url'=>"site/signup", 'h1'=>"Signup"],
            ['url'=>"/", 'h1'=>"Congratulations"]
        ];
    }

}
