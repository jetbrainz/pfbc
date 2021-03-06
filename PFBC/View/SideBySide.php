<?php
namespace PFBC\View;

class SideBySide extends \PFBC\View {
	protected $class = "form-horizontal";

	public function render() {
		$this->_form->appendAttribute("class", $this->class);

		echo '<form', $this->_form->getAttributes(), ' role="form">';
		$this->_form->getErrorView()->render();

		$elements = $this->_form->getElements();
		$elementSize = sizeof($elements);
		$elementCount = 0;
		for($e = 0; $e < $elementSize; ++$e) {
			$element = $elements[$e];
			$wr1 = $wr2 = '';
			if (!empty ($element->getAttribute('elementwidth'))) {
				$wr1 = '<div class="col-md-6">';
				$wr2 = '</div>';
			}

			if($element instanceof \PFBC\Element\Hidden || $element instanceof \PFBC\Element\HTML)
				$element->render();
            elseif($element instanceof \PFBC\Element\Button) {
                if($e == 0 || !$elements[($e - 1)] instanceof \PFBC\Element\Button)
					echo '<div class="clearfix form-actions">';
				else
					echo ' ';
				
				$element->render();

                if(($e + 1) == $elementSize || !$elements[($e + 1)] instanceof \PFBC\Element\Button)
                    echo '</div>';
            } elseif ($element instanceof \PFBC\Element\Radio) {
				echo $wr1, '<div class="radio2" id="element_', $element->getAttribute('id'), '">', $this->renderLabel($element), '', $element->render(), $this->renderDescriptions($element), '</div>', $wr2;
				++$elementCount;
			} elseif ($element instanceof \PFBC\Element\Checkbox) {
				echo $wr1, '<div class="checkbox2" id="element_', $element->getAttribute('id'), '">', $this->renderLabel($element), '', $element->render(), $this->renderDescriptions($element), '</div>', $wr2;
				++$elementCount;
			} else {
				echo $wr1, '<div class="form-group" id="element_', $element->getAttribute('id'), '">', $this->renderLabel($element), '', $element->render(), $this->renderDescriptions($element), '</div>', $wr2;
				++$elementCount;
			}
		}

		echo '</form>';
    }

	protected function renderLabel(\PFBC\Element $element) {
        $label = $element->getLabel();
        if(!empty($label)) {
			$class = '';
			if ($element->getAttribute('labelwidth')) {
				$class = ' class="col-sm-' . $element->getAttribute('labelwidth').'"';
			}
			echo '<label for="', $element->getAttribute("id"), '"'.$class.'>';
			if($element->isRequired())
				echo '<span class="required">* </span>';
			echo $label, '</label>'; 
        }
    }
}
