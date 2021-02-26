<?php
require_once('simpletest/reporter.php');

/**
 * Better view of the tests to run & results on the browser
 */
class CustomHtmlReporter extends HtmlReporter {
    protected $_timer;

    /**
     * Constructor of the class
     *
     * @return void
     */
    function __construct() {
        $this->HtmlReporter();
    }

    /**
     * Show the title of tests in the test page
     *
     * @return void
     *
     * @see simpletest/HtmlReporter::paintHeader()
     */
    function paintHeader($test_name) {
        print "<h1>$test_name</h1>\n";
        $this->_timer = microtime(true);
        flush();
    }

    /**
     * Customize the footer of the test page
     *
     * @return void
     *
     * @see simpletest/HtmlReporter::paintFooter()
     */
    function paintFooter($test_name) {
        $duration = microtime(true) - $this->_timer;
        $micro = round($duration - floor($duration), 2);
        $seconds = floor($duration);
        $minutes = floor($seconds / 60);
        $seconds = $seconds % 60;
        $d = $minutes ? $minutes .' minute' .($minutes > 1 ? 's ' : ' ') : '';
        $d .= ($seconds + $micro) .' seconds';
        echo '<div style="border:1px solid orange; background: lightyellow; color:orange">Time taken: '. $d .'</div>'; 
        parent::paintFooter($test_name);
    }

    /**
     * Customize the way passes are displayed
     *
     * @return void
     *
     * @see simpletest/SimpleScorer::paintPass()
     */
    function paintPass($message) {
        parent::paintPass($message);
        if (isset($_REQUEST['show_pass'])) {
            print '<span class="pass">Pass</span>: ';
            $breadcrumb = $this->getTestList();
            array_shift($breadcrumb);
            print implode(" -&gt; ", $breadcrumb);
            print " -&gt; " . $this->_htmlEntities($message) . "<br />\n";
        }
    }

    /**
     * Customize the way fails are displayed
     *
     * @return void
     *
     * @see simpletest/HtmlReporter::paintFail()
     */
    function paintFail($message) {
        echo '<p><input type="checkbox" onclick="$(this).siblings().invoke(\'toggle\');" /><span>';
        parent::paintFail($message);
        echo '</span></p>';
    }

}

?>