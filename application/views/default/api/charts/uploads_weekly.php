$('#chart_data').html('');
var jsondata = [
	{
		Day: '<?php $d = '-6'; echo date('Y-m-d', strtotime($d.' days')) ?>',
		Uploads: '<?=	$this->db ->get_where('refrence', array('time >' => strtotime($d.' days 12:00 AM'), 'time <' => strtotime($d.' days 11:59:59 PM')))->num_rows() ?>',
		index:0
	}, {
		Day: '<?php $d = '-5'; echo date('Y-m-d', strtotime($d.' days')) ?>',
		Uploads: '<?=	$this->db->get_where('refrence', array('time >' => strtotime($d.' days 12:00 AM'), 'time <' => strtotime($d.' days 11:59:59 PM')))->num_rows() ?>',
		index:1
	}, {
		Day: '<?php $d = '-4'; echo date('Y-m-d', strtotime($d.' days')) ?>',
		Uploads: '<?=	$this->db->get_where('refrence', array('time >' => strtotime($d.' days 12:00 AM'), 'time <' => strtotime($d.' days 11:59:59 PM')))->num_rows() ?>',
		index:2
	}, {
		Day: '<?php $d = '-3'; echo date('Y-m-d', strtotime($d.' days')) ?>',
		Uploads: '<?=	$this->db->get_where('refrence', array('time >' => strtotime($d.' days 12:00 AM'), 'time <' => strtotime($d.' days 11:59:59 PM')))->num_rows() ?>',
		index:3
	}, {
		Day: '<?php $d = '-2'; echo date('Y-m-d', strtotime($d.' days')) ?>',
		Uploads: '<?=	$this->db->get_where('refrence', array('time >' => strtotime($d.' days 12:00 AM'), 'time <' => strtotime($d.' days 11:59:59 PM')))->num_rows() ?>',
		index:4
	}, {
		Day: '<?php $d = '-1'; echo date('Y-m-d', strtotime($d.' days')) ?>',
		Uploads: '<?=	$this->db->get_where('refrence', array('time >' => strtotime($d.' days 12:00 AM'), 'time <' => strtotime($d.' days 11:59:59 PM')))->num_rows() ?>',
		index:5
	}, {
		Day: '<?php echo date('Y-m-d', strtotime('today')) ?>',
		Uploads: '<?=	$this->db->get_where('refrence', array('time >' => strtotime('today 12:00 AM'), 'time <' => strtotime('today 11:59:59 PM')))->num_rows() ?>',
		index:6
	}
];
var data = polyjs.data({
	data: jsondata
});

polyjs.chart({
	layers: [
		{
			data: data,
			type: 'path',
			x:  'Day',
			y: 'Uploads'
		}, {
			data: data,
			type: 'point',
			x: 'Day',
			y: 'Uploads'
		}
	],
	title: 'Past 7 Days Uploads',
	width: <?=$height?>,
	height: <?=$width?>,
	dom: 'chart_data'
});