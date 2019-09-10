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
		$id = "6";
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
			<h1 style="line-height: 30px"><small>'."О компании".'</small></h1>
			
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

						


						<div class="form-group">
							<label class="control-label" for="textinput">Изображение</label>
							<div class="">
								<img src="'.$item["img"].'" class="genesis-image" style="max-width:200px; max-height:200px;" /><label for="img" class="file"> Выберите изображение <input type="file" name="img" id="img" /></label></div>
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


									$img = $_FILES['img'];
									if(isset($_FILES['img']) && $img['name']!=="")
									{
										$ignore=0;
										@mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads');
										chmod($_SERVER['DOCUMENT_ROOT'].'/uploads',0777);
		                if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads'))
		                {
		                  die ("Не удается создать папку uploads в корневой директории. Создайте ее самостоятельно и предоставьте системе доступ к ней.");
		                }
		                $tm = time();
		                $ext = ".".pathinfo($img['name'], PATHINFO_EXTENSION);
										$target_file = $_SERVER['DOCUMENT_ROOT']."/uploads/".$tm."_".md5($img['name']).$ext;
										if(move_uploaded_file($img['tmp_name'], $target_file))
		                {
											compressImage($target_file);
										    $set[] = "`img`='".("/uploads/".$tm."_".md5($img['name'])).$ext."'";
		                }
		                else
		                {
		                    $set[] = "`img`=''";
		                    buildMsg("Не удается загрузить изображение. Попробуйте отправить файл меньшего размера.", "danger");
		                }
									}
		              else {
		                $img = "";
		              }

									

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
	echo masterRender("О компании", $content, 12);
