<?php
class LookForItemTitle extends UnitTestCase {

    function testSearchItem() {
        $controller = BrowserController::getInstance();
        $controller->login();
        $selenium = $controller->getSelenium();
        $selenium->open("/projects/".$GLOBALS['project']);
        $selenium->waitForPageToLoad("30000");
        $selenium->click("link=Documents");
        $selenium->waitForPageToLoad("30000");
        $selenium->open("/plugins/docman/?group_id=".$GLOBALS['project_id']."&action=details&id=".$GLOBALS['docman_root_id']."&section=actions");
        $selenium->waitForPageToLoad("30000");
        $hasPermission = $selenium->isTextPresent("You can create a new document in this folder.");
        $this->assertTrue($hasPermission, 'User don\'t have permission to create a document');
        if ($hasPermission) {
            $selenium->click("link=create a new document");
            $selenium->waitForPageToLoad("30000");
            $title = "empty".time();
            $selenium->type("title", $title);
            $selenium->type("description", "description ".time());
            $selenium->click("item_item_type_6");
            $selenium->click("//input[@value='Create document']");
            $selenium->waitForPageToLoad("30000");
            $this->assertTrue($selenium->isTextPresent("Document successfully created."), 'Folder not created');
            $selenium->click("docman_toggle_filters");
            $selenium->type("global_txt", $title);
            $selenium->click("docman_report_submit");
            $selenium->waitForPageToLoad("30000");
            $this->assertTrue($selenium->isTextPresent($title), 'Search didn\'t found "'.$title.'" with pattern"'.$title.'"');
            $pattern = "*".substr($title, 1);
            $selenium->type("global_txt", $pattern);
            $selenium->click("docman_report_submit");
            $selenium->waitForPageToLoad("30000");
            $this->assertTrue($selenium->isTextPresent($title), 'Search didn\'t found "'.$title.'" with pattern"'.$pattern.'"');
            $pattern = substr($title, 0, -1)."*";
            $selenium->type("global_txt", $pattern);
            $selenium->click("docman_report_submit");
            $selenium->waitForPageToLoad("30000");
            $this->assertTrue($selenium->isTextPresent($title), 'Search didn\'t found "'.$title.'" with pattern"'.$pattern.'"');
            $pattern = "*".substr(substr($title, 1), 0, -1)."*";
            $selenium->type("global_txt", $pattern);
            $selenium->click("docman_report_submit");
            $selenium->waitForPageToLoad("30000");
            $this->assertTrue($selenium->isTextPresent($title), 'Search didn\'t found "'.$title.'" with pattern"'.$pattern.'"');

            $selenium->click("//a[text()='".$title."']");
            $selenium->waitForPageToLoad("30000");
            $selenium->click("link=Edit properties");
            $selenium->waitForPageToLoad("30000");
            $selenium->click("link=Actions");
            $selenium->waitForPageToLoad("30000");
            $selenium->click("link=delete this document");
            $selenium->waitForPageToLoad("30000");
            $selenium->click("confirm");
            $selenium->waitForPageToLoad("30000");
            $this->assertTrue($selenium->isTextPresent("Item successfully deleted."), 'Document not deleted');
        }
    }

}
?>