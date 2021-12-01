


  <!--图片轮换-->
  
  <?php if(count($flash)>0){?>
        <div class="flashNews">

<div class="sub_box">
			<div id="p-select" class="sub_nav">
				<div class="sub_no" id="bd1lfsj">
					<ul>
						<?php if(is_array($flash)){foreach($flash AS $index=>$value) { ?>
						<li <?php if($index==0){?>class="show" <?php }?>><?php echo $index+1;?></li>
						
						<?php }}?>
					
					</ul>
				</div>
			</div>
			<div id="bd1lfimg">
				<div>
					<dl class="show"></dl>
					
					<?php if(is_array($flash)){foreach($flash AS $index=>$value) { ?>
										<dl class="">
						<dt><a href="<?php echo set_url('news',$value['id'],'show'); ?>" title="" target="_blank">
						<img src="<?php echo $HttpPath; ?><?php echo $value['src']; ?>" alt="<?php echo $value['title']; ?>"></a></dt>
						<dd>
							<h2><a href="<?php echo set_url('news',$value['id'],'show'); ?>" target="_blank"><?php echo $value['title']; ?></a></h2>
					
						</dd>
					</dl>
					<?php }}?>
										
									</div>
			</div>
		</div>
		<script type="text/javascript">movec();</script>

        </div>

<?php }?>
        <!--图片轮换-->
        