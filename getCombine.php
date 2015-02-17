<?php
ini_set('memory_limit','2G');
$conn = mysql_connect('127.0.0.1', 'root', 'ivy7paul');
$db_selected = mysql_select_db('Jaguars', $conn);
if (!$conn) {
    die('Could not connect: ' . mysql_error());
}



function colorFunc($prob) {
    $redColors = array(248, 105, 107);
    $yellowColors = array(255, 235, 132);
    $greenColors = array(99, 190, 123);
    if ($prob < .50) {
        $red   = $redColors[0] + ((2*$prob) * ($yellowColors[0]-$redColors[0]));
        $green = $redColors[1] + ((2*$prob) * ($yellowColors[1]-$redColors[1]));
        $blue  = $redColors[2] + ((2*$prob) * ($yellowColors[2]-$redColors[2]));
    }
    else {
        $red =   $greenColors[0] + ((2-(2*$prob)) * ($yellowColors[0]-$greenColors[0]));
        $green = $greenColors[1] + ((2-(2*$prob)) * ($yellowColors[1]-$greenColors[1]));
        $blue =  $greenColors[2] + ((2-(2*$prob)) * ($yellowColors[2]-$greenColors[2]));
    }
    return "rgb(".intval($red).",".intval($green).",".intval($blue).")";
}


$players = array();
$autocomplete = array();

// keep track of the current ID we are working on
$curCid = 0;
$query = "SELECT * FROM dscombine WHERE (nflId IS NOT NULL OR year=2015) ORDER BY last ASC, first ASC ";
$result = mysql_query($query);
$eventNames = array( 'ht', 'wt', 'bmi', 'arm', 'hand', 'dash40', 'dash20', 'dash10', 'bench', 'vert', 'broad', 'cone', 'shuttle'  );
$events = array();
$label = array( 'ht'=>'Height', 'wt'=>'Weight', 'bmi'=>'BMI', 'arm'=>'Arm Length', 'hand'=>'Hand Size', 'dash40'=>'40Yd Dash', 'dash20'=>'20Yd Dash', 'dash10'=>'10Yd Dash', 'bench'=>'Bench Press', 'vert'=>'Vertical', 'broad'=>'Broad Jump', 'shuttle'=>'Shuttle', 'cone'=>'Cone Drill' );
$labelsm = array( 'ht'=>'Ht', 'wt'=>'Wt', 'bmi'=>'BMI', 'arm'=>'Arm', 'hand'=>'Hand', 'dash40'=>'40Yd', 'dash20'=>'20Yd', 'dash10'=>'10Yd', 'bench'=>'Bench', 'vert'=>'Vertical', 'broad'=>'Broad', 'shuttle'=>'Shuttle', 'cone'=>'Cone' );
$playerValues = array();
while ($row = mysql_fetch_assoc($result)) {
    if (!(array_key_exists($row['pos'], $playerValues)))
        $playerValues[$row['pos']] = array();
    $playerValues[$row['pos']][$row['dsid']] = array( 'dsid'=>$row['dsid'], 'name'=>$row['first'].' '.$row['last'], 'year'=>$row['year'], 'pos'=>$row['pos'], 'ht'=>$row['ht'], 'wt'=>$row['wt'], 'bmi'=>$row['bmi'], 'arm'=>$row['arm'], 'hand'=>$row['hand'], 'dash40'=>$row['dash40'], 'dash20'=>$row['dash20'], 'dash10'=>$row['dash10'], 'bench'=>$row['bench'], 'vert'=>$row['vert'], 'broad'=>$row['broad'], 'shuttle'=>$row['shuttle'], 'cone'=>$row['cone'], 'forcerankdash40'=>$row['forcerankdash40'], 'forcerankdash20'=>$row['forcerankdash20'], 'forcerankdash10'=>$row['forcerankdash10'], 'forcerankbench'=>$row['forcerankbench'], 'forcerankvert'=>$row['forcerankvert'], 'forcerankbroad'=>$row['forcerankbroad'], 'forcerankshuttle'=>$row['forcerankshuttle'], 'forcerankcone'=>$row['forcerankcone'], 'irankdash40'=>$row['irankdash40'], 'irankdash20'=>$row['irankdash20'], 'irankdash10'=>$row['irankdash10'], 'irankbench'=>$row['irankbench'], 'irankvert'=>$row['irankvert'], 'irankbroad'=>$row['irankbroad'], 'irankshuttle'=>$row['irankshuttle'], 'irankcone'=>$row['irankcone'] );
    array_push($autocomplete, array('value'=>$row['first']." ".$row['last'], 'data'=> $row['dsid'] ));
    $dsid = strval($row['dsid']);
    $players[$dsid] = array( 'dsid'=>$row['dsid'], 'name'=>$row['first'].' '.$row['last'], 'pos'=>$row['pos'], 'ht'=>$row['ht'], 'wt'=>$row['wt'], 'bmi'=>$row['bmi'], 'arm'=>$row['arm'], 'hand'=>$row['hand'], 'chart'=>array() );
    for ($i=0; $i < count($eventNames); $i++) { 
        $e = $eventNames[$i];
        $val = floatval($row[$e]);

        // update the player values
        array_push($players[$dsid]['chart'], array( 'event'=>$e, 'color'=>colorFunc($row['rank'.$e]), 'label'=>$label[$e], 'labelsm'=>$labelsm[$e], 'val'=>$row[$e], 'i'=>round(100*$row['i'.$e]), 'irank'=>round(100*$row['irank'.$e]), 'rank'=>round(100*$row['rank'.$e]), 'forcerank'=>round(100*$row['forcerank'.$e]), 'iforcerank'=>round(100*$row['iforcerank'.$e]) ));

        // update the event PDF
        if (!$val) continue;
        if (!(array_key_exists($eventNames[$i], $events))) {
            $events[$eventNames[$i]] = array(  );
        }
        if (!(array_key_exists($row['pos'], $events[$eventNames[$i]])))
            $events[$eventNames[$i]][$row['pos']] = array( 'min'=>$val, 'max'=>$val, 'values'=>array() );
        array_push($events[$eventNames[$i]][$row['pos']]['values'], $val);
        $events[$eventNames[$i]][$row['pos']]['min'] = min($val, $events[$eventNames[$i]][$row['pos']]['min']);
        $events[$eventNames[$i]][$row['pos']]['max'] = max($val, $events[$eventNames[$i]][$row['pos']]['max']);

    }
}
// sort the values
foreach ($events as $eventNames => $value) {
    foreach ($value as $pos => $v) {
        sort($events[$eventNames][$pos]['values']);
        if (in_array($eventNames, array( 'dash40', 'dash20', 'dash10', 'shuttle', 'cone' ))) {
            rsort($events[$eventNames][$pos]['values']);
        }
    }
}


echo json_encode(array( 'players'=>$players, 'playerValues'=>$playerValues, 'autocomplete'=>$autocomplete, 'events'=>$events ) );
mysql_close($conn);
return;

?>