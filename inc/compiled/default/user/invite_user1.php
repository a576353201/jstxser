

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<div class="page">
    <span class='tit'>账号：</span> <?php echo $userinfo['name']; ?>
    <view class="btn_grey" onclick="copy('<?php echo $userinfo['name']; ?>')" style="margin-left: 5px;cursor: pointer">复制</view>
    <br>

    <span  class='tit'>类型：</span>
    <?php if($userinfo['isdaili']==1){?>
    <span class="btn_green">代理</span>
    <?php } else { ?>
    <span class="btn_yellow">玩家</span>
    <?php }?>
    <?php if($userinfo['vip']==1){?>
    <span class="btn_blue">计划员</span>
    <?php }?><br>

    <span  class='tit'>团队人数：</span> <span style='color:#2319dc'><?php echo $userinfo['team_num']; ?></span> <br>
    <span  class='tit'>团队余额：</span> <span style='color:#2319dc'><?php echo $userinfo['team_money']; ?></span>元 <br>
    <span  class='tit'>个人余额：</span> <span style='color:#2319dc'><?php echo $userinfo['money']; ?></span>元 <br>
    <span  class='tit'>在线状态：</span>
    <?php if($userinfo['isonline']){?>
    <span style='color:#2319dc'>在线</span>
    <?php } else { ?>
    <span  >离线</span>
    <?php }?>
    <br>
    <?php if($userinfo['logintime']>0){?>
        <span class='tit'>登录时间：</span> <?php echo date('Y-m-d H:i',$userinfo['logintime']); ?> <br>
      <?php }?>

    <span  class='tit'>注册时间：</span><?php echo date('Y-m-d H:i',$userinfo['regtime']); ?><br>


</div>



<script>
    function copy(text) {
        console.log(text);
        Clipboard.copy(text);
    }
    window.Clipboard = (function(window, document, navigator) {
        var textArea,
            copy;

        // 判断是不是ios端
        function isOS() {
            return navigator.userAgent.match(/ipad|iphone/i);
        }
        //创建文本元素
        function createTextArea(text) {
            textArea = document.createElement('textArea');
            textArea.innerHTML = text;
            textArea.value = text;
            document.body.appendChild(textArea);
        }
        //选择内容
        function selectText() {
            var range,
                selection;

            if (isOS()) {
                range = document.createRange();
                range.selectNodeContents(textArea);
                selection = window.getSelection();
                selection.removeAllRanges();
                selection.addRange(range);
                textArea.setSelectionRange(0, 999999);
            } else {
                textArea.select();
            }
        }

        //复制到剪贴板
        function copyToClipboard() {
            try{
                if(document.execCommand("Copy")){

                    layer.msg('复制成功',{ type: 1, anim: 2 ,time:1000});
                }else{

                    layer.msg('复制失败！请手动复制！',{ type: 1, anim: 2 ,time:1000});
                }
            }catch(err){

                layer.msg('复制错误！请手动复制！',{ type: 1, anim: 2 ,time:1000});

            }
            document.body.removeChild(textArea);
        }

        copy = function(text) {
            createTextArea(text);
            selectText();
            copyToClipboard();
        };

        return {
            copy: copy
        };
    })(window, document, navigator);

</script>

<style>
    .page{
        background-color: #fff;

        line-height:35px;
        text-align: left;
        margin-top: 10px;
    }
    .page::-webkit-scrollbar{
        display: none;
    }

    .page > div{
        height: 35px;


    }
    .page  .tit{
        display: inline-block;
        width: 110px;
        text-align: right;
        color: #666;
    }

    .btn_green{
        background-color: #0aad6c;
        color: #fff;font-size: 12px;
        display: inline-block;
        height: 18px;
        line-height: 18px;
        padding: 0px 5px;
        border-radius: 5px;
        text-align: center;
    }
    .btn_blue{
        background-color: #2319dc;
        color: #fff;font-size: 12px;
        display: inline-block;
        height: 18px;
        line-height: 18px;
        padding: 0px 5px;
        border-radius: 5px;
        text-align: center;
    }

    .btn_grey{
        background-color: #ddd;
        color: #000;font-size: 12px;
        display: inline-block;
        height: 12px;
        line-height: 12px;
        padding: 2px 5px;
        border-radius: 5px;
        text-align: center;

</style>
<?php include_once template("footer");?>