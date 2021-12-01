<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>css/task.css?v=<?php echo time(); ?>" type="text/css" media="screen" />
<script>


function click_search(){

	if(document.getElementById('word').value==''){



		 window.wxc.xcConfirm('请输入要搜索的内容！',window.wxc.xcConfirm.typeEnum.warning);
		  document.getElementById('word').focus();

		return  false;

	}

}

</script>


	<div style='padding-top:10px;text-align:center;padding-bottom:10px;'>

   		<form action='search.php' method='get'>

   		   <input type='text'  name='word' value='<?php echo $_GET['word']; ?>' id='word'  class='search' placeholder="请输入您要搜索的内容"><input type='submit' class='btn' value='搜索'  onclick='return click_search();'>

   		</form>


   		</div>







<?php if(count($list)>0){?>
  <article class="task-list-wrapper data-list-wrapper">
   		    	<?php if(is_array($list)){foreach($list AS $index=>$value) { ?>
                    <p style="width: 100%;height:10px ;background: #f5f5f5;position: relative;"></p><section>
            <a href="info.php?id=<?php echo $value['id']; ?>">
                <h4 class="TaskLogo">
                	<span><?php if($value['top']==1){?>[<span style='color:#ff0000;'>置顶</span>]<?php }?><?php echo $value['title']; ?></span>

                </h4>
                <p>
                    <span class="price">¥<?php echo $value['money']; ?></span>
                    <span> <?php echo $value['active_num']; ?>人</span>
                    <span>
                    <?php if($value['status']==1){?><?php echo $value['end']; ?>天后投稿截止
                    <?php } else { ?>
中标服务商：<?php echo $value['active_name']; ?>

                    <?php }?>

                    </span>
                </p>
            </a>
        </section>

        <?php }}?>

                    <p style="width: 100%;height:10px ;background: #f5f5f5;position: relative;"></p>    </article>


                    <div class="page"><?php echo $page_html; ?></div>




<?php } else { ?>
<div  style='height:40px;line-height:40px;text-align:center;'>没有找到相关需求</div>

<?php }?>









<?php include_once template("footer");?>