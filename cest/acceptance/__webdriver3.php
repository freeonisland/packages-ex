<?php

/**
     * init webdriver
     */
    public function setUp(): void
    {
        $desiredCapabilities = WebDriver\Remote\DesiredCapabilities::phantomjs();
        $desiredCapabilities->setCapability('trustAllSSLCertificates', true);
        $desiredCapabilities->setCapability('javascriptEnabled', true);
        $desiredCapabilities->setCapability('phantomjs.page.customHeaders.Authorization',  "Basic c3VwcG9ydC50bWFpZDokdVAzNGEyVyFuPg==");
        $desiredCapabilities->setCapability('phantomjs.page.windowHandleSize',  "width:480");
      
        $this->webDriver = WebDriver\Remote\RemoteWebDriver::create(
            'http://192.168.99.100:4444/wd/hub',
            $desiredCapabilities
        );
        $this->baseUrl = 'http://vip1:vip1@www.imagesdefense.fr/nos-collections/theme/societe.html';
        
        // Set window size to 800x600 px
        #https://github.com/php-webdriver/php-webdriver/wiki/Example-command-reference
        //$this->webDriver->manage()->window()->setSize(new WebDriver\WebDriverDimension(8000, 600));
        
        $this->webDriver->manage()->window()->maximize(); #300, 400
    }

    /**
     * Method testUntitledTestCase
     * @test
     */
    public function testRenaultSearch()
    {
        // open | https://www.imagesdefense.fr/nos-collections/theme/societe.html | 
        $this->webDriver->get("http://vip1:vip1@www.imagesdefense.fr/nos-collections/theme/societe.html");
        
        // click | id=search | 
        $this->webDriver->findElement(WebDriver\WebDriverBy::id("search"))->click();
        // type | id=search | char
        $this->webDriver->findElement(WebDriver\WebDriverBy::id("search"))->sendKeys("char");
        // submit | id=search_mini_form | 
        $this->webDriver->findElement(WebDriver\WebDriverBy::id("search_mini_form"))->submit();
        $this->shot(__DIR__.'/2.png');
        //error_log($this->webDriver->getPageSource(), 3, __DIR__.'/fail2.log');
        $this->waitXpath("//dl[@id='narrow-by-list']");
        // click | //dl[@id='narrow-by-list']/dd[5]/ol/li[7]/a/label | 
       // $this->webDriver->findElement(WebDriver\WebDriverBy::xpath("//dl[@id='narrow-by-list']/dd[5]/ol/li[7]/a/label"))->click();
        //$this->webDriver->findElement(WebDriver\WebDriverBy::xpath("//dl[@id='narrow-by-list']/dd[5]"));
       // codecept_debug(get_class_methods($this->webDriver->findElement(WebDriver\WebDriverBy::xpath("//dl[@id='narrow-by-list']/dd[5]"))));
        // click | id=refine_results_search | 
        /*$this->webDriver->findElement(WebDriver\WebDriverBy::id("refine_results_search"))->click();
        // type | id=refine_results_search | Renault
        $this->webDriver->findElement(WebDriver\WebDriverBy::id("refine_results_search"))->sendKeys("Renault");
        // submit | id=refine_results | 
        $this->webDriver->findElement(WebDriver\WebDriverBy::id("refine_results"))->submit();
        $this->waitXpath("//dl[@id='narrow-by-list']/dd[4]/ol/li[6]/a/label");
        // click | //dl[@id='narrow-by-list']/dd[4]/ol/li[6]/a/label | 
        $this->webDriver->findElement(WebDriver\WebDriverBy::xpath("//dl[@id='narrow-by-list']/dd[4]/ol/li[6]/a/label"))->click();
        $this->waitXpath("//dl[@id='narrow-by-list']/dd[5]/ol/li[3]/a/label");
        // click | //dl[@id='narrow-by-list']/dd[5]/ol/li[3]/a/label | 
        $this->webDriver->findElement(WebDriver\WebDriverBy::xpath("//dl[@id='narrow-by-list']/dd[5]/ol/li[3]/a/label"))->click();*/
    }



 - WebDriver:
            url: https://ima.fr
            browser: phantomjs
            host: sel
            port: 4444
            window_size: maximize #Initial window size. Set to maximize 
            capabilities: 
              #  acceptSslCerts: true
                trustAllSSLCertificates: true
                javascriptEnabled: true
                phantomjs.page.customHeaders.Authorization:  "Basic c3VwcG9yyFuPg==" #user:pass
