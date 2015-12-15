<?php

/*
 * Copyright (c) 2011 Litle & Co.
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

namespace litle\sdk\Test\unit;

use litle\sdk\Obj2xml;

class Obj2xmlTest extends \PHPUnit_Framework_TestCase
{
    public function test_enhanced_data_more_than_10_line_items()
    {
        $hash =
            ['merchantSdk' => '', 'enhancedData' => [
                'lineItemData1'  => (['itemSequenceNumber' => '1', 'itemDescription' => 'First']),
                'lineItemData2'  => (['itemSequenceNumber' => '2', 'itemDescription' => 'Second']),
                'lineItemData3'  => (['itemSequenceNumber' => '3', 'itemDescription' => 'Third']),
                'lineItemData4'  => (['itemSequenceNumber' => '4', 'itemDescription' => 'Fourth']),
                'lineItemData5'  => (['itemSequenceNumber' => '5', 'itemDescription' => 'Fifth']),
                'lineItemData6'  => (['itemSequenceNumber' => '6', 'itemDescription' => 'Sixth']),
                'lineItemData7'  => (['itemSequenceNumber' => '7', 'itemDescription' => 'Seventh']),
                'lineItemData8'  => (['itemSequenceNumber' => '8', 'itemDescription' => 'Eighth']),
                'lineItemData9'  => (['itemSequenceNumber' => '9', 'itemDescription' => 'Ninth']),
                'lineItemData10' => (['itemSequenceNumber' => '10', 'itemDescription' => 'Tenth']),
                'lineItemData11' => (['itemSequenceNumber' => '11', 'itemDescription' => 'Eleventh']),
            ]];
        $outputxml = Obj2xml::toXml($hash, [], 'authorization');
        //Finding this means the schema will fail validation
        $this->assertTrue(false === strpos($outputxml, 'lineItemData11'));
    }
}
