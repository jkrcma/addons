<?php

/**
 * Test: FirePHP::fireLog() and exception.
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette
 * @subpackage UnitTests
 */

use Nette\Debug;



require __DIR__ . '/../FirePHP.php';



function first($arg1, $arg2)
{
	second(TRUE, FALSE);
}



function second($arg1, $arg2)
{
	third(array(1, 2, 3));
}


function third($arg1)
{
	throw new Exception('The my exception', 123);
}

try {
	first(10, 'any string');

} catch (Exception $e) {
	FirePHP::fireLog($e);
}

/*
Assert::match('%A%
X-Wf-Protocol-nette: http://meta.wildfirehq.org/Protocol/JsonStream/0.2
X-Wf-nette-Plugin-1: http://meta.firephp.org/Wildfire/Plugin/FirePHP/Library-FirePHPCore/0.2.0
X-Wf-nette-Structure-1: http://meta.firephp.org/Wildfire/Structure/FirePHP/FirebugConsole/0.1
X-Wf-nette-1-1-n1: |[{"Type":"TRACE","Label":null},{"Class":"Exception","Message":"The my exception","File":"%a%","Line":%d%,"Trace":[{"file":"%a%","line":%d%,"function":"third","args":[[1,2,3]]},{"file":"%a%","line":%d%,"function":"second","args":[true,false]},{"file":"%a%","line":%d%,"function":"first","args":[10,"any string"]}],"Type":"","Function":""}]|
', implode("\r\n", headers_list()));
*/