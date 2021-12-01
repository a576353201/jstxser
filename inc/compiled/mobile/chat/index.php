

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css" type="text/css" media="screen" />
<script src="/static/js/group_mobile.js"></script>
<div class="group_nav" style="display: none">
    <div class="search_line">

        <div class="search">
            <input type="text" class="input" name="keyword" value="" placeholder="请输入要搜索的聊天室"><button class="button"><i class="icon-search"></i>搜索</button>

        </div>

    </div>


</div>

<div class="grouptop">
    <span class="back" onclick="history.back();"><i class="icon-left-open-3"></i></span>
  <ul class="menu">
      <li class="active" onclick="change_menu(0);">推荐</li>
      <li  onclick="change_menu(1);">最新</li>
  </ul>
    <i class="icon-search" onclick="show_search();"></i>
</div>

<div class="seacrchtop">
    <li onclick="show_search();"><i class="icon-left-open"></i> </li>
    <li><input class="input1" id="keyword" value="" placeholder="请输入您要搜索的群组"> </li>

    <li>
        <div class="btn" onclick="go_search();"><i class="icon-search"></i>搜索</div>
    </li>

</div>
    <ul id="grouplist" class="grouplist">


    </ul>
<ul id="searchlist" class="grouplist" style="display: none">


</ul>
     <div class="loading">

         <img src="/static/images/loading.gif" ><span>加载中</span>
     </div>


<script>
    var menuid=3;
    var act='top';
    var page=1;
    function  chat(id) {
        location.href='chat.php?id='+id;
    }
    var loading=null;
    function get_list(act,page) {
        $('.loading').html(' <img src="/static/images/loading.gif" ><span>加载中</span>');
        $('.loading').show();
        $.post("../api/group.php?act=group_list",{act:act,page:page}, function(result){
           layer.close(loading);
            var res=JSON.parse(result);
            if(res.code=='200'){
                var html="";

                if(res.data.length>0){

                    for(var i=0;i<res.data.length;i++){
                        var value=res.data[i];
                        if(value.isin==1){
                            var click="parent.open_chatarea("+value.id+",'"+value.name+"','"+value.avatar+"');";
                        }else{
                            var click="parent.group_detail("+value.id+");";
                        }

                        html+="<li onclick=\""+click+"\">";
                        html+="<div class='avatar'><img src='"+value['avatar']+"'  onerror=\"this.src='../uploads/group.jpg'\" /></div>";
                        html+="<div class=\"info\">\n" +
                            "                <div class=\"title\">"+value.name+"</div>\n" +
                            "                <div ><i class=\"icon-users-1\"></i>"+value['people_count']+"/"+value['people_max']+"人</div>\n" +
                            "                <div class=\"tag\">"+value['tags']+"</div>\n" +
                            "            </div>";
                        html+="</li>";
                    }
                    //console.log(res);
                    if(page==1)
                        $('#grouplist').html(html);
                    else  $('#grouplist').append(html);

                         $('.loading').html(' <img src="/static/images/loading.gif" ><span>加载中</span>');
                    $('.loading').hide();
                }
                else{
                    $('.loading').html('亲爱的，到底了！');
                    $('.loading').show();
                }


            }else{
                layer.msg("网络连接失败",{ type: 1, anim: 2 ,time:1000});
            }

        });
    }


    function get_data(act1) {
        act=act1;
        page=1;
        loading=layer.load(1, {
            shade: [0.1,'#fff']
        });
        get_list(act,page);
    }

    function  change_menu(num) {
        if(num==0) act='top';else act='new';
     var li=   document.querySelector('.menu').querySelectorAll('li');
     for(var i=0;i<li.length;i++){
         if(i==num) li[i].className='active';
         else li[i].className='';
     }

        get_data(act);


    }
   function show_search() {
       if(document.querySelector('.seacrchtop').style.display=='table'){
           document.querySelector('.seacrchtop').style.display='none';
           document.querySelector('#grouplist').style.display='';
           document.querySelector('#searchlist').style.display='none';
       }else{
           document.querySelector('.seacrchtop').style.display='table';
           $('#grouplist').hide();
           document.querySelector('#searchlist').style.display='';
       }

   }
    get_data('top');


    function go_search() {
        if($('#keyword').val()==''){
            layer.msg("关键字不能为空",{ type: 1, anim: 2 ,time:2000});
            return false;
        }
        var keyword=$('#keyword').val();
        $.post("../api/group.php?act=group_search",{keyword:keyword}, function(result){
            layer.close(loading);
            var res=JSON.parse(result);
            if(res.code=='200'){
                var html="";
                console.log(res);
                if(res.data.length>0){

                    for(var i=0;i<res.data.length;i++){
                        var value=res.data[i];
                        if(value.isin==1){
                            var click="parent.open_chatarea("+value.id+",'"+value.name+"','"+value.avatar+"');";
                        }else{
                            var click="parent.group_detail("+value.id+");";
                        }
                        var name=value.name.replace(keyword,'<span style="color: #ff0000">'+keyword+'</span>');
                        var tags=value.tags.replace(keyword,'<span style="color: #ff0000">'+keyword+'</span>');
                        html+="<li onclick=\""+click+"\">";
                        html+="<div class='avatar'><img src='"+value['avatar']+"'  onerror=\"this.src='../uploads/group.jpg'\" /></div>";
                        html+="<div class=\"info\">\n" +
                            "                <div class=\"title\">"+name+"</div>\n" +
                            "                <div ><i class=\"icon-users-1\"></i>"+value['people_count']+"/"+value['people_max']+"人</div>\n" +
                            "                <div class=\"tag\">"+tags+"</div>\n" +
                            "            </div>";
                        html+="</li>";
                    }
                    //console.log(res);

                        $('#searchlist').html(html);

                }
                else{
                    $('#searchlist').html("<div class='nodata'>没有找到对应的群组</div>");
                }
                document.querySelector('#searchlist').style.display='';

            }else{
                layer.msg("网络连接失败",{ type: 1, anim: 2 ,time:1000});
            }

        });


    }


    document.querySelector('#grouplist').addEventListener('scroll' , function() {
        //var height = document.getElementById("divData").offsetHeight;//250
        //var height=$("#divData").height();//250
        var scrollHeight =  document.querySelector('#grouplist').scrollHeight;//251
        var scrollTop =  document.querySelector('#grouplist').scrollTop;//0-18
        var clientHeight =  document.querySelector('#grouplist').clientHeight;//233

        if (scrollHeight - clientHeight - scrollTop<=60) {

             page++;
            get_list(act,page);
        }else{

        }
    })
</script>



<?php include_once template("footer");?>