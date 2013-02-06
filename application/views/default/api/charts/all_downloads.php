<?php $rand = rand();?>
var chart<?=$rand?> = new FusionCharts("<?=$base_url?>flash/charts/Pie3D.swf", "ChartId", "<?=$height?>", "<?=$width?>", "0", "0"); chart<?=$rand?>.setDataXML("<chart caption='All Downloads' showPercentageValues='0'><set label='Anonymous' value='<?=$this->db->where('user', '0')->count_all_results('downloads')?>' /><set label='Registered' value='<?=$this->db->where('user !=', '0')->count_all_results('downloads')?>' /></chart>"); chart<?=$rand?>.render("chart_data");

