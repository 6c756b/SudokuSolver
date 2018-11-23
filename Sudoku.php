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

    public function solveBoard($GRID): bool
    {
        $row = -1;
        $col = -1;
        $isEmpty = true;

        for ($i = 0; $i < $this->SIZE; $i++) {
            for ($j = 0; $j < $this->SIZE; $j++) {
                if ($GRID[$i][$j] == 0) {
                    $row = $i;
                    $col = $j;
                    $isEmpty = false;
                    break;
                }
            }
            if (!$isEmpty) {
                break;
            }
        }

        if ($isEmpty) {
            return true;
        }

        for ($num = 1; $num <= $this->SIZE; $num++) {
            if ($this->isSafe($GRID, $col, $row, $num)) {
                $GRID[$col][$row] = $num;
                if ($this->solveBoard($GRID)) {
                    return true;
                } else {
                    $GRID[$col][$row] = 0;
                }
            }
        }
        return false;
    }


    private function isSafe($GRID, $col, $row, $num): bool
    {
        for ($d = 0; $d < $this->SIZE; $d++) {
            if ($GRID[$col][$d] == $num) {
                return false;
            }
        }

        for ($r = 0; $r < $this->SIZE; $r++) {
            if ($GRID[$r][$row] == $num) {
                return false;
            }
        }

        $boxRowStart = $row - $row % $this->BOXSIZE;
        $boxColStart = $col - $col % $this->BOXSIZE;

        for ($d = $boxColStart; $d < $boxColStart + $this->BOXSIZE; $d++) {
            for ($r = $boxRowStart; $r < $boxRowStart + $this->BOXSIZE; $r++) {
                if ($GRID[$r][$d] == $num) {
                    return false;
                }
            }
        }
        return true;

    }

    public function getGrid()
    {
        return $this->GRID;
    }
}

