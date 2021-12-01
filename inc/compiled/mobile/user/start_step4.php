
<script>
<?php if($user['group']!=4 && $system['user_file']==1){?>


var user_file=1;


<?php } else { ?>
var user_file=0;
<?php }?>
</script>

<?php if($user['group']==4 || $system['user_file']==1){?>




<div class='line'  style='height:auto;<?php if($user['agree']==1){?>display:none;<?php }?>'>

<?php if($user['group']!=4){?><span class='must'>*</span><span style='font-size:20px;'>个人照片/证件照片</span><?php } else { ?><span style='font-size:20px;'>营业执照</span><?php }?>

<span style='font-size:14px;'>(请上传小于2MB的照片<?php if($user['group']!=4){?>,仅限上传2张，正面和反面<?php }?>)</span>


    <input type="hidden" name='file[file1]' id='file_add1' value='<?php echo $file['file1']; ?>'>

<iframe src='../upload_mobile.php?fileid=file_add1&img=<?php echo $file['file1']; ?>&iframeid=upload_src1&num=2&dir=icp'  id='upload_src1'  style='width:100%;height:100px;'marginwidth="0px" frameborder="0" scrolling="no" ></iframe>
</div>

<?php }?>

<div class='line'  style='height:auto;'>

<?php if($user['group']!=4){?><span class='must'>*</span><span style='font-size:20px;'>生活照片</span><?php } else { ?><span style='font-size:20px;'>组织机构代码证</span><?php }?>


<span style='font-size:14px;'>(请上传小于2MB的照片)</span>

    <input type="hidden" name='file[file2]' id='file_add2' value='<?php echo $file['file2']; ?>'>
<input type="hidden" name='file[info]' id='file_add2_info' value='<?php echo $file['info']; ?>'>
<iframe src='../upload_mobile1.php?fileid=file_add2&img=<?php echo $file['file2']; ?>&info=<?php echo $file['info']; ?>&iframeid=upload_src2'  id='upload_src2'  style='width:100%;height:100px;'marginwidth="0px" frameborder="0" scrolling="no" ></iframe>
</div>




<div class='line'>

<div style='padding-left:40px;'>

<?php if($type=='edit'){?>
<input type='button' class='btn00' value='上一步'  onclick="location.href='start.php?step=<?php if($user['group']==4){?>1<?php } else { ?>3<?php }?>&type=<?php echo $type; ?>';"; >
<input type='submit' class='btn01' value='保存并查看名片'  onclick="return click_sub(<?php echo $step; ?>,<?php echo $user['group']; ?>)"; >


<?php } else { ?>

<input type='button' class='btn00' value='上一步'  onclick="location.href='start.php?step=<?php if($user['group']==4){?>1<?php } else { ?>3<?php }?>&type=<?php echo $type; ?>';"; >
<input type='submit' class='btn01' value='确认并提交'  onclick="return click_sub(<?php echo $step; ?>,<?php echo $user['group']; ?>)"; >

<?php }?>
</div>
</div>