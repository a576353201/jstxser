<?php
include_once 'common.php';
$type=trim($_GET['type']);
if($type=='getmenu'){
	echo "<select name='type2'  onchange=\"ShowNextMenuNav(this.value,".$_GET['type3'].")\">  <option value='0'>二级栏目</option>";
	echo get_secondmenu($_GET[id],$_GET['type3']);

	echo "</select>";

}
if($type=='getmenu2'){
      $menu=$db->fetch_all("select * from ".tname('menu')." where pid='{$_GET['id']}'  order by sortnum asc,id asc");
 if(count($menu)>0){

          ?>

        <?php
        foreach ($menu as $key=> $value) {

        	if(strpos($task['typeids'], "@".$value['id'].'@')!==false) $select="checked";
        	else $select="";
        	?>
        	<div style='width:120px;float:left;'>
        	<input type="checkbox" name='typeids[]' value='<?php echo $value['id'];?>'  <?php echo $select;?>>
<?php echo $value['title']?>
        	</div>

        	<?php
        }
        ?>


          <?php }

}


?>