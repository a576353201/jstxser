

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/group.js?v=<?php echo $cachekey; ?>"></script>





<div class="words">
    <?php if(is_array($words)){foreach($words AS $index=>$value) { ?>
    <div class="word" onclick="click_word('<?php echo $value; ?>')"><?php echo $value; ?></div>
    <?php }}?>

</div>

<view style="margin-top:10px;text-align:  center;">
    <button class="layer_btns cancel"  onclick="var index = parent.layer.getFrameIndex(window.name); parent.layer.close(index);">
        <uni-icons type='close' style="font-size: 18px;margin-right: 5px;color: #333;font-weight: 600;"></uni-icons>
        取消</button>
    <button class="layer_btns ok" onclick="sub()">
        <uni-icons type='checkbox' style="font-size: 18px;color: #fff;margin-right: 5px;"></uni-icons>
        确认</button>
</view>

</view>
<script>
    var userid=parseInt('<?php echo $userid; ?>');
    var thischecked="";
    function click_word(word) {
        var checked=thischecked.split(',');
        if(thischecked.indexOf(word)>-1){

            var arr=[];
            for(var i=0;i<checked.length;i++){

                if(checked[i]!=word){
                    arr.push(checked[i]);
                }
            }

            thischecked=arr.join(',');
        }else{
            if(checked.length>=<?php echo $system['logout_wordsnum']; ?>){

                parent.layer.msg("最多可以选择<?php echo $system['logout_wordsnum']; ?>个踢出理由",{ type: 1, anim: 2 ,time:1000});

                return false;
            }
            if(thischecked!='') thischecked+=','
            thischecked+=word;
        }

      var word=  document.querySelector('.words').querySelectorAll('.word');
        for(var i=0;i<word.length;i++){
            if(thischecked.indexOf(word[i].innerHTML)>-1){
                word[i].className='word active';
            }
            else word[i].className='word';
        }

    }
    function sub() {
        var data={type:'deleteGroup',userid:userid,group_id:<?php echo $group_id; ?>,fromid:<?php echo $_SESSION['userid']; ?>,mark:thischecked};
            parent.send_data(JSON.stringify(data));
        parent.layer.msg("操作成功",{ type: 1, anim: 2 ,time:1000});
        setTimeout(function () {
            var index = parent.layer.getFrameIndex(window.name); parent.layer.close(index);
        },800)

    }
</script>
<style>
    .warp {
        position: fixed;
        left: 10%;
        width: 80%;
        top:25%;
        max-height: 400px;
        z-index: 10;
        background-color: #fff;
        border-radius: 10px;
        padding: 5px 0px;
        border: 1px #eee solid;
    }

    .warp .title{
        height:40px;
        line-height: 40px;
        text-align: center;
        color: #000;
        font-size: 16px;

    }
    .words{
        max-height:  200px;
        overflow-y: scroll;
        width: 100%;
        text-align: center;

    }
    .words::-webkit-scrollbar{
        display: none;
    }

    .words .word{
        display: inline-block;
        margin: 5px 8px;
        height: 32px; line-height: 32px;
        padding: 0px 5px;
        min-width: 70px;
        border: 1px #666 solid;
        border-radius: 5px;
        color: #666;
        background-color: #fff;
        cursor: pointer;
    }
    .words .word.active{
        border: 1px #2319dc solid;
        color: #fff;
        background-color: #2319dc;
    }
    .layer_btns{


        display: inline-block;
        line-height:35px;
        padding: 0px 20px;
        border-radius: 5px;
        border: 0px;
        text-align: center;
        cursor: pointer;
        height:35px;
        color:#fff;
        margin:0px 10px;
        font-size:16px;
    }
    .layer_btns.ok{
        background: -webkit-linear-gradient(left top, #3388ff , #2319dc);
        background: -o-linear-gradient(bottom right, #3388ff, #2319dc);
        background: -moz-linear-gradient(bottom right, #3388ff, #2319dc);
        background: linear-gradient(to bottom right, #3388ff , #2319dc);

    }
    .layer_btns.cancel{
        border: 1px solid #666;
        color: #666;
        background-color: #fff;


    }

</style>

<?php include_once template("footer");?>