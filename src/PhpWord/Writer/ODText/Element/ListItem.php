<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @see         https://github.com/PHPOffice/PHPWord
 *
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpWord\Writer\ODText\Element;

/**
 * ListItem element writer.
 *
 * @since 0.10.0
 */
class ListItem extends AbstractElement
{
    /**
     * Write list item element.
     */
    public function write(): void
    {
        $xmlWriter = $this->getXmlWriter();
        $element = $this->getElement();
        if (!$element instanceof \PhpOffice\PhpWord\Element\ListItem) {
            return;
        }

        $textObject = $element->getTextObject();
        $pStyle = $textObject->getParagraphStyle();
        if (!is_string($pStyle)) {
            $pStyle = 'Normal';
        }

        $xmlWriter->startElement('text:list');
        $xmlWriter->startElement('text:list-item');

        $xmlWriter->startElement('text:p');
        $xmlWriter->writeAttribute('text:style-name', $pStyle);

        $elementWriter = new Text($xmlWriter, $textObject, true);
        $elementWriter->write();

        $xmlWriter->endElement(); // text:list
        $xmlWriter->endElement(); // text:p
        $xmlWriter->endElement(); // text:list-item
    }
}
