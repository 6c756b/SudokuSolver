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
    private $BOXSIZE = 3;

    /**
     * Sudoku constructor.
     * @param $SIZE
     */
    public function __construct($SIZE)
    {
        $this->SIZE = $SIZE;
        //$this->BOXSIZE = sqrt($this->SIZE);
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

    public function createTestBoard()
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

    public function solveBoard(): bool
    {
        if (!$this->findUnassignedLocation()) {
            return true;
        }

        for ($num = 1; $num <= 9; $num++) {
            if ($this->isSafe($this->ROW, $this->ROW, $num)) {
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

    private function findUnassignedLocation(): bool
    {
        for ($this->COL = 0; $this->COL < $this->SIZE; $this->COL++) {
            for ($this->ROW = 0; $this->ROW < $this->SIZE; $this->ROW++) {
                if ($this->GRID[$this->COL][$this->ROW] == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    private function isSafe($col, $row, $num): bool
    {
        return
            !$this->usedInRow($row, $num) &&
            !$this->usedInCol($col, $num) &&
            !$this->usedInBox($col - $col % 3, $row - $row % 3, $num);
    }

    private function usedInRow($row, $num): bool
    {
        for ($col = 0; $col < $this->SIZE; $col++) {
            if ($this->GRID[$col][$row] == $num) {
                return true;
            }
        }
        return false;
    }

    private function usedInCol($col, $num): bool
    {
        for ($row = 0; $row < $this->SIZE; $row++) {
            if ($this->GRID[$col][$row] == $num) {
                return true;
            }
        }
        return false;
    }

    private function usedInBox($startCol, $startRow, $num): bool
    {
        for ($col = 0; $col < $this->BOXSIZE; $col++) {
            for ($row = 0; $row < $this->BOXSIZE; $row++) {
                if ($this->GRID[$col + $startCol][$row + $startRow] == $num) {
                    echo "usedInBox true";
                    return true;
                }
            }
        }
        return false;
    }
}

