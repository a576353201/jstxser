    <?php include_once template("header");?>


    <link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/article/article.css?v=b62882d32e1d25a47dad7ec52996d6d1" type="text/css"/>
    <style>
        .article-content {border:1px solid #d3d3d3;background-color:#F9F9F9;}
        .public-nav-sub{
            border: #96beec 1px solid;
            padding: 0px 0px !important;
            height: 32px !important;

        }
        .public-nav-sub ul{
            padding:0px 0px !important;

        }
 #public_header_tab li{
     border-right: #96beec 1px solid;
line-height: 30px;height: 30px;
 }
        #public_more_box{top:5px;}
        .pagination {
            height: 33px;
            line-height: 33px;
            background-color: #ffffff;
            text-align: center;
            border: 1px #f2f2f2 solid;

        }
    </style>

    <div class="container cst-mainbody" style="background-color: #fff;">
        <div class="location-box">
            <ul>
                <li></li>
                <li>
                    <span>当前位置:</span>

                    <?php echo show_position($news['type1'],'news'); ?>
                </li>
            </ul>
        </div>
    <div class="article-content">
        <div class="article-title" style="    border-bottom: 1px solid #da0000;">
            <?php echo show_position($news['type1'],'news'); ?>
        </div>
        <div class="article-mess">
            <div class="article-mess-title"><?php echo $news['title']; ?></div>
            <div class="article-mess-span">


                <span>时间:<?php echo date('Y-m-d H:i:s',$news['addtime']); ?></span>
            </div>

            <div class="article-message" style="line-height: 30px">
                <?php echo $news['content']; ?>


            </div>
        </div>
    </div>
    </div>






    <?php include_once template("footer");?>
