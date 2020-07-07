<?php
 
class HomePageCest
{
    public function _before(AcceptdriverTester $I)
    {
        $I->amOnPage('/');
    }

    protected function _inject(\Helper\SignUp $signUp, \Helper\NavBar $navBar)
    {
        $this->signUp = $signUp;
        $this->navBar = $navBar;
    }

    /**
     * ref: https://codeception.com/docs/03-AcceptanceTests
     */
    public function tryAccessLinks(AcceptdriverTester $I)
    {
        $I->see('testing');
        #$I->pause();
        ### SCREENSHOT ###
        #$I->makeHtmlSnapshot();
        #$I->makeScreenshot(); #webdriver only
        ### LINKS ###
        #[id,name,css,xpath,link,class] => 'text displayed'
        #link(text), button(value,name,text), image(alt)
        // label displayed, not in html
        $I->click(["link" => "QUICK START"]); #link in the home page, button in uppercase 
        $I->click(["link" => "CODECEPTION_"]); #click on logo
        $I->click("/html/body/div[2]/div/div/div/div/a[1]"); #link in the home page button in uppercase 
        $I->click(["link" => "quickstart"]); #click on the top menu link
        $I->click("QuickStart"); #click on element on HTML source
        $I->click("A Complete Getting Started Guide");
    }

    /**
     * ref: https://codeception.com/docs/03-AcceptanceTests
     */
    public function tryAccessSee(AcceptdriverTester $I)
    {
        $I->amOnPage('docs/02-GettingStarted');

        ### SEE ###
        $I->see("Syntax"); #different with PhpBrowser (exists on html source)
        $I->seeElement("#getting-started");
        $I->dontSee("Bad text in this page");
        $I->dontSeeElement('.error');


        $startedPage->checkSyntax(); #put all this validations into a pageobject

        //codecept_debug($I->customhelper_getCurrentUrl()); #with codecept --debug
        $I->seeInCurrentUrl('docs/02-GettingStarted');
        $text = $I->grabTextFrom('h1#getting-started');
        #$api_key = $I->grabValueFrom('input[name=api]');
        #codecept_debug($text);
        #CONDITIONAL
        #$I->canSeeInCurrentUrl('not/exists/but/will/continue'); #maybe or not
        #SILENCE
        #step_decorators:  
        #    - \Codeception\Step\TryTo 
        # in acceptance.suite.yml then "bin/codecept build"
        $I->tryToClick('X', '.alert_popup_if_exists'); 
        #$I->seeCheckboxIsChecked('#agree');
        $I->seeInField('query', '');
        $I->seeLink('The Codeception Syntax');
        $I->see("Getting Started"); #different with PhpBrowser (exists on html source)
        $I->seeInTitle('Codeception');
        $I->dontSeeInTitle('Login');
        #$I->wait(1);
        $I->waitForElement(['css' => 'h1#getting-started'], 5);
        $I->waitForElement("h1#getting-started", 5); #WebDriver only
        $I->seeElement("h1#getting-started"); #WebDriver only, visible for user
        $I->seeCurrentUrlEquals('/docs/02-GettingStarted');
        $I->seeCurrentUrlMatches('/(\d+)-Getting/');
        $I->seeInCurrentUrl('02-');
        $user_id = $I->grabFromCurrentUrl('/(\d+)-Getting/');
    }

    /**
     * add use \Codeception\Lib\Actor\Shared\Friend; 
     * in cept\_support\AcceptdriverTester.php
     */
    public function tryAccessMultipleWindows(AcceptdriverTester $I)
    {
        ### COOKIES ###
        $I->setCookie('auth', '123345');
        $I->grabCookie('auth');
        $I->seeCookie('auth');
        
        $client = $I->haveFriend('client');
        $client->does(function(AcceptdriverTester $I) {
            $I->amOnPage('/docs/02-GettingStarted#Debugging');
            $I->fillField('query', 'data');
            #$I->click('Send');
            $I->see('Search', 'h1.page-title');
        });
    }

    /**
     * ref: https://codeception.com/docs/03-AcceptanceTests
     */
    public function tryAccessForms(AcceptdriverTester $I)
    {
        $I->amOnPage("/docs/02-GettingStarted");
        ### FORMS ###
        $I->fillField('query', 'data'); // we can use input name or id
        #$I->selectOption('name','option');
        #$I->fillField('password', new \Codeception\Step\Argument\PasswordArgument('thisissecret'));
        #$I->click('Update');
        /*$I->performOn('.modal_windows', function(\Codeception\Module\WebDriver $I) {
            $I->see('Warning');
            $I->see('Are you sure you want to delete this?');
            $I->click('Yes');
        });*/
        // send 
        // $I->submitForm('#update_form', 
        //     array('user' => [
        //         'name' => 'Miles',
        //         'email' => 'Davis',
        //         'gender' => 'm',
        //         'submitButton' => 'Update'
        //     ])
        // , 'submitButton');
    }

    public function _failed(\AcceptanceTester $I)
    {
        // will be executed on test failure
    }
    
    public function _passed(\AcceptanceTester $I)
    {
        // will be executed when test is successful
    }
}
```

codeception.yml
```
settings:
    shuffle: true
```

or
```
codecept run -o "settings: shuffle: true"
```

GROUPS
```
/**
 * @group admin
 */
//
// @group editor (Cept files)

cordeception.yml
groups:
    # add 2 tests to db group
    db: [cept/acceptdriver]
```


```
<?php
namespace Page\Acceptdriver;
class Started
{
    // include url of current page
    public static $URL = 'docs/02-GettingStarted#Debugging';
    public $header = 'h1#getting-started';
    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }
    /**
     * @var \AcceptdriverTester;
     */
    protected $acceptdriverTester;
    public function __construct(\AcceptdriverTester $I)
    {
        $this->acceptdriverTester = $I;
    }
    public function checkSyntax()
    {
        $I = $this->acceptdriverTester;
        $I->see("Syntax"); #different with PhpBrowser (exists on html source)
        $I->seeElement($this->header);
        $I->dontSee("Bad text in this page");
        $I->dontSeeElement('.error');
    }
}
```



2




```
<?php 
namespace acceptdriver;
class HomePageCest
{
    /*
wantToTest($text)  
wantTo($text) 
execute($callable) 
expectTo($prediction) 
expect($prediction)
amGoingTo($argumentation) 
am($role) 
lookForwardTo($achieveValue) 
comment($description) 
pause()
 amOnPage() 
 fillField('Username','davert') 
 click('Login') 
 see('Hello, davert') 
 dontSee() 
 $I->seeElement('.notice')  
 seeNumberOfElements(['css' => 'button.link'], 5)
 seeInCurrentUrl('/user/miles') 
 seeCheckboxIsChecked('#agree') 
 seeInField('user[name]', 'Miles') 
 seeLink('Login');
 CONDIT° NO FAIL(config) 
    canSeeInCurrentUrl('/user/miles') 
    canSeeCheckboxIsChecked('#agree') 
    cantSeeInField('user[name]', 'Miles')
    (config:\Codeception\Step\TryTo)    
    
    $I->tryToClick('x', '.alert');  
    $I->tryToSeeElement('.alert')
 seeInTitle() 
 seeCurrentUrlEquals() 
 seeCurrentUrlMatches() 
 seeInCurrentUrl() 
 $user_id = $I->grabFromCurrentUrl('~^/user/(\d+)/~');
 - WebDriver
 wait(3) 
$I->loadSessionSnapshot('login') 
saveSessionSnapshot('login')  Codeception\Lib\Interfaces\SessionSnapshot
 Helper Webdriver: _initializeSession  _closeSession  _restart  _capabilities 
     */

/**
* phpbrowser api: https://codeception.com/docs/modules/PhpBrowser
* webdriver: https://codeception.com/docs/modules/WebDriver
*/
    public function _before(\AcceptdriverTester $I)
    {
        $I->amOnPage('/');
        /**
         * in: cept\_support\AcceptdriverTester.php
         */
        $I->_customActor_seeThatInTitle('database testing');
    }

    /**
     * ref: https://codeception.com/docs/03-AcceptanceTests
     */
    public function tryAccessLinks(\AcceptdriverTester $I)
    {return;
        $I->see('testing');
        #$I->pause();
        ### SCREENSHOT ###
        #$I->makeHtmlSnapshot();
        #$I->makeScreenshot(); #webdriver only
        ### LINKS ###
        #[id,name,css,xpath,link,class] => 'text displayed'
        #link(text), button(value,name,text), image(alt)
        // label displayed, not in html
        $I->click(["link" => "QUICK START"]); #link in the home page, button in uppercase 
        $I->click(["link" => "CODECEPTION_"]); #click on logo
        $I->click("/html/body/div[2]/div/div/div/div/a[1]"); #link in the home page button in uppercase 
        $I->click(["link" => "quickstart"]); #click on the top menu link
        $I->click("QuickStart"); #click on element on HTML source
        $I->click("A Complete Getting Started Guide");
    }
    /**
     * ref: https://codeception.com/docs/03-AcceptanceTests
     * 
     * @depends tryAccessLinks
     */
    public function tryAccessSee(\AcceptdriverTester $I, \Page\Acceptdriver\Started $startedPage, \Step\Acceptdriver\Admin $I_from_step)
    {
        $I->lookForwardTo('Test seeing');
        $I->amOnPage('docs/02-GettingStarted');
        ### SEE ###
        /**
         * Custom generate:Page
         */
        $startedPage->checkSyntax(); #put all this validations into a pageobject
        /*$I->see("Syntax"); #different with PhpBrowser (exists on html source)
        $I->seeElement("#getting-started");
        $I->dontSee("Bad text in this page");
        $I->dontSeeElement('.error');*/
        //codecept_debug($I->customhelper_getCurrentUrl()); #with codecept --debug
        /**
         * Custom generate:Step
         */
        $I_from_step->validate();
        $I->seeInCurrentUrl('docs/02-GettingStarted');
        $text = $I->grabTextFrom('h1#getting-started');
        #$api_key = $I->grabValueFrom('input[name=api]');
        #codecept_debug($text);
        #CONDITIONAL
        #$I->canSeeInCurrentUrl('not/exists/but/will/continue'); #maybe or not
        #SILENCE
        #step_decorators:  
        #    - \Codeception\Step\TryTo 
        # in acceptance.suite.yml then "bin/codecept build"
        $I->tryToClick('X', '.alert_popup_if_exists'); 
        #$I->seeCheckboxIsChecked('#agree');
        $I->seeInField('query', '');
        $I->seeLink('The Codeception Syntax');
        $I->see("Getting Started"); #different with PhpBrowser (exists on html source)
        $I->seeInTitle('Codeception');
        $I->dontSeeInTitle('Login');
        #$I->wait(1);
        $I->waitForElement(['css' => 'h1#getting-started'], 5);
        $I->waitForElement("h1#getting-started", 5); #WebDriver only
        $I->seeElement("h1#getting-started"); #WebDriver only, visible for user
        $I->seeCurrentUrlEquals('/docs/02-GettingStarted');
        $I->seeCurrentUrlMatches('/(\d+)-Getting/');
        $I->seeInCurrentUrl('02-');
        $user_id = $I->grabFromCurrentUrl('/(\d+)-Getting/');
        /**
         * Loaded in acceptancedriver.suite.yml 
         *      - \Helper\Acceptdriver
         * in: cept\_support\Helper\Acceptdriver.php
         *      return $this->getModule('WebDriver')->_getCurrentUri();
         */
        $url = $I->customhelper_getCurrentUrl(); #$this->assertNotEmpty($url);
    }
    /**
     * add use \Codeception\Lib\Actor\Shared\Friend; 
     * in cept\_support\AcceptdriverTester.php
     */
    public function tryAccessMultipleWindows(\AcceptdriverTester $I)
    {return;
        ### COOKIES ###
        $I->setCookie('auth', '123345');
        $I->grabCookie('auth');
        $I->seeCookie('auth');
        $client = $I->haveFriend('client');
        $client->does(function(\AcceptdriverTester $I) {
            $I->amOnPage('/docs/02-GettingStarted#Debugging');
            $I->fillField('query', 'data');
            #$I->click('Send');
            $I->see('Search', 'h1.page-title');
        });
    }

    /**
     * ref: https://codeception.com/docs/03-AcceptanceTests
     */
    public function tryAccessForms(\AcceptdriverTester $I)
    {return;
        $I->amOnPage("/docs/02-GettingStarted");
        ### FORMS ###
        $I->fillField('query', 'data'); // we can use input name or id
        #$I->selectOption('name','option');
        #$I->fillField('password', new \Codeception\Step\Argument\PasswordArgument('thisissecret'));
        #$I->click('Update');
        /*$I->performOn('.modal_windows', function(\Codeception\Module\WebDriver $I) {
            $I->see('Warning');
            $I->see('Are you sure you want to delete this?');
            $I->click('Yes');
        });*/
        // send 
        // $I->submitForm('#update_form', 
        //     array('user' => [
        //         'name' => 'Miles',
        //         'email' => 'Davis',
        //         'gender' => 'm',
        //         'submitButton' => 'Update'
        //     ])
        // , 'submitButton');
    }
}
