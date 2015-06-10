<?php
namespace Oefenweb\DamerauLevenshtein\Test;

use Oefenweb\DamerauLevenshtein\DamerauLevenshtein;

class DamerauLevenshteinTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests `getSimilarity`.
     *
     * @return void
     */
    public function testGetSimilarity()
    {
        $inputs = array(
            array('foo', 'foo'),
            array('foo', 'fooo'),
            array('foo', 'bar'),

            array('123', '12'),
            array('qwe', 'qwa'),
            array('awe', 'qwe'),
            array('фыв', 'фыа'),
            array('vvvqw', 'vvvwq'),
            array('qw', 'wq'),
            array('qq', 'ww'),
            array('qw', 'qw'),
            array('пионер', 'плеер'),
            array('пионер', 'пионеер'),
            array('пионер', 'поинер'),
            array('pioner', 'poner'),
            array('пионер', 'понер'),
        );
        $outputs = array(
            0,
            1,
            3,

            1,
            1,
            1,
            1,
            1,
            1,
            2,
            0,
            3,
            1,
            1,
            1,
            1,
        );

        foreach ($inputs as $i => $input) {
            $DamerauLevenshtein = new DamerauLevenshtein($input[0], $input[1]);
            $result = $DamerauLevenshtein->getSimilarity();
            $expected = $outputs[$i];

            $this->assertSame($expected, $result);
        }
    }

    /**
     * Tests `getInsCost`.
     *
     * @return void
     */
    public function testGetInsCost()
    {
        list($firstString, $secondString) = $this->getDefaultStrings();
        list($insCost, $delCost, $subCost, $transCost) = $this->getDefaultCosts();

        // Default insert cost

        $DamerauLevenshtein = new DamerauLevenshtein($firstString, $secondString);
        $result = $DamerauLevenshtein->getInsCost();
        $expected = $insCost;

        $this->assertSame($expected, $result);

        // Non-default insert cost

        $insCost = 2;

        $DamerauLevenshtein = new DamerauLevenshtein(
            $firstString,
            $secondString,
            $insCost,
            $delCost,
            $subCost,
            $transCost
        );
        $result = $DamerauLevenshtein->getInsCost();
        $expected = $insCost;

        $this->assertSame($expected, $result);
    }

    /**
     * Tests `getDelCost`.
     *
     * @return void
     */
    public function testGetDelCost()
    {
        list($firstString, $secondString) = $this->getDefaultStrings();
        list($insCost, $delCost, $subCost, $transCost) = $this->getDefaultCosts();

        // Default delete cost

        $DamerauLevenshtein = new DamerauLevenshtein($firstString, $secondString);
        $result = $DamerauLevenshtein->getDelCost();
        $expected = $delCost;

        $this->assertSame($expected, $result);

        // Non-default delete cost

        $delCost = 2;

        $DamerauLevenshtein = new DamerauLevenshtein(
            $firstString,
            $secondString,
            $insCost,
            $delCost,
            $subCost,
            $transCost
        );
        $result = $DamerauLevenshtein->getDelCost();
        $expected = $delCost;

        $this->assertSame($expected, $result);
    }

    /**
     * Tests `getSubCost`.
     *
     * @return void
     */
    public function testGetSubCost()
    {
        list($firstString, $secondString) = $this->getDefaultStrings();
        list($insCost, $delCost, $subCost, $transCost) = $this->getDefaultCosts();

        // Default substitution cost

        $DamerauLevenshtein = new DamerauLevenshtein($firstString, $secondString);
        $result = $DamerauLevenshtein->getSubCost();
        $expected = $subCost;

        $this->assertSame($expected, $result);

        // Non-default substitution cost

        $subCost = 2;

        $DamerauLevenshtein = new DamerauLevenshtein(
            $firstString,
            $secondString,
            $insCost,
            $delCost,
            $subCost,
            $transCost
        );
        $result = $DamerauLevenshtein->getSubCost();
        $expected = $subCost;

        $this->assertSame($expected, $result);
    }

    /**
     * Tests `getTransCost`.
     *
     * @return void
     */
    public function testGetTransCost()
    {
        list($firstString, $secondString) = $this->getDefaultStrings();
        list($insCost, $delCost, $subCost, $transCost) = $this->getDefaultCosts();

        // Default transposition cost

        $DamerauLevenshtein = new DamerauLevenshtein($firstString, $secondString);
        $result = $DamerauLevenshtein->getTransCost();
        $expected = $transCost;

        $this->assertSame($expected, $result);

        // Non-default transposition cost

        $transCost = 2;

        $DamerauLevenshtein = new DamerauLevenshtein(
            $firstString,
            $secondString,
            $insCost,
            $delCost,
            $subCost,
            $transCost
        );
        $result = $DamerauLevenshtein->getTransCost();
        $expected = $transCost;

        $this->assertSame($expected, $result);
    }

    /**
     * Tests `getRelativeDistance`.
     *
     * @return void
     */
    public function testGetRelativeDistance()
    {
        $delta = pow(10, -4);

        $firstString = 'O\'Callaghan';
        $secondString = 'OCallaghan';

        $DamerauLevenshtein = new DamerauLevenshtein($firstString, $secondString);
        $result = $DamerauLevenshtein->getRelativeDistance();
        $expected = 0.90909090909091;
        $this->assertEquals($expected, $result, '', $delta);

        $firstString = 'Thom';
        $secondString = 'Mira';

        $DamerauLevenshtein = new DamerauLevenshtein($firstString, $secondString);
        $result = $DamerauLevenshtein->getRelativeDistance();
        $expected = 0.0;
        $this->assertEquals($expected, $result, '', $delta);

        $firstString = 'Oldeboom';
        $secondString = 'Ven';

        $DamerauLevenshtein = new DamerauLevenshtein($firstString, $secondString);
        $result = $DamerauLevenshtein->getRelativeDistance();
        $expected = 0.125;
        $this->assertEquals($expected, $result, '', $delta);

        $firstString = 'ven';
        $secondString = 'Ven';

        $DamerauLevenshtein = new DamerauLevenshtein($firstString, $secondString);
        $result = $DamerauLevenshtein->getRelativeDistance();
        $expected = 0.66666666666667;
        $this->assertEquals($expected, $result, '', $delta);

        $firstString = 'enV';
        $secondString = 'Ven';

        $DamerauLevenshtein = new DamerauLevenshtein($firstString, $secondString);
        $result = $DamerauLevenshtein->getRelativeDistance();
        $expected = 0.33333333333333;
        $this->assertEquals($expected, $result, '', $delta);
    }

    /**
     * Tests `getMatrix`.
     *
     * @return void
     */
    public function testGetMatrix()
    {
        list($firstString, $secondString) = $this->getDefaultStrings();

        $DamerauLevenshtein = new DamerauLevenshtein($firstString, $secondString);
        $actual = $DamerauLevenshtein->getMatrix();
        $expected = array(
            array(0, 1, 2, 3),
            array(1, 1, 2, 3),
            array(2, 2, 2, 3),
            array(3, 3, 3, 3)
        );
        $this->assertSame($expected, $actual);
    }

    /**
     * Tests `displayMatrix`.
     *
     * @return void
     */
    public function testDisplayMatrix()
    {
        list($firstString, $secondString) = $this->getDefaultStrings();

        $DamerauLevenshtein = new DamerauLevenshtein($firstString, $secondString);
        $actual = $DamerauLevenshtein->displayMatrix();
        $expected = implode('', array(
            "  foo\n",
            " 0123\n",
            "b1123\n",
            "a2223\n",
            "r3333\n",
        ));
        $this->assertSame($expected, $actual);
    }

    /**
     * Returns the default costs.
     *
     * @return array Costs (insert, delete, substitution, transposition)
     */
    protected function getDefaultCosts()
    {
        $insCost = 1;
        $delCost = 1;
        $subCost = 1;
        $transCost = 1;

        return array($insCost, $delCost, $subCost, $transCost);
    }

    /**
     * Returns the default strings.
     *
     * @return array Strings (foo, bar)
     */
    protected function getDefaultStrings()
    {
        $firstString = 'foo';
        $secondString = 'bar';

        return array($firstString, $secondString);
    }
}
