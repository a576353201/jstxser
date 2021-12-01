    <?php include_once template("header");?>

    <link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/article/article.css?v=b62882d32e1d25a47dad7ec52996d6d1" type="text/css"/>


<style>

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

</style>
    <div class="container cst-mainbody" style="background-color: #fff;">
        <div class="location-box">
            <ul>
                <li></li>
                <li>
                    <span>当前位置:</span>
                    <a href="<?php echo $HttpPath; ?>"><?php echo $system['web_title']; ?></a>  &gt; <a href="#"><?php echo $type1['title']; ?></a>
                </li>
            </ul>
        </div>
        <div class="article-content">
            <div class="article-title" style="    border-bottom: 1px solid #da0000;">
                <span><?php echo $type1['title']; ?></span>
                <a href="<?php echo $HttpPath; ?>">首页</a>/<a href="#"><?php echo $type1['title']; ?></a>
            </div>
            <ul class="article-ul">
                <?php if(is_array($news)){foreach($news AS $index=>$value) { ?>
                <li>
                    <a href='news.php?id=<?php echo $value['id']; ?>' ><b style="margin-right:3px;">标题:</b><?php echo $value['title']; ?></a>

                    <div>
                        <span style="margin-right:3px;">时间:</span><?php echo date('Y-m-d',$value['addtime']); ?>                       </div>
                </li>
                <?php }}?>

            </ul>
            <ul class="pagination">
                <?php echo $page_html; ?>

            </ul>            </div>
    </div>


    <?php include_once template("footer");?>
