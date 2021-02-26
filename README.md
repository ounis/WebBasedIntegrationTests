#
# Copyright (c) STMicroelectronics 2011. All rights reserved
#

This is a solution to run integration tests using SeleniumRC


LICENSE
=======
This code is distributed under the GPL v2 Licence. See the file COPYING for details.

INSTALLATION
============
This code requires the installation of PEAR 1.9.2 by typing

> pear install PEAR-1.9.2

Then install Testing_Selenium 0.4.3 by typing

> pear install channel://pear.php.net/Testing_Selenium-0.4.3

For the Selenium part you need to download selenium-server-standalone-2.0b3.jar from http://seleniumhq.org/download

Then create a Firefox profile for selenium (you may need to delete extentions.rdf for addons popup)

After that and before trying to run any tests you need to open the platform to be tested by the firefox profile and accept the certificate

Then run Selenium by

> java -jar selenium-server-standalone-2.0b3.jar -singlewindow -firefoxProfileTemplate "/path/to/firefox/profile/"