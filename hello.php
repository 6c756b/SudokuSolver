<html>
<head>
    <title>Sudoku Solver</title>
</head>
<body>
<?php
require 'Sudoku.php';
# First Example

$sudoku = new Sudoku(9);
$sudoku->createTestBoard();
$sudoku->printBoard();

?>
</body>
</html>