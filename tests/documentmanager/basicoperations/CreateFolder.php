<?php
class CreateFolder extends UnitTestCase {

    function testCreateFolder() {
        $controller = BrowserController::getInstance();
        $controller->login();
        $selenium = $controller->getSelenium();
        $selenium->open("/projects/".$GLOBALS['project']);
        $selenium->waitForPageToLoad("30000");
        $selenium->click("link=Documents");
        $selenium->waitForPageToLoad("30000");
        $selenium->open("/plugins/docman/?group_id=".$GLOBALS['project_id']."&action=details&id=".$GLOBALS['docman_root_id']."&section=actions");
        $selenium->waitForPageToLoad("30000");
        $hasPermission = $selenium->isTextPresent("You can create a new folder in this folder.");
        $this->assertTrue($hasPermission, 'User don\'t have permission to create a folder');
        if ($hasPermission) {
            $selenium->click("link=create a new folder");
            $selenium->waitForPageToLoad("30000");
            $title1 = "folder1 ".time();
            $selenium->type("title", $title1);
            $selenium->type("description", "description1 ".time());
            $selenium->click("//input[@value='Create folder']");
            $selenium->waitForPageToLoad("30000");
            $this->assertTrue($selenium->isTextPresent("Document successfully created."), 'Folder not created');
            $selenium->click("//a[@id='docman_item_show_menu_".$GLOBALS['docman_root_id']."']/img");
            $selenium->click("link=New folder");
            $selenium->waitForPageToLoad("30000");
            $title2 = "folder2 ".time();
            $selenium->type("title", $title2);
            $selenium->type("description", "description2 ".time());
            $selenium->click("//input[@value='Create folder']");
            $selenium->waitForPageToLoad("30000");
            $this->assertTrue($selenium->isTextPresent("Document successfully created."), 'Folder not created');

            preg_match('/docman_item_title_link_([0-9]+)/', $selenium->getAttribute("xpath=(//a[text()='".$title1."'])[1]@id"), $id1);
            preg_match('/docman_item_title_link_([0-9]+)/', $selenium->getAttribute("xpath=(//a[text()='".$title2."'])[1]@id"), $id2);
            $selenium->click("//a[@id='docman_item_show_menu_".$id1[1]."']/img");
            $selenium->click("link=Delete");
            $selenium->waitForPageToLoad("30000");
            $selenium->click("confirm");
            $selenium->waitForPageToLoad("30000");
            $selenium->click("//a[@id='docman_item_show_menu_".$id2[1]."']/img");
            $selenium->click("link=Delete");
            $selenium->waitForPageToLoad("30000");
            $selenium->click("confirm");
            $selenium->waitForPageToLoad("30000");
        }
    }

}
?>