<?php
	include "master-include.php";
	include "engine/core.php";
	if(!in_array($_SESSION['user'][''], array (
  0 => '',
)) || $GLOBALS['unauthorized_access']==1){
			include "menu.php";
			foreach($menu as $m)
			{
				$rls = [];
				foreach(explode(",", $m["roles"]) as $r)
				{
					$rls[] = trim($r);
				}
				if($m["unauthorized_access"]==1)
				{
					header("Location: {$m['link']}");
					die("");
				}
			}

			die("У вас нет доступа");
		}


	class GLOBAL_STORAGE
	{
	   static $parent_object;
	}
	

	$action = $_REQUEST['action'];
	$actions = [];

	

	define("RPP", 50); //кол-во строк на странице

	function array2csv($array)
	{
	   if (count($array) == 0)
	   {
	     return null;
	   }
	   ob_start();
	   $df = fopen("php://output", 'w');
	   fprintf($df, chr(0xEF).chr(0xBB).chr(0xBF));
	   fputcsv($df, array_keys($array[0]));
	   foreach ($array as $row)
	   {
	      fputcsv($df, array_values($row));
	   }
	   fclose($df);
	   return ob_get_clean();
	}

	function download_send_headers($filename)
	{
	    // disable caching
	    $now = gmdate("D, d M Y H:i:s");
	    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
	    header("Last-Modified: {$now} GMT");

	    // force download
	    header("Content-Type: application/force-download");
	    header("Content-Type: application/octet-stream");
	    header("Content-Type: application/download");

	    // disposition / encoding on response body
	    header("Content-Disposition: attachment;filename={$filename}");
	    header("Content-Transfer-Encoding: binary");
	}

	$actions['csv'] = function()
	{
		if(function_exists("allowCSV"))
		{
			if(!allowCSV())
			{
				die("У вас нет прав на экспорт CSV");
			}
		}
		download_send_headers("data_export_" . date("Y-m-d") . ".csv");
		$data = get_data(true)[0];

		if(function_exists("processCSV"))
		{
			$data = processCSV($data);
		}

		echo array2csv($data);
		die();
	};

	$actions[''] = function()
	{
			
   		$status_values = '[{"text":"Новый", "value":"new"},
{"text":"Принят в работу", "value":"allow"},{"text":"Отклонен", "value":"decline"},{"text":"Отправлен", "value":"shipped"},{"text":"Завершен", "value":"finished"}]';
		$status_values_text = "";
		foreach(json_decode($status_values, true) as $opt)
		{
			$status_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$is_paid_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$is_paid_values_text = "";
		foreach(json_decode($is_paid_values, true) as $opt)
		{
			$is_paid_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$payment_type_values = '[{"text":"Наличные", "value":"cash"},{"text":"Онлайн", "value":"online"}]';
		$payment_type_values_text = "";
		foreach(json_decode($payment_type_values, true) as $opt)
		{
			$payment_type_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$delivery_type_values = json_encode(q("SELECT name as text, id as value FROM delivery", []));
			$delivery_type_values_text = "";
				foreach(json_decode($delivery_type_values, true) as $opt)
				{
				  $delivery_type_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
				}

		list($items, $pagination, $cnt) = get_data();

		$sort_order[$_REQUEST['sort_by']] = $_REQUEST['sort_order'];

$next_order['id']='asc';
$next_order['dt']='asc';
$next_order['status']='asc';
$next_order['is_paid']='asc';
$next_order['']='asc';
$next_order['total_price']='asc';
$next_order['name']='asc';
$next_order['email']='asc';
$next_order['phone']='asc';
$next_order['address']='asc';
$next_order['payment_type']='asc';
$next_order['delivery_type']='asc';
$next_order['msg']='asc';

		if($_REQUEST['sort_order']=='asc')
		{
			$sort_icon[$_REQUEST['sort_by']] = '<span class="fa fa-sort-alpha-up" style="margin-left:5px;"></span>';
			$next_order[$_REQUEST['sort_by']] = 'desc';
		}
		else if($_REQUEST['sort_order']=='desc')
		{
			$sort_icon[$_REQUEST['sort_by']] = '<span class="fa fa-sort-alpha-down" style="margin-left:5px;"></span>';
			$next_order[$_REQUEST['sort_by']] = '';
		}
		else if($_REQUEST['sort_order']=='')
		{
			$next_order[$_REQUEST['sort_by']] = 'asc';
		}
		$filter_caption = "";
		$show = '
		<script>
				window.onload = function ()
				{
					$(\'.big-icon\').html(\'<i class="fas fa-crown"></i>\');
				};


		</script>
		
		<style>
			html body.concept, html body.concept header, body.concept .table
			{
				background-color:#F2E9E2;
				color:;
			}

			.genesis-text-color
			{
				color:;
			}

			#tableMain div.genesis-item:nth-child(even), #tableMain div.genesis-item:nth-child(even) div.genesis-item-property
			{
  				background-color:  !important;
			}

			body.concept .page-link,
			body.concept .page-link:hover{
				color: ;
			}

			html body.concept, html body.concept header, body.concept .table
			{
				color: ;
			}

		</style>
		<!-- Modal -->
		<div class="modal fade" id="csv_create_modal" role="dialog" aria-labelledby="csvCreateModal" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form method="POST">
					<input type="hidden" name="action" value="csv_create_execute">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Массовое добавление записей</h5>
						</div>
						<div class="modal-body">
							<small>Вставьте сюда новые записи. Каждая запись на новой строчке: <b class="csv-create-format"></b></small>
							<textarea name="csv"></textarea>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn cancel" data-dismiss="modal" aria-label="Close">Закрыть</button>
							<button type="submit" class="btn blue-inline" id="csv_create_execute">Сохранить</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="content-header">
			<div class="btn-wrap">
				<h2><a href="#" class="back-btn"><span class="fa fa-arrow-circle-left"></span></a> '."Заказы".' </h2>
				
				<p class="small res-cnt">Кол-во результатов: <span class="cnt-number-span">'.$cnt.'</span></p>
			</div>
			
			<form class="navbar-form search-form" role="search">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Поиск" name="srch-term" id="srch-term" value="'.$_REQUEST['srch-term'].'">
					<button class="input-group-addon"><i class="fa fa-search"></i></button>
				</div>
			</form>
			
		</div>
		<div>'.
		""
		.'</div>';

		$show .= filter_divs();

		$show.='
		
		<div class="table-wrap" data-fl-scrolls>';
		$table='
			<div class="data-container genesis-presentation-table  table-clickable" id="tableMain">
			<div class="genesis-header">
				<div>

			<div class="genesis-header-property">
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=id&sort_order='. ($next_order['id']) .'\' class=\'sort\' column=\'id\' sort_order=\''.$sort_order['id'].'\'>ID'. $sort_icon['id'].'</a>
			</div>

			<div class="genesis-header-property">
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=dt&sort_order='. ($next_order['dt']) .'\' class=\'sort\' column=\'dt\' sort_order=\''.$sort_order['dt'].'\'>Дата'. $sort_icon['dt'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input autocomplete="off" type="text" class="form-control daterange filter-date-range" name="dt_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</div>

			<div class="genesis-header-property">
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=status&sort_order='. ($next_order['status']) .'\' class=\'sort\' column=\'status\' sort_order=\''.$sort_order['status'].'\'>Статус'. $sort_icon['status'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="status_filter">


							'.str_replace(chr(39), '&#39;', $status_values_text).'


							</select>
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</div>

			<div class="genesis-header-property">
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=is_paid&sort_order='. ($next_order['is_paid']) .'\' class=\'sort\' column=\'is_paid\' sort_order=\''.$sort_order['is_paid'].'\'>Оплачен'. $sort_icon['is_paid'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="is_paid_filter">


							'.str_replace(chr(39), '&#39;', $is_paid_values_text).'


							</select>
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</div>

			<div class="genesis-header-property">
				   Товары
			</div>

			<div class="genesis-header-property">
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=total_price&sort_order='. ($next_order['total_price']) .'\' class=\'sort\' column=\'total_price\' sort_order=\''.$sort_order['total_price'].'\'>Стоимость'. $sort_icon['total_price'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="number" min="-2147483648" max="2147483648" step="0.01" class="form-control filter-number-from" name="total_price_filter_from" placeholder="От"/>
							<span class="input-group-btn" style="width:0px;"></span>
							<input type="number" min="-2147483648" max="2147483648" step="0.01" class="form-control filter-number-to" name="total_price_filter_to" placeholder="До"/>
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</div>

			<div class="genesis-header-property">
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=name&sort_order='. ($next_order['name']) .'\' class=\'sort\' column=\'name\' sort_order=\''.$sort_order['name'].'\'>Имя'. $sort_icon['name'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="text" class="form-control filter-text" name="name_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</div>

			<div class="genesis-header-property">
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=email&sort_order='. ($next_order['email']) .'\' class=\'sort\' column=\'email\' sort_order=\''.$sort_order['email'].'\'>E-mail'. $sort_icon['email'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="text" class="form-control filter-text" name="email_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</div>

			<div class="genesis-header-property">
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=phone&sort_order='. ($next_order['phone']) .'\' class=\'sort\' column=\'phone\' sort_order=\''.$sort_order['phone'].'\'>Телефон'. $sort_icon['phone'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="text" class="form-control filter-text" name="phone_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</div>

			<div class="genesis-header-property">
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=address&sort_order='. ($next_order['address']) .'\' class=\'sort\' column=\'address\' sort_order=\''.$sort_order['address'].'\'>Адрес'. $sort_icon['address'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="text" class="form-control filter-text" name="address_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</div>

			<div class="genesis-header-property">
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=payment_type&sort_order='. ($next_order['payment_type']) .'\' class=\'sort\' column=\'payment_type\' sort_order=\''.$sort_order['payment_type'].'\'>Тип оплаты'. $sort_icon['payment_type'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="payment_type_filter">


							'.str_replace(chr(39), '&#39;', $payment_type_values_text).'


							</select>
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</div>

			<div class="genesis-header-property">
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=delivery_type&sort_order='. ($next_order['delivery_type']) .'\' class=\'sort\' column=\'delivery_type\' sort_order=\''.$sort_order['delivery_type'].'\'>Способ доставки'. $sort_icon['delivery_type'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="delivery_type_filter">


							'.str_replace(chr(39), '&#39;', $delivery_type_values_text).'


							</select>
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</div>

			<div class="genesis-header-property">
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=msg&sort_order='. ($next_order['msg']) .'\' class=\'sort\' column=\'msg\' sort_order=\''.$sort_order['msg'].'\'>Комментарий'. $sort_icon['msg'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="text" class="form-control filter-text" name="msg_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</div>
					<div class="genesis-header-property"></div>
				</div>
		</div>
		<div class="genesis-tbody">';


		if(count($items) > 0)
		{
			$agregate = get_agregate();
			foreach($items as $item)
			{
				$master = ($item['master'] == 1) ? 'Да' : 'Нет';
				
				$tr = "

				<div class='genesis-item' pk='{$item['id']}'>
					
					".(function_exists("processTD")?processTD("<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=id&sort_order='. ($next_order['id']) .'\' class=\'sort\' column=\'id\' sort_order=\''.$sort_order['id'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['id'] ?? '<span class="fa fa-sort"></span>')).'</a>'."</span>
			<span class='genesis-attached-column-name'>ID:</span>
		</span>".htmlspecialchars($item['id'])."</div>", $item, "ID"):"<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=id&sort_order='. ($next_order['id']) .'\' class=\'sort\' column=\'id\' sort_order=\''.$sort_order['id'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['id'] ?? '<span class="fa fa-sort"></span>')).'</a>'."</span>
			<span class='genesis-attached-column-name'>ID:</span>
		</span>".htmlspecialchars($item['id'])."</div>")."
".(function_exists("processTD")?processTD("<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=dt&sort_order='. ($next_order['dt']) .'\' class=\'sort\' column=\'dt\' sort_order=\''.$sort_order['dt'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['dt'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<input autocomplete=\"off\" type=\"text\" class=\"form-control daterange filter-date-range\" name=\"dt_filter\">
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>Дата:</span>
		</span><span>".(new DateTime(($item['dt']?$item['dt']:"1970-01-01 00:00:00") ))->format('Y-m-d H:i')."</span></div>", $item, "Дата"):"<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=dt&sort_order='. ($next_order['dt']) .'\' class=\'sort\' column=\'dt\' sort_order=\''.$sort_order['dt'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['dt'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<input autocomplete=\"off\" type=\"text\" class=\"form-control daterange filter-date-range\" name=\"dt_filter\">
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>Дата:</span>
		</span><span>".(new DateTime(($item['dt']?$item['dt']:"1970-01-01 00:00:00") ))->format('Y-m-d H:i')."</span></div>")."
".(function_exists("processTD")?processTD("<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=status&sort_order='. ($next_order['status']) .'\' class=\'sort\' column=\'status\' sort_order=\''.$sort_order['status'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['status'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<select class=\"form-control filter-select\" name=\"status_filter\">


							".str_replace(chr(39), '&#39;', $status_values_text)."


							</select>
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>Статус:</span>
		</span>
		<span class='editable' data-inp='select' data-type='select' data-source='".htmlspecialchars($status_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='status'>".select_mapping($status_values, $item['status'])."</span>
		</div>", $item, "Статус"):"<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=status&sort_order='. ($next_order['status']) .'\' class=\'sort\' column=\'status\' sort_order=\''.$sort_order['status'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['status'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<select class=\"form-control filter-select\" name=\"status_filter\">


							".str_replace(chr(39), '&#39;', $status_values_text)."


							</select>
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>Статус:</span>
		</span>
		<span class='editable' data-inp='select' data-type='select' data-source='".htmlspecialchars($status_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='status'>".select_mapping($status_values, $item['status'])."</span>
		</div>")."
".(function_exists("processTD")?processTD("<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=is_paid&sort_order='. ($next_order['is_paid']) .'\' class=\'sort\' column=\'is_paid\' sort_order=\''.$sort_order['is_paid'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['is_paid'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<select class=\"form-control filter-select\" name=\"is_paid_filter\">


							".str_replace(chr(39), '&#39;', $is_paid_values_text)."


							</select>
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>Оплачен:</span>
		</span>
		<span class='editable' data-inp='select' data-type='select' data-source='".htmlspecialchars($is_paid_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='is_paid'>".select_mapping($is_paid_values, $item['is_paid'])."</span>
		</div>", $item, "Оплачен"):"<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=is_paid&sort_order='. ($next_order['is_paid']) .'\' class=\'sort\' column=\'is_paid\' sort_order=\''.$sort_order['is_paid'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['is_paid'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<select class=\"form-control filter-select\" name=\"is_paid_filter\">


							".str_replace(chr(39), '&#39;', $is_paid_values_text)."


							</select>
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>Оплачен:</span>
		</span>
		<span class='editable' data-inp='select' data-type='select' data-source='".htmlspecialchars($is_paid_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='is_paid'>".select_mapping($is_paid_values, $item['is_paid'])."</span>
		</div>")."
".(function_exists("processTD")?processTD("
		<div class='genesis-item-property '>
			<span class='genesis-attached-column-info'>
				<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=&sort_order='. ($next_order['']) .'\' class=\'sort\' column=\'\' sort_order=\''.$sort_order[''].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon[''] ?? '<span class="fa fa-sort"></span>')).'</a>'."</span>
				<span class='genesis-attached-column-name'>Товары:</span>
			</span>
			<div class='text-center genesis-button-container'>
				<a href='order_products.php?order_id={$item["id"]}' class='btn btn-primary btn-genesis '>
					<span class='fa fa-cubes'></span> 
				</a>
			</div>
		</div>

		", $item, "Товары"):"
		<div class='genesis-item-property '>
			<span class='genesis-attached-column-info'>
				<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=&sort_order='. ($next_order['']) .'\' class=\'sort\' column=\'\' sort_order=\''.$sort_order[''].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon[''] ?? '<span class="fa fa-sort"></span>')).'</a>'."</span>
				<span class='genesis-attached-column-name'>Товары:</span>
			</span>
			<div class='text-center genesis-button-container'>
				<a href='order_products.php?order_id={$item["id"]}' class='btn btn-primary btn-genesis '>
					<span class='fa fa-cubes'></span> 
				</a>
			</div>
		</div>

		")."
".(function_exists("processTD")?processTD("<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=total_price&sort_order='. ($next_order['total_price']) .'\' class=\'sort\' column=\'total_price\' sort_order=\''.$sort_order['total_price'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['total_price'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<input type=\"number\" min=\"-2147483648\" max=\"2147483648\" step=\"0.01\" class=\"form-control filter-number-from\" name=\"total_price_filter_from\" placeholder=\"От\"/>
							<span class=\"input-group-btn\" style=\"width:0px;\"></span>
							<input type=\"number\" min=\"-2147483648\" max=\"2147483648\" step=\"0.01\" class=\"form-control filter-number-to\" name=\"total_price_filter_to\" placeholder=\"До\"/>
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>Стоимость:</span>
		</span>".htmlspecialchars($item['total_price'])."</div>", $item, "Стоимость"):"<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=total_price&sort_order='. ($next_order['total_price']) .'\' class=\'sort\' column=\'total_price\' sort_order=\''.$sort_order['total_price'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['total_price'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<input type=\"number\" min=\"-2147483648\" max=\"2147483648\" step=\"0.01\" class=\"form-control filter-number-from\" name=\"total_price_filter_from\" placeholder=\"От\"/>
							<span class=\"input-group-btn\" style=\"width:0px;\"></span>
							<input type=\"number\" min=\"-2147483648\" max=\"2147483648\" step=\"0.01\" class=\"form-control filter-number-to\" name=\"total_price_filter_to\" placeholder=\"До\"/>
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>Стоимость:</span>
		</span>".htmlspecialchars($item['total_price'])."</div>")."
".(function_exists("processTD")?processTD("<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=name&sort_order='. ($next_order['name']) .'\' class=\'sort\' column=\'name\' sort_order=\''.$sort_order['name'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['name'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<input type=\"text\" class=\"form-control filter-text\" name=\"name_filter\">
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>Имя:</span>
		</span>".htmlspecialchars($item['name'])."</div>", $item, "Имя"):"<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=name&sort_order='. ($next_order['name']) .'\' class=\'sort\' column=\'name\' sort_order=\''.$sort_order['name'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['name'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<input type=\"text\" class=\"form-control filter-text\" name=\"name_filter\">
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>Имя:</span>
		</span>".htmlspecialchars($item['name'])."</div>")."
".(function_exists("processTD")?processTD("<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=email&sort_order='. ($next_order['email']) .'\' class=\'sort\' column=\'email\' sort_order=\''.$sort_order['email'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['email'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<input type=\"text\" class=\"form-control filter-text\" name=\"email_filter\">
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>E-mail:</span>
		</span>".htmlspecialchars($item['email'])."</div>", $item, "E-mail"):"<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=email&sort_order='. ($next_order['email']) .'\' class=\'sort\' column=\'email\' sort_order=\''.$sort_order['email'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['email'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<input type=\"text\" class=\"form-control filter-text\" name=\"email_filter\">
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>E-mail:</span>
		</span>".htmlspecialchars($item['email'])."</div>")."
".(function_exists("processTD")?processTD("<div class='genesis-item-property '>
			<span class='genesis-attached-column-info'>
				<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=phone&sort_order='. ($next_order['phone']) .'\' class=\'sort\' column=\'phone\' sort_order=\''.$sort_order['phone'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['phone'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<input type=\"text\" class=\"form-control filter-text\" name=\"phone_filter\">
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
				<span class='genesis-attached-column-name'>Телефон:</span>
			</span>".htmlspecialchars($item['phone'])."</div>", $item, "Телефон"):"<div class='genesis-item-property '>
			<span class='genesis-attached-column-info'>
				<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=phone&sort_order='. ($next_order['phone']) .'\' class=\'sort\' column=\'phone\' sort_order=\''.$sort_order['phone'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['phone'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<input type=\"text\" class=\"form-control filter-text\" name=\"phone_filter\">
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
				<span class='genesis-attached-column-name'>Телефон:</span>
			</span>".htmlspecialchars($item['phone'])."</div>")."
".(function_exists("processTD")?processTD("<div class='genesis-item-property '>
			<span class='genesis-attached-column-info'>
				<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=address&sort_order='. ($next_order['address']) .'\' class=\'sort\' column=\'address\' sort_order=\''.$sort_order['address'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['address'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<input type=\"text\" class=\"form-control filter-text\" name=\"address_filter\">
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
				<span class='genesis-attached-column-name'>Адрес:</span>
			</span>
			<span>".htmlspecialchars($item['address'])."</span>
			</div>", $item, "Адрес"):"<div class='genesis-item-property '>
			<span class='genesis-attached-column-info'>
				<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=address&sort_order='. ($next_order['address']) .'\' class=\'sort\' column=\'address\' sort_order=\''.$sort_order['address'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['address'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<input type=\"text\" class=\"form-control filter-text\" name=\"address_filter\">
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
				<span class='genesis-attached-column-name'>Адрес:</span>
			</span>
			<span>".htmlspecialchars($item['address'])."</span>
			</div>")."
".(function_exists("processTD")?processTD("<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=payment_type&sort_order='. ($next_order['payment_type']) .'\' class=\'sort\' column=\'payment_type\' sort_order=\''.$sort_order['payment_type'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['payment_type'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<select class=\"form-control filter-select\" name=\"payment_type_filter\">


							".str_replace(chr(39), '&#39;', $payment_type_values_text)."


							</select>
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>Тип оплаты:</span>
		</span>
		<span class='editable' data-inp='select' data-type='select' data-source='".htmlspecialchars($payment_type_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='payment_type'>".select_mapping($payment_type_values, $item['payment_type'])."</span>
		</div>", $item, "Тип оплаты"):"<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=payment_type&sort_order='. ($next_order['payment_type']) .'\' class=\'sort\' column=\'payment_type\' sort_order=\''.$sort_order['payment_type'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['payment_type'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<select class=\"form-control filter-select\" name=\"payment_type_filter\">


							".str_replace(chr(39), '&#39;', $payment_type_values_text)."


							</select>
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>Тип оплаты:</span>
		</span>
		<span class='editable' data-inp='select' data-type='select' data-source='".htmlspecialchars($payment_type_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='payment_type'>".select_mapping($payment_type_values, $item['payment_type'])."</span>
		</div>")."
".(function_exists("processTD")?processTD("<div class='genesis-item-property '>
				<span class='genesis-attached-column-info'>
					<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=delivery_type&sort_order='. ($next_order['delivery_type']) .'\' class=\'sort\' column=\'delivery_type\' sort_order=\''.$sort_order['delivery_type'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['delivery_type'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<select class=\"form-control filter-select\" name=\"delivery_type_filter\">


							".str_replace(chr(39), '&#39;', $delivery_type_values_text)."


							</select>
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
					<span class='genesis-attached-column-name'>Способ доставки:</span>
				</span><span class='editable' data-inp='select' data-type='select' data-source='".htmlspecialchars($delivery_type_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='delivery_type'>".select_mapping($delivery_type_values, $item['delivery_type'])."</span></div>", $item, "Способ доставки"):"<div class='genesis-item-property '>
				<span class='genesis-attached-column-info'>
					<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=delivery_type&sort_order='. ($next_order['delivery_type']) .'\' class=\'sort\' column=\'delivery_type\' sort_order=\''.$sort_order['delivery_type'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['delivery_type'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<select class=\"form-control filter-select\" name=\"delivery_type_filter\">


							".str_replace(chr(39), '&#39;', $delivery_type_values_text)."


							</select>
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
					<span class='genesis-attached-column-name'>Способ доставки:</span>
				</span><span class='editable' data-inp='select' data-type='select' data-source='".htmlspecialchars($delivery_type_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='delivery_type'>".select_mapping($delivery_type_values, $item['delivery_type'])."</span></div>")."
".(function_exists("processTD")?processTD("<div class='genesis-item-property '>
			<span class='genesis-attached-column-info'>
				<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=msg&sort_order='. ($next_order['msg']) .'\' class=\'sort\' column=\'msg\' sort_order=\''.$sort_order['msg'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['msg'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<input type=\"text\" class=\"form-control filter-text\" name=\"msg_filter\">
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
				<span class='genesis-attached-column-name'>Комментарий:</span>
			</span>
			<span>".htmlspecialchars($item['msg'])."</span>
			</div>", $item, "Комментарий"):"<div class='genesis-item-property '>
			<span class='genesis-attached-column-info'>
				<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=msg&sort_order='. ($next_order['msg']) .'\' class=\'sort\' column=\'msg\' sort_order=\''.$sort_order['msg'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['msg'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<input type=\"text\" class=\"form-control filter-text\" name=\"msg_filter\">
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
				<span class='genesis-attached-column-name'>Комментарий:</span>
			</span>
			<span>".htmlspecialchars($item['msg'])."</span>
			</div>")."
					<div class='genesis-control-cell'><a href='#' class='edit_btn'><i class='fa fa-edit' style='color:grey;'></i></a> </div>
				</div>";

				if(function_exists("processTR"))
				{
					$tr = processTR($tr, $item);
				}

				$table.=$tr;
			}



			$table .= "</div></div></div>".$pagination;

		}
		else
		{
			$table.=' </div></div><div class="empty_table">Нет информации</div>';
		}

		if(function_exists("processTable"))
		{
			$table = processTable($table);
		}

		$show.=$table."<div></div>".' ';

		if(function_exists("processPage"))
		{
			$show = processPage($show);
		}

		$show.="
		<style></style>
		<script></script>";


		return $show;

	};



	$actions['edit'] = function()
	{
		$id = $_REQUEST['genesis_edit_id'];
		if(isset($id))
		{
			$item = q("SELECT * FROM _orders WHERE id=?",[$id]);
			$item = $item[0];
		}

		
				$delivery_type_options = q("SELECT name as text, id as value FROM delivery",[]);
				$delivery_type_options_html = "";
				foreach($delivery_type_options as $o)
				{
					$delivery_type_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["delivery_type"]?"selected":"").">{$o['text']}</option>";
				}
			

		$html = '
			<form class="form" enctype="multipart/form-data" method="POST">
				<fieldset>'.
					(isset($id)?
					'<input type="hidden" name="id" value="'.$id.'">
					<input type="hidden" name="action" value="edit_execute">'
					:
					'<input type="hidden" name="action" value="create_execute">'
					)
					.'

					
		          <div class="form-group not-editable">
		            <label class="control-label" for="textinput">ID</label>
		            <div>
		            <p>
		              '.$item["id"].'
		            </p>
		            </div>
		          </div>

		          

		          <div class="form-group not-editable">
		            <label class="control-label" for="textinput">Дата</label>
		            <div>
		            <p>
		              '.$item["dt"].'
		            </p>
		            </div>
		          </div>

		          



				<div class="form-group">
					<label class="control-label" for="textinput">Статус</label>
					<div>
						<select id="status" name="status" class="form-control input-md ">
							<option value="new" '.($item["status"]=="new"?"selected":"").'>Новый</option> 
<option value="allow" '.($item["status"]=="allow"?"selected":"").'>Принят в работу</option> 
<option value="decline" '.($item["status"]=="decline"?"selected":"").'>Отклонен</option> 
<option value="shipped" '.($item["status"]=="shipped"?"selected":"").'>Отправлен</option> 
<option value="finished" '.($item["status"]=="finished"?"selected":"").'>Завершен</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Оплачен</label>
					<div>
						<select id="is_paid" name="is_paid" class="form-control input-md ">
							<option value="1" '.($item["is_paid"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["is_paid"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			

		          <div class="form-group not-editable">
		            <label class="control-label" for="textinput">Стоимость</label>
		            <div>
		            <p>
		              '.$item["total_price"].'
		            </p>
		            </div>
		          </div>

		          


								<div class="form-group">
									<label class="control-label" for="textinput">Имя</label>
									<div>
										<input id="name" name="name" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["name"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">E-mail</label>
									<div>
										<input id="email" name="email" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["email"]).'">
									</div>
								</div>

							


						<div class="form-group">
							<label class="control-label" for="textinput">Телефон</label>
							<div>
								<input id="phone" name="phone" type="text" data-inp="phone" class="form-control input-md  " placeholder=""  value="'.htmlspecialchars($item["phone"]).'">
							</div>
						</div>

					


							<div class="form-group">
								<label class="control-label" for="textinput">Адрес</label>
								<div>
									<textarea id="address" name="address" class="form-control input-md  "  >'.htmlspecialchars($item["address"]).'</textarea>
								</div>
							</div>

						



				<div class="form-group">
					<label class="control-label" for="textinput">Тип оплаты</label>
					<div>
						<select id="payment_type" name="payment_type" class="form-control input-md ">
							<option value="cash" '.($item["payment_type"]=="cash"?"selected":"").'>Наличные</option> 
<option value="online" '.($item["payment_type"]=="online"?"selected":"").'>Онлайн</option> 

						</select>
					</div>
				</div>

			

				<div class="form-group">
					<label class="control-label" for="textinput">Способ доставки</label>
					<div>
						<select id="delivery_type" name="delivery_type" class="form-control input-md " >
							'.$delivery_type_options_html.'
							</select>
					</div>
				</div>

			


							<div class="form-group">
								<label class="control-label" for="textinput">Комментарий</label>
								<div>
									<textarea style="display: none;" id="msg" name="msg" class="form-control input-md  "  disabled>'.htmlspecialchars($item["msg"]).'</textarea>
								<span>'.htmlspecialchars($item["msg"]).'</span>
								</div>
							</div>

						
					<div class="text-center not-editable">
						
					</div>

				</fieldset>
			</form>

		';

		if(function_exists("processEditModalHTML"))
		{
			$html = processEditModalHTML($html);
		}
		die($html);
	};

	$actions['create'] = function()
	{

		

		$html = '
			<form class="form" enctype="multipart/form-data" method="POST">
				<fieldset>
					<input type="hidden" name="action" value="create_execute">
					
					<div class="text-center not-editable">
						
					</div>
				</fieldset>
			</form>

		';

		if(function_exists("processCreateModalHTML"))
		{
			$html = processCreateModalHTML($html);
		}
		die($html);
	};


	$actions['edit_page'] = function()
	{
		$id = $_REQUEST['genesis_edit_id'];
		if(isset($id))
		{
			$item = q("SELECT * FROM _orders WHERE id=?",[$id]);
			$item = $item[0];
		}
		else
		{
			die("Ошибка. Редактирование несуществующей записи (вы не указали id)");
		}

		
				$delivery_type_options = q("SELECT name as text, id as value FROM delivery",[]);
				$delivery_type_options_html = "";
				foreach($delivery_type_options as $o)
				{
					$delivery_type_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["delivery_type"]?"selected":"").">{$o['text']}</option>";
				}
			


		$html = '
			<h1 style="line-height: 30px"> Редактирование <br /><small>'."Заказы".' #'.$id.'</small></h1>
			<form class="form" enctype="multipart/form-data" method="POST">
				<input type="hidden" name="back" value="'.$_SERVER['HTTP_REFERER'].'">
				<fieldset>'.
					(isset($id)?
					'<input type="hidden" name="id" value="'.$id.'">
					<input type="hidden" name="action" value="edit_execute">'
					:
					'<input type="hidden" name="action" value="create_execute">'
					)
					.'

					
		          <div class="form-group not-editable">
		            <label class="control-label" for="textinput">ID</label>
		            <div>
		            <p>
		              '.$item["id"].'
		            </p>
		            </div>
		          </div>

		          

		          <div class="form-group not-editable">
		            <label class="control-label" for="textinput">Дата</label>
		            <div>
		            <p>
		              '.$item["dt"].'
		            </p>
		            </div>
		          </div>

		          



				<div class="form-group">
					<label class="control-label" for="textinput">Статус</label>
					<div>
						<select id="status" name="status" class="form-control input-md ">
							<option value="new" '.($item["status"]=="new"?"selected":"").'>Новый</option> 
<option value="allow" '.($item["status"]=="allow"?"selected":"").'>Принят в работу</option> 
<option value="decline" '.($item["status"]=="decline"?"selected":"").'>Отклонен</option> 
<option value="shipped" '.($item["status"]=="shipped"?"selected":"").'>Отправлен</option> 
<option value="finished" '.($item["status"]=="finished"?"selected":"").'>Завершен</option> 

						</select>
					</div>
				</div>

			



				<div class="form-group">
					<label class="control-label" for="textinput">Оплачен</label>
					<div>
						<select id="is_paid" name="is_paid" class="form-control input-md ">
							<option value="1" '.($item["is_paid"]=="1"?"selected":"").'>Да</option> 
<option value="0" '.($item["is_paid"]=="0"?"selected":"").'>Нет</option> 

						</select>
					</div>
				</div>

			

		          <div class="form-group not-editable">
		            <label class="control-label" for="textinput">Стоимость</label>
		            <div>
		            <p>
		              '.$item["total_price"].'
		            </p>
		            </div>
		          </div>

		          


								<div class="form-group">
									<label class="control-label" for="textinput">Имя</label>
									<div>
										<input id="name" name="name" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["name"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">E-mail</label>
									<div>
										<input id="email" name="email" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["email"]).'">
									</div>
								</div>

							


						<div class="form-group">
							<label class="control-label" for="textinput">Телефон</label>
							<div>
								<input id="phone" name="phone" type="text" data-inp="phone" class="form-control input-md  " placeholder=""  value="'.htmlspecialchars($item["phone"]).'">
							</div>
						</div>

					


							<div class="form-group">
								<label class="control-label" for="textinput">Адрес</label>
								<div>
									<textarea id="address" name="address" class="form-control input-md  "  >'.htmlspecialchars($item["address"]).'</textarea>
								</div>
							</div>

						



				<div class="form-group">
					<label class="control-label" for="textinput">Тип оплаты</label>
					<div>
						<select id="payment_type" name="payment_type" class="form-control input-md ">
							<option value="cash" '.($item["payment_type"]=="cash"?"selected":"").'>Наличные</option> 
<option value="online" '.($item["payment_type"]=="online"?"selected":"").'>Онлайн</option> 

						</select>
					</div>
				</div>

			

				<div class="form-group">
					<label class="control-label" for="textinput">Способ доставки</label>
					<div>
						<select id="delivery_type" name="delivery_type" class="form-control input-md " >
							'.$delivery_type_options_html.'
							</select>
					</div>
				</div>

			


							<div class="form-group">
								<label class="control-label" for="textinput">Комментарий</label>
								<div>
									<textarea id="msg" name="msg" class="form-control input-md  "  disabled>'.htmlspecialchars($item["msg"]).'</textarea>
								</div>
							</div>

						

				</fieldset>
				<div>
					<a href="?'.(http_build_query(array_filter($_REQUEST, function($k){return !in_array($k, ['action', 'genesis_edit_id']);}, ARRAY_FILTER_USE_KEY))).'" class="btn cancel" >Закрыть</a>
					<button type="button" class="btn blue-inline" id="edit_page_save">Сохранить</a>
				</div>
			</form>

		';

		if(function_exists("processEditPageHTML"))
		{
			$html = processEditPageHTML($html);
		}
		return $html;
	};

	$actions['reorder'] = function()
	{
		$line = json_decode($_REQUEST['genesis_ids_in_order'], true);
		for ($i=0; $i < count($line); $i++)
		{
			qi("UPDATE `orders` SET `` = ? WHERE id = ?", [$i, $line[$i]]);
		}


		die(json_encode(['status'=>0]));

	};


	$actions['csv_create_execute'] = function()
	{
		if(function_exists("allowInsert"))
		{
			if(!allowInsert())
			{
				header("Location: ".$_SERVER['HTTP_REFERER']);
				die("");
			}
		}


		$sql = "INSERT IGNORE INTO orders () VALUES ()";

		$lines = preg_split("/\r\n|\n|\r/", $_REQUEST['csv']);
		$success_count = 0;
		$errors_count = 0;
		foreach($lines as $line)
		{
			$line = str_getcsv($line);
			qi($sql, []);
			$last_id = qInsertId();
			if($last_id && $last_id>0)
			{
				$success_count++;
			}
			else
			{
				$errors_count++;
			}

			if(function_exists("afterInsert"))
			{
				afterInsert($last_id);
			}
		}

		buildMsg(
			($success_count>0?"Успешно добавлено: {$success_count}<br>":"").
			($errors_count>0?"Ошибок: {$errors_count}":""),

			$errors_count==0?"success":"danger"
		);





		header("Location: ".$_SERVER['HTTP_REFERER']);
		die("");

	};

	$actions['create_execute'] = function()
	{
		if(function_exists("allowInsert"))
		{
			if(!allowInsert())
			{
				header("Location: ".$_SERVER['HTTP_REFERER']);
				die("");
			}
		}
		

		$params = [];
		$sql = "INSERT INTO orders () VALUES ()";
		if(function_exists("processInsertQuery"))
		{
			list($sql, $params) = processInsertQuery($sql, $params);
		}

		qi($sql, array_values($params));
		$last_id = qInsertId();

		if(function_exists("afterInsert"))
		{
			afterInsert($last_id);
		}

		

		header("Location: ".$_SERVER['HTTP_REFERER']);
		die("");

	};

	$actions['edit_execute'] = function()
	{
		$skip = false;
		if(function_exists("allowUpdate"))
		{
			if(!allowUpdate())
			{
				$skip = true;
			}
		}
		if(!$skip)
		{
			$id = $_REQUEST['id'];
			$set = [];

			$set[] = is_null($_REQUEST['status'])?"`status`=NULL":"`status`='".addslashes($_REQUEST['status'])."'";
$set[] = is_null($_REQUEST['is_paid'])?"`is_paid`=NULL":"`is_paid`='".addslashes($_REQUEST['is_paid'])."'";
$set[] = is_null($_REQUEST['name'])?"`name`=NULL":"`name`='".addslashes($_REQUEST['name'])."'";
$set[] = is_null($_REQUEST['email'])?"`email`=NULL":"`email`='".addslashes($_REQUEST['email'])."'";
$set[] = is_null($_REQUEST['phone'])?"`phone`=NULL":"`phone`='".addslashes($_REQUEST['phone'])."'";
$set[] = is_null($_REQUEST['address'])?"`address`=NULL":"`address`='".addslashes($_REQUEST['address'])."'";
$set[] = is_null($_REQUEST['payment_type'])?"`payment_type`=NULL":"`payment_type`='".addslashes($_REQUEST['payment_type'])."'";
$set[] = is_null($_REQUEST['delivery_type'])?"`delivery_type`=NULL":"`delivery_type`='".addslashes($_REQUEST['delivery_type'])."'";
$set[] = is_null($_REQUEST['msg'])?"`msg`=NULL":"`msg`='".addslashes($_REQUEST['msg'])."'";

			if(count($set)>0)
			{
				$set = implode(", ", $set);
				$sql = "UPDATE orders SET $set WHERE id=?";
				if(function_exists("processUpdateQuery"))
				{
					$sql = processUpdateQuery($sql);
				}

				qi($sql, [$id]);
				if(function_exists("afterUpdate"))
				{
					afterUpdate($id);
				}
			}
		}

		if(isset($_REQUEST['back']))
		{
			header("Location: {$_REQUEST['back']}");
		}
		else
		{
			header("Location: ".$_SERVER['HTTP_REFERER']);
		}
		die("");
	};



	$actions['delete'] = function()
	{
		if(function_exists("allowDelete"))
		{
			if(!allowDelete())
			{
				die("0");
			}
		}

		$id = $_REQUEST['id'];
		try
		{
			qi("DELETE FROM orders WHERE id=?", [$id]);
			if(function_exists("afterDelete"))
			{
				afterDelete();
			}
			echo "1";
		}
		catch (Exception $e)
		{
			echo "0";
		}

		die("");
	};

	function filter_query($srch)
	{
		$filters = [];
		
		if(isset2($_REQUEST['dt_filter_from']) && isset2($_REQUEST['dt_filter_to']))
		{
			$filters[] = "dt >= '{$_REQUEST['dt_filter_from']}' AND dt <= '{$_REQUEST['dt_filter_to']}'";
		}

		

		if(isset2($_REQUEST['status_filter']))
		{
			$filters[] = "`status` = '{$_REQUEST['status_filter']}'";
		}
				

		if(isset2($_REQUEST['is_paid_filter']))
		{
			$filters[] = "`is_paid` = '{$_REQUEST['is_paid_filter']}'";
		}
				

		if(isset2($_REQUEST['total_price_filter_from']) && isset2($_REQUEST['total_price_filter_to']))
		{
			$filters[] = "total_price >= {$_REQUEST['total_price_filter_from']} AND total_price <= {$_REQUEST['total_price_filter_to']}";
		}

		

		if(isset2($_REQUEST['name_filter']))
		{
			$filters[] = "`name` LIKE '%{$_REQUEST['name_filter']}%'";
		}
				

		if(isset2($_REQUEST['email_filter']))
		{
			$filters[] = "`email` LIKE '%{$_REQUEST['email_filter']}%'";
		}
				

		if(isset2($_REQUEST['phone_filter']))
		{
			$filters[] = "`phone` LIKE '%{$_REQUEST['phone_filter']}%'";
		}
				

		if(isset2($_REQUEST['address_filter']))
		{
			$filters[] = "`address` LIKE '%{$_REQUEST['address_filter']}%'";
		}
				

		if(isset2($_REQUEST['payment_type_filter']))
		{
			$filters[] = "`payment_type` = '{$_REQUEST['payment_type_filter']}'";
		}
				

		if(isset2($_REQUEST['delivery_type_filter']))
		{
			$filters[] = "`delivery_type` = '{$_REQUEST['delivery_type_filter']}'";
		}
				

		if(isset2($_REQUEST['msg_filter']))
		{
			$filters[] = "`msg` LIKE '%{$_REQUEST['msg_filter']}%'";
		}
				

		$filter="";
		if(count($filters)>0)
		{
			$filter = implode(" AND ", $filters);
			if($srch=="")
			{
				$filter = " WHERE $filter";
			}
			else
			{
				$filter = " AND ($filter)";
			}
		}
		return $filter;
	}

	function filter_divs()
	{
		$status_values = '[{"text":"Новый", "value":"new"},
{"text":"Принят в работу", "value":"allow"},{"text":"Отклонен", "value":"decline"},{"text":"Отправлен", "value":"shipped"},{"text":"Завершен", "value":"finished"}]';
		$status_values_text = "";
		foreach(json_decode($status_values, true) as $opt)
		{
			$status_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$is_paid_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
		$is_paid_values_text = "";
		foreach(json_decode($is_paid_values, true) as $opt)
		{
			$is_paid_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$payment_type_values = '[{"text":"Наличные", "value":"cash"},{"text":"Онлайн", "value":"online"}]';
		$payment_type_values_text = "";
		foreach(json_decode($payment_type_values, true) as $opt)
		{
			$payment_type_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$delivery_type_values = json_encode(q("SELECT name as text, id as value FROM delivery", []));
			$delivery_type_values_text = "";
				foreach(json_decode($delivery_type_values, true) as $opt)
				{
				  $delivery_type_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
				}
		
		if(isset2($_REQUEST['dt_filter_from']))
		{
			$from = date('d.m.Y', strtotime($_REQUEST['dt_filter_from']));
			$to = date('d.m.Y', strtotime($_REQUEST['dt_filter_to']));
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='dt_filter_from' value='{$_REQUEST['dt_filter_from']}'>
					<input type='hidden' class='filter' name='dt_filter_to' value='{$_REQUEST['dt_filter_to']}'>
					<span class='fa fa-times remove-tag'></span> Дата: <b>{$from}–{$to}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($status_values, true), function($i)
		{
			return $i['value']==$_REQUEST['status_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['status_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='status_filter' value='{$_REQUEST['status_filter']}'>
					<span class='fa fa-times remove-tag'></span> Статус: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($is_paid_values, true), function($i)
		{
			return $i['value']==$_REQUEST['is_paid_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['is_paid_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='is_paid_filter' value='{$_REQUEST['is_paid_filter']}'>
					<span class='fa fa-times remove-tag'></span> Оплачен: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		if(isset2($_REQUEST['total_price_filter_from']) && isset2($_REQUEST['total_price_filter_to']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='total_price_filter_from' value='{$_REQUEST['total_price_filter_from']}'>
					<input type='hidden' class='filter' name='total_price_filter_to' value='{$_REQUEST['total_price_filter_to']}'>
					<span class='fa fa-times remove-tag'></span> Стоимость: <b>{$_REQUEST['total_price_filter_from']}–{$_REQUEST['total_price_filter_to']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		if(isset2($_REQUEST['name_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='name_filter' value='{$_REQUEST['name_filter']}'>
				   <span class='fa fa-times remove-tag'></span> Имя: <b>{$_REQUEST['name_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		

		if(isset2($_REQUEST['email_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='email_filter' value='{$_REQUEST['email_filter']}'>
				   <span class='fa fa-times remove-tag'></span> E-mail: <b>{$_REQUEST['email_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		

		if(isset2($_REQUEST['phone_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='phone_filter' value='{$_REQUEST['phone_filter']}'>
				   <span class='fa fa-times remove-tag'></span> Телефон: <b>{$_REQUEST['phone_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		

		if(isset2($_REQUEST['address_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='address_filter' value='{$_REQUEST['address_filter']}'>
				   <span class='fa fa-times remove-tag'></span> Адрес: <b>{$_REQUEST['address_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		

		$text_option = array_filter(json_decode($payment_type_values, true), function($i)
		{
			return $i['value']==$_REQUEST['payment_type_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['payment_type_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='payment_type_filter' value='{$_REQUEST['payment_type_filter']}'>
					<span class='fa fa-times remove-tag'></span> Тип оплаты: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($delivery_type_values, true), function($i)
		{
			return $i['value']==$_REQUEST['delivery_type_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['delivery_type_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='delivery_type_filter' value='{$_REQUEST['delivery_type_filter']}'>
					<span class='fa fa-times remove-tag'></span> Способ доставки: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		if(isset2($_REQUEST['msg_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='msg_filter' value='{$_REQUEST['msg_filter']}'>
				   <span class='fa fa-times remove-tag'></span> Комментарий: <b>{$_REQUEST['msg_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		
		$show = $filter_caption.$filter_divs;

		return $show;
	}

	function get_agregate()
	{

		$items = [];

		$srch = "";
		
			if($_REQUEST['srch-term'])
			{
				$srch = "WHERE ((`name` LIKE '%{$_REQUEST['srch-term']}%') or (`email` LIKE '%{$_REQUEST['srch-term']}%') or (`phone` LIKE '%{$_REQUEST['srch-term']}%') or (`address` LIKE '%{$_REQUEST['srch-term']}%'))";
			}

		$filter = filter_query($srch);
		$where = "name <> ''";
		if($where != "")
		{
			if($filter!='' || $srch !='')
			{
				$where = " AND ($where)";
			}
			else
			{
				$where = " WHERE ($where)";
			}
		}

		$sql = "SELECT 1 as stub  FROM (SELECT main_table.*  FROM _orders main_table) temp $srch $filter $where $order";

		$debug = (isset($_REQUEST['alef_debug']) && $_REQUEST['alef_debug']==1);
		if(in_array($_SERVER['SERVER_NAME'], ["test-genesis.alef.im", "devtest-genesis.alef.im", "localhost"]) || $debug)
		{
			echo "<!--SQL AGREGATE {$sql} -->\n";
		}

		$result = q($sql, []);
		return $result[0];
	}

	function get_data($force_kill_pagination=false)
	{
		if(function_exists("allowSelect"))
		{
			if(!allowSelect())
			{
				die("У вас нет доступа к данной странице");
			}
		}

		$pagination = 1;
		if($force_kill_pagination==true)
		{
			$pagination = 0;
		}
		$items = [];

		$srch = "";
		
			if($_REQUEST['srch-term'])
			{
				$srch = "WHERE ((`name` LIKE '%{$_REQUEST['srch-term']}%') or (`email` LIKE '%{$_REQUEST['srch-term']}%') or (`phone` LIKE '%{$_REQUEST['srch-term']}%') or (`address` LIKE '%{$_REQUEST['srch-term']}%'))";
			}

		$filter = filter_query($srch);
		$where = "name <> ''";
		if($where != "")
		{
			if($filter!='' || $srch !='')
			{
				$where = " AND ($where)";
			}
			else
			{
				$where = " WHERE ($where)";
			}
		}


		
				$default_sort_by = '`dt`';
				$default_sort_order = 'desc';
			

		if(isset($default_sort_by) && $default_sort_by)
		{
			$order = "ORDER BY $default_sort_by $default_sort_order";
		}

		if(isset($_REQUEST['sort_by']) && $_REQUEST['sort_by']!="")
		{
			$order = "ORDER BY {$_REQUEST['sort_by']} {$_REQUEST['sort_order']}";
		}

		$debug = (isset($_REQUEST['alef_debug']) && $_REQUEST['alef_debug']==1);
		if($pagination == 1)
		{
			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT  main_table.*  FROM _orders main_table) temp $srch $filter $where $order LIMIT :start, :limit";
			if(function_exists("processSelectQuery"))
			{
				$sql = processSelectQuery($sql);
			}


			if(in_array($_SERVER['SERVER_NAME'], ["test-genesis.alef.im", "devtest-genesis.alef.im", "localhost"]) || $debug)
			{
				echo "<!--SQL DATA {$sql} -->\n";
			}

			$items = q($sql,
				[
					'start' => MAX(($_GET['page']-1), 0)*RPP,
					'limit' => RPP
				]);
			$cnt = qRows();
			$pagination = pagination($cnt);
		}
		else
		{
			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT main_table.*  FROM _orders main_table) temp $srch $filter $where $order";
			if(in_array($_SERVER['SERVER_NAME'], ["test-genesis.alef.im", "devtest-genesis.alef.im", "localhost"]) || $debug)
			{
				echo "<!--SQL DATA {$sql} -->";
			}
			if(function_exists("processSelectQuery"))
			{
				$sql = processSelectQuery($sql);
			}
			$items = q($sql, []);
			$cnt = qRows();
			$pagination = "";
		}

		if(function_exists("processData"))
		{
			$items = processData($items);
		}

		return [$items, $pagination, $cnt];
	}

	

	$content = $actions[$action]();
	echo masterRender("Заказы", $content, 4);
