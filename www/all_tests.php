<?php
require_once('../include/AllTests.class.php');

$allTests = new AllTests();

$reporter = $allTests->run(new CustomHtmlReporter());

?>