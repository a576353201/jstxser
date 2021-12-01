    <?php include_once template("header");?>

    <link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/article/article.css?v=b62882d32e1d25a47dad7ec52996d6d1" type="text/css"/>



    <div class="container cst-mainbody" style="background-color: #fff;">

        <div class="article-content">
            <div class="article-title">

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
