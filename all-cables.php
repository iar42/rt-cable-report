<?php

$tabhandler['reports']['allcables'] = 'DisplayAllCables'; // register a report rendering function
$tab['reports']['allcables'] = 'All Cables'; // title of the report tab

function DisplayAllCables()
{
	$query = 'SELECT L.cable AS cableid, O.name AS dev1, P.name AS port1, D.dict_value as type1, ' .
	         '       O2.name AS dev2, P2.name as port2, D2.dict_value as type2 ' .
	         'FROM Link as L ' .
	         'LEFT JOIN Port as P on P.id = L.porta ' .
	         'LEFT JOIN Port as P2 on P2.id = L.portb ' .
	         'LEFT JOIN Object as O on O.id = P.object_id ' .
	         'LEFT JOIN Object as O2 on O2.id = P2.object_id ' .
	         'LEFT JOIN Dictionary as D on D.dict_key = P.type ' .
	         'LEFT JOIN Dictionary as D2 on D2.dict_key = P2.type ' .
	         'ORDER BY L.cable DESC';
	$result = usePreparedSelectBlade ($query);
	$row = $result->fetch (PDO::FETCH_ASSOC);

	echo '<div class=portlet>';
	echo "<h2>All Cables:</h2>";
	echo '<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>';
	echo '<tr>';
	echo '<th>Cable ID</th>';
	echo '<th>Device 1</th>';
	echo '<th>Port 1</th>';
	echo '<th>Type 1</th>';
	echo '<th>Device 2</th>';
	echo '<th>Port 2</th>';
	echo '<th>Type 2</th>';
	echo '</tr>';
	$count = 0;
	$lastcableid = "";
        foreach ($result as $row)
        {
		if( $lastcableid == $row['cableid'] ) { $count--; }
		echo '<tr class="row_' . (++$count%2 ? "odd" : "even") . ' tdleft" valign=top>';
		echo '<td><b>' . $row['cableid'] . '</b></td>';
		echo '<td><b>' . $row['dev1'] . '</b></td>';
		echo '<td><b>' . $row['port1'] . '</b></td>';
		echo '<td>' . $row['type1'] . '</td>';
		echo '<td><b>' . $row['dev2'] . '</b></td>';
		echo '<td><b>' . $row['port2'] . '</b></td>';
		echo '<td>' . $row['type2'] . '</td>';
		#print_r($row);
		echo '</tr>';
		$lastcableid = $row['cableid'];
	}
	echo '</table>';
	echo '</div>';
}

?>
