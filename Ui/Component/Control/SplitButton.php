<?php
/**
 * Copyright © Acesofspades. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aos\CustomerView\Ui\Component\Control;

/**
 * Class SplitButton
 */
class SplitButton extends \Magento\Ui\Component\Control\SplitButton
{
    /**
     * Retrieve attributes html
     *
     * @return string
     */
    public function getAttributesHtml()
    {
        $classes = [];

        $disabled = $this->getDisabled() ? 'disabled' : '';
        $title = $this->getTitle();
        if (empty($title)) {
            $title = $this->getLabel();
        }
        if ($this->hasSplit()) {
            $classes[] = 'actions-split';
        }
        if ($this->hasData('class')) {
            $classes[] = $this->getClass();
        }
        if ($disabled) {
            $classes[] = $disabled;
        }

        return $this->attributesToHtml($this->prepareAttributes($title, $classes, $disabled));
    }
}
