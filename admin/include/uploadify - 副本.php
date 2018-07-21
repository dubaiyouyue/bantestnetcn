<?php
require_once '../login/login_check.php';
require_once 'upfile.class.php';
require_once 'watermark.class.php';

/*初始化*/
echo 'SUC,';
$metinfo=0;
$gz_file_maxsize=$gz_file_maxsize*1024*1024;
$file_size=$_FILES['Filedata']['size'];
if($file_size>$gz_file_maxsize){
	echo $lang_filemaxsize;
	exit;
}
$filesize=round($_FILES['Filedata']['size']/1024,2);
/*批量上传内容csv文件*/
if($type=="contentup"){
	$gz_file_format='csv';
	$f = new upfile($gz_file_format,'',$gz_file_maxsize,'','1','|');
	if($f->get_error()){
		echo $f->get_errorcode();
		die();
	}
	$filename=time().'.csv';
	$flienamecsv=$f->upload("Filedata",$filename);
	$flienamecsv='../../'.$flienamecsv;
	if($f->get_error()){
		echo $f->get_errorcode();
		die();
	}
	$fileField=$_FILES['Filedata']['name'];
	$fileField=str_replace(".csv","",$fileField);
	$metinfo='1$'.$flienamecsv.'|'.$fileField;
/*单独上传缩略图*/
}elseif($type=="small") {  
	$f = new upfile($gz_file_format,'',$gz_file_maxsize,'','1','|');
	if($f->get_error()){
		echo $f->get_errorcode();
		die();
	}
	$f->savepath = $f->savepath.'thumb/';
	$imgurls = $f->upload('Filedata');
	if($f->get_error()){
		echo $f->get_errorcode();
		die();
	}
	$metinfo='1$'.$imgurls;
/*大图上传-水印-缩略图生成*/
}elseif($type=='big_wate_img'){
	$f = new upfile($gz_file_format,'',$gz_file_maxsize,'','1','|');
	if($f->get_error()){
		echo $f->get_errorcode();
		die();
	}
	$imgurls = $f->upload('Filedata');
	if($f->get_error()){
		echo $f->get_errorcode();
		die();
	}
	$gz_big_img = $imgurls; 
	$img = new Watermark();
	if($gz_big_wate==1){
		if($gz_wate_class==2){
			$img->gz_image_name = $gz_wate_bigimg;
			$img->gz_image_pos  = $gz_watermark;
		}else{
			$img->gz_text       = $gz_text_wate;
			$img->gz_text_size  = $gz_text_bigsize;
			$img->gz_text_color = $gz_text_color;
			$img->gz_text_angle = $gz_text_angle;
			$img->gz_text_pos   = $gz_watermark;
			$img->gz_text_font  = $gz_text_fonts;
		}
		$img->src_image_name ="../".$imgurls;
		$img->save_file = $f->waterpath.$f->savename;
		$img->create();
		$imgurls ="../upload/".date('Ym')."/watermark/".$f->savename;
	}
	$gz_dis_img='../'.$gz_big_img;
	if($wate==3){$gz_img_x=$gz_productdetail_x;$gz_img_y=$gz_productdetail_y;}
	if($wate==5){$gz_img_x=$gz_imgdetail_x;$gz_img_y=$gz_imgdetail_y;}
	if($gz_img_x&&$gz_img_y){
		$gz_dis_imgs=$f->createthumb($gz_dis_img,$gz_img_x,$gz_img_y,'thumb_dis/');
		if($f->get_error()==1){
			echo $f->get_errorcode();
			die();
		}
		if($gz_big_wate==1){
			if($gz_wate_class==2){
				$img->gz_image_name = $gz_wate_bigimg;
				$img->gz_image_pos  = $gz_watermark;
			}else{
				$img->gz_text       = $gz_text_wate;
				$img->gz_text_size  = $gz_text_bigsize;
				$img->gz_text_color = $gz_text_color;
				$img->gz_text_angle = $gz_text_angle;
				$img->gz_text_pos   = $gz_watermark;
				$img->gz_text_font  = $gz_text_fonts;
			}
			$img->src_image_name =$gz_dis_imgs;
			$img->save_file = $gz_dis_imgs;
			$img->create();
		}
	}
	if($gz_autothumb_ok && $module!=67 && $module){
		imgstyle($module);
		$gz_big_img="../".$gz_big_img;
		$imgurlss = $f->createthumb($gz_big_img,$gz_img_x,$gz_img_y);
		if($f->get_error()==1){
			echo $f->get_errorcode();
			die();
		}
		if($gz_thumb_wate==1){
			if($gz_wate_class==2){
				$img->gz_image_name = $gz_wate_img;
				$img->gz_image_pos = $gz_watermark;
			}else {
				$img->gz_text = $gz_text_wate;
				$img->gz_text_size = $gz_text_size;
				$img->gz_text_color = $gz_text_color;
				$img->gz_text_angle = $gz_text_angle;
				$img->gz_text_pos   = $gz_watermark;
				$img->gz_text_font = $gz_text_fonts;
			}
			$img->src_image_name =$imgurlss;
			$img->save_file =$imgurlss;
			$img->create();
		}
		$imgurls_a=explode("../",$imgurlss);
		$imgurlss="../".$imgurls_a[2];
	}
	$metinfo='1$'.$imgurls.'|'.$imgurlss;
	if(!$module||$module==67)$metinfo='1$'.$imgurls;
/*ICO图标*/
}elseif($type=='metico'){
	$f = new upfile($gz_file_format,'../../',$gz_file_maxsize,'','1','|');
	if($f->get_error()){
		echo $f->get_errorcode();
		die();
	}
	$file = $f->upload('Filedata','favicon');
	if($f->get_error()){
		echo $f->get_errorcode();
		die();
	}
	$metinfo='1$'.$file;
/*文件上传*/
}elseif($type=='upfile'){
	$f = new upfile($gz_file_format,'../../upload/file/',$gz_file_maxsize,'','1','|');
	if($f->get_error()){
		echo $f->get_errorcode();
		die();
	}
	$file = $f->upload('Filedata');
	if($f->get_error()){
		echo $f->get_errorcode();
		die();
	}
	$metinfo='1$'.$file;
	if($module==4)$metinfo.='|'.$filesize;
/*图片上传*/
}elseif($type=='upimage'){
	$f = new upfile($gz_file_format,'',$gz_file_maxsize,'','1','|');
	if($f->get_error()){
		echo $f->get_errorcode();
		die();
	}
	$imgurls = $f->upload('Filedata');
	if($f->get_error()){
		echo $f->get_errorcode();
		die();
	}	
	$metinfo='1$'.$imgurls;
}elseif($type=='upimage-met'){
	$f = new upfile($gz_file_format,'',$gz_file_maxsize,'','1','|');
	if($f->get_error()){
		echo $f->get_errorcode();
		die();
	}
	$imgurls = $f->upload('Filedata');
	if($f->get_error()){
		echo $f->get_errorcode();
		die();
	}	
	if($gz_big_wate==1){
		$img = new Watermark();
		if($gz_wate_class==2){
			$img->gz_image_name = $gz_wate_bigimg;
			$img->gz_image_pos  = $gz_watermark;
		}else{
			$img->gz_text       = $gz_text_wate;
			$img->gz_text_size  = $gz_text_bigsize;
			$img->gz_text_color = $gz_text_color;
			$img->gz_text_angle = $gz_text_angle;
			$img->gz_text_pos   = $gz_watermark;
			$img->gz_text_font  = $gz_text_fonts;
		}
		$img->src_image_name ="../".$imgurls;
		$img->save_file = $f->waterpath.$f->savename;
		$img->create();
		$imgurls ="../upload/".date('Ym')."/watermark/".$f->savename;
	}
	$metinfo='1$'.$imgurls;
}elseif($type=='skin'){
die();
/*模板文件*/
	$filetype=explode('.',$_FILES['Filedata']['name']);
	if($filetype[count($filetype)-1]=='zip'){
		if(stristr($gz_file_format,'zip') === false){
			echo $lang_jsx36;
			die();
		}
		//if(!is_writable('../../templates/'))@chmod('../../templates/',0777);
		$filenamearray=explode('.zip',$_FILES['Filedata']['name']);
	    $skin_if=$db->get_one("SELECT * FROM {$gz_skin_table} WHERE skin_file='{$filenamearray[0]}'");
	    if($skin_if){
			$metinfo=$lang_loginSkin;
		}else{
			$f = new upfile('zip','../../templates/','','');
			if($f->get_error()){
				echo $f->get_errorcode();
				die();
			}
			if(file_exists('../../templates/'.$filenamearray[0].'.zip'))$filenamearray[0]='metinfo'.$filenamearray[0];
			$gz_upsql = $f->upload('Filedata',$filenamearray[0]); 
			include "pclzip.lib.php";
			$archive = new PclZip('../../templates/'.$filenamearray[0].'.zip');		
			if($archive->extract(PCLZIP_OPT_PATH, '../../templates/') == 0)$metinfo=$archive->errorInfo(true);
			$list = $archive->listContent();
			$error=0;
			foreach($list as $key=>$val){
				if(preg_match("/\.(asp|aspx|jsp)/i",$val[filename])){
					$error=1;
				}
				if(!is_dir('../../templates/'.$val[filename])&&preg_match("/\.(php)/i",$val[filename])){
					$danger=explode('|','preg_replace|assert|dirname|file_exists|file_get_contents|file_put_contents|fopen|mkdir|unlink|readfile|eval|cmd|passthru|system|gzuncompress|exec|shell_exec|fsockopen|pfsockopen|proc_open|scandir');
					$ban='preg_replace|assert|eval|\$_POST|\$_GET';
					foreach($danger as $key1 => $val1){					
						$str=file_get_contents('../../templates/'.$val[filename]);
						$str=str_replace(array('\'','"','.'),'',$str);
						if(preg_match("/([^A-Za-z0-9_]$val1)[\r\n\t]{0,}([\[\(])/i",$str)){	
							$error=1;
						}
						if(preg_match('/('.$ban.')/i',$str)){	
							$error=1;
						}
						
					}
				}
			}
			@unlink('../../templates/'.$filenamearray[0].'.zip');
			if($error){
				foreach($list as $key=>$val){
					if(is_dir('../../templates/'.$val[filename])){
						@deldir('../../templates/'.$val[filename]);
					}else{
						@unlink('../../templates/'.$val[filename]);
					}
				}
				$metinfo='含有危险函数，禁止上传！！';
			}else{
				$metinfo='1$'.$filenamearray[0];
			}
		}
	}else{
		$metinfo=$lang_uplaoderr2;
	}
/*数据库文件*/
}elseif($type=='sql'){
	if(strstr($_FILES['Filedata']['name'],'.sql') == '.sql'){
		if(stristr($gz_file_format,'sql') === false){
			echo $lang_jsx37;
			die();
		}
		$filenamearray=explode('.sql',$_FILES['Filedata']['name']);
		$f = new upfile('sql,zip','../databack/','','');
		if($f->get_error()){
			echo $f->get_errorcode();
			die();
		}
		if(file_exists('../databack/'.$filenamearray[0].'.sql'))$filenamearray[0]='metinfo'.$filenamearray[0];
		if($_FILES['Filedata']['name']!=''){
				$gz_upsql   = $f->upload('Filedata',$filenamearray[0]); 
		}
		include "pclzip.lib.php";
		$archive = new PclZip('../databack/sql/'.'metinfo_'.$filenamearray[0].'.zip');
		$archive->add('../databack/'.$filenamearray[0].'.sql',PCLZIP_OPT_REMOVE_PATH,'../databack/');
		$metinfo='1$'.'../databack/'.$filenamearray[0].'.sql';
	}else{
		$filetype=explode('.',$_FILES['Filedata']['name']);
		if($filetype[count($filetype)-1]=='zip'){
			if(stristr($gz_file_format,'zip') === false){
				echo $lang_jsx36;
				die();
			}
			$filenamearray=explode('.zip',$_FILES['Filedata']['name']);
			$f = new upfile('sql,zip','../databack/sql/','','');
			if($f->get_error()){
				echo $f->get_errorcode();
				die();
			}
			if(file_exists('../databack/sql/'.$filenamearray[0].'.zip'))$filenamearray[0]='metinfo'.$filenamearray[0];
			if($_FILES['Filedata']['name']!=''){
					$gz_upsql = $f->upload('Filedata',$filenamearray[0]); 
			}
			include "pclzip.lib.php";
			$archive = new PclZip('../databack/sql/'.$filenamearray[0].'.zip');
			if($archive->extract(PCLZIP_OPT_PATH, '../databack') == 0){
				$metinfo=$archive->errorInfo(true);
			}
			else{
				$list = $archive->listContent();
				$metinfo='1$'.'../databack/sql/'.$filenamearray[0].'.zip';
			}
		}else{
			$metinfo=$lang_uplaoderr3;
		}
	}
}
echo $metinfo;
?>