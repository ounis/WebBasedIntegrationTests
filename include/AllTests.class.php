<?php
/**
 * Copyright (c) STMicroelectronics 2011. All rights reserved
 *
 * This code is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this code. If not, see <http://www.gnu.org/licenses/>.
 */

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