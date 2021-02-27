<?php

/**
 * Use SeleniumRC to control the browser
 * Uses singleton pattern
 */
class BrowserController {

    static $instance;

    static $selenium;

    static $started = false;

    /**
     * We don't permit an explicit call of the constructor! (like $controller = new BrowserController())
     *
     * @return void
     */
    private function __construct() {
    }

    /**
     * We don't permit cloning the singleton (like $browserController = clone $controller)
     *
     * @return void
     */
    private function __clone() {
    }

    /**
     * Return the instance of BrowserController
     *
     * @param String $browser browser to be launched (default : Firefox)
     *
     * @return BrowserController
     */
    function getInstance($browser = "*firefox") {
        if (self::$instance === null) {
            self::$instance = new self();
            self::$selenium = new Testing_Selenium($browser, $GLOBALS['host']);
        }
        self::start();
        return self::$instance;
    }

    /**
     * Return the SeleniumRC controller instance
     *
     * @return Testing_Selenium
     */
    function getSelenium() {
        return self::$selenium;
    }

    /**
     * Launch the browser
     *
     * @return void
     */
    function start() {
        if (!self::$started) {
            self::$selenium->start();
        }
        self::$started = true;
    }

    /**
     * Close the browser
     *
     * @return void
     */
    function stop() {
        if (self::$started) {
            self::$selenium->stop();
        }
        self::$started = false;
    }

    /**
     * In case there is no login for the current session authenticate
     *
     * @return void
     */
    function login() {
        self::$selenium->open("/");
        self::$selenium->waitForPageToLoad("30000");
        $loggedIn = self::$selenium->isTextPresent("Logged In:");
        if (!$loggedIn) {
            self::$selenium->open("/account/login.php");
            self::$selenium->waitForPageToLoad("30000");
            self::$selenium->type("form_loginname", $GLOBALS['user']);
            self::$selenium->type("form_pw", $GLOBALS['password']);
            self::$selenium->click("login");
            self::$selenium->waitForPageToLoad("30000");
        }
    }

}

?>