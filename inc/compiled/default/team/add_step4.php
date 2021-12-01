<div class='line'  style='height:auto;'>

<span style='font-size:20px;'>报名表盖章扫描件</span>

<span style='font-size:14px;'>(请上传小于2MB的照片,格式限于jpg、png)</span>


    <input type="hidden" name='file[file1]' id='file_add1' value='<?php echo $file['file1']; ?>'>

<iframe src='../upload_pc.php?fileid=file_add1&img=<?php echo $file['file1']; ?>&iframeid=upload_src1'  id='upload_src1'  style='width:100%;height:100px;'marginwidth="0px" frameborder="0" scrolling="no" ></iframe>
</div>



<div class='line'  style='height:auto;'>

<span style='font-size:20px;'>外援的协议或有关证明</span>


<span style='font-size:14px;'>(请上传小于2MB的照片,格式限于jpg、png)</span>


    <input type="hidden" name='file[file2]' id='file_add2' value='<?php echo $file['file2']; ?>'>

<iframe src='../upload_pc.php?fileid=file_add2&img=<?php echo $file['file2']; ?>&iframeid=upload_src2'  id='upload_src2'  style='width:100%;height:100px;'marginwidth="0px" frameborder="0" scrolling="no" ></iframe>
</div>

<div class='line'  style='height:auto;'>

<span style='font-size:20px;'>团队合影</span>


<span style='font-size:14px;'>(请上传小于2MB的照片,格式限于jpg、png)</span>


    <input type="hidden" name='file[file3]' id='file_add3' value='<?php echo $file['file3']; ?>'>

<iframe src='../upload_pc.php?fileid=file_add3&img=<?php echo $file['file3']; ?>&iframeid=upload_src3'  id='upload_src3'  style='width:100%;height:100px;'marginwidth="0px" frameborder="0" scrolling="no" ></iframe>
</div>



<div class='line'>

<div style='padding-left:120px;'>
<input type='button' class='btn00' value='上一步'  onclick="location.href='add.php?type=<?php echo $_GET['type']; ?>&step=3&id=<?php echo $_GET['id']; ?>&tid=<?php echo $_GET['tid']; ?>';" >
<input type='submit' class='btn01' value='确认<?php if($team['sub']==1){?>修改<?php } else { ?>报名<?php }?>'  onclick="<?php if($team['sub']!=1){?>if(confirm('确定要报名吗? ')==false) return false;<?php }?>return click_sub(<?php echo $step; ?>)"; >

</div>
</div>