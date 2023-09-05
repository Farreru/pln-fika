<?php

$UnknownTable = json_decode(file_get_contents('http://localhost/pln/function.php?action=showDataWithUnitID&id=5'),true);

$systemGroups = [];
$jumlah_equipment = 1;

// Group data by system and unit
foreach ($UnknownTable as $row) {
    $systemName = $row["nama_system"];
    $unitName = $row["nama_unit"];
    if (!isset($systemGroups[$unitName])) {
        $systemGroups[$unitName] = [];
    }
    if (!isset($systemGroups[$unitName][$systemName])) {
        $systemGroups[$unitName][$systemName] = [];
    }
    $systemGroups[$unitName][$systemName][] = $row["nama_equipment"];
    $jumlah_equipment++;
}

// Generate the HTML table
echo '<table border="1" style="margin-top: 10px;">
    <tbody>
        <tr>
            <th>Unit</th>
            <th>System</th>
            <th>Equipment</th>
        </tr>';

foreach ($systemGroups as $unitName => $systems) {
    $firstUnit = true;
    $unitRowCount = 0;

    foreach ($systems as $systemName => $equipments) {
        $systemRowCount = count($equipments);
        // echo $systemRowCount . '- ini count';
        // $unitRowCount += $systemRowCount++ ;

        echo '<tr>';

        if ($firstUnit) {
            echo "<td rowspan='$jumlah_equipment'>$unitName</td>";
            $firstUnit = false;
        }

        echo "<td rowspan='$systemRowCount'>$systemName</td>";

        foreach ($equipments as $index => $equipment) {
            if ($index > 0) {
                echo '</tr><tr>';
            }
            echo "<td>$equipment</td>";
        }

        echo '</tr>';
    }
}

echo '</tbody></table>';
