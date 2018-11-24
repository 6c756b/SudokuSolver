<?php
/**
 * Created by PhpStorm.
 * User: Constantin
 * Date: 15.11.2018
 * Time: 12:54
 */

class Sudoku
{
    public static function printSudoku($GRID)
    {
        foreach ($GRID as $row) {
            foreach ($row as $col) {
                echo $col . " ";
            }
            echo "<br />";
        }
    }

    public static function solveBoard($GRID, $n): bool
    {
        $row = -1;
        $col = -1;
        $isEmpty = true;

        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
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
            Sudoku::printSudoku($GRID);
            return true;
        }

        for ($num = 1; $num <= $n; $num++) {
            if (Sudoku::isSafe($GRID, $col, $row, $num)) {
                $GRID[$row][$col] = $num;
                if (Sudoku::solveBoard($GRID, $n)) {
                    return true;
                } else {
                    $GRID[$row][$col] = 0;
                }
            }
        }
        return false;
    }

    public static function isSafe($GRID, $col, $row, $num): bool
    {
        for ($d = 0; $d < sizeof($GRID); $d++) {
            if ($GRID[$row][$d] == $num) {
                return false;
            }
        }

        for ($r = 0; $r < sizeof($GRID); $r++) {
            if ($GRID[$r][$col] == $num) {
                return false;
            }
        }

        $boxSize = (int)sqrt(sizeof($GRID));
        $boxRowStart = $row - $row % $boxSize;
        $boxColStart = $col - $col % $boxSize;

        for ($r = $boxRowStart; $r < $boxRowStart + $boxSize; $r++) {
            for ($d = $boxColStart; $d < $boxColStart + $boxSize; $d++) {
                if ($GRID[$r][$d] == $num) {
                    return false;
                }
            }
        }
        return true;

    }

}




