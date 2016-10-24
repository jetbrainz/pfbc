<?php
namespace PFBC\View;

class Vertical extends \PFBC\View {
	public function render() {
		echo '<form', $this->_form->getAttributes(), ' role="form">';
		$this->_form->getErrorView()->render();

		$elements = $this->_form->getElements();
        $elementSize = sizeof($elements);
        $elementCount = 0;
        for($e = 0; $e < $elementSize; ++$e) {
            $element = $elements[$e];

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
            }
            else {
				if ($element->getAttribute('type') == 'checkbox') {
					echo '<div class="checkbox">';
					$this->renderLabelCheckbox($element);
					$element->render();
					echo '<div class="clear"></div></div>';
				} elseif ($element->getAttribute('type') != 'HTML') {
					echo '<div class="form-group">';
					$this->renderLabel($element);
					$element->render();
					$this->renderDescriptions($element);
					echo '<div class="clear"></div></div>';
				} else {
					$element->render();
				}
                ++$elementCount;
            }
        }

		echo '</form>';
    }

	protected function renderLabel(\PFBC\Element $element) {
        $label = $element->getLabel();

		$wr1 = $wr2 = '';
		if ($element->getAttribute('controlwidth')) {
			$wr1 = '<div>';
			$wr2 = '</div>';
		}

		echo $wr1.'<label for="', $element->getAttribute("id"), '">';
        if(!empty($label)) {
			if($element->isRequired())
				echo '<span class="required">* </span>';
			echo $label;	
        }
		echo '</label>'.$wr2;
    }

	protected function renderLabelCheckbox(\PFBC\Element $element) {
		$wr1 = $wr2 = '';
		if ($element->getAttribute('controlwidth')) {
			$wr1 = '<div>';
			$wr2 = '</div>';
		}

		$label = $element->getLabel();

		if(!empty($label)) {
			echo $wr1;
			if($element->isRequired())
				echo '<span class="required">* </span>';
			echo $label;
			echo $wr2;
		}
	}
}
