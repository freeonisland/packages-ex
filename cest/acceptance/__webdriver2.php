<?php

DOCKER------------
sel:
        image: nkovacs/selenium-standalone-phantomjs
        restart: always
        ports:
            - 4444:4444
            - 5900:5900
        networks: 
            - web

PHP------------
$capabilities = array(
            WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::PHANTOMJS, #WebDriverBrowserType::PHANTOMJS,
            WebDriverCapabilityType::ACCEPT_SSL_CERTS=> true,
            WebDriverCapabilityType::JAVASCRIPT_ENABLED=>true,
            'phantomjs.page.customHeaders.Authorization' => "Basic " . base64_encode('user:pass')
        );
            
        $this->webDriver = RemoteWebDriver::create('sel:4444/wd/hub', $capabilities); 

CODECEPTION------------------
    enabled:
        - \Helper\Acceptance
        - WebDriver:
            url: 'https://imagesdefense.fr' #user:pass
            browser: phantomjs
            host: sel
            port: 4444
            capabilities: 
              #  acceptSslCerts: true
                trustAllSSLCertificates: true
                javascriptEnabled: true
                phantomjs.page.customHeaders.Authorization:  "Basic c3VwcG9ydC50bWFpZDokdVAzNGEyVyFuPg==" #base64_encode('user:pass')



<?php
// Your code here!

/*
<?php

#https://php-webdriver.github.io/php-webdriver/latest/Facebook/WebDriver/Remote/RemoteWebDriver.html

use Facebook\WebDriver;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;
use Facebook\WebDriver\Remote\WebDriverBrowserType;
use Facebook\WebDriver\Remote\RemoteWebDriver;

class WebDriverCest 
{
    /**
     * @var \RemoteWebDriver
     *
    protected $webDriver;
    protected $url = 'https://imagesdefense.fr';

    public function _before()
    {
        $capabilities = array(
            WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::PHANTOMJS,
            WebDriverCapabilityType::ACCEPT_SSL_CERTS=> true,
            WebDriverCapabilityType::JAVASCRIPT_ENABLED=>true,
            'phantomjs.page.customHeaders.Authorization' => "Basic " . base64_encode('support.tmaid:$uP34a2W!n>')
        );
            
        $this->webDriver = RemoteWebDriver::create('sel:4444/wd/hub', $capabilities); //192.168.16.2
        /*$this->webDriver->get($this->url);

        $desiredCapabilities = WebDriver\Remote\DesiredCapabilities::chrome();
        $desiredCapabilities->setCapability('trustAllSSLCertificates', true);
        $this->webDriver = WebDriver\Remote\RemoteWebDriver::create(
            $_SERVER['SELENIUM_HUB'],
            $desiredCapabilities
        );
        $this->baseUrl = $_SERVER['SELENIUM_BASE_URL'];*
    }//--web-security=false --local-to-remote-url-access=true --ssl-protocol=any --ignore-ssl-errors=true.


/**
     * @var \RemoteWebDriver
     *
    protected $webDriver;
    protected $url = 'https://user:pass@imagesdefense.fr';
    public function setUp(): void
    {
        $capabilities = array(WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::PHANTOMJS,
            WebDriverCapabilityType::ACCEPT_SSL_CERTS=> true,
            WebDriverCapabilityType::JAVASCRIPT_ENABLED=>true);
        $this->webDriver = RemoteWebDriver::create('172.21.0.3:4444/wd/hub', $capabilities); //192.168.16.2
    }//--web-security=false --local-to-remote-url-access=true --ssl-protocol=any --ignore-ssl-errors=true.
    public function testHome()
    {
        $this->webDriver->get($this->url);
        $this->assertStringContainsString("valoriser les archives audiovisuelles", $this->webDriver->getPageSource());
        /*$this->webDriver->switchTo()->alert()->sendKeys('User test'); // enter text
        $this->webDriver->switchTo()->alert()->accept(); // submit
        $this->assertStringContainsString("extraites", $this->webDriver->getTitle());*
    }    

    public function tryToGetHome()
    {
        // open | https://www.imagesdefense.fr/ | 
        $this->webDriver->get("https://www.imagesdefense.fr/");
        // click | link=› Recherche avancée | 
        $this->webDriver->findElement(WebDriver\WebDriverBy::linkText("› Recherche avancée"))->click();
        // click | //div[@id='type_filter_chosen']/ul | 
        $this->webDriver->findElement(WebDriver\WebDriverBy::xpath("//div[@id='type_filter_chosen']/ul"))->click();
        // click | //div[@id='type_filter_chosen']/div/ul/li[3] | 
        $this->webDriver->findElement(WebDriver\WebDriverBy::xpath("//div[@id='type_filter_chosen']/div/ul/li[3]"))->click();
        // click | //form[@id='form-validate']/div[3]/button/span/span | 
        $this->webDriver->findElement(WebDriver\WebDriverBy::xpath("//form[@id='form-validate']/div[3]/button/span/span"))->click();
    }    

    public function _after()
    {
        $this->webDriver->close();
    }
}


*/


selenium

/**
 * firefox:
        image: selenium/node-firefox:3.4.0
        # volumes:
        #     - /dev/shm:/dev/shm
        depends_on:
            - hub
        
        environment:
            HUB_HOST: hub
            HUB_PORT_4444_TCP_ADDR: hub
            HUB_PORT_4444_TCP_PORT: 4444
    chrome:
        image: selenium/node-chrome:3.4.0
        # volumes:
        #     - /dev/shm:/dev/shm
        depends_on:
            - hub
        
        environment:
            HUB_HOST: hub
            HUB_PORT_4444_TCP_ADDR: hub
            HUB_PORT_4444_TCP_PORT: 4444
    hub:
        image: selenium/hub:3.4.0
        ports:
            - 4444:4444
 */


/**
 return value

$this->start(9999)->shouldBeString();
$hash = $this->start(9999)->getWrappedObject();

*/

- WebDriver:
        url: https://u:p@imagesdefense.fr
        browser: phantomjs
        host: sel
        port: 4444

$capabilities = array(
            WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::PHANTOMJS,
            WebDriverCapabilityType::ACCEPT_SSL_CERTS=> true,
            WebDriverCapabilityType::JAVASCRIPT_ENABLED=>true,
            'phantomjs.page.customHeaders.Authorization' => "Basic " . base64_encode('u:p')
        );


actor: AcceptanceTester
modules:
    enabled:
        - \Helper\Acceptance
        - WebDriver:
            url: https://imagesdefense.fr
            browser: phantomjs
            host: sel
            port: 4444
            capabilities: 
              #  acceptSslCerts: true
                trustAllSSLCertificates: true
                javascriptEnabled: true
                phantomjs.page.customHeaders.Authorization:  "Basic c3VwcG9ydC50bWFpZDokdVAzNGEyVyFuPg=="
