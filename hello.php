<html>
<head>
    <title>Sudoku Solver</title>
</head>
<body>
<?php
require 'Sudoku.php';
# First Example
$GRID = array(
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
$s = new Sudoku($GRID);
Sudoku::printSudoku($GRID);

echo "<br>";
Sudoku::solveBoard($GRID, 9);

echo "ENDE";
?>
</body>
</html>