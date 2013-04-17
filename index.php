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

echo "<table style='width:100%;' border='1px solid black;'>";
echo "<th>";
foreach ($groups as $group => $value)
    echo "<td width='$width%'>$group</td>";
echo "</th>";
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
echo "</table>";
