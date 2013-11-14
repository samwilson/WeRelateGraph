<?php if (!defined('MEDIAWIKI')) die(0);

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'WeRelateGraph',
	'author' => "Sam Wilson <[mailto:sam@samwilson.id.au sam@samwilson.id.au]>",
	'url' => "http://mediawiki.org/wiki/Extension:WeRelate",
	'descriptionmsg' => 'werelategraph-desc',
	'version' => 2.0,
);
$wgExtensionMessagesFiles['WeRelateGraph'] = __DIR__ . '/WeRelateGraph.i18n.php';

/**
 * Class loading and the Special page
 */
$wgAutoloadClasses['SpecialWeRelateGraph'] = __DIR__.'/Special.php';
$wgAutoloadClasses['WeRelateGraph_GraphViz'] = __DIR__.'/GraphViz.php';
$wgSpecialPages['WeRelateGraph'] = 'SpecialWeRelateGraph';
