<?php

$DOCUMENT_KEY = "truxish2114558de";


/**
 * 输出字典配置
 */
function document($value,$api)
{

	global $DOCUMENT_KEY;

	if(!is_array($value)){
		return;
	}

	$document = ($_POST['document']=='')?urldecode($_GET['document']):$_POST['document'];
	if($document == $DOCUMENT_KEY){
		$parse = ($_POST['parse']=='')?urldecode($_GET['parse']):$_POST['parse'];
		$azauto = ($_POST['azauto']=='')?urldecode($_GET['azauto']):$_POST['azauto'];
		if(empty($parse)){
			$parse = "txt";
		}

		$file_name = dirname(__FILE__)."/Class.$api.php";

		if(file_exists($file_name))
		{
			include_once($file_name);
			$class = $api;
			if(class_exists($class)){
				$elment = new $class();

				if(!$azauto){
					$az = "字段自动英汉翻译【已关闭】，开启请添加请求参数【&azauto=true】<br />";
				}else{
					$az = "字段自动英汉翻译【已开启】，关闭请删除请求参数【azauto】<br />";
				}
				echo iconv("UTF-8", "GBK",$az);

				if($elment instanceof NoteClass && $elment instanceof HttpParamsListener){
					$elment->document_http($elment,$value,$parse);
				}
				if($elment instanceof NoteClass){
					$elment->document_format($value,$parse);
				}else{
					echo $class." no extend NoteClass!";
				}

			}else{
				echo $class.' class no found!';
			}

		}else{
			echo $file_name.'  no found!';
		}
		exit;
	}

}






?>