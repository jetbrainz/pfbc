<?php
namespace PFBC\Element;

class Checkbox extends \PFBC\OptionElement {
	protected $_attributes = array("type" => "checkbox");
	protected $inline;

	public function render() { 
		if(isset($this->_attributes["value"])) {
			if(!is_array($this->_attributes["value"]))
				$this->_attributes["value"] = array($this->_attributes["value"]);
		}
		else
			$this->_attributes["value"] = array();

		if(substr($this->_attributes["name"], -2) != "[]")
			$this->_attributes["name"] .= "[]";

		$labelClass = $this->_attributes["type"];
		if(!empty($this->inline))
			$labelClass .= "-inline";

		$count = 0;

		$wr1 = $wr2 = '';
		if (!empty ($this->_attributes['controlwidth'])) {
			$wr1 = '<div class="clear"><div class="col-sm-'.$this->_attributes['controlwidth'].'">';
			$wr2 = '</div></div>';
		}
		echo '<br clear="all" />';
		foreach($this->options as $value => $text) {
			$value = $this->getOptionValue($value);

		    if (empty ($this->_attributes['labelOutside'])) {
			echo $wr1.'<input id="', $this->_attributes["id"], '-', $count, '"', $this->getAttributes(array("id", "value", "checked", "required")), ' value="', $this->filter($value), '"';
			if(in_array($value, $this->_attributes["value"]))
			    echo ' checked="checked"';
			echo '/> <label for="', $this->_attributes["id"],  '-', $count, '" class="' , $labelClass , '">', $text, ' </label> '.$wr2;
		    } else {
			echo $wr1.'<label class="', $labelClass, '"> <input id="', $this->_attributes["id"], '-', $count, '"', $this->getAttributes(array("id", "value", "checked", "required")), ' value="', $this->filter($value), '"';
			if(in_array($value, $this->_attributes["value"]))
			    echo ' checked="checked"';
			echo '/> ', $text, ' </label> '.$wr2;
		    }
			++$count;
		}
	}
}
