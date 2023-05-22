<?php

// PHP program to find rank of a matrix
// @source https://www.geeksforgeeks.org/program-for-rank-of-matrix/

$R = 3;
$C = 3;

/* function for exchanging two rows of
a matrix */
function swap(&$mat, $row1, $row2, $col)
{
    for ($i = 0; $i < $col; $i++)
    {
        $temp = $mat[$row1][$i];
        $mat[$row1][$i] = $mat[$row2][$i];
        $mat[$row2][$i] = $temp;
    }
}


/* function for finding rank of matrix */
function rankOfMatrix($mat)
{
    global $R, $C;
    $rank = $C;

    for ($row = 0; $row < $rank; $row++)
    {
        // Before we visit current row 'row', we make
        // sure that mat[row][0],....mat[row][row-1]
        // are 0.

        // Diagonal element is not zero
        if ($mat[$row][$row])
        {
            for ($col = 0; $col < $R; $col++)
            {
                if ($col != $row)
                {
                    // This makes all entries of current
                    // column as 0 except entry 'mat[row][row]'
                    $mult = $mat[$col][$row] / $mat[$row][$row];
                    for ($i = 0; $i < $rank; $i++)
                        $mat[$col][$i] -= $mult * $mat[$row][$i];
                }
            }
        }

        // Diagonal element is already zero. Two cases
        // arise:
        // 1) If there is a row below it with non-zero
        // entry, then swap this row with that row
        // and process that row
        // 2) If all elements in current column below
        // mat[r][row] are 0, then remove this column
        // by swapping it with last column and
        // reducing number of columns by 1.
        else
        {
            $reduce = true;

            /* Find the non-zero element in current
                column */
            for ($i = $row + 1; $i < $R; $i++)
            {
                // Swap the row with non-zero element
                // with this row.
                if ($mat[$i][$row])
                {
                    swap($mat, $row, $i, $rank);
                    $reduce = false;
                    break ;
                }
            }

            // If we did not find any row with non-zero
            // element in current column, then all
            // values in this column are 0.
            if ($reduce)
            {
                // Reduce number of columns
                $rank--;

                // Copy the last column here
                for ($i = 0; $i < $R; $i++)
                    $mat[$i][$row] = $mat[$i][$rank];
            }

            // Process this row again
            $row--;
        }

        // Uncomment these lines to see intermediate results
        // display(mat, R, C);
        // printf("\n");
    }
    return $rank;
}

/* function for displaying the matrix */
function display($mat, $row, $col)
{
    for ($i = 0; $i < $row; $i++)
    {
        for ($j = 0; $j < $col; $j++)
            print(" $mat[$i][$j]");
        print("\n");
    }
}

// Driver code
// rank = 2 (OK)
/*
$mat = array(array(10, 20, 10),
    array(-20, -30, 10),
    array(30, 50, 0));
*/

// rank = 2 (OK)
$mat = array(
    array(-1, 1, -1, -2, 0),
    array(2, 2, 6, 0, 0, -4),
    array(4, 3, 11, 1, -7)
);

print("Rank of the matrix is : ".rankOfMatrix($mat));

// This code is contributed by mits
