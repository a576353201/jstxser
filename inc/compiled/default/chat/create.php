

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/group.js?v=<?php echo $cachekey; ?>"></script>
<ul class="layer_nav">
    <li class="active">新建群组</li>

</ul>

<ul class="profile" >
    <li>名称：</li>
    <li><input type="text" class="input1" id="name" value="" placeholder="请输入群组名称">

    </li>

</ul>

<ul class="profile" >
    <li>介绍：</li>
    <li>
        <textarea id="content" placeholder="请输入群组介绍"></textarea>

    </li>

</ul>
<ul class="profile" >
    <li>Logo：</li>
    <li>
        <img src="" class="avatar" style="display: none">
        <div class="add_btn"  onclick="document.querySelector('#cameraInput').click();"><i class="icon-upload-cloud" ></i>浏览</div>
    </li>

</ul>
<ul class="profile" >
    <li>加群验证：</li>
    <li>
       <input type="radio" name="no_invite" value="1" checked> 需要验证
        &nbsp;
        <input type="radio" name="no_invite" value="0"> 无需验证
    </li>

</ul>

<ul class="profile" >
    <li>标签：</li>
    <li>
        <div class="tags_show">

        </div>

        <div class="add_btn" onclick="add_tags();"><i class="icon-plus-circle" ></i>选择标签</div>
    </li>

</ul>
<ul class="profile" >
    <input type="button" value="确认并提交" class="button1" onclick="return click_sub();">
</ul>
<form id="form111" method="post" action=""  enctype="multipart/form-data"  style='display:none;'>

    <input type="file" capture="camera" id="cameraInput" name="cameraInput"   />


</form>
<div class="tags">

    <div class="content">
        <div class="title">选择标签（最多<?php echo $system['tags_sum']; ?>个）</div>
        <?php if(is_array($tags)){foreach($tags AS $key=>$value) { ?>

        <span onclick="click_tags(<?php echo $key; ?>,'<?php echo $value; ?>')"><b><?php echo $value; ?></b>
    <i class="icon-ok"></i>
    </span>

        <?php }}?>

    </div>

<i class="close icon-cancel-circle" onclick=" $('.tags').hide();"></i>
</div>
<script>
    window.onload=function () {
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(index);
    }
    var sub=0;
    function click_sub() {
        sub=0;
        if($('#name').val()==''){
            layer.msg("请输入群组名称",{ type: 1, anim: 2 ,time:2000});
            return false;
        }
//        if($('#content').val()==''){
//            layer.msg("请输入群组介绍",{ type: 1, anim: 2 ,time:2000});
//            return false;
//        }
//        if($('#content').val().length<5){
//            layer.msg("群组介绍不能少于5个字",{ type: 1, anim: 2 ,time:1000});
//            return false;
//        }
        if(is_loading==1){
            sub=1;
            layer.msg("头像正在上传中，请稍等提交",{ type: 1, anim: 2 ,time:1000});
            return false;
        }
        var no_invite=0;
       var radio= document.getElementsByName('no_invite');
       for(var i=0;i<radio.length;i++){
           if(radio[i].checked) no_invite=radio[i].value;
       }
        $.post("../api/group.php?act=createGroup",{id:parent.parent.userid,name:$('#name').val(),content:$('#content').val(),avatar:avatar,tags:tags,no_invite:no_invite}, function(result){

            var res=JSON.parse(result);
            if(res.code=='200'){
                layer.msg("创建成功",{ type: 1, anim: 2 ,time:1000});

                parent.open_chatarea(res.data.id,res.data.name,res.data.avatar)
                var index = parent.layer.getFrameIndex(window.name);
                parent.layer.close(index);
            }else{

                layer.msg("网络错误",{ type: 1, anim: 2 ,time:1000});

            }

        });
    }

var tags_sum=<?php echo $system['tags_sum']; ?>;
    var tags='';
function click_tags(num) {
  var span = document.querySelector('.tags').querySelectorAll('span');
  var clicknum=0;
    for(var i=0;i<span.length;i++){

            if(span[i].className=='active') clicknum++;

    }
  for(var i=0;i<span.length;i++){
      if(i==num){
          if(span[i].className=='active'){
              span[i].className='';
          }

              else{
                  if(clicknum>=tags_sum){
                      return  layer.msg("最多可以选择"+tags_sum+"个标签",{ type: 1, anim: 2 ,time:1000});
                  }
              span[i].className='active';
          }

      }
}
   var tags_show='';
    tags='';
    for(var i=0;i<span.length;i++){

        if(span[i].className=='active') {
          var html=  span[i].querySelector('b').innerHTML
           tags_show+="<span>"+html+"</span>";
          if(tags!='') tags+=',';
          tags+=html;
        }

    }
    $('.tags_show').html(tags_show);
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.iframeAuto(index);

}
    function  add_tags() {
        $('.tags').show();
    }
    var avatar='';
    var is_loading=0;
    var filechooser = document.getElementById("cameraInput");
    var canvas = document.createElement("canvas");
    var tCanvas = document.createElement("canvas");
    var maxsize =10*1024 * 1024;
    filechooser.onchange = function () {

        if (!this.files.length) return;

        var files = Array.prototype.slice.call(this.files);
        files.forEach(function (file, i) {
            if (!/\/(?:jpeg|png|gif)/i.test(file.type)) {   layer.msg("您选择的图片格式不正确",{ type: 1, anim: 2 ,time:1000});;return;}
            var reader = new FileReader();

//          获取图片大小
            var size = file.size/1024 > 1024 ? (~~(10*file.size/1024/1024))/10 + "MB" :  ~~(file.size/1024) + "KB";
            reader.onload = function () {

                var result = this.result;

                if (result.length <= maxsize) {

                    var img = new Image();
                    document.querySelector('.avatar').src=result;
                    $('.avatar').show();
                    if(result.length>2*1024*1024 ){
                        if(img.complete){

                            result= compress(img);
                            upload(result, file.type, $(li));

                            return ;
                        }

                        else{
                            img.onload = function(){
                                result= compress(img);
                                upload(result, file.type);
                                return ;
                            }
                        }
                    }
                    else{
                        upload(result, file.type);
                        return;
                    }
                }
                else{
                    layer.msg("图片最大上传10MB！",{ type: 1, anim: 2 ,time:1000});
                    return false;
                }


            };
            reader.readAsDataURL(file);
        })
    };

    //    使用canvas对大图片进行压缩
    function compress(img) {
        var initSize = img.src.length;
        var width = img.width;
        var height = img.height;
        //如果图片大于四百万像素，计算压缩比并将大小压至400万以下
        var canvas = document.createElement("canvas");

        canvas.width = width;
        canvas.height = height;
        var drawer = canvas.getContext("2d");
        drawer.drawImage(img, 0, 0,width, height);
        var ndata  = canvas.toDataURL("image/jpeg", 0.6);

        tCanvas.width = tCanvas.height = canvas.width = canvas.height = 0;
        return ndata;
    }
    //    图片上传，将base64的图片转成二进制对象，塞进formdata上传
    function upload(basestr, type) {
        var loading=layer.load(1, {
            shade: [0.1,'#fff']
        });
        var base64Data = basestr.substr(22);
        //在前端截取22位之后的字符串作为图像数据
        //开始异步上
        //   console.log(base64Data);
        is_loading=1;
        $.post("../api/index.php?act=uploadImage&type=group&dir=avatar", { id:parent.userid,"imgData": base64Data }, function (data, status) {
            layer.close(loading);
            is_loading=0;
            if(data.code==200){
                avatar=data.url;

                layer.msg("头像上传成功",{ type: 1, anim: 2 ,time:1000});
                if(sub==1)click_sub();
            }
            else{
                // location.reload();
                layer.msg("上传超时",{ type: 1, anim: 2 ,time:1000});
            }


        }, "json");


    }
</script>
<?php include_once template("footer");?>