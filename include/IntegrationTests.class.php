<?php
require_once('CustomHtmlReporter.class.php');
require_once 'BrowserController.class.php';
#require_once 'simpletest/unit_tester.php';
require_once 'set.php';

/**
 * Class that launches selected tests
 */
class IntegrationTests {#extends TestSuite {

    /**
     * Add given files to the test suite
     *
     * @param Array $files array of file path of tests to add to test suite
     *
     * @return void
     */
    function addFiles($files) {
        if (file_exists('../log/last_run')) {
            rename('../log/last_run', '../log/integration_tests_'.time());
        }
        $fp = fopen('../log/last_run', 'a');
        fwrite($fp, "Run on ".date('l jS \of F Y h:i:s A')."\n");
        foreach ($files as $file) {
            #$this->addFile($file);
            fwrite($fp, basename($file)."\n");
        }
        fclose($fp);
    }

    /**
     * Run the test suite then close the browser
     *
     * @return void
     * @static
     *
     * @see simpletest/TestSuite::run()
     */
    static function run(&$reporter) {
        #parent::run($reporter);
        BrowserController::stop();
    }

}

?>