<html>
<head>
    <title>Sudoku Solver</title>
</head>
<body>
<?php
require 'Sudoku.php';
# First Example

$sudoku = new Sudoku(9);
$GRID = $sudoku->getGrid();
$sudoku->createTestBoard();
$sudoku->printBoard();
echo sizeof($GRID);
if ($sudoku::solveBoard($GRID, 9)) ;
{
    echo "<p>Solution:</p>";
    $sudoku->printBoard();
}

?>
</body>
</html>