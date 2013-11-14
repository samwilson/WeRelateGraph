<?php

if (!defined('MEDIAWIKI')) {
	die(0);
}

class SpecialWeRelateGraph extends SpecialPage {

	function __construct() {
		parent::__construct('WeRelateGraph');
	}

	function execute($sourcePageName) {
		global $IP;
		$this->setHeaders();
		$title = null;
		if (!empty($sourcePageName)) {
			$title = Title::newFromText($sourcePageName);
			$page = WikiPage::factory($title);
			if (!$page->exists()) {
				$this->getOutput()->addHTML('<div class="error">' . wfMessage('nopagetext') . '</div>');
			} else {
				$graphviz = new WeRelateGraph_GraphViz($title);
				$treebranch = new WeRelateTreebranch_treebranch($title);
				$treebranch->addObserver(array($this, 'visitPage'));
				$treebranch->addObserver(array($graphviz, 'visitPage'));
				$treebranch->traverse();

				//$this->getOutput()->addHTML("<pre>".  htmlentities($graphviz)."</pre>");
				$html = renderGraphviz($graphviz);
				$this->getOutput()->addHTML($html);

				return;
			}
		}
	}

	public function visitPage(Title $title) {
		if ($title->getNamespace() != NS_WERELATECORE_PERSON) {
			return;
		}
		$person = new WeRelateCore_person($title);
		//$this->getOutput()->addWikiText('[[' . $person->getTitle() . '|' . $person->getFullName() . ']], ');
	}

}
