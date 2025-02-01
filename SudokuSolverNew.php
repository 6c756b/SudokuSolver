<style>
    body { background: #1D2844; }
    p,ul,ol,div,td,layer,table,body { font-family: Tahoma, Arial, Verdana, helvetica, sans-serif, times new roman; font-size: 12px; color: #61828F; }
    .submitsagen { color: #c4c4c4; font-size: 12px; font-weight: bold; border: 1px solid #404040; margin-left: 1px; margin-right: 1px; background-color: #1D2844; }
    table { border-collapse: collapse; }
    td { padding: 2px 5px; }
    
    .bg { background-color: #61828F; color: #1D2844; }
    .new { color: lime !important; font-weight: bold; }
    td input { background-color: #1D2844; color: white; width: 25px; border: 1px solid #404040; text-align: center; }
    td.bg input { background-color: #61828F; color: white; width: 25px; border: 1px solid #404040; text-align: center; }
    .solution td { padding: 4px 10px; }
</style>
<?php

function solveSudoku(&$board) {
    $row = $col = 0;

    // Find the next empty cell
    if (!findEmptyCell($board, $row, $col)) {
        return true; // No empty cells, puzzle solved
    }

    // Try digits 1-6
    for ($num = 1; $num <= 6; $num++) {
        if (isSafe($board, $row, $col, $num)) {
            $board[$row][$col] = $num;

            if (solveSudoku($board)) {
                return true;
            }

            $board[$row][$col] = 0; // Backtrack
        }
    }

    return false; // Trigger backtracking
}

function findEmptyCell($board, &$row, &$col) {
    for ($r = 0; $r < 6; $r++) {
        for ($c = 0; $c < 6; $c++) {
            if ($board[$r][$c] == 0) {
                $row = $r;
                $col = $c;
                return true;
            }
        }
    }
    return false;
}

function isSafe($board, $row, $col, $num) {
    return !inRow($board, $row, $num) &&
           !inCol($board, $col, $num) &&
           !inBox($board, $row - $row % 3, $col - $col % 2, $num);
}

function inRow($board, $row, $num) {
    for ($c = 0; $c < 6; $c++) {
        if ($board[$row][$c] == $num) {
            return true;
        }
    }
    return false;
}

function inCol($board, $col, $num) {
    for ($r = 0; $r < 6; $r++) {
        if ($board[$r][$col] == $num) {
            return true;
        }
    }
    return false;
}

function inBox($board, $startRow, $startCol, $num) {
    for ($r = 0; $r < 3; $r++) { // 2 Zeilen in der Box
        for ($c = 0; $c < 2; $c++) { // 3 Spalten in der Box
            if ($board[$startRow + $r][$startCol + $c] == $num) {
                return true;
            }
        }
    }
    return false;
}


function printBoard($board) {
    for ($r = 0; $r < 6; $r++) {
        for ($c = 0; $c < 6; $c++) {
            if ($c % 2 == 0) echo " | ";
            echo $board[$r][$c] . " ";
        }
        echo "<br />";
        if ($r == 2) echo "<hr />";
        echo PHP_EOL;
    }
}

function printBoard2($board, $colorArr) {
    // ------------------------------------------------------------------------------------------ LOESUNG
	echo "<br><br>L&ouml;sung:<br>";
	echo "<br><table class='solution'><tr>";
	$arrWhite = array(2, 3, 8, 9, 14, 15, 18, 19, 22, 23, 24, 25, 28, 29, 30, 31, 34, 35);
    $flattenedBoard = array_merge(...$board);
        
	foreach ($flattenedBoard as $i => $cell)
	{
		if ($i % 6 == 0 && $i > 0)
		{
			echo "</tr>\n<tr>";	
		}
		elseif ($i % 2 == 0 && $i > 0)
		{
			echo "<td>&nbsp;</td>";
		}

		if ($i == 18) { echo "<tr><td colspan=8 style='padding: 0px; border: 10px solid transparent;'></td></tr>\n"; }
		
		$bg = (in_array($i, $arrWhite)) ? "bg" : "";
		$new = ($colorArr[$i] == '') ? "new" : "";
		echo "<td class='$bg $new'>" . $cell . "</td>";


	}
	echo "</tr></table>\n";
}

function mapToInt($row) {
    return array_map(function($value) {
        return $value === "" ? 0 : (int)$value;
    }, $row);
}
// Example 6x6 Sudoku puzzle (0 represents an empty cell)
$board = [
    [0, 1, 0, 5, 0, 0],
    [5, 0, 0, 0, 0, 0],
    [0, 0, 3, 0, 2, 0],
    [1, 0, 0, 0, 0, 6],
    [0, 0, 0, 4, 0, 0],
    [0, 2, 0, 0, 0, 0],
];


if (isset($_POST["f"])) {
	
	$colorArr = array();
	foreach($_POST["f"] as $dim1) {
		foreach($dim1 as $dim2) {
			array_push($colorArr, $dim2);
		}
	}
    
    echo "<pre>";
	//$board = $_POST["f"]; // Inut Array 2-Dim    
    $board = array_map("mapToInt", $_POST["f"]);

    if (solveSudoku($board)) {
        //printBoard($board);
        printBoard2($board, $colorArr);
    } else {
        echo "No solution exists.";
    }
}
?>



<br /><br />


<form method="post" autocomplete="off">
  <table>
   <tr>
    <td class=""  ><input type="text" name="f[0][0]" value="<?=$_POST["f"][0][0];?>"></td>
    <td class=""  ><input type="text" name="f[0][1]" value="<?=$_POST["f"][0][1];?>"></td>
    <td class="bg"><input type="text" name="f[0][2]" value="<?=$_POST["f"][0][2];?>"></td>
    <td class="bg"><input type="text" name="f[0][3]" value="<?=$_POST["f"][0][3];?>"></td>
    <td class=""  ><input type="text" name="f[0][4]" value="<?=$_POST["f"][0][4];?>"></td>
    <td class=""  ><input type="text" name="f[0][5]" value="<?=$_POST["f"][0][5];?>"></td>
   </tr>
   <tr>
    <td class=""><input type="text" name="f[1][0]" value="<?=$_POST["f"][1][0];?>"></td>
    <td class=""><input type="text" name="f[1][1]" value="<?=$_POST["f"][1][1];?>"></td>
    <td class="bg"><input type="text" name="f[1][2]" value="<?=$_POST["f"][1][2];?>"></td>
    <td class="bg"><input type="text" name="f[1][3]" value="<?=$_POST["f"][1][3];?>"></td>
    <td class=""><input type="text" name="f[1][4]" value="<?=$_POST["f"][1][4];?>"></td>
    <td class=""><input type="text" name="f[1][5]" value="<?=$_POST["f"][1][5];?>"></td>
   </tr>
   <tr>
    <td class=""><input type="text" name="f[2][0]" value="<?=$_POST["f"][2][0];?>"></td>
    <td class=""><input type="text" name="f[2][1]" value="<?=$_POST["f"][2][1];?>"></td>
    <td class="bg"><input type="text" name="f[2][2]" value="<?=$_POST["f"][2][2];?>"></td>
    <td class="bg"><input type="text" name="f[2][3]" value="<?=$_POST["f"][2][3];?>"></td>
    <td class=""><input type="text" name="f[2][4]" value="<?=$_POST["f"][2][4];?>"></td>
    <td class=""><input type="text" name="f[2][5]" value="<?=$_POST["f"][2][5];?>"></td>
   </tr>
   <tr>
    <td class="bg"><input type="text" name="f[3][0]" value="<?=$_POST["f"][3][0];?>"></td>
    <td class="bg"><input type="text" name="f[3][1]" value="<?=$_POST["f"][3][1];?>"></td>
    <td class=""><input type="text" name="f[3][2]" value="<?=$_POST["f"][3][2];?>"></td>
    <td class=""><input type="text" name="f[3][3]" value="<?=$_POST["f"][3][3];?>"></td>
    <td class="bg"><input type="text" name="f[3][4]" value="<?=$_POST["f"][3][4];?>"></td>
    <td class="bg"><input type="text" name="f[3][5]" value="<?=$_POST["f"][3][5];?>"></td>
   </tr>
   <tr>
    <td class="bg"><input type="text" name="f[4][0]" value="<?=$_POST["f"][4][0];?>"></td>
    <td class="bg"><input type="text" name="f[4][1]" value="<?=$_POST["f"][4][1];?>"></td>
    <td class=""><input type="text" name="f[4][2]" value="<?=$_POST["f"][4][2];?>"></td>
    <td class=""><input type="text" name="f[4][3]" value="<?=$_POST["f"][4][3];?>"></td>
    <td class="bg"><input type="text" name="f[4][4]" value="<?=$_POST["f"][4][4];?>"></td>
    <td class="bg"><input type="text" name="f[4][5]" value="<?=$_POST["f"][4][5];?>"></td>
   </tr>
   <tr>
    <td class="bg"><input type="text" name="f[5][0]" value="<?=$_POST["f"][5][0];?>"></td>
    <td class="bg"><input type="text" name="f[5][1]" value="<?=$_POST["f"][5][1];?>"></td>
    <td class=""><input type="text" name="f[5][2]" value="<?=$_POST["f"][5][2];?>"></td>
    <td class=""><input type="text" name="f[5][3]" value="<?=$_POST["f"][5][3];?>"></td>
    <td class="bg"><input type="text" name="f[5][4]" value="<?=$_POST["f"][5][4];?>"></td>
    <td class="bg"><input type="text" name="f[5][5]" value="<?=$_POST["f"][5][5];?>"></td>
   </tr>


</table>
<br />
<input type="submit" name="submit" value="Submit" class="submitsagen">

</form>

<script type="text/javascript" src="../js/jquery.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function () {

      $('input').keyup(function (e) {
        if (e.which == 39) { // right arrow
          $(this).closest('td').next().find('input').focus();

        } else if (e.which == 37) { // left arrow
          $(this).closest('td').prev().find('input').focus();

        } else if (e.which == 40) { // down arrow
          $(this).closest('tr').next().find('td:eq(' + $(this).closest('td').index() + ')').find('input').focus();

        } else if (e.which == 38) { // up arrow
          $(this).closest('tr').prev().find('td:eq(' + $(this).closest('td').index() + ')').find('input').focus();
        } else { // KeyUp - Move to next input
			$(this).closest('td').next().find('input').focus();
		}
      });
    });
  </script>
