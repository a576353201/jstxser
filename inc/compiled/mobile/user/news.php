
<?php include_once template("header");?>
<style>
    .warp{
        width:100%;
        height: 100vh;
        display: inline-block;

    }
    .warp .left{
        width: 200px;
        float: left;
        height: 100vh;
        overflow-x:hidden;
        overflow-y: scroll;
        border-right: 1px solid #ddd;
    }
    .warp .left li{
        display: block;
        height: 30px;
        line-height: 30px;
        padding:10px 10px;
        padding-left: 20px;
        border-bottom: 1px #ddd dashed;
        color: #111;
        font-size: 16px;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        word-break: break-all;
        cursor: pointer;
    }
    .warp .left li.active{
        border-left: 4px solid #2319dc;
        color: #2319dc;
    }
    .warp .right{
        width:100%;
        height: 100vh;
        float: right;
        text-align: center;
    }
    .warp .right .line{
        display: none;
        position: relative;
        height: 100vh;
        width: 100%;
    }
    .warp .right .line.active{
        display: inline-block;
    }
    .warp .right .line .top{
        position: absolute;
        left: 0px;
        width: 100%;
        height: 50px;
        top:0px;
        text-align: center;
        border-bottom: 1px #ddd solid;
    }
    .warp .right .line .top .title{
        height: 30px;
        line-height: 30px;
        font-size: 16px;
        color: #000;
        font-weight: 600;
    }
    .warp .right .line .top .time{
        height: 20px;
        line-height: 20px;
        color: #999;
        font-size: 12px;

    }
    .warp .right .line  .content{
        position: absolute;
        top: 65px;
        left: 0px;
        width: calc(100% - 12px);
        height: calc(100vh - 70px);
        overflow-x:hidden;
        overflow-y: scroll;
        text-align: left;
        line-height: 30px;
        padding:5px 10px;

        color: #333;
        font-size: 14px;
    }
    .warp .right .line  .content p{
        font-size: 14px !important;
    }
    .warp .left::-webkit-scrollbar,    .warp .right .line  .content::-webkit-scrollbar{
        display: inline-block;
        width: 5px;
        background-color: #fff;
    }
    .warp .left::-webkit-scrollbar-thumb,    .warp .right .line  .content::-webkit-scrollbar-thumb{
        background-color: #e5e5e5;
        border-radius: 3px;
    }


</style>

<div class="warp">


    <div class="right">
        <?php if(is_array($news)){foreach($news AS $index=>$value) { ?>

      <div class="line <?php if($index==0){?>active<?php }?>">

          <div class="top">

              <div class="title"><?php echo $value['title']; ?></div>
              <div class="time"><i class="icon-clock"></i><?php echo date('Y-m-d H:i:s',$value['edittime']); ?></div>
          </div>

<div class="content">


    <?php echo $value['content']; ?>
</div>


      </div>


        <?php }}?>


    </div>
</div>
<script>
    function click_item(num) {
        var li=document.querySelector('.left').querySelectorAll('li');
        var line=document.querySelector('.right').querySelectorAll('.line');
        for(var i=0;i<li.length;i++){
            if(i==num){
                li[i].className='active';
                line[i].className='line active';
            }
            else{
                li[i].className='';
                line[i].className='line';
            }
        }

    }

</script>

