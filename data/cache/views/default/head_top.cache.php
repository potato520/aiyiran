<?php if(!defined('IN_MAINONE')) exit(); ?>
<html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>个人中心--纪念馆管理</title>
    <!-- <link rel="stylesheet" href="/template/default/member/css/Base.css"> -->

</head>
<body>
<div class="header_yc">
    <div class="clearfix headMain_yc">
        <div class="clearfix headL_yc">
            <span class="fl title_yc"></span>
            <ul class="fl clearfix firstUl_yc">
                <li <?php if($isNav == 1) { ?> class="active" <?php } ?>>
                    <a href="/member/Index/index"><i class="icon1_yc"></i>首页</a>
                </li>
                <li <?php if($isNav == 2) { ?> class="active" <?php } ?>>
                    <a href="javascript:;">纪念馆管理<i class="icon2_yc"></i></a>
                    <ul class="secondUl_yc">
                        <li><a href="/member/memorial/lists">我管理的馆</a></li>
                        <li><a href="/member/memorial/follow">我关注的馆</a></li>
                        <li><a href="/member/memorial/create">创建新馆</a></li>
                    </ul>
                </li>
                <li <?php if($isNav == 3) { ?> class="active" <?php } ?>>
                    <a href="javascript:;">资金管理<i class="icon2_yc"></i></a>
                    <ul class="secondUl_yc">
                        <li><a href="/member/Recharge/consumption">消费记录</a></li>
                        <li><a href="/member/Recharge/recording">充值记录</a></li>
                        <li><a href="/member/Recharge/online">在线充值</a></li>
                        <!-- <li><a href="javascript:;">会员充值</a></li> -->
                    </ul>
                </li>
                <li <?php if($isNav == 4) { ?> class="active" <?php } ?>>
                    <a href="javascript:;">祭拜记录<i class="icon2_yc"></i></a>
                    <ul class="secondUl_yc">
                        <li><a href="/member/Recharge/sacrifice">我贡献的祭品</a></li>
                        <!-- <li><a href="javascript:;">我发布的悼文</a></li> -->
                        <li><a href="/member/Recharge/comment">我发布的评论</a></li>
                        <li><a href="/member/Recharge/message">我发布的留言</a></li>
                    </ul>
                </li>
                <li <?php if($isNav == 5) { ?> class="active" <?php } ?>>
                    <a href="javascript:;">账号设置<i class="icon2_yc"></i></a>
                    <ul class="secondUl_yc">
                        <li><a href="/member/User/userinfo">个人资料</a></li>
                        <li><a href="/member/User/safe/">安全设置</a></li>
                        <li><a href="/member/User/accountbound">第三方帐号绑定</a></li>
                    </ul>
                </li>
                <li <?php if($isNav == 6) { ?> class="active" <?php } ?>>
                    <a href="/member/Systeminfo/lists">系统消息</a>
                </li>
            </ul>
        </div>
        <div class="headR_yc">
            <ul class="clearfix">
                <li>
                    <a href="/category/Category/index/cid/281"><i class="icon3_yc"></i>帮助中心</a>
                </li>
                <li>
                    <a href="/member/User/userinfo"><img src="<?php echo extends_path($_SESSION['front_login_info']['user_photo'], IMG_PATH.'/wdl_03.png');?>" alt="头像" class="toux_yc"><?php echo Template::addquote($GLOBALS['username']);?></a>
                </li>
                <li>
                    <a href="/user/User/loginout"><i class="icon4_yc"></i>退出</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<script type="text/javascript" src="/template/default/member/js/jq.js" ></script>
<script type="text/javascript" src="/template/default/member/js/jquery.form.js" ></script>


<!-- layer插件 -->
<link rel="stylesheet" href="/template/default/member/layer/skin/default/layer.css" type="text/css">
<script src="/template/default/member/layer/layer.js"></script>

<script type="text/javascript">
// $('body').on('click', 'a', function(e) {
//     e.target.target = '_blank';
// });
</script>
