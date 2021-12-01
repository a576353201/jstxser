<?php
class Page{
public $page;//当前页
public $total;//总条数
public $totalpage;//总页数
public $num;//每页条数
public $from;//开始位置
public $url;//当前url
public $pagenum;//关联页数
function __construct($sql,$num,$page,$pagenum='10'){
	if(!$page) $page=1;
	$this->num=$num;
	$this->page=$page;
	$this->pagenum=$pagenum;
$query=mysql_query($sql);
$this->total=mysql_num_rows($query);
if($this->total%$num==0)
$this->totalpage= floor ($this->total/$num);
else
$this->totalpage= floor($this->total/$num)+1;
if($page>$this->totalpage)
$page=$this->totalpage;
$this->from=$this->num*($this->page-1);
if($this->from<0)
$this->from=0;

}

function set_url($page){

	$url="//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	if(strpos($url,"?")){
		if(strpos($url,"page")){
			if(!strpos($url,"&"))
			$this->url=$_SERVER['PHP_SELF']."?page=".$page;
			else{
			$u=explode("&", $url);
			$this->url=$u[0];
			for($i=1;$i<count($u)-1;$i++)
			if(!strpos($u[$i],"page"))
			$this->url=$this->url."&".$u[$i];
			}
			$this->url=$this->url."&page=".$page;
		}
		else
	$this->url=$url."&page=".$page;
	}

	else
	$this->url=$url."?page=".$page;
	return $this->url;
}


//上一页
function get_pre_page($page){
	if($page<$this->pagenum)
	$this->pagenum=$page;
	$start=$page-$this->pagenum;
	if($start<1) $start=1;
	$html='';
	for($i=$start;$i<$page;$i++){
		if($i!=$this->page)
		$html.=  "<li><a href='".$this->set_url($i)."' class='page'>".$i."</a></li>";
		else
            $html.=   "<li  class='active'><a href='".$this->set_url($i)."' >".$i."</a></li>";
	}
	return $html;
}



//下一页
function get_next_page($page){
	if($this->totalpage-$page<$this->pagenum)
	$this->pagenum=$this->totalpage-$page;

	$end=$this->page+$this->pagenum;
	if($end>$this->totalpage) $end=$this->totalpage;
	$html='';
	for($i=$page+1;$i<=$end;$i++){
			if($i!=$this->page)
                $html.=   "<li><a href='".$this->set_url($i)."' >".$i."</a></li>";
		else
            $html.=   "<li  class='active'><a href='".$this->set_url($i)."' >".$i."</a></li>";

	}
	return $html;
}



function get_page(){
	$html= "";
if($this->page>1){
$html.="<li><a href='".$this->set_url($this->page-1)."'>«</a></li>";

}
else $html.="<li>«</li>";

$from=$this->page-3;
$to=$this->page+5;
if($from<1) $from=1;
if($to>$this->totalpage)$to=$this->totalpage;
    if($from>2){
        $html.= "<li><a href='".$this->set_url(1)."' >1</a></li><li>...</li>";
    }

    for($i=$from;$i<=$to;$i++){
    if($i==$this->page) $class='active';
    else $class="";
    $html.= "<li><a href='".$this->set_url($i)."' class='{$class}'>{$i}</a></li>";

}
if($to+1<$this->totalpage){
    $html.= "<li>...</li><li><a href='".$this->set_url($this->totalpage)."' >{$this->totalpage}</a></li>";
}

if($this->page>=$this->totalpage)
$html.="<li>»</li>";
else {
$this->get_next_page($this->page);
$html.= "<li><a href='".$this->set_url($this->page+1)."'>»</a></li>";
}
return $html;
}

}

class Page1{
public $page;//当前页
public $total;//总条数
public $totalpage;//总页数
public $num;//每页条数
public $from;//开始位置
public $url;//当前url
public $pagenum;//关联页数
public $arr;
function __construct($arr,$page,$num=30,$pagenum='3'){
	if(!$page) $page=1;
	$this->num=$num;
	$this->page=$page;
	$this->pagenum=$pagenum;
    $this->arr=$arr;
$this->total=count($arr);
if($this->total%$num==0)
$this->totalpage= floor ($this->total/$num);
else
$this->totalpage= floor($this->total/$num)+1;
if($page>$this->totalpage)
$page=$this->totalpage;
$this->from=$this->num*($this->page-1);
if($this->from<0)
$this->from=0;

}

function get_arr(){

	foreach ($this->arr as $key=> $value){
		if($key>=$this->from and $key<$this->from+$this->num){
			$array[]=$value;


		}



	}

	return $array;

}


function set_url($page){

	$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	if(strpos($url,"?")){
		if(strpos($url,"page")){
			if(!strpos($url,"&"))
			$this->url=$_SERVER['PHP_SELF']."?page=".$page;
			else{
			$u=explode("&", $url);
			$this->url=$u[0];
			for($i=1;$i<count($u)-1;$i++)
			if(!strpos($u[$i],"page"))
			$this->url=$this->url."&".$u[$i];
			}
			$this->url=$this->url."&page=".$page;
		}
		else
	$this->url=$url."&page=".$page;
	}

	else
	$this->url=$url."?page=".$page;
	return $this->url;
}


//上一页
function get_pre_page($page){
	if($page<$this->pagenum)
	$this->pagenum=$page;
	$start=$page-$this->pagenum;
	if($start<1) $start=1;
	for($i=$start;$i<$page;$i++){
		if($i!=$this->page)
		return  "<li>&nbsp;<a href='".$this->set_url($i)."' class='page'>".$i."</a></li>";
		else
		return  $this->page;
	}
}



//下一页
function get_next_page($page){
	if($this->totalpage-$page<$this->pagenum)
	$this->pagenum=$this->totalpage-$page;
	for($i=$page+1;$i<=$page+$this->pagenum;$i++){
			if($i!=$this->page)
		return  "&nbsp;    <li><a href='".$this->set_url($i)."' class='page'>".$i."</a></li>";
		else
		return  $this->page;

	}
}



function get_page(){
	$html= "每页".$this->num."条&nbsp;第".$this->page."页&nbsp;共".$this->totalpage."页&nbsp;共".$this->total."条";
if($this->page>1){
$html.="<a href='".$this->set_url(1)."'>首页</a>&nbsp;<a href='".$this->set_url($this->page-1)."'>上一页</a>&nbsp;";
$this->get_pre_page($this->page);
}
else $html.="首页&nbsp;上一页";
	$html.= $this->page;
if($this->page>=$this->totalpage)
$html.="下一页&nbsp;尾页";
else {
$this->get_next_page($this->page);
$html.= "<a href='".$this->set_url($this->page+1)."'>下一页</a>&nbsp;<a href='".$this->set_url($this->totalpage)."'>尾页</a>&nbsp;";
}
return $html;
}

}


?>