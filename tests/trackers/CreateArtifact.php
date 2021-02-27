<?php
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