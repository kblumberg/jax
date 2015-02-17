<!-- cd ~/Sites/combine -->
<!DOCTYPE html>
<html lang="en">
<head>
	<title>NFL Combine Tool</title>

	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- Core JS -->
	<script src="js/jquery.min.js"></script>

	<!-- DataTables -->
	<link rel="stylesheet" type="text/css" href="css/site.css">
	<link rel="stylesheet" type="text/css" href="css/dataTables.css">
	<script type="text/javascript" src="js/site.js"></script>
	<script type="text/javascript" language="javascript" src="js/dataTables.min.js"></script>

	<script src="js/bootstrap.min.js"></script>

	<!-- Sliders -->
	<script src="js/plugin.js"></script>
	<script src="js/main.js"></script>
	<link href="css/sliders.css" media="all" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="css/custom.css" rel="stylesheet">

	<!-- Autocomplete -->
	<script src="js/jquery.autocomplete.min.js"></script>

	<!-- AM Charts -->
	<script src="js/amcharts/amcharts.js" type="text/javascript"></script>
	<script src="js/amcharts/serial.js" type="text/javascript"></script>

	<!-- Bootstrap Switch -->
	<script src="js/bootstrap-switch.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="css/bootstrap-switch.css">
</head>
<body>

	

	<nav class="navbar navbar-inverse navbar-fixed-top">
	  <!-- <div class="container"> -->
		<div class="navbar-header">
			<img id="jaguar" src="img/jaguar-shield.png" />
		</div>
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Jacksonville Jaguars NFL Combine Tool</a>

			</div>
			<div class="navbar-header" style="float:right; padding-right:70px;">
			<div id="search">
				<input id="player-search" type="text" class="form-control" placeholder="Search for...">
			</div>
		</div>
	</nav>
	<a id="add-player" class="add-action-plus btn btn-info btn-lg">
	<!--  data-toggle="modal" -->
			<span  style="font-size:18px;" class="glyphicon glyphicon-plus"></span>
	</a>
	<div class="container">
		<!-- <div class="row">
			<div class="col-lg-8"></div>
			<div class="col-lg-4">
				<input id="player-search" type="text" class="form-control" placeholder="Search for...">
			</div>
		</div> -->

		<div class="row">
			<div class="col-lg-7" id="playerSpotlight" >
				<div class="demo">
					<div id="playerSpotlightChart"></div>
					<div id="playerInputs">
						<?php
							$_eventNames = array( 'ht', 'wt', 'bmi', 'dash40', 'dash20', 'dash10', 'bench', 'vert', 'broad', 'cone', 'shuttle' );
							echo "<div class='control-group'>";
							for ($i=0; $i < count($_eventNames); $i++) { 
								echo "<div class='input-right'><input type='text' for='".$_eventNames[$i]."' ></input></div>";
							}
							echo "</div>";
						?>
					</div>
				</div>
			</div>
			<div class="col-lg-5" id="similarPlayers">
				<div class="demo" id="similarPlayersChart">
					<table class="" id="simTable">
						
					</table>
				</div>
			</div>
		</div>
		<!-- <div class="row" >
			<div class="col-lg-12 demo" id="sliders"></div>
		</div> -->
		<div class="row" >
			<div class="col-lg-12 demo" id="table">
				<div class="panel with-nav-tabs panel-primary">
					<div class="panel-heading">
						<ul class="nav nav-tabs nav-justified"> 
						<?php
							$pos = array( 'C', 'CB', 'DE', 'DT', 'FB', 'FS', 'ILB', 'OG', 'OLB', 'OT', 'QB', 'RB', 'SS', 'TE', 'WR' );
							for ($i=0; $i < count($pos); $i++) { 
								if (!$i) 	echo '<li class="active" pos="'.$pos[$i].'"><a href="#tab'.$pos[$i].'" data-toggle="tab">'.$pos[$i].'</a></li>';
								else 		echo '<li pos="'.$pos[$i].'"><a href="#tab'.$pos[$i].'" data-toggle="tab">'.$pos[$i].'</a></li>';
							}
						?>
						</ul>
					</div>
					<div class="panel-body">
						<div class="tab-content">

							<?php
								$pos = array( 'C', 'CB', 'DE', 'DT', 'FB', 'FS', 'ILB', 'OG', 'OLB', 'OT', 'QB', 'RB', 'SS', 'TE', 'WR' );
								for ($i=0; $i < count($pos); $i++) { 
									if (!$i) 	echo '<div class="tab-pane fade in active" id="tab'.$pos[$i].'">';
									else 		echo '<div class="tab-pane fade" id="tab'.$pos[$i].'">';
									echo "<table id='table".$pos[$i]."' class='table table-hover' ></table>";
									echo "</div>";
								}
							?>
						</div>
					</div>
				</div>
				<!-- <table id="example" class="table table-hover" ></table> -->
			</div>
		</div>
	</div>
	<div id="backdrop" class="modal-backdrop fade in hidden"></div>


	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

<div id="add-contract-modal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<!-- <button type="button" class="close" data-dismiss="modal">×</button> -->
				<h3>Add a Prospect</h3>
			</div>
			<div class="modal-body">
				<form id="add-contract-form">

				<?php 
					$labels = array(
						'first'=> 'First Name',
						'last'=> 'Last Name',
						'pos'=> 'Position',
						'ht'=> 'Height',
						'wt'=> 'Weight',
						'bmi'=> 'BMI',
						'dash40'	=> '40yd Dash',
						'dash20'	=> '20yd Dash',
						'dash10'	=> '10yd Dash',
						'bench'	=> 'Bench Press',
						'vert'	=> 'Vertical',
						'broad'	=> 'Broad Jump',
						'cone'	=> 'Cone Drill',
						'shuttle'=> 'Shuttle',
					);
					foreach ($labels as $key => $value) {
						echo 
						'<div class="control-group">
							<label class="input-left" for="'.$key.'">'.$value.'</label>
							<div class="input-right">
								<input type="text" name="'.$key.'" />
							</div>
						</div>';
					}
				?>
				</form>
			</div>
			<div class="modal-footer"> 

			<button type="button" class="pull-left btn btn-link" data-dismiss="modal">Cancel</button>
			<button id="add-submit" class="btn btn-primary disabled "   data-dismiss="modal">Add</button>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript" src="js/prettify.js"></script>
<script type="text/javascript" src="js/jquery.sortable5.min.js"></script>
<script type="text/javascript" src="js/jquery.pnotify.min.js"></script>
<script type="text/javascript">

var stadium = (function () {
    var json = null;
    $.ajax({
        'async': true,
        'global': false,
        'url': 'data/json/topDist.json',
        'dataType': "json",
        'success': function (data) {
        	console.log('data');
        	console.log(data);
            json = data;
        },
		error: function(XMLHttpRequest, textStatus, errorThrown) { 
			alert("Status: " + textStatus); alert("Error: " + errorThrown); 
		}
    });
    return json;
})(); 
console.log(stadium);

var _players=null, _autocomplete=null, _events=null;
var _player=null;
var _timedEvents = [ 'dash40', 'dash20', 'dash10', 'shuttle', 'cone' ];
var _measuredEvents = [ 'ht', 'broad' ];
var _labels = {
	'ht': 'Height',
	'wt': 'Weight',
	'bmi': 'BMI',
	'dash40'	: '40yd Dash',
	'dash20'	: '20yd Dash',
	'dash10'	: '10yd Dash',
	'bench'	: 'Bench Press',
	'vert'	: 'Vertical',
	'broad'	: 'Broad Jump',
	'cone'	: 'Cone Drill',
	'shuttle': 'Shuttle',
}
var _labelssm = {
	'ht': 'Ht',
	'wt': 'Wt',
	'bmi': 'BMI',
	'dash40'	: '40yd',
	'dash20'	: '20yd',
	'dash10'	: '10yd',
	'bench'	: 'Bench',
	'vert'	: 'Vertical',
	'broad'	: 'Broad',
	'cone'	: 'Cone',
	'shuttle': 'Shuttle',
}
var _icoefs=null, _wcoefs=null;
$.getJSON("data/json/icoefs.json", function(json) {
	_icoefs = json;
});
$.getJSON("data/json/wcoefs.json", function(json) {
	_wcoefs = json;
});


// convert score to color gradient
function colorFunc(val) {
	val = val/100.0;
	redColors = [248, 105, 107];
	greenColors = [255, 235, 132];
	blueColors = [99, 190, 123];
	if (val < .5) {
		var red = redColors[0] + (1-(2*val)) * (greenColors[0]-redColors[0]);
		var green = redColors[1] + (1-(2*val)) * (greenColors[1]-redColors[1]);
		var blue = redColors[2] + (1-(2*val)) * (greenColors[2]-redColors[2]);
	}
	else {
		var red = blueColors[0] - (2-(2*val)) * (blueColors[0]-greenColors[0]);
		var green = blueColors[1] - (2-(2*val)) * (blueColors[1]-greenColors[1]);
		var blue = blueColors[2] - (2-(2*val)) * (blueColors[2]-greenColors[2]);
	}
	return "rgb("+parseInt(red)+","+parseInt(green)+","+parseInt(blue)+")";
}


function makeChart (typ, player, animated) {
	// for (var i=0; i<_players[player.dsid]['chart'].length; i++) {
	// 	var c = _players[player.dsid]['chart'][i];
	// 	var r = getRanking(c['event'], parseFloat(c['val']), player.pos);
	// 	c['rank'] = Math.round(r);
	// }
	// console.log('makeChart');
	// console.log(player);
	// return;	
	var chart = AmCharts.makeChart(typ+'Chart', {
	"titles": [{
		"text": player.name,
		"size": 15
	}],
	"type": "serial",
	"theme": "light",
	"dataProvider": player.chart,
	"valueAxes": [{
		"maximum": 100,
		"minimum": 0,
		"axisAlpha": 0,
		"dashLength": 4,
		"position": "left"
	}],
	"startDuration": animated,
	"graphs": [{
		"balloonText": "<span style='font-size:13px;'>[[label]]: <b>[[val]] ([[rank]]%)</b></span>",
		"bulletOffset": 16,
		"bulletSize": 34,
		"colorField": "color",
		// "color": "#000000",
		"cornerRadiusTop": 8,
		// "customBulletField": "bullet",
		"fillAlphas": 0.8,
		"lineAlpha": 0,
		"type": "column",
		"valueField": "rank",
		"customBulletField": "bullet",
		"labelText": '[[labelsm]]',
		"labelPosition": 'inside',
		"lineColor": '#000000',
		'fontSize': 10,
	}],
	"marginTop": 0,
	"marginRight": 0,
	"marginLeft": 0,
	"marginBottom": 0,
	"autoMargins": false,
	"categoryField": "stage",
	"categoryAxis": {
		"axisAlpha": 0,
		"gridAlpha": 0,
		// "inside": true,
		"tickLength": 0
	},  
	"exportConfig":{
	"menuTop":"0px",
	"menuRight":"0px",
	"menuItems": [{
		"icon": 'http://www.amcharts.com//lib/3/images/export.png',
		"format": 'png'   
	}]  
	}
});
}

function getWtAdjScore (pos, event, wt, val) {

}

$('#table, #simTable').on('click', 'tr[dsid]', function () {
	console.log('player is now');
	_player = _players[$(this).attr('dsid')];
	drawSliders(_player);
	makeChart('playerSpotlight', _player , 1);
	getSimilar(_player);
})


// $(document).ready( function () {
// 	$('#example').dataTable();
// } );

function drawTable (pos) {
	var newHtml = '<thead><tr><th>Player</th><th>Year</th><th>Position</th>';
	for (var i=0; i<_eventNames.length; i++) {
		newHtml += '<th>'+_labels[_eventNames[i]]+'</th>';
		// newHtml += '<th>'+_eventNames[i]+'</th><th>Force'+_eventNames[i]+'</th>';
	}
	newHtml += '</tr></thead><tbody>'
	for (var dsid in _playerValues[pos]) {
		var p = _playerValues[pos][dsid];
		newHtml += '<tr dsid="'+p['dsid']+'">';
		newHtml += '<td>'+p.name+'</td>'+'<td>'+p.year+'</td>'+'<td>'+p.pos+'</td>';
		for (var j=0; j<_eventNames.length; j++) {
			var e = _eventNames[j];
			if (!p[e])
				newHtml += '<td>-</td>';
			else
				newHtml += '<td>'+p[e]+'</td>';
			// newHtml += '<td>'+p[e]+'</td><td>'+p['forcerank'+e]+'</td>';
		}
		newHtml += '</tr>';
	}
	newHtml +='</tbody></table>'
	document.getElementById('table'+pos).innerHTML = newHtml;
	if (!$('#table'+pos).hasClass('dataTable'))
		$('#table'+pos).dataTable();
}

function drawSliders (player) {
	console.log(player);
	/*
	var newHtml = '';
	for (var i=0; i<_eventNames.length; i++) {

		var mx = ($.inArray(e, _timedEvents)>=0) ? (_events[e][player.pos].max*100)+10 : _events[e][player.pos].max+5;
		var mn = ($.inArray(e, _timedEvents)>=0) ? Math.max(0, (_events[e][player.pos].min*100)-10) : Math.max(0, _events[e][player.pos].min-5);
		var val = null;
		for (var j=0; j<player.chart.length; j++) {
			if (player.chart[j]['event']==e) {
				val=player.chart[j]['val'];
				if ($.inArray(e, _timedEvents)>=0) val = Math.round(val*100);
				break;
			}
		}
		var checked = val ? 'checked' : '';	
		var disabled = val ? '' : 'disabled';	
		if (e=='vert') {
			newHtml += '<div class="row"><div class="col-lg-2">'+_labels[e]+'<input style="float:right" data-off-text="Off" data-on-text="On" data-label-width="15px" data-handle-width="15px" type="checkbox" name="my-checkbox" '+checked+'></input></div><div class="col-lg-8 '+disabled+'"><input data-kind='+e+' class="slider" data-slider-max="'+mx*2+'" data-slider-min="'+mn*2+'" data-slider-value="'+val*2+'" type="text"></div></div>';
		}
		else
			newHtml += '<div class="row"><div class="col-lg-2">'+_labels[e]+'<input style="float:right" data-off-text="Off" data-on-text="On" data-label-width="15px" data-handle-width="15px" type="checkbox" name="my-checkbox" '+checked+'></input></div><div class="col-lg-8 '+disabled+'"><input data-kind='+e+' class="slider" data-slider-max="'+mx+'" data-slider-min="'+mn+'" data-slider-value="'+val+'" type="text"></div></div>';
	}*/

	newHtml = '<div class=\'control-group\'>';
	for (var i=0; i<_eventNames.length; i++) {
		var e = _eventNames[i];
		var val = 0;
		for (var j=0; j<player.chart.length; j++) {
			if (player.chart[j]['event']==e) {
				val=player.chart[j]['val'];
				$('input[for="'+e+'"]').html('');
				if (!val) 
					val = '';
				else if ($.inArray(e, _timedEvents)>=0) {
					$('input[for="'+e+'"]').attr('placeholder', Math.round(val*100)/100);
				}
				else if ($.inArray(e, _measuredEvents)>=0) {
					$('input[for="'+e+'"]').attr('placeholder', parseInt(val)+"\'"+Math.round(((val%1)+0.005)*12));
				}
				else {
					$('input[for="'+e+'"]').attr('placeholder', val);
				}
				val = Math.round(val*100)/100;
				// else if ($.inArray(e, _measuredEvents)>=0) {
				// 	var separators = ['\.' ];
				// 	console.log('val: '+parseInt(val)+'\''+Math.round((val%1)*12)+'\"');
				// 	var tokens = val.toString().split(new RegExp(separators.join('|'), 'g'));
				// 	console.log(tokens);
				// 	val = parseInt(val)+'\''+Math.round((val%1)*12)+'\"';
				// 	// val = parseInt(tokens[0])*12 + parseInt(tokens[1]);
				// 	console.log(escape(val));
				// }
			}
		}
		if (!val) val='';
		if ($.inArray(e, _measuredEvents)>=0) {
			var placeholder = parseInt(val)+"\'"+Math.round(((val%1)+0.01)*12)+"\"";
			console.log(placeholder);
			newHtml += '<div class=\'input-right\'><input placeholder="'+parseInt(val)+"\'"+Math.round(((val%1)+0.005)*12)+'" type=\'text\' for=\''+e+'\' ></input></div>';
		}
		else 
			newHtml += "<div class='input-right'><input placeholder='"+(val)+"' type='text' for='"+e+"' ></input></div>";
	}
	newHtml += '</div>';

	// document.getElementById('playerInputs').innerHTML = newHtml;
	// $('.slider').slider();
	// $("[name='my-checkbox']").bootstrapSwitch();
}

function updatePlayer (p, e, v, r) {
	// if (e=='ht' || e=='wt') {
	// 	_players[p][e] = v;
	// 	return;
	// }
	_playerValues[p.pos][p.dsid][e] = v;
	_playerValues[p.pos][p.dsid]['i'+e] = v;
	_playerValues[p.pos][p.dsid]['rank'+e] = r;
	_playerValues[p.pos][p.dsid]['irank'+e] = r;
	var c = _players[parseInt(p.dsid)]['chart'];
	for (var i=0; i<c.length; i++) {
		if (c[i]['event']==e) {
			c[i]['val'] = v;
			c[i]['rank'] = Math.round(r);
			c[i]['color'] = colorFunc(r);
			_playerValues[p.pos][p.dsid][e] = Math.round(v*100)/100;
			_playerValues[p.pos][p.dsid]['i'+e] = bmi;
			_playerValues[p.pos][p.dsid]['rank'+e] = Math.round(r);
			_playerValues[p.pos][p.dsid]['irank'+e] = r;
		}
		else if ((e=='ht' || e=='wt') && c[i]['event']=='bmi') {
			var ht = _playerValues[p.pos][p.dsid]['ht'];
			var wt = _playerValues[p.pos][p.dsid]['wt'];
			var bmi = (wt*703) / (ht*12*ht*12);
			var r = getRanking('bmi', bmi, p.pos);
			c[i]['val'] = bmi;
			c[i]['rank'] = r;
			c[i]['color'] = colorFunc(r);
			_playerValues[p.pos][p.dsid]['bmi'] = Math.round(bmi*100)/100;
			_playerValues[p.pos][p.dsid]['ibmi'] = bmi;
			_playerValues[p.pos][p.dsid]['rankbmi'] = Math.round(r);
			_playerValues[p.pos][p.dsid]['irankbmi'] = r;
			$('#playerInputs input[for="bmi"]').attr('placeholder', Math.round(bmi*100)/100);
		}
	}
	console.log(p);
	makeChart('playerSpotlight', _players[parseInt(p.dsid)], 0);
	getSimilar(_player);

}

function getRanking (e, v, p) {
	var vs = _events[e][p]['values'];
	var len = vs.length;
	for (var i=0; i<len; i++) {
		if ($.inArray(e, _timedEvents)>=0 && vs[i]<v) {
			return i*100 / len;
		}
		else if ($.inArray(e, _timedEvents)<0 && vs[i]>v) {
			return i*100 / len;
		}
	}
	return 99;
}

function compareSim(a,b) {
	if (a.sim < b.sim) return -1;
	if (a.sim > b.sim) return 1;
	return 0;
}

function getSimilar (p1) {
	console.log('getSimilar');
	p1 = _playerValues[p1.pos][p1.dsid];
	console.log(p1);
	sims = []
	for (var dsid in _playerValues[p1.pos]) {
		var p2 = _playerValues[p1.pos][dsid];
		if (p2.dsid==p1.dsid) continue;
		var sim = 0;
		for (var j=0; j<_eventNames.length; j++) {
			var e = _eventNames[j];
			var s = Math.abs(parseFloat(p1['irank'+e])-parseFloat(p2['irank'+e]) )
			if (isNaN(s)) s=1;
			sim += s;
		}
		sims.push({'player':p2, 'sim':sim});
	}
	sims.sort(compareSim);
	console.log(sims);
	var newHtml = '<thead><tr><th>Name</th>';
	for (var j=0; j<_eventNames.length; j++)
		newHtml += '<th>'+_labelssm[_eventNames[j]]+'</th>';
	newHtml += '</tr></thead><tbody>';

	for (var i=0; i<10; i++) {
		newHtml += '<tr dsid="'+sims[i].player.dsid+'"><td>'+sims[i].player.name+'</td>';
		for (var j=0; j<_eventNames.length; j++) {
			var e = _eventNames[j];
			if (!sims[i].player[e]) 
				newHtml += '<td>-</td>';
			else if ($.inArray(e, ['ht', 'bmi', 'dash40', 'dash20', 'dash10', 'broad', 'shuttle', 'cone'] )>=0)
				newHtml += '<td>'+Math.round(sims[i].player[e]*100)/100+'</td>';
			else
				newHtml += '<td>'+Math.round(sims[i].player[e])+'</td>';
		}
		newHtml += '</tr>';
	}
	newHtml += '</tbody>';
	document.getElementById('simTable').innerHTML = newHtml;

}

$.post('getCombine.php', null, function(data) {
	data = JSON.parse(data);
	console.log(data);
	_events = data['events'];
	_eventNames = [ 'ht', 'wt', 'bmi', 'dash40', 'dash20', 'dash10', 'bench', 'vert', 'broad', 'cone', 'shuttle' ];
	_players = data['players'];
	_playerValues = data['playerValues'];
	drawTable('C');
	_autocomplete = data['autocomplete'];





	$('#player-search').autocomplete({
		lookup: _autocomplete,
		onSelect: function (suggestion) {
			_player = _players[suggestion.data];
			console.log('player is now');
			console.log(_player);
			drawSliders(_player);
			makeChart('playerSpotlight', _player, 1);
			getSimilar(_player);
		}
	});
});

$("#playerInputs input").focusout(function() {
	console.log($(this));
	console.log($(this).attr('for'));
	console.log(_player);
	var e = $(this).attr('for');
	var pos = _player.pos;
	var val = $(this).val();
	console.log('Changed '+e+' to '+val+' ('+pos+')');
	if (val=='') val = $(this).attr('placeholder');
	if ($.inArray(e, _measuredEvents)>=0) {
		val = parseInt(val.split('\'')[0]) + (parseInt(val.split('\'')[1])/12.0);
	}
	console.log('Changed '+e+' to '+val+' ('+pos+')');
	var r = getRanking(e, val, pos);
	updatePlayer(_player, e, val, r);
	// if ($.inArray(e, _timedEvents)) {};
	// console.log('inside');
});

$('#table ul.nav-tabs li').click(function () {
	console.log($(this).attr('pos'));
	drawTable($(this).attr('pos'));
})


	// $('#add-contract-modal').modal('show').on('shown.bs.modal', function () {
	// 	console.log('HOOWO');
	// });

$('#add-player').click(function () {
	$('#add-contract-modal').modal('show').on('shown.bs.modal', function () {
		console.log('HOOWO');
	});
})

</script>
  </body>
</html>
