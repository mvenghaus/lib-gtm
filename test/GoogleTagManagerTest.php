<?php

namespace Inkl\GoogleTagManager;

use Inkl\GoogleTagManager\Schema\Id;

class GoogleTagManagerTest extends \PHPUnit_Framework_TestCase
{
	public function testGetTag()
	{
		$id = 123;

		$expectedResult = <<<EOF
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{$id}');</script>
EOF;

		$this->assertSame($expectedResult, GoogleTagManager::getInstance()->getTag(new Id($id)));
	}

	public function testGetNoScriptTag()
	{
		$id = 123;

		$expectedResult = <<<EOF
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={$id}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
EOF;

		$this->assertSame($expectedResult, GoogleTagManager::getInstance()->getNoScriptTag(new Id($id)));
	}

	public function testGetDataLayer()
	{
		$varName = 'testvar';
		$varValue = 'testvalue';

		$expectedResult = <<<EOF
<script>
	var dataLayer = [{"{$varName}":"{$varValue}"}];
</script>
EOF;

		$result = GoogleTagManager::getInstance()
			->addDataLayerVariable($varName, $varValue)
			->getDataLayer();

		$this->assertSame($expectedResult, $result);
	}
}