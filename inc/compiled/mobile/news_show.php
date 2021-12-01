    <?php include_once template("header");?>


    <link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/article/article.css?v=b62882d32e1d25a47dad7ec52996d6d1" type="text/css"/>


    <div class="container cst-mainbody" style="background-color: #fff;">
    <div class="article-content">
        <div class="article-title">
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
