<style>
.yes {background:green;}
.maybe {background:yellow;}
.no {background:red;}
</style>

<?php
$allUsers = Array();

exec('grep -v :$ /etc/group', $lines);

foreach ($lines as $key => $line) {
    $temp = explode(':', $line);
    $users = explode(',', $temp[3]);
    foreach ($users as $user){
        $allUsers[$user] = true;
        $groups[$temp[0]][$user] = true;
    }
}

$width = 100 / (count($groups) + 1);

echo "<table id='myTable' class='tablesorter' style='width:100%;'>";
echo "<thead><tr><th>";
foreach ($groups as $group => $value)
    echo "<td  width='$width%'>$group</td>";
echo "</th></tr>";
echo "<tbody>";
foreach ($allUsers as $allUser => $n){
    echo "<tr>";
    echo "<td>$allUser</td>";
    foreach ($groups as $group => $users)
        if (array_key_exists($allUser, $users))
            echo "<td class='yes'></td>";
        else
            if (array_key_exists($allUser, $groups['sudo']))
                echo "<td class='maybe'></td>";
            else
                echo "<td class='no'></td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";

echo "<link rel='stylesheet' href='js/blue/style.css'>";
echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>";
echo "<script type='text/javascript' src='js/jquery.tablesorter.min.js'></script> 
<script>
$(document).ready(function() 
    { 
        $('#myTable').tablesorter(); 
    } 
);
</script>";
