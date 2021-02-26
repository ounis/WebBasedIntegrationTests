<?php
require_once 'simpletest/autorun.php';
require_once 'IntegrationTests.class.php';

/**
 * This class runs all available tests.
 */
class AllTests extends IntegrationTests {

    /**
     * Constructor of the class
     *
     * @return void
     */
    function AllTests() {
        $this->TestSuite('Selenium Test Suite');
        $this->addFiles('../tests');
    }

    /**
     * Collect all tests that are under tests directory
     *
     * @param String $path tests directory
     *
     * @return void
     */
    function addFiles($path) {
        $testFiles = new DirectoryIterator($path);
        foreach ($testFiles as $node) {
            if (!$node->isDot()) {
                if ($node->isDir()) {
                    $this->addFiles($node->getPathName());
                } else {
                    $this->addFile($node->getPathName());
                }
            }
        }
    }

}

?>