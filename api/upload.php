<?php
include_once '../inc/common.php';
function createVideoThumb($fileName,$dir){
    if(file_exists($dir.'/'.$fileName)){
        $movie = new ffmpeg_movie($dir.'/'.$fileName);//这里就是视频的存储
        $ff_frame = $movie->getFrame(1);
        $gd_image = $ff_frame->toGDImage();

        $filenames =substr($fileName,0,strrpos($fileName,'.'));
        $img=$dir.'/'.$filenames."_video.jpg";//存图片的路径
        imagejpeg($gd_image, $img);
        imagedestroy($gd_image);
        return $img;
    }
    // else echo $dir.'/'.$fileName;

}
$act=trim($_GET['act']);
$res=array('code'=>200);
//上传图片
if($act=='uploadImage'){
    $base64_string = $_POST['imgData'];


    if($_GET['dir']){

        $savepath = '../uploads/images/'.$_GET['dir'].'/'.date('Y').'/'.date('m').'/'.date('d');
    }
    else
        $savepath = '../uploads/images/'.date('Y').'/'.date('m').'/'.date('d');

    if(!file_exists($savepath)) mkdirs($savepath);
    //$savepath = $savepath.'/'.$savename;
    include_once '../inc/Image.php';
    $image=new Image();
    $return= $image->up_image($_FILES['file'],$savepath);


    if($return['code']==200){

        $savepath=str_replace('../','',$savepath);
        $res['url']=$savepath.'/'.$return['url'];
        $res['uploaded']=1;
        $res['message']='上传成功';
    }else{
        $res['code']=0;
        $res['errMsg']=$return['msg'];
        $res['message']=$return['msg'];
        $res['uploaded']=0;
    }
    exit(json_encode($res));
}
//上传声音

if($act=='uploadfile11'){

    if($_GET['dir']){

        $savepath = '../uploads/audio/'.$_GET['dir'].'/'.date('Y').'/'.date('m').'/'.date('d');
    }
    else
        $savepath = '../uploads/audio/'.date('Y').'/'.date('m').'/'.date('d');

    if(!file_exists($savepath)) mkdirs($savepath);
    $tmp_name = $_FILES['file']["tmp_name"];
    $str=explode('.', $_FILES['file']["name"]);
    $filename=time().rand(1000,9999).".".$str[count($str)-1];
    if (move_uploaded_file($tmp_name,$savepath."/".$filename)){
        $savepath=str_replace('../','',$savepath);
        $res['url']=$savepath.'/'.$filename;
        $res['uploaded']=1;
        $res['message']='上传成功';

    }
    else
    {
        $res['code']=0;
        $res['errMsg']='上传失败';
        $res['message']='上传失败';
        $res['uploaded']=0;
    }

    exit(json_encode($res));
}
//上传视频

if($act=='uploadVedio'){

    if($_GET['dir']){

        $savepath = '../uploads/audio/'.$_GET['dir'].'/'.date('Y').'/'.date('m').'/'.date('d');
    }
    else
        $savepath = '../uploads/audio/'.date('Y').'/'.date('m').'/'.date('d');

    if(!file_exists($savepath)) mkdirs($savepath);

    $tmp_name = $_FILES['file']["tmp_name"];
    $str=explode('.', $_FILES['file']["name"]);
    $filename=time().rand(1000,9999).".".$str[count($str)-1];
    if (move_uploaded_file($tmp_name,$savepath."/".$filename)){
        createVideoThumb($filename,$savepath);
        $savepath=str_replace('../','',$savepath);
        $res['url']=$savepath.'/'.$filename;

        $res['uploaded']=1;
        $res['message']='上传成功';

    }
    else
    {
        $res['code']=0;
        $res['errMsg']='上传失败';
        $res['message']='上传失败';
        $res['uploaded']=0;
    }

    exit(json_encode($res));
}


if($act=='uploadVedio1'){

    if($_GET['dir']){

        $savepath = '../uploads/audio/'.$_GET['dir'].'/'.date('Y').'/'.date('m').'/'.date('d');
    }
    else
        $savepath = '../uploads/audio/'.date('Y').'/'.date('m').'/'.date('d');

    if(!file_exists($savepath)) mkdirs($savepath);
    $base64_string = $_POST['imgData'];
    $savename = uniqid().'.mp4';
    $savepath1 = $savepath.'/'.$savename;
    $filename = base64_to_img( $base64_string, $savepath1 );

    if ($filename){
        createVideoThumb($savename,$savepath1);
        $savepath1=str_replace('../','',$savepath1);
        $res['url']=$savepath1;

        $res['uploaded']=1;
        $res['message']='上传成功';

    }
    else
    {
        $res['code']=0;
        $res['errMsg']='上传失败';
        $res['message']='上传失败';
        $res['uploaded']=0;
    }

    exit(json_encode($res));
}

if($act=='uploadfile'){

    if($_GET['dir']){

        $savepath = '../uploads/audio/'.$_GET['dir'].'/'.date('Y').'/'.date('m').'/'.date('d');
    }
    else
        $savepath = '../uploads/audio/'.date('Y').'/'.date('m').'/'.date('d');

    if(!file_exists($savepath)) mkdirs($savepath);

    $tmp_name = $_FILES['file']["tmp_name"];


    $base64_string = $_POST['imgData'];
    $filename = $_POST['filename'];
    $savename = $filename;
    $savepath1 = $savepath.'/'.$savename;
    $filename = base64_to_img( $base64_string, $savepath1 );



//    $data = explode(",",$_POST ['imgData']);
//    $data = $data[1];
//    $data =base64_decode($data);
//    file_put_contents($savepath1,$_POST ['imgData'],FILE_APPEND);

    if (move_uploaded_file($tmp_name,$savepath."/".$filename)){
        //createVideoThumb($savename,$savepath1);
        $savepath1=str_replace('../','',$savepath1);
        $res['url']=$savepath1;

        $res['uploaded']=1;
        $res['message']='上传成功';

    }
    else
    {
        $res['code']=0;
        $res['errMsg']='上传失败';
        $res['message']='上传失败';
        $res['uploaded']=0;
    }

    exit(json_encode($res));
}

//二维码
if($act=='getMyQrcodeCard'){
    //$url=$HttpPath.'?type='.$_REQUEST['type'].'&id='.$_REQUEST['id'];
    $logo='';
    if($_REQUEST['type']=='qr_user') {
        $user=userinfo($_REQUEST['id']);
        $logo="../".$user['avatar'];
        $url=json_encode(array('action'=>'user','id'=>$_REQUEST['id']));
    }
    if($_REQUEST['type']=='qr_group') {
        $group=GroupInfo($_REQUEST['id']);
        $logo="../".$group['avatar'];
        $url=json_encode(array('action'=>'group','id'=>$_REQUEST['id']));
    }

    $path=qr_creat($url);
    $res['code']=200;
    $res['statusCode']=200;
    $res['data']=$path;
    exit(json_encode($res));
}

if($act=='update'){

    $sys=get_system();
    if ($_POST['osname']=='Android')  $osname='Android';else $osname='ios';
    $version=$sys['version_'.$osname];
    if($version==$_POST['version']){
        $data['status']=0;
    }else{
        $data['status']=1;
        $data['downurl']=$sys['down_'.$osname];
        $data['content']=$sys['update_'.$osname];
    }
    $res['code']=200;
    $res['data']=$data;
    exit(json_encode($res));

}

?>