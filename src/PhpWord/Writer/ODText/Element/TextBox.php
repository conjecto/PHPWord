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

use PhpOffice\PhpWord\Shared\Converter;

/**
 * TextBox element writer.
 *
 * @since 0.10.0
 */
class TextBox extends AbstractElement
{
    /**
     * Write element.
     */
    public function write(): void
    {
        $xmlWriter = $this->getXmlWriter();
        $element = $this->getElement();
        if (!$element instanceof \PhpOffice\PhpWord\Element\TextBox) {
            return;
        }

        $paragraphStyle = $element->getParagraphStyle();
        $mediaIndex = $element->getMediaIndex();
        $style = $element->getStyle();

        if (!$this->withoutP) {
            $xmlWriter->startElement('text:p');
            $xmlWriter->writeAttribute('text:style-name', $paragraphStyle);
        }
        
        $xmlWriter->startElement('draw:frame');
        $xmlWriter->writeAttribute('draw:style-name', 'fr' . $mediaIndex);
        $xmlWriter->writeAttribute('draw:name', $element->getElementId());
        $xmlWriter->writeAttribute('text:anchor-type', 'paragraph');
        $xmlWriter->writeAttribute('style:rel-width', '100%');
        $xmlWriter->writeAttribute('draw:z-index', 0);

        if ($style->getWidth()) {
            $width = Converter::pixelToCm($style->getWidth());
            $xmlWriter->writeAttribute('svg:width', $width.'cm');
        }

        if ($style->getHeight()) {
            $height = Converter::pixelToCm($style->getHeight());
            $xmlWriter->writeAttribute('svg:height', $height.'cm');
        }

        $xmlWriter->startElement('draw:text-box');
        $xmlWriter->writeAttribute('fo:min-height', "0.499cm");

        $containerWriter = new Container($xmlWriter, $element);
        $containerWriter->write();

        $xmlWriter->endElement(); // draw:text-box

        $xmlWriter->endElement(); // draw:frame

        if (!$this->withoutP) {
            $xmlWriter->endElement(); // text:p
        }
    }
}
