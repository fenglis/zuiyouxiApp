<?php
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>巴别时代</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, maximum-scale=1,user-scalable=no">
    <script src="//static1.zuiyouxi.com/web/public/js/jquery.js"></script>
    <link href="//static1.zuiyouxi.com/web/public/css/reset.css" rel="stylesheet">
    <link href="//static1.zuiyouxi.com/zyxapp/static/css/page.css?v=20170303" rel="stylesheet">
    <script>
        var _hmt = _hmt || [];
        (function()
            { var hm = document.createElement("script"); hm.src = "https://hm.baidu.com/hm.js?3dc0b38100bbaf621972a4f2bd815e76"; var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(hm, s); }

        )();
        $('table').wrap('<div class="table_wrapper cl"></div>')
    </script>
</head>
<body>
<div class="con_infor">
    <div class="title">
        <h2><?= $article['title']?></h2>
        <em class="time"><?= $article['created']?></em>
    </div>
    <div class="infor_text">
        <?= $article['content']?>
    </div>
</div>
</body>
</html>