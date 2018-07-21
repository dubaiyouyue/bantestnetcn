<!--<?php
$sidebar=metlabel_sidebar(0);//内页侧栏标签
$sidebar_title=metlabel_sidebar(1);//内页侧栏标题
$s=metlabel_navnow(5);
$s4=metlabel_navnow(4);
$s6=metlabel_navnow(6);     //获取主每个栏目的主id

//侧栏显示条件：存在子栏目||文章详情页&&不是产品详情页

//20161205
// print_r($s['0']['mors']);
//$ssscccccc=$s6['id'];
//$show_rrruoonewcc = $db->get_one("SELECT * FROM $gz_column WHERE bigclass='$ssscccccc' order by no_order");
//$show_rrruoonewcc=$show_rrruoonewcc['id'];
//dump($s['0']['url']);exit;
//if(!$s['bigclass'])
//dump($s6);exit;
//父栏目id
$newffff_new_ss=$class_list[$classnow]['id'];
if($newffff_new_ss==$s6['id'] && $s['0']['bigclass']){
    //跳转到子栏目
    foreach($s as $nnnkkk=>$nnnkkva){
        $newnnnkvall[$nnnkkva['no_order']][]=$nnnkkva;
    }
    //dump($newnnnkvall);exit;
    header('Location:'.$newnnnkvall['0']['0']['url']);//跳转到带www的网址
    //header后的PHP代码还会被执行 .确保重定向后，后续代码不会被执行 
    exit;
}
//end
//右栏目变色
$cssid=$class_list[$classnow]['id'];
if($cssid){
  $getlmid=$db->get_one("select * from gz_column where id=$cssid "); //获取父级  
  if($getlmid){
    $idsaa=$getlmid['bigclass'];
    $get_bigclass=$db->get_one("select * from gz_column where id=$idsaa "); //查询当前id的父级数据
    if($get_bigclass['bigclass']==$s6['id']){             //如果父级的bigclass等于当前栏目的主id（导航栏目的id）则说明当前id为三级栏目id
        $cssid=$get_bigclass['id'];         
    }
  }
}

$s4=str_ireplace('cur current'.$cssid,'current',$s4);
//$s4=str_ireplace('cur current','current',$s4);

//end


$asideok = ($sidebar||($class_list[$classnow][module]==2&&$id))&&!($class_list[$classnow][module]==3&&$id)?1:0;
$section = $asideok?'':'gz_section_asidenone';
$sehed   = $id&&$class_list[$classnow][module]!=1?'gz_section_sehed':'';
$alls_img=$db->get_all("select * from gz_flash ORDER by no_order");
foreach($alls_img as $kg=>$vg){
  if(strstr($vg['module'],$s6['id'])){
    $this_img=$vg;
  }
}
echo <<<EOT
-->
<!---------------------------------datu 开始--------------------------------->
<div class="datu4" style="background: url({$this_img[img_path]}) no-repeat center; width:100%; height:450px;"></div>
<!---------------------------------datu 结束--------------------------------->
<!--
EOT;
echo <<<EOT
-->
<div class="container clearfix">
   <div class="lanmubox clearfix">
     <div class="lanmu">
       <div class="dabiaoti">{$sidebar_title}</div>
        <div class="lmwz">
            <ul>
              {$s4}
           </ul>
        </div>
    </div>
  </div>
   
   <div class="content">
      <div class="weizhibox">
         <P>当前位置：<a href="{$index_url}" style="color:#333;">{$lang_home}</a> &gt; {$nav_x[name]}</P>
      </div>
<!--
EOT;



  $modname=$class_list[$classnow]['name'];
  $mid=$class_list[$classnow]['id'];
  foreach($s as $ky=>$vs){
    if($vs['id']==$mid&&$vs['mors']){
    $listsv=$vs['mors'];
    }
  }

echo <<<EOT
-->
      <div class="btwzbox">
         <h3>{$modname}</h3>
      </div>
<!--
EOT;

?>