<?php
	include "engine/core.php";
	include "master-include.php";
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





	


	$actions[''] = function()
	{
		$id = "1";
		if(isset($id))
		{
			$item = q("SELECT * FROM texts WHERE id=?",[$id]);
			$item = $item[0];
		}
		else
		{
			die("Ошибка. Редактирование несуществующей записи (вы не указали id)");
		}

		


		$html = '
			
		<style>
			html body.concept, html body.concept header, body.concept .table
			{
				background-color:#F2E9E2;
				color:;
			}

			#tableMain tr:nth-child(even)
			{
  				background-color: ;
			}
		</style>
			<h1 style="line-height: 30px"><small>'."О нас".'</small></h1>
			
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

							<div class="form-group">
							<label class="control-label" for="textinput">Изображения</label><br/>
								<a href="about_img.php" class="btn btn-primary btn-genesis ">
									<span class="fa fa-images"></span> 
								</a>
							</div>
					

								<div class="form-group">
									<label class="control-label" for="textinput">Заголовок</label>
									<div>
										<input id="title" name="title" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["title"]).'">
									</div>
								</div>

							


							<div class="form-group">
								<label class="control-label" for="textinput">Текст</label>
								<div>
									<textarea id="txt" name="txt" class="form-control input-md  ckeditor" style="height:500px;" >'.htmlspecialchars($item["txt"]).'</textarea>
								</div>
							</div>

						

				</fieldset>
				<div>
					<button type="button" class="btn blue-inline" id="edit_page_save">Сохранить</a>
				</div>
			</form>
			

		';

		if(function_exists("processPage"))
		{
			$html = processPage($html);
		}
		return $html;
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

			$set[] = is_null($_REQUEST['title'])?"`title`=NULL":"`title`='".addslashes($_REQUEST['title'])."'";
$set[] = is_null($_REQUEST['txt'])?"`txt`=NULL":"`txt`='".addslashes($_REQUEST['txt'])."'";

			if(count($set)>0)
			{
				$set = implode(", ", $set);
				$sql = "UPDATE texts SET $set WHERE id=?";
				if(function_exists("processUpdateQuery"))
				{
					$sql = processUpdateQuery($sql);
				}

				qi($sql, [$id]);
				if(function_exists("afterUpdate"))
				{
					afterUpdate();
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







	

	$content = $actions[$action]();
	echo masterRender("О нас", $content, 13);
