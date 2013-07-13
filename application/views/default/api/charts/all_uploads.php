<?php
$registered = $this->db->get_where('refrence', array('user' => '0'))->num_rows();
$anonym = $this->db->get_where('refrence', array('user !=' => '0'))->num_rows();
?>
$('#chart_data').html('');
	var jsondata = [
		{
			a: <?=$anonym?>,
			User: 'Anonymous'
		},
		{
			a: <?=$registered?>,
			User: 'Registered'
		}
	];
	var data = polyjs.data({
		data: jsondata
	});
	polyjs.chart({
		title: 'All Uploads',
		width: <?=$height?>,
		height: <?=$width?>,
		dom: 'chart_data',
		layers: [
			{
				data: data,
				type: 'bar',
				y: 'a',
				color: "User"
			}
		],
		coord: {
			type: 'polar'
		},
		guides: {
			y: {
				padding: 0,
				position: 'none'
			},
			x: {
				padding: 0,
				position: 'none'
			}
		}
	});