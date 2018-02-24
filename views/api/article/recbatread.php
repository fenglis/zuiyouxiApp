<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>巴别时代</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=750, maximum-scale=1,user-scalable=no">
    <link href="//static1.zuiyouxi.com/zyxapp/static/css/reset.css" rel="stylesheet">
    <link href="//static1.zuiyouxi.com/zyxapp/static/css/page.css?v=20170303" rel="stylesheet">
    <link href="//static1.zuiyouxi.com/zyxapp/static/css/swipebox.css?v=5" rel="stylesheet">
    <script src="//static1.zuiyouxi.com/zyxapp/static/js/jquery-2.0.3.min.js"></script>
    <script src="//static1.zuiyouxi.com/zyxapp/static/js/swipebox.js?v=5"></script>
    <script>
        var _hmt = _hmt || [];
        (function()
            { var hm = document.createElement("script"); hm.src = "https://hm.baidu.com/hm.js?490f8ff2f1038fe2548b3448f79ef580"; var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(hm, s); }

        )();
    </script>
</head>
<body>
<div class="con_szzr">
    <?php $path = \Yii::$app->params['attachUrl'] . \Yii::$app->params['recommendImage']; ?>
    <h2><p>上阵阵容</p></h2>
    <table class="wj">
        <tr>
            <td>
                <img src="<?=$path . '/' . $generals[0]?>" alt="">
            </td>
            <td class="big">
                <img src="<?=$path . '/' . $generals[1]?>" alt="">
            </td>
            <td class="br_n">
                <img src="<?=$path . '/' . $generals[2]?>" alt="">
            </td>
        </tr>
        <tr>
            <td>
                <img src="<?=$path . '/' . $generals[3]?>" alt="">
            </td>
            <td class="big">
                <img src="<?=$path . '/' . $generals[4]?>" alt="">
            </td>
            <td class="br_n">
                <img src="<?=$path . '/' . $generals[5]?>" alt="">
            </td>
        </tr>
    </table>
    <ul class="tj_info cl">
        <li class="tj_author cl"><span class="title">推荐人：</span><em><?=$recbat['referrer']?></em></li>
        <li class="star cl">
            <span class="title">获得难度：</span>
            <?php for ($i = 0; $i < $recbat['difficulty']; $i++) {?>
                <img src="//static1.zuiyouxi.com/zyxapp/static/images/re-star.png" alt="">
            <?php }?>
            <?php for ($i = 0; $i < 5-$recbat['difficulty']; $i++) {?>
                <img src="//static1.zuiyouxi.com/zyxapp/static/images/re-star-hollow.png" alt="">
            <?php }?>
        </li>
        <li class="friend cl">
            <!--<span class="title">小伙伴：</span>-->
            <p class="text"><?=$recbat['content']?></p>
        </li>
    </ul>
    <ul class="img_info cl">
        <li><a class="swipebox" href="<?=$path . '/' . $screenshot[0]?>"><img src="<?=$path . '/' . $screenshot[0]?>" alt=""></a></li>
        <li><a class="swipebox" href="<?=$path . '/' . $screenshot[1]?>"><img src="<?=$path . '/' . $screenshot[1]?>" alt=""></a></li>
        <li><a class="swipebox" href="<?=$path . '/' . $screenshot[2]?>"><img src="<?=$path . '/' . $screenshot[2]?>" alt=""></a></li>
    </ul>
</div>
</body>
</html>
<script type="text/javascript">
    $(function(){
        $('.swipebox').swipebox({
            hideBarsDelay : 0
        });
    })
</script>
