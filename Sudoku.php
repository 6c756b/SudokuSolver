<?php
/**
 * Created by PhpStorm.
 * User: Constantin
 * Date: 15.11.2018
 * Time: 12:54
 */

class Sudoku
{
    private $SIZE = 9;
    private $GRID;
    private $ROW = 0;
    private $COL = 0;

    /**
     * Sudoku constructor.
     * @param $SIZE
     */
    public function __construct($SIZE)
    {
        $this->SIZE = $SIZE;
        for ($c = 0; $c < $this->SIZE; $c++) {
            $this->GRID[$c] = array();
            for ($r = 0; $r < $this->SIZE; $r++) {
                $this->GRID[$c][$r] = $r + 1;
            }
        }
    }

    function printBoard()
    {
        for ($c = 0; $c < $this->SIZE; $c++) {
            for ($r = 0; $r < $this->SIZE; $r++) {
                echo $this->GRID[$c][$r] . " ";
                if ($r == 2 or $r == 5) {
                    print "| ";
                }
            }
            print "<br>";

        }
    }

    function createTestBoard()
    {
        $this->GRID = array(
            array(3, 0, 6, 5, 0, 8, 4, 0, 0),
            array(5, 2, 0, 0, 0, 0, 0, 0, 0),
            array(0, 8, 7, 0, 0, 0, 0, 3, 1),
            array(0, 0, 3, 0, 1, 0, 0, 8, 0),
            array(9, 0, 0, 8, 6, 3, 0, 0, 5),
            array(0, 5, 0, 0, 9, 0, 6, 0, 0),
            array(1, 3, 0, 0, 0, 0, 2, 5, 0),
            array(0, 0, 0, 0, 0, 0, 0, 7, 4),
            array(0, 0, 5, 2, 0, 6, 3, 0, 0)
        );
    }

    function solveBoard(): bool
    {

        if (!$this->findUnassignedLocation()) {
            return true;
        }

        for ($num = 1; $num <= 9; $num++) {
            if ($this->isSafe($num, $)) {
                $this->GRID[$this->ROW][$this->COL] = $num;

                if ($this->solveBoard()) {
                    return true;
                }

                //FAILED, UNASSIGNED
                $this->GRID[$this->ROW][$this->COL] = 0;
            }
        }
        return false;
    }

    private function findUnassignedLocation()
    {
        for ($c = 0; $c < $this->SIZE; $c++) {
            for ($r = 0; $r < $this->SIZE; $r++) {
                if ($this->GRID[$c][$r] == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    private function isSafe(int $num)
    {
        return !$this->usedInRow()
    }

}

