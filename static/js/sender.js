var filechooser = document.getElementById("cameraInput");
var filechooser1 = document.getElementById("cameraInput1");
var filechooser2 = document.getElementById("cameraInput2");
var canvas = document.createElement("canvas");
var tCanvas = document.createElement("canvas");
var maxsize =10*1024 * 1024;
var isloading=0;
var mid1='';
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
              //  document.querySelector('#group_avatar').src=result;
                mid1='m' + Math.random().toString(36).substring(2);
                var tempdata={sender_id:userid,msg_id:mid1,_mid:mid1,isloading:1,message:{type:'image',content:result},sender:{avatar:avatar,nickname:nickname}};
                addone(tempdata);
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
filechooser2.onchange = function () {
    debugger

    if (!this.files.length) return;

    var files = Array.prototype.slice.call(this.files);
    files.forEach(function (file, i) {

       // if (!/\/(?:r|ogg)/i.test(file.type)) {   layer.msg("您选择的文件格式不正确1",{ type: 1, anim: 2 ,time:1000});;return;}
        var reader = new FileReader();

        reader.readAsDataURL(file);
        var filename=file.name;
//          获取图片大小
        var size = file.size/1024 > 1024 ? (~~(20*file.size/1024/1024))/10 + "MB" :  ~~(file.size/1024) + "KB";
        reader.filename = file.name;


        reader.onload = function (e) {

            var result = this.result;
            console.log(result)
            if (result.length <= maxsize) {

                var img = new Image();
                //  document.querySelector('#group_avatar').src=result;
                mid1='m' + Math.random().toString(36).substring(2);
                var tempdata={sender_id:userid,msg_id:mid1,_mid:mid1,isloading:1,message:{type:'file',content:result},sender:{avatar:avatar,nickname:nickname}};
                addone(tempdata);

                upload_file(result, e.target.filename);
                return;

            }
            else{
                layer.msg("视频最大上传20MB！",{ type: 1, anim: 2 ,time:1000});
                return false;
            }


        };
        //reader.readAsDataURL(file);
    })
};

filechooser1.onchange = function () {
    debugger

    if (!this.files.length) return;

    var files = Array.prototype.slice.call(this.files);
    files.forEach(function (file, i) {

        if (!/\/(?:mp4|ogg)/i.test(file.type)) {   layer.msg("您选择的视频格式不正确1",{ type: 1, anim: 2 ,time:1000});;return;}
        var reader = new FileReader();

        reader.readAsDataURL(file);
//          获取图片大小
        var size = file.size/1024 > 1024 ? (~~(20*file.size/1024/1024))/10 + "MB" :  ~~(file.size/1024) + "KB";
        reader.onload = function () {

            var result = this.result;
             console.log(result)
            if (result.length <= maxsize) {

                var img = new Image();
                //  document.querySelector('#group_avatar').src=result;
                mid1='m' + Math.random().toString(36).substring(2);
                var tempdata={sender_id:userid,msg_id:mid1,_mid:mid1,isloading:1,message:{type:'vedio',content:result},sender:{avatar:avatar,nickname:nickname}};
                addone(tempdata);

                upload_video(result);
                return;

            }
            else{
                layer.msg("视频最大上传20MB！",{ type: 1, anim: 2 ,time:1000});
                return false;
            }


        };
        //reader.readAsDataURL(file);
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

    var base64Data = basestr.substr(22);
    //在前端截取22位之后的字符串作为图像数据
    //开始异步上
           //   console.log(base64Data);
        isloading=1;
        $.post("../api/index.php?act=uploadImage&type=chat&dir=chat", { group_id:group_id,"imgData": base64Data }, function (data, status) {

            isloading=0;
            if(data.code==200){
                if(isgroup==1)
                    var data={type:'group',userid:userid,group_id:group_id,content:data.url,msgtype:'image',mid:mid1};
                else   var data={type:'chat',userid:userid,friend_uid:group_id,content:data.url,msgtype:'image',mid:mid1};

                parent.send_data(JSON.stringify(data));

            }
            else{
                // location.reload();
                layer.msg("图片发送失败",{ type: 1, anim: 2 ,time:1000});
            }


        }, "json");


}
function upload_video(basestr) {
    var base64Data = basestr.substr(22);
    //在前端截取22位之后的字符串作为图像数据
    //开始异步上

    isloading=1;
    $.post("../api/upload.php?act=uploadVedio1", { group_id:group_id,"imgData": base64Data }, function (data, status) {

        isloading=0;
        if(data.code==200){
            if(isgroup==1)
                var data={type:'group',userid:userid,group_id:group_id,content:data.url,msgtype:'vedio',mid:mid1};
            else   var data={type:'chat',userid:userid,friend_uid:group_id,content:data.url,msgtype:'vedio',mid:mid1};
          console.log(data);
            parent.send_data(JSON.stringify(data));

        }
        else{
            // location.reload();
            layer.msg("视频发送失败",{ type: 1, anim: 2 ,time:1000});
        }


    }, "json");
}


function upload_file(basestr,filename){
    var base64Data = basestr.substr(22);
    //在前端截取22位之后的字符串作为图像数据
    //开始异步上

    isloading=1;
    $.post("../api/upload.php?act=uploadfile", { group_id:group_id,filename:filename,"imgData": base64Data }, function (data, status) {

        isloading=0;
        if(data.code==200){
            if(isgroup==1)
                var data={type:'group',userid:userid,group_id:group_id,content:data.url,msgtype:'file',mid:mid1};
            else   var data={type:'chat',userid:userid,friend_uid:group_id,content:data.url,msgtype:'file',mid:mid1};
            console.log(data);
            parent.send_data(JSON.stringify(data));

        }
        else{
            // location.reload();
            layer.msg("文件发送失败",{ type: 1, anim: 2 ,time:1000});
        }


    }, "json");
}

var layer_img=null;
function  showimg(src) {
 //   $('#showimg img').src(src);
    if(ismobile==1){
        layer_img= layer.open({
            type: 1,
            title: false,
            closeBtn: 1,
            area: ['auto'],
            skin: 'layui-layer-nobg', //没有背景色
            shadeClose: true,
            content: "<img src='"+src+"'  style='max-width: 100%;max-height: 800px' onclick='layer.close(layer_img)'/>"
        });


    }else{
        parent.layer_img= parent.layer.open({
            type: 1,
            title: false,
            closeBtn: 1,
            area: ['auto'],
            skin: 'layui-layer-nobg', //没有背景色
            shadeClose: true,
            content: "<img src='"+src+"'  style='max-width: 100%;max-height: 800px' onload='setthisheight()' />"
        });


    }



}
