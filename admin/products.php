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
			$product_collections_values = q('SELECT GROUP_CONCAT(CONCAT("\"", REPLACE(name, "\"", "&quot;"), "\"") SEPARATOR ", ") as tags FROM collections',[]);
          $product_collections_values = '['.$product_collections_values[0]['tags'].']';
$product_collections_values = q('SELECT GROUP_CONCAT(CONCAT("\"", REPLACE(name, "\"", "&quot;"), "\"") SEPARATOR ", ") as tags FROM collections',[]);
		$product_collections_values = '['.$product_collections_values[0]['tags'].']';
   		$category_id_values = json_encode(q("SELECT name as text, id as value FROM categories", []));
			$category_id_values_text = "";
				foreach(json_decode($category_id_values, true) as $opt)
				{
				  $category_id_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
				}
$is_visible_values = '[{"text":"Да", "value":"1"},
{"text":"Нет", "value":"0"}]';
			$is_visible_values_text = "";
			foreach(json_decode($is_visible_values, true) as $opt)
			{
			  $is_visible_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
			}
				  

		list($items, $pagination, $cnt) = get_data();

		$sort_order[$_REQUEST['sort_by']] = $_REQUEST['sort_order'];

$next_order['id']='asc';
$next_order['name']='asc';
$next_order['category_id']='asc';
$next_order['product_collections']='asc';
$next_order['price']='asc';
$next_order['is_visible']='asc';
$next_order['is_new']='asc';
$next_order['']='asc';
$next_order['']='asc';

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
					$(\'.big-icon\').html(\'<i class="fas fa-cubes"></i>\');
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
							<small>Вставьте сюда новые записи. Каждая запись на новой строчке: <b class="csv-create-format">ID, Наименование, Описание, Категория, Коллекции, Цена, Отображать, Новинка</b></small>
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
				<h2><a href="#" class="back-btn"><span class="fa fa-arrow-circle-left"></span></a> '."Товары".' </h2>
				<button class="btn blue-inline add_button" data-toggle="modal" data-target="#modal-main">ДОБАВИТЬ</button>
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=name&sort_order='. ($next_order['name']) .'\' class=\'sort\' column=\'name\' sort_order=\''.$sort_order['name'].'\'>Наименование'. $sort_icon['name'].'</a>
					
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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=category_id&sort_order='. ($next_order['category_id']) .'\' class=\'sort\' column=\'category_id\' sort_order=\''.$sort_order['category_id'].'\'>Категория'. $sort_icon['category_id'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="category_id_filter">


							'.str_replace(chr(39), '&#39;', $category_id_values_text).'


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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=product_collections&sort_order='. ($next_order['product_collections']) .'\' class=\'sort\' column=\'product_collections\' sort_order=\''.$sort_order['product_collections'].'\'>Коллекции'. $sort_icon['product_collections'].'</a>
					
        <span class=\'fa fa-filter filter btn btn-default product_collections_tags_filter \' data-placement=\'bottom\' data-content=\'<div class="form-group" style="min-width:160px;">
                    <label class="control-label" for="textinput">Коллекции</label>
                    <div>
                      <input id="product_collections" name="product_collections_filter_tags" type="text"  class="form-control input-md filter-tags" style="min-width:150px;">
                    </div>
                  </div>
                  <span class="input-group-btn">
    								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
    							</span>\'>
        </span>



	            <script>

	              function product_collections_filter_tags()
	              {
	                $("#product_collections").textext(
	                {
	                  plugins : "autocomplete tags"
	                })
	                .bind("getSuggestions", function(e, data)
	                {
	                  var list = '.$product_collections_values.',
	                  textext = $(e.target).textext()[0],
	                  query = (data ? data.query : "") || "";

	                  $(this).trigger ("setSuggestions",
	                  {
	                    result : textext.itemManager().filter(list, query)
	                  });
	                });

	              }


	              if (window.jQuery)
	              {
	                $(".product_collections_tags_filter").off("shown.bs.popover").on("shown.bs.popover",product_collections_filter_tags);
	              }
	              else
	              {
	                window.addEventListener("DOMContentLoaded", function()
	                {
	                  $(".product_collections_tags_filter").off("shown.bs.popover").on("shown.bs.popover", product_collections_filter_tags);
	                });
	              }

	            </script>
	          
				</nobr>
			</div>

			<div class="genesis-header-property">
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=price&sort_order='. ($next_order['price']) .'\' class=\'sort\' column=\'price\' sort_order=\''.$sort_order['price'].'\'>Цена'. $sort_icon['price'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input type="number" min="-2147483648" max="2147483648" step="0.01" class="form-control filter-number-from" name="price_filter_from" placeholder="От"/>
							<span class="input-group-btn" style="width:0px;"></span>
							<input type="number" min="-2147483648" max="2147483648" step="0.01" class="form-control filter-number-to" name="price_filter_to" placeholder="До"/>
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</div>

			<div class="genesis-header-property">
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=is_visible&sort_order='. ($next_order['is_visible']) .'\' class=\'sort\' column=\'is_visible\' sort_order=\''.$sort_order['is_visible'].'\'>Отображать'. $sort_icon['is_visible'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="is_visible_filter">


							'.str_replace(chr(39), '&#39;', $is_visible_values_text).'


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
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=is_new&sort_order='. ($next_order['is_new']) .'\' class=\'sort\' column=\'is_new\' sort_order=\''.$sort_order['is_new'].'\'>Новинка'. $sort_icon['is_new'].'</a>
					
      <span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group text-center">
              <input type="checkbox" class="filter-checkbox" name="is_new_filter">
              <span class="input-group-btn">
                <button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
              </span>
            </div>\'>
      </span>
				</nobr>
			</div>

			<div class="genesis-header-property">
				   Галерея
			</div>

			<div class="genesis-header-property">
				   Атрибуты
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
".(function_exists("processTD")?processTD("
	<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=name&sort_order='. ($next_order['name']) .'\' class=\'sort\' column=\'name\' sort_order=\''.$sort_order['name'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['name'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<input type=\"text\" class=\"form-control filter-text\" name=\"name_filter\">
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>Наименование:</span>
		</span>
		<span class='editable' data-placeholder='' data-inp='text' data-url='engine/ajax.php?action=editable&table=products' data-pk='{$item['id']}' data-name='name'>".htmlspecialchars($item['name'])."</span>
	</div>", $item, "Наименование"):"
	<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=name&sort_order='. ($next_order['name']) .'\' class=\'sort\' column=\'name\' sort_order=\''.$sort_order['name'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['name'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<input type=\"text\" class=\"form-control filter-text\" name=\"name_filter\">
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>Наименование:</span>
		</span>
		<span class='editable' data-placeholder='' data-inp='text' data-url='engine/ajax.php?action=editable&table=products' data-pk='{$item['id']}' data-name='name'>".htmlspecialchars($item['name'])."</span>
	</div>")."
".(function_exists("processTD")?processTD("<div class='genesis-item-property '>
				<span class='genesis-attached-column-info'>
					<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=category_id&sort_order='. ($next_order['category_id']) .'\' class=\'sort\' column=\'category_id\' sort_order=\''.$sort_order['category_id'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['category_id'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<select class=\"form-control filter-select\" name=\"category_id_filter\">


							".str_replace(chr(39), '&#39;', $category_id_values_text)."


							</select>
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
					<span class='genesis-attached-column-name'>Категория:</span>
				</span><span class='editable' data-inp='select' data-type='select' data-source='".htmlspecialchars($category_id_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=products' data-pk='{$item['id']}' data-name='category_id'>".select_mapping($category_id_values, $item['category_id'])."</span></div>", $item, "Категория"):"<div class='genesis-item-property '>
				<span class='genesis-attached-column-info'>
					<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=category_id&sort_order='. ($next_order['category_id']) .'\' class=\'sort\' column=\'category_id\' sort_order=\''.$sort_order['category_id'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['category_id'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<select class=\"form-control filter-select\" name=\"category_id_filter\">


							".str_replace(chr(39), '&#39;', $category_id_values_text)."


							</select>
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
					<span class='genesis-attached-column-name'>Категория:</span>
				</span><span class='editable' data-inp='select' data-type='select' data-source='".htmlspecialchars($category_id_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=products' data-pk='{$item['id']}' data-name='category_id'>".select_mapping($category_id_values, $item['category_id'])."</span></div>")."
".(function_exists("processTD")?processTD("<div class='genesis-item-property'>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=product_collections&sort_order='. ($next_order['product_collections']) .'\' class=\'sort\' column=\'product_collections\' sort_order=\''.$sort_order['product_collections'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['product_collections'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
        <span class='fa fa-filter filter  product_collections_tags_filter ' data-placement='bottom' data-content='<div class=\"form-group\" style=\"min-width:160px;\">
                    <label class=\"control-label\" for=\"textinput\">Коллекции</label>
                    <div>
                      <input id=\"product_collections\" name=\"product_collections_filter_tags\" type=\"text\"  class=\"form-control input-md filter-tags\" style=\"min-width:150px;\">
                    </div>
                  </div>
                  <span class=\"input-group-btn\">
    								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
    							</span>'>
        </span>



	            <script>

	              function product_collections_filter_tags()
	              {
	                $(\"#product_collections\").textext(
	                {
	                  plugins : \"autocomplete tags\"
	                })
	                .bind(\"getSuggestions\", function(e, data)
	                {
	                  var list = ".$product_collections_values.",
	                  textext = $(e.target).textext()[0],
	                  query = (data ? data.query : \"\") || \"\";

	                  $(this).trigger (\"setSuggestions\",
	                  {
	                    result : textext.itemManager().filter(list, query)
	                  });
	                });

	              }


	              if (window.jQuery)
	              {
	                $(\".product_collections_tags_filter\").off(\"shown.bs.popover\").on(\"shown.bs.popover\",product_collections_filter_tags);
	              }
	              else
	              {
	                window.addEventListener(\"DOMContentLoaded\", function()
	                {
	                  $(\".product_collections_tags_filter\").off(\"shown.bs.popover\").on(\"shown.bs.popover\", product_collections_filter_tags);
	                });
	              }

	            </script>
	          </span>
			<span class='genesis-attached-column-name'>Коллекции:</span>
		</span>{$item['product_collections']}</div>", $item, "Коллекции"):"<div class='genesis-item-property'>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=product_collections&sort_order='. ($next_order['product_collections']) .'\' class=\'sort\' column=\'product_collections\' sort_order=\''.$sort_order['product_collections'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['product_collections'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
        <span class='fa fa-filter filter  product_collections_tags_filter ' data-placement='bottom' data-content='<div class=\"form-group\" style=\"min-width:160px;\">
                    <label class=\"control-label\" for=\"textinput\">Коллекции</label>
                    <div>
                      <input id=\"product_collections\" name=\"product_collections_filter_tags\" type=\"text\"  class=\"form-control input-md filter-tags\" style=\"min-width:150px;\">
                    </div>
                  </div>
                  <span class=\"input-group-btn\">
    								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
    							</span>'>
        </span>



	            <script>

	              function product_collections_filter_tags()
	              {
	                $(\"#product_collections\").textext(
	                {
	                  plugins : \"autocomplete tags\"
	                })
	                .bind(\"getSuggestions\", function(e, data)
	                {
	                  var list = ".$product_collections_values.",
	                  textext = $(e.target).textext()[0],
	                  query = (data ? data.query : \"\") || \"\";

	                  $(this).trigger (\"setSuggestions\",
	                  {
	                    result : textext.itemManager().filter(list, query)
	                  });
	                });

	              }


	              if (window.jQuery)
	              {
	                $(\".product_collections_tags_filter\").off(\"shown.bs.popover\").on(\"shown.bs.popover\",product_collections_filter_tags);
	              }
	              else
	              {
	                window.addEventListener(\"DOMContentLoaded\", function()
	                {
	                  $(\".product_collections_tags_filter\").off(\"shown.bs.popover\").on(\"shown.bs.popover\", product_collections_filter_tags);
	                });
	              }

	            </script>
	          </span>
			<span class='genesis-attached-column-name'>Коллекции:</span>
		</span>{$item['product_collections']}</div>")."
".(function_exists("processTD")?processTD("<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=price&sort_order='. ($next_order['price']) .'\' class=\'sort\' column=\'price\' sort_order=\''.$sort_order['price'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['price'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<input type=\"number\" min=\"-2147483648\" max=\"2147483648\" step=\"0.01\" class=\"form-control filter-number-from\" name=\"price_filter_from\" placeholder=\"От\"/>
							<span class=\"input-group-btn\" style=\"width:0px;\"></span>
							<input type=\"number\" min=\"-2147483648\" max=\"2147483648\" step=\"0.01\" class=\"form-control filter-number-to\" name=\"price_filter_to\" placeholder=\"До\"/>
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>Цена:</span>
		</span><span class='editable' data-placeholder='' data-inp='decimal' data-url='engine/ajax.php?action=editable&table=products' data-pk='{$item['id']}' data-name='price'>".htmlspecialchars($item['price'])."</span></div>", $item, "Цена"):"<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=price&sort_order='. ($next_order['price']) .'\' class=\'sort\' column=\'price\' sort_order=\''.$sort_order['price'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['price'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<input type=\"number\" min=\"-2147483648\" max=\"2147483648\" step=\"0.01\" class=\"form-control filter-number-from\" name=\"price_filter_from\" placeholder=\"От\"/>
							<span class=\"input-group-btn\" style=\"width:0px;\"></span>
							<input type=\"number\" min=\"-2147483648\" max=\"2147483648\" step=\"0.01\" class=\"form-control filter-number-to\" name=\"price_filter_to\" placeholder=\"До\"/>
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>Цена:</span>
		</span><span class='editable' data-placeholder='' data-inp='decimal' data-url='engine/ajax.php?action=editable&table=products' data-pk='{$item['id']}' data-name='price'>".htmlspecialchars($item['price'])."</span></div>")."
".(function_exists("processTD")?processTD("<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=is_visible&sort_order='. ($next_order['is_visible']) .'\' class=\'sort\' column=\'is_visible\' sort_order=\''.$sort_order['is_visible'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['is_visible'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<select class=\"form-control filter-select\" name=\"is_visible_filter\">


							".str_replace(chr(39), '&#39;', $is_visible_values_text)."


							</select>
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>Отображать:</span>
		</span> <span class=''>".renderRadioGroup("is_visible", $is_visible_values, "products", $item['id'], $item['is_visible'])."</div>", $item, "Отображать"):"<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=is_visible&sort_order='. ($next_order['is_visible']) .'\' class=\'sort\' column=\'is_visible\' sort_order=\''.$sort_order['is_visible'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['is_visible'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
			<span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group\">
							<select class=\"form-control filter-select\" name=\"is_visible_filter\">


							".str_replace(chr(39), '&#39;', $is_visible_values_text)."


							</select>
							<span class=\"input-group-btn\">
								<button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
							</span>
						</div>'>
			</span></span>
			<span class='genesis-attached-column-name'>Отображать:</span>
		</span> <span class=''>".renderRadioGroup("is_visible", $is_visible_values, "products", $item['id'], $item['is_visible'])."</div>")."
".(function_exists("processTD")?processTD("<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=is_new&sort_order='. ($next_order['is_new']) .'\' class=\'sort\' column=\'is_new\' sort_order=\''.$sort_order['is_new'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['is_new'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
      <span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group text-center\">
              <input type=\"checkbox\" class=\"filter-checkbox\" name=\"is_new_filter\">
              <span class=\"input-group-btn\">
                <button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
              </span>
            </div>'>
      </span></span>
			<span class='genesis-attached-column-name'>Новинка:</span>
		</span>
		<div class='checkbox-container'><input  data-url='engine/ajax.php?action=editable&table=products' data-pk='{$item['id']}' data-name='is_new' type='checkbox'".($item['is_new']==1?" checked ":" ")." class='ajax-checkbox'></div></div>", $item, "Новинка"):"<div class='genesis-item-property '>
		<span class='genesis-attached-column-info'>
			<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=is_new&sort_order='. ($next_order['is_new']) .'\' class=\'sort\' column=\'is_new\' sort_order=\''.$sort_order['is_new'].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon['is_new'] ?? '<span class="fa fa-sort"></span>')).'</a>'."
      <span class='fa fa-filter filter ' data-placement='bottom' data-content='<div class=\"input-group text-center\">
              <input type=\"checkbox\" class=\"filter-checkbox\" name=\"is_new_filter\">
              <span class=\"input-group-btn\">
                <button class=\"btn btn-primary add-filter\" type=\"button\"><span class=\"fa fa-filter\"></a></button>
              </span>
            </div>'>
      </span></span>
			<span class='genesis-attached-column-name'>Новинка:</span>
		</span>
		<div class='checkbox-container'><input  data-url='engine/ajax.php?action=editable&table=products' data-pk='{$item['id']}' data-name='is_new' type='checkbox'".($item['is_new']==1?" checked ":" ")." class='ajax-checkbox'></div></div>")."
".(function_exists("processTD")?processTD("
		<div class='genesis-item-property '>
			<span class='genesis-attached-column-info'>
				<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=&sort_order='. ($next_order['']) .'\' class=\'sort\' column=\'\' sort_order=\''.$sort_order[''].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon[''] ?? '<span class="fa fa-sort"></span>')).'</a>'."</span>
				<span class='genesis-attached-column-name'>Галерея:</span>
			</span>
			<div class='text-center genesis-button-container'>
				<a href='products_gallery.php?product_id={$item["id"]}' class='btn btn-primary btn-genesis '>
					<span class='fa fa-images'></span> 
				</a>
			</div>
		</div>

		", $item, "Галерея"):"
		<div class='genesis-item-property '>
			<span class='genesis-attached-column-info'>
				<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=&sort_order='. ($next_order['']) .'\' class=\'sort\' column=\'\' sort_order=\''.$sort_order[''].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon[''] ?? '<span class="fa fa-sort"></span>')).'</a>'."</span>
				<span class='genesis-attached-column-name'>Галерея:</span>
			</span>
			<div class='text-center genesis-button-container'>
				<a href='products_gallery.php?product_id={$item["id"]}' class='btn btn-primary btn-genesis '>
					<span class='fa fa-images'></span> 
				</a>
			</div>
		</div>

		")."
".(function_exists("processTD")?processTD("
		<div class='genesis-item-property '>
			<span class='genesis-attached-column-info'>
				<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=&sort_order='. ($next_order['']) .'\' class=\'sort\' column=\'\' sort_order=\''.$sort_order[''].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon[''] ?? '<span class="fa fa-sort"></span>')).'</a>'."</span>
				<span class='genesis-attached-column-name'>Атрибуты:</span>
			</span>
			<div class='text-center genesis-button-container'>
				<a href='product_attributes.php?product_id={$item["id"]}' class='btn btn-primary btn-genesis '>
					<span class='fa fa-cogs'></span> 
				</a>
			</div>
		</div>

		", $item, "Атрибуты"):"
		<div class='genesis-item-property '>
			<span class='genesis-attached-column-info'>
				<span class='buttons-panel'>".'<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=&sort_order='. ($next_order['']) .'\' class=\'sort\' column=\'\' sort_order=\''.$sort_order[''].'\'>'. (str_replace('style="margin-left:5px;"','',$sort_icon[''] ?? '<span class="fa fa-sort"></span>')).'</a>'."</span>
				<span class='genesis-attached-column-name'>Атрибуты:</span>
			</span>
			<div class='text-center genesis-button-container'>
				<a href='product_attributes.php?product_id={$item["id"]}' class='btn btn-primary btn-genesis '>
					<span class='fa fa-cogs'></span> 
				</a>
			</div>
		</div>

		")."
					<div class='genesis-control-cell'><a href='#' class='edit_btn'><i class='fa fa-edit' style='color:grey;'></i></a> <a href='#' class='delete_btn'><i class='fa fa-trash' style='color:red;'></i></a></div>
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
			$item = q("SELECT * FROM products WHERE id=?",[$id]);
			$item = $item[0];
		}

		
				$category_id_options = q("SELECT name as text, id as value FROM categories",[]);
				$category_id_options_html = "";
				foreach($category_id_options as $o)
				{
					$category_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["category_id"]?"selected":"").">{$o['text']}</option>";
				}
			
$product_collections_values = q('SELECT GROUP_CONCAT(CONCAT("\"", REPLACE(name, "\"", "&quot;"), "\"") SEPARATOR ", ") as tags FROM collections',[]);
	$product_collections_values = '['.$product_collections_values[0]['tags'].']';
	$product_collections_tm = time();
	$product_collections_selected_values = q('SELECT GROUP_CONCAT(CONCAT("\"", REPLACE(b.name, "\"", "&quot;"), "\"") SEPARATOR ", ") as tags FROM products_collections a LEFT JOIN collections b ON (a.collection_id=b.id) WHERE a.product_id=?',[$item['id']]);
	$product_collections_selected_values = '['.$product_collections_selected_values[0]['tags'].']';
$is_visible_values = '[{"text":"Да", "value":"1"},
{"text":"Нет", "value":"0"}]';

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

		          


								<div class="form-group">
									<label class="control-label" for="textinput">Наименование</label>
									<div>
										<input id="name" name="name" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["name"]).'">
									</div>
								</div>

							


							<div class="form-group">
								<label class="control-label" for="textinput">Описание</label>
								<div>
									<textarea id="txt" name="txt" class="form-control input-md  ckeditor"  >'.htmlspecialchars($item["txt"]).'</textarea>
								</div>
							</div>

						

				<div class="form-group">
					<label class="control-label" for="textinput">Категория</label>
					<div>
						<select id="category_id" name="category_id" class="form-control input-md " >
							'.$category_id_options_html.'
							</select>
					</div>
				</div>

			


		<div class="form-group">
			<label class="control-label" for="textinput">Коллекции</label>
			<div class= >
				<input id="product_collections" name="product_collections" type="text"  class="form-control input-md product_collections" style="width:558px; ">
			</div>
		</div>

		<script>

function product_collections_tags_'.$product_collections_tm.'()
{
$(".product_collections").textext(
{
  plugins : "autocomplete tags"
})
.bind("getSuggestions", function(e, data)
{
  var list = '.$product_collections_values.',
  textext = $(e.target).textext()[0],
  query = (data ? data.query : "") || "";

  $(this).trigger ("setSuggestions",
  {
	result : textext.itemManager().filter(list, query)
  });
});

setTimeout(function()
{
  $(".product_collections").textext()[0].tags()._formData.forEach(function(i){$(".product_collections").textext()[0].tags().removeTag(i)});
  $(".product_collections").textext()[0].tags().addTags('.$product_collections_selected_values.');
}, 500);
}

if (window.jQuery)
{

product_collections_tags_'.$product_collections_tm.'();

}
else
{
window.addEventListener("DOMContentLoaded", function()
{
				$(product_collections_tags_'.$product_collections_tm.'());
});
}

		</script>

	


	               <div class="form-group">
	                 <label class="control-label" for="textinput">Цена</label>
	                 <div>
	                   <input id="price" name="price" type="number" step="0.01" class="form-control input-md " placeholder=""  value="'.htmlspecialchars($item["price"]).'">
	                 </div>
	               </div>

	             



            <div class="form-group">
              <label class="control-label" for="textinput">Отображать</label>
              <div class="" >'.renderEditRadioGroup("is_visible", $is_visible_values, $item["is_visible"]).'
              </div>
            </div>

          


						<div class="form-group">
							<label class="control-label" for="textinput">Новинка</label>
							<div>
								<input id="is_new" name="is_new" class=""  type="checkbox"  value="1" '.($item["is_new"]==1?"checked":"").'>
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

		
				$category_id_options = q("SELECT name as text, id as value FROM categories",[]);
				$category_id_options_html = "";
				foreach($category_id_options as $o)
				{
					$category_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["category_id"]?"selected":"").">{$o['text']}</option>";
				}
			
$product_collections_values = q('SELECT GROUP_CONCAT(CONCAT("\"", REPLACE(name, "\"", "&quot;"), "\"") SEPARATOR ", ") as tags FROM collections',[]);
	$product_collections_values = '['.$product_collections_values[0]['tags'].']';
	$product_collections_tm = time();
	$product_collections_selected_values = q('SELECT GROUP_CONCAT(CONCAT("\"", REPLACE(b.name, "\"", "&quot;"), "\"") SEPARATOR ", ") as tags FROM products_collections a LEFT JOIN collections b ON (a.collection_id=b.id) WHERE a.product_id=?',[$item['id']]);
	$product_collections_selected_values = '['.$product_collections_selected_values[0]['tags'].']';
$is_visible_values = '[{"text":"Да", "value":"1"},
{"text":"Нет", "value":"0"}]';

		$html = '
			<form class="form" enctype="multipart/form-data" method="POST">
				<fieldset>
					<input type="hidden" name="action" value="create_execute">
					
		          <div class="form-group not-editable">
		            <label class="control-label" for="textinput">ID</label>
		            <div>
		            <p>
		              '.$item["id"].'
		            </p>
		            </div>
		          </div>

		          


								<div class="form-group">
									<label class="control-label" for="textinput">Наименование</label>
									<div>
										<input id="name" name="name" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["name"]).'">
									</div>
								</div>

							


							<div class="form-group">
								<label class="control-label" for="textinput">Описание</label>
								<div>
									<textarea id="txt" name="txt" class="form-control input-md  ckeditor"  >'.htmlspecialchars($item["txt"]).'</textarea>
								</div>
							</div>

						

				<div class="form-group">
					<label class="control-label" for="textinput">Категория</label>
					<div>
						<select id="category_id" name="category_id" class="form-control input-md " >
							'.$category_id_options_html.'
							</select>
					</div>
				</div>

			


		<div class="form-group">
			<label class="control-label" for="textinput">Коллекции</label>
			<div class= >
				<input id="product_collections" name="product_collections" type="text"  class="form-control input-md product_collections" style="width:558px; ">
			</div>
		</div>

		<script>

function product_collections_tags_'.$product_collections_tm.'()
{
$(".product_collections").textext(
{
  plugins : "autocomplete tags"
})
.bind("getSuggestions", function(e, data)
{
  var list = '.$product_collections_values.',
  textext = $(e.target).textext()[0],
  query = (data ? data.query : "") || "";

  $(this).trigger ("setSuggestions",
  {
	result : textext.itemManager().filter(list, query)
  });
});

setTimeout(function()
{
  $(".product_collections").textext()[0].tags()._formData.forEach(function(i){$(".product_collections").textext()[0].tags().removeTag(i)});
  $(".product_collections").textext()[0].tags().addTags('.$product_collections_selected_values.');
}, 500);
}

if (window.jQuery)
{

product_collections_tags_'.$product_collections_tm.'();

}
else
{
window.addEventListener("DOMContentLoaded", function()
{
				$(product_collections_tags_'.$product_collections_tm.'());
});
}

		</script>

	


	               <div class="form-group">
	                 <label class="control-label" for="textinput">Цена</label>
	                 <div>
	                   <input id="price" name="price" type="number" step="0.01" class="form-control input-md " placeholder=""  value="'.htmlspecialchars($item["price"]).'">
	                 </div>
	               </div>

	             



            <div class="form-group">
              <label class="control-label" for="textinput">Отображать</label>
              <div class="" >'.renderEditRadioGroup("is_visible", $is_visible_values, $item["is_visible"]).'
              </div>
            </div>

          


						<div class="form-group">
							<label class="control-label" for="textinput">Новинка</label>
							<div>
								<input id="is_new" name="is_new" class=""  type="checkbox"  value="1" '.($item["is_new"]==1?"checked":"").'>
							</div>
						</div>

					
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
			$item = q("SELECT * FROM products WHERE id=?",[$id]);
			$item = $item[0];
		}
		else
		{
			die("Ошибка. Редактирование несуществующей записи (вы не указали id)");
		}

		
				$category_id_options = q("SELECT name as text, id as value FROM categories",[]);
				$category_id_options_html = "";
				foreach($category_id_options as $o)
				{
					$category_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["category_id"]?"selected":"").">{$o['text']}</option>";
				}
			
$product_collections_values = q('SELECT GROUP_CONCAT(CONCAT("\"", REPLACE(name, "\"", "&quot;"), "\"") SEPARATOR ", ") as tags FROM collections',[]);
	$product_collections_values = '['.$product_collections_values[0]['tags'].']';
	$product_collections_tm = time();
	$product_collections_selected_values = q('SELECT GROUP_CONCAT(CONCAT("\"", REPLACE(b.name, "\"", "&quot;"), "\"") SEPARATOR ", ") as tags FROM products_collections a LEFT JOIN collections b ON (a.collection_id=b.id) WHERE a.product_id=?',[$item['id']]);
	$product_collections_selected_values = '['.$product_collections_selected_values[0]['tags'].']';
$is_visible_values = '[{"text":"Да", "value":"1"},
{"text":"Нет", "value":"0"}]';


		$html = '
			<h1 style="line-height: 30px"> Редактирование <br /><small>'."Товары".' #'.$id.'</small></h1>
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

		          


								<div class="form-group">
									<label class="control-label" for="textinput">Наименование</label>
									<div>
										<input id="name" name="name" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["name"]).'">
									</div>
								</div>

							


							<div class="form-group">
								<label class="control-label" for="textinput">Описание</label>
								<div>
									<textarea id="txt" name="txt" class="form-control input-md  ckeditor"  >'.htmlspecialchars($item["txt"]).'</textarea>
								</div>
							</div>

						

				<div class="form-group">
					<label class="control-label" for="textinput">Категория</label>
					<div>
						<select id="category_id" name="category_id" class="form-control input-md " >
							'.$category_id_options_html.'
							</select>
					</div>
				</div>

			


		<div class="form-group">
			<label class="control-label" for="textinput">Коллекции</label>
			<div class= >
				<input id="product_collections" name="product_collections" type="text"  class="form-control input-md product_collections" style="width:558px; ">
			</div>
		</div>

		<script>

function product_collections_tags_'.$product_collections_tm.'()
{
$(".product_collections").textext(
{
  plugins : "autocomplete tags"
})
.bind("getSuggestions", function(e, data)
{
  var list = '.$product_collections_values.',
  textext = $(e.target).textext()[0],
  query = (data ? data.query : "") || "";

  $(this).trigger ("setSuggestions",
  {
	result : textext.itemManager().filter(list, query)
  });
});

setTimeout(function()
{
  $(".product_collections").textext()[0].tags()._formData.forEach(function(i){$(".product_collections").textext()[0].tags().removeTag(i)});
  $(".product_collections").textext()[0].tags().addTags('.$product_collections_selected_values.');
}, 500);
}

if (window.jQuery)
{

product_collections_tags_'.$product_collections_tm.'();

}
else
{
window.addEventListener("DOMContentLoaded", function()
{
				$(product_collections_tags_'.$product_collections_tm.'());
});
}

		</script>

	


	               <div class="form-group">
	                 <label class="control-label" for="textinput">Цена</label>
	                 <div>
	                   <input id="price" name="price" type="number" step="0.01" class="form-control input-md " placeholder=""  value="'.htmlspecialchars($item["price"]).'">
	                 </div>
	               </div>

	             



            <div class="form-group">
              <label class="control-label" for="textinput">Отображать</label>
              <div class="" >'.renderEditRadioGroup("is_visible", $is_visible_values, $item["is_visible"]).'
              </div>
            </div>

          


						<div class="form-group">
							<label class="control-label" for="textinput">Новинка</label>
							<div>
								<input id="is_new" name="is_new" class=""  type="checkbox"  value="1" '.($item["is_new"]==1?"checked":"").'>
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
			qi("UPDATE `products` SET `` = ? WHERE id = ?", [$i, $line[$i]]);
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


		$sql = "INSERT IGNORE INTO products (`name`, `txt`, `category_id`, `price`, `is_visible`, `is_new`) VALUES (?, ?, ?, ?, ?, ?)";

		$lines = preg_split("/\r\n|\n|\r/", $_REQUEST['csv']);
		$success_count = 0;
		$errors_count = 0;
		foreach($lines as $line)
		{
			$line = str_getcsv($line);
			qi($sql, [trim($line[0]), trim($line[1]), trim($line[2]), trim($line[3]), trim($line[4]), trim($line[5]), trim($line[6]), trim($line[7])]);
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
		$name = $_REQUEST['name'];
$txt = $_REQUEST['txt'];
$category_id = $_REQUEST['category_id'];
$price = $_REQUEST['price'];
$is_visible = $_REQUEST['is_visible'];
$is_new = $_REQUEST['is_new'];

		$params = [$name, $txt, $category_id, $price, $is_visible, $is_new];
		$sql = "INSERT INTO products (`name`, `txt`, `category_id`, `price`, `is_visible`, `is_new`) VALUES (?, ?, ?, ?, ?, ?)";
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

		$all_tags = q("SELECT `name` FROM `collections`", []);
		$names = [];
		$bad_tags = '';
		
		foreach ($all_tags as $t) {
			
			$names[] = mb_strtolower($t['name']);			
			
		}
		
		$product_collections_vals = [];
		$product_collections_vals2 = [];

		if(count(json_decode($_REQUEST['product_collections'], true))>0)
		{
			foreach (json_decode($_REQUEST['product_collections'], true) as $k)
			{
				$product_collections_vals[] = '("'.$k.'")';
				if (in_array(mb_strtolower($k), $names)) {
					$product_collections_vals2[] = '"'.$k.'"';
				}
			}
			$product_collections_vals = implode(", ", $product_collections_vals);
			$product_collections_vals2 = implode(", ", $product_collections_vals2);
			
			if (!in_array(mb_strtolower($k), $names)) {
				$bad_tags .= $k.", ";
			}

			//qi("INSERT IGNORE INTO collections (name) VALUES {$product_collections_vals}", []);
			qi("INSERT INTO products_collections (product_id, collection_id) SELECT $last_id as product_id, id as collection_id FROM collections WHERE name IN ({$product_collections_vals2})",[]);
		}
		
		if ($bad_tags != '') {
			$bad_tags = substr($bad_tags, 0, -2);
			buildMsg("Следующие коллекции отсутствуют в системе: ".$bad_tags.". Пожалуйста, сначала создайте коллекции.", "danger");
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

			$set[] = is_null($_REQUEST['name'])?"`name`=NULL":"`name`='".addslashes($_REQUEST['name'])."'";
$set[] = is_null($_REQUEST['txt'])?"`txt`=NULL":"`txt`='".addslashes($_REQUEST['txt'])."'";
$set[] = is_null($_REQUEST['category_id'])?"`category_id`=NULL":"`category_id`='".addslashes($_REQUEST['category_id'])."'";

		$product_collections_vals = [];
		$product_collections_vals2 = [];
		
		$all_tags = q("SELECT `name` FROM `collections`", []);
		$names = [];
		$bad_tags = '';
		
		foreach ($all_tags as $t) {
			
			$names[] = mb_strtolower($t['name']);			
			
		}

		qi("DELETE FROM products_collections WHERE product_id=?",[$id]);
		if(count(json_decode($_REQUEST['product_collections'], true))>0)
		{
			foreach (json_decode($_REQUEST['product_collections'], true) as $k)
			{
				$product_collections_vals[] = '("'.$k.'")';
				if (in_array(mb_strtolower($k), $names)) {
					$product_collections_vals2[] = '"'.$k.'"';
				}
				
				if (!in_array(mb_strtolower($k), $names)) {
					$bad_tags .= $k.", ";
				}
			}
			$product_collections_vals = implode(", ", $product_collections_vals);
			$product_collections_vals2 = implode(", ", $product_collections_vals2);

			//qi("INSERT IGNORE INTO collections (name) VALUES {$product_collections_vals}", []);
			qi("INSERT INTO products_collections (product_id, collection_id) SELECT $id as product_id, id as collection_id FROM collections WHERE name IN ({$product_collections_vals2})",[]);
		}

		
$set[] = is_null($_REQUEST['price'])?"`price`=NULL":"`price`='".addslashes($_REQUEST['price'])."'";
$set[] = is_null($_REQUEST['is_visible'])?"`is_visible`=NULL":"`is_visible`='".addslashes($_REQUEST['is_visible'])."'";
$set[] = is_null($_REQUEST['is_new'])?"`is_new`=NULL":"`is_new`='".addslashes($_REQUEST['is_new'])."'";

			if(count($set)>0)
			{
				$set = implode(", ", $set);
				$sql = "UPDATE products SET $set WHERE id=?";
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
			
			if ($bad_tags != '') {
				$bad_tags = substr($bad_tags, 0, -2);
				buildMsg("Следующие коллекции отсутствуют в системе: ".$bad_tags.". Пожалуйста, сначала создайте коллекции.", "danger");
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
			qi("DELETE FROM products WHERE id=?", [$id]);
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
		
		if(isset2($_REQUEST['name_filter']))
		{
			$filters[] = "`name` LIKE '%{$_REQUEST['name_filter']}%'";
		}
				

		if(isset2($_REQUEST['category_id_filter']))
		{
			$filters[] = "`category_id` = '{$_REQUEST['category_id_filter']}'";
		}
				

          		if(isset2($_REQUEST['product_collections_filter_tags']))
          		{
                  $product_collections_filter_tags_comma = implode(', ', array_map(function($s){return "'$s'";}, explode(', ', $_REQUEST['product_collections_filter_tags'])));
                  $product_collections_filter_tag_ids = q("SELECT id FROM `collections` WHERE name IN ($product_collections_filter_tags_comma)", []);
                  $tag_flt = [];
                  foreach($product_collections_filter_tag_ids as $row)
                  {
                    $id = $row['id'];
                    $tag_flt[] = "(`product_collections_ids` LIKE '%, $id,%')";
                  }
                  $filters[] = implode(' OR ', $tag_flt);

          		}
          				

		if(isset2($_REQUEST['price_filter_from']) && isset2($_REQUEST['price_filter_to']))
		{
			$filters[] = "price >= {$_REQUEST['price_filter_from']} AND price <= {$_REQUEST['price_filter_to']}";
		}

		

		if(isset2($_REQUEST['is_visible_filter']))
		{
			$filters[] = "`is_visible` = '{$_REQUEST['is_visible_filter']}'";
		}
				

if(isset2($_REQUEST['is_new_filter']))
{
  $filters[] = "`is_new` = '{$_REQUEST['is_new_filter']}'";
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
		$category_id_values = json_encode(q("SELECT name as text, id as value FROM categories", []));
			$category_id_values_text = "";
				foreach(json_decode($category_id_values, true) as $opt)
				{
				  $category_id_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
				}
$is_visible_values = '[{"text":"Да", "value":"1"},
{"text":"Нет", "value":"0"}]';
			$is_visible_values_text = "";
			foreach(json_decode($is_visible_values, true) as $opt)
			{
			  $is_visible_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
			}
				  
		
		if(isset2($_REQUEST['name_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='name_filter' value='{$_REQUEST['name_filter']}'>
				   <span class='fa fa-times remove-tag'></span> Наименование: <b>{$_REQUEST['name_filter']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}

		

		$text_option = array_filter(json_decode($category_id_values, true), function($i)
		{
			return $i['value']==$_REQUEST['category_id_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['category_id_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='category_id_filter' value='{$_REQUEST['category_id_filter']}'>
					<span class='fa fa-times remove-tag'></span> Категория: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

          		if(isset2($_REQUEST['product_collections_filter_tags']))
          		{
          			$filter_divs .= "
          			<div class='filter-tag'>
          					<input type='hidden' class='filter' name='product_collections_filter_tags' value='{$_REQUEST['product_collections_filter_tags']}'>
          				   <span class='fa fa-times remove-tag'></span> Коллекции: <b>{$_REQUEST['product_collections_filter_tags']}</b>
          			</div>";

          			$filter_caption = "Фильтры: ";
              }

		if(isset2($_REQUEST['price_filter_from']) && isset2($_REQUEST['price_filter_to']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='price_filter_from' value='{$_REQUEST['price_filter_from']}'>
					<input type='hidden' class='filter' name='price_filter_to' value='{$_REQUEST['price_filter_to']}'>
					<span class='fa fa-times remove-tag'></span> Цена: <b>{$_REQUEST['price_filter_from']}–{$_REQUEST['price_filter_to']}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($is_visible_values, true), function($i)
		{
			return $i['value']==$_REQUEST['is_visible_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['is_visible_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='is_visible_filter' value='{$_REQUEST['is_visible_filter']}'>
					<span class='fa fa-times remove-tag'></span> Отображать: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

if(isset2($_REQUEST['is_new_filter']))
{
  $filter_divs .= "
  <div class='filter-tag'>
      <input type='hidden' class='filter' name='is_new_filter' value='{$_REQUEST['is_new_filter']}'>
       <span class='fa fa-times remove-tag'></span> Новинка: <b>".($_REQUEST['is_new_filter']?"Вкл":"Выкл")."</b>
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
				$srch = "WHERE ((`name` LIKE '%{$_REQUEST['srch-term']}%') or (`txt` LIKE '%{$_REQUEST['srch-term']}%'))";
			}

		$filter = filter_query($srch);
		$where = "";
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

		$sql = "SELECT 1 as stub  FROM (SELECT main_table.* , (SELECT GROUP_CONCAT(t.name SEPARATOR ', ') FROM products_collections ut LEFT JOIN collections t ON (ut.collection_id=t.id) WHERE ut.product_id=main_table.id) as product_collections,
		(SELECT CONCAT(', ', GROUP_CONCAT(t.id SEPARATOR ', '),',') FROM products_collections ut LEFT JOIN collections t ON (ut.collection_id=t.id) WHERE ut.product_id=main_table.id) as product_collections_ids FROM products main_table) temp $srch $filter $where $order";

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
				$srch = "WHERE ((`name` LIKE '%{$_REQUEST['srch-term']}%') or (`txt` LIKE '%{$_REQUEST['srch-term']}%'))";
			}

		$filter = filter_query($srch);
		$where = "";
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


		
				$default_sort_by = '';
				$default_sort_order = '';
			

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
			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT  main_table.* , (SELECT GROUP_CONCAT(t.name SEPARATOR ', ') FROM products_collections ut LEFT JOIN collections t ON (ut.collection_id=t.id) WHERE ut.product_id=main_table.id) as product_collections,
		(SELECT CONCAT(', ', GROUP_CONCAT(t.id SEPARATOR ', '),',') FROM products_collections ut LEFT JOIN collections t ON (ut.collection_id=t.id) WHERE ut.product_id=main_table.id) as product_collections_ids FROM products main_table) temp $srch $filter $where $order LIMIT :start, :limit";
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
			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT main_table.* , (SELECT GROUP_CONCAT(t.name SEPARATOR ', ') FROM products_collections ut LEFT JOIN collections t ON (ut.collection_id=t.id) WHERE ut.product_id=main_table.id) as product_collections,
		(SELECT CONCAT(', ', GROUP_CONCAT(t.id SEPARATOR ', '),',') FROM products_collections ut LEFT JOIN collections t ON (ut.collection_id=t.id) WHERE ut.product_id=main_table.id) as product_collections_ids FROM products main_table) temp $srch $filter $where $order";
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
	echo masterRender("Товары", $content, 19);
