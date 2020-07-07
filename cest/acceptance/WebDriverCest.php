<?php

$capabilities = array(
            WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::PHANTOMJS,
            WebDriverCapabilityType::ACCEPT_SSL_CERTS=> true,
            WebDriverCapabilityType::JAVASCRIPT_ENABLED=>true,
            'phantomjs.page.customHeaders.Authorization' => "Basic " . base64_encode('u:p')
        );


#https://php-webdriver.github.io/php-webdriver/latest/Facebook/WebDriver/Remote/RemoteWebDriver.html

use Facebook\WebDriver;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;
use Facebook\WebDriver\Remote\WebDriverBrowserType;
use Facebook\WebDriver\Remote\RemoteWebDriver;

class WebDriverCest 
{
    /**
     * @var \RemoteWebDriver
     */
    protected $webDriver;
    protected $url = 'https://imagesdefense.fr';

    public function _before()
    {
        
       /* $capabilities = array(
            WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::PHANTOMJS, #WebDriverBrowserType::PHANTOMJS,
            WebDriverCapabilityType::ACCEPT_SSL_CERTS=> true,
            WebDriverCapabilityType::JAVASCRIPT_ENABLED=>true,
            #'phantomjs.page.customHeaders.Authorization' => "Basic " . base64_encode('support.tmaid:$uP34a2W!n>')
        );
            
        $this->webDriver = RemoteWebDriver::create('sel:4444/wd/hub', $capabilities); //192.168.16.2*/
        /*$this->webDriver->get($this->url);

        $desiredCapabilities = WebDriver\Remote\DesiredCapabilities::chrome();
        $desiredCapabilities->setCapability('trustAllSSLCertificates', true);
        $this->webDriver = WebDriver\Remote\RemoteWebDriver::create(
            $_SERVER['SELENIUM_HUB'],
            $desiredCapabilities
        );
        $this->baseUrl = $_SERVER['SELENIUM_BASE_URL'];*/
    }//--web-security=false --local-to-remote-url-access=true --ssl-protocol=any --ignore-ssl-errors=true.


    public function tryToGetHomeWebDriver(AcceptanceTester $I)
    {
        return;
        // $I->amOnPage('/');
        // $I->see('catalogue');

        // open | https://www.imagesdefense.fr/ | 
        $capabilities = array(
            WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::PHANTOMJS, #WebDriverBrowserType::PHANTOMJS,
            //WebDriverCapabilityType::ACCEPT_SSL_CERTS=> true,
            WebDriverCapabilityType::JAVASCRIPT_ENABLED=>true,
            'phantomjs.page.customHeaders.Authorization' => "Basic " . base64_encode('support.tmaid:$uP34a2W!n>')
        );
            
        $this->webDriver = RemoteWebDriver::create('sel:4444/wd/hub', $capabilities); //192.168.16.2

       # $this->webDriver->get("https://www.imagesdefense.fr/");
       $this->webDriver->get('https://support.tmaid:$uP34a2W!n>@imagesdefense.fr');
       

        echo 'e';
        var_dump( $this->webDriver->getTitle() ); 
        echo 'r';

        // click | link=› Recherche avancée | 
        $this->webDriver->findElement(WebDriver\WebDriverBy::linkText("› Recherche avancée"))->click();
        // click | //div[@id='type_filter_chosen']/ul | 
        $this->webDriver->findElement(WebDriver\WebDriverBy::xpath("//div[@id='type_filter_chosen']/ul"))->click();
        // click | //div[@id='type_filter_chosen']/div/ul/li[3] | 
        $this->webDriver->findElement(WebDriver\WebDriverBy::xpath("//div[@id='type_filter_chosen']/div/ul/li[3]"))->click();
        // click | //form[@id='form-validate']/div[3]/button/span/span | 
        $this->webDriver->findElement(WebDriver\WebDriverBy::xpath("//form[@id='form-validate']/div[3]/button/span/span"))->click();

        var_dump( $this->webDriver->getContent() ); 

        $this->webDriver->close();
    }    

    public function tryToGetHomeAcceptance(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('produire');
    }    


    public function _after()
    {
       
    }
}