<?php
namespace Model;
/**
 * the Example model class
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class Example {
	private $test_field;
	public function setTestField($field) {
		$this->test_field = $field;
	}
	public function getTestField() {
		return $this->test_field;
	}
}