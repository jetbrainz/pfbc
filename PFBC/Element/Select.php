<?php
namespace PFBC\Element;

class Select extends \PFBC\OptionElement {
	protected $_attributes = array();

	public function render() { 
		if(isset($this->_attributes["value"])) {
			if(!is_array($this->_attributes["value"]))
				$this->_attributes["value"] = array($this->_attributes["value"]);
		}
		else
			$this->_attributes["value"] = array();

		if(!empty($this->_attributes["multiple"]) && substr($this->_attributes["name"], -2) != "[]")
			$this->_attributes["name"] .= "[]";

		$wr1 = $wr2 = '';
		
		if (!empty ($this->_attributes['controlwidth'])) {
			$wr1 = '<div class="col-sm-'.$this->_attributes['controlwidth'].'">';
			$wr2 = '</div>';
		}
		
		echo $wr1.'<select', $this->getAttributes(array("value", "selected")), '>';
		$selected = false;
		foreach($this->options as $value => $text) {
			$value = $this->getOptionValue($value);
			echo '<option value="', $this->filter($value), '"';
			if(!$selected && in_array($value, $this->_attributes["value"])) {
				echo ' selected="selected"';
				$selected = true;
			}	
			echo '>', $text, '</option>';
		}	
		echo '</select>'.$wr2;
	}
}
