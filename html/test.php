<?php

header( "Content-type: application/vnd.ms-excel; charset=euc-kr" );
header( "Expires: 0" );
header( "Cache-Control: must-revalidate, post-check=0,pre-check=0" );
header( "Pragma: public" );
header( "Content-Disposition: attachment; filename=test.xls" );

$a   = array("1","2","3");
$b   = array("2","4","5");
$sum = array("3","6","8");

echo "
    <table>
    <tr>
        <td>a</td>
        <td>b</td>
        <td>sum</td>
    </tr>
    ";

for($i=0; $i<3; $i++) {
        echo "<tr><td>$a[$i]</td><td>$b[$i]</td><td>$sum[$i]</td></tr>";
}

echo "
    </table>
    ";
?>
