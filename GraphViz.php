<?php

class WeRelateGraph_GraphViz {

	private $dot_source;

	public function __construct() {
		$this->output('digraph FamilyTree {');
		$this->output('graph [rankdir="LR"]');
		$this->output('edge [arrowhead=none]');
	}

	public function visitPage(Title $title) {

		// People
		if ($title->getNamespace() == NS_WERELATECORE_PERSON) {
			$person = new WeRelateCore_person($title);

			$this->output($this->cleanName($person)." [label=<".$person->getFullName()
				."<BR align=\"left\"/>b. ".$person->getBirthDate()
				."<BR align=\"left\"/>d. ".$person->getDeathDate()
				."<BR align=\"left\"/>>,"
				."URL=\"".$person->getTitle()->getCanonicalURL()."\", shape=box, ]");

			foreach ($person->getFamilies('child') as $family) {
			$this->output($this->cleanName($family).' -> '.$this->cleanName($person));
			}

			foreach ($person->getFamilies('spouse') as $family) {
				$this->output($this->cleanName($person).' -> '.$this->cleanName($family));
			}
		}

		// Families
		if ($title->getNamespace() == NS_WERELATECORE_FAMILY) {
			$family = new WeRelateCore_family($title);
			$url = $family->getTitle()->getCanonicalURL();
			$this->output($this->cleanName($family).' [label="m. '.$family->getMarriageDate().'" URL="'.$url.'",shape=""]');
		}

	}

	private function cleanName($obj) {
		return strtr($obj->getTitle()->getDBkey(), '()', '__');
	}

	function output($line, $permit_dupes = false) {
		if (!is_array($this->dot_source)) {
			$this->dot_source = array();
		}
		if (!in_array($line, $this->dot_source) || $permit_dupes) {
			$this->dot_source[] = $line;
		}
	}

	/**
	 * Get the DOT source code.
	 *
	 * @return string
	 */
	public function __toString() {
		return join("\n", $this->dot_source).'}';
	}

}
