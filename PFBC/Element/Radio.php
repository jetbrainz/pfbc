<?php
namespace PFBC\Element;

class Radio extends \PFBC\OptionElement {
	protected $_attributes = array("type" => "radio");
	protected $inline;

	public function render() { 
		$labelClass = $this->_attributes["type"];
		if(!empty($this->inline))
			$labelClass .= "-inline";

		$wr1 = $wr2 = $wr11 = $wr22 = '';
		if (!empty ($this->_attributes['controlwidth'])) {
			$wr1 = '<div class="clear"><div class="col-sm-'.$this->_attributes['controlwidth'].'">';
			$wr2 = '</div></div>';
			if(!empty($this->inline)) {
				$wr11 = $wr1;
				$wr22 = $wr2;
				$wr1 = '';
				$wr2 = '';
			}
		}

		$count = 0;
		echo $wr11;
		foreach($this->options as $value => $text) {
			$value = $this->getOptionValue($value);

			echo $wr1.'<label class="', $labelClass . '"> <input id="', $this->_attributes["id"], '-', $count, '"', $this->getAttributes(array("id", "value", "checked")), ' value="', $this->filter($value), '"';
			if(isset($this->_attributes["value"]) && $this->_attributes["value"] == $value)
				echo ' checked="checked"';
			echo '/> ', $text, ' </label> '.$wr2;
			++$count;
		}
		echo $wr22;
	}
}
