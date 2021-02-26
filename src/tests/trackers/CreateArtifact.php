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

class CreateArtifact extends UnitTestCase {

    function testCreateArtifact() {
        $controller = BrowserController::getInstance();
        $controller->login();
        $selenium = $controller->getSelenium();
        $selenium->open("/projects/".$GLOBALS['project']);
        $selenium->waitForPageToLoad("30000");
        $selenium->click("link=Trackers");
        $selenium->waitForPageToLoad("30000");
        $selenium->click("link=".$GLOBALS['tracker']);
        $selenium->waitForPageToLoad("30000");
        $selenium->click("link=Submit A New ".$GLOBALS['trackerName']);
        $selenium->waitForPageToLoad("30000");
        $selenium->select("severity", "label=9 - Critical");
        $selenium->type("summary", "selenium test ".time());
        $selenium->type("tracker_details", "some text");
        $selenium->click("SUBMIT");
        $selenium->waitForPageToLoad("30000");
        $this->assertTrue($selenium->isTextPresent("Artifact Successfully Created (".$GLOBALS['trackerShortName']." #"), "Artifact not created");
    }

}
?>