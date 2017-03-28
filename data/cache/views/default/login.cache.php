<?php if(!defined('IN_MAINONE')) exit(); ?>
<!--连接中的type用来判断是刷新当前页面还是跳转到用户中心1:代表刷新当前页面,2代表前往用户中心，默认为1-->
<!-- <form action='/user/Login/login/' method='post' id='loginForm'> -->
<div class="login_r" style="display: block;">
                        <h3>账号登录</h3>
        <!-- 验证是否提交 -->
        <input type="hidden" class="pwd"  name='dosubmit' value="1"/>
                        <div class="inp_text user_name">
                        <?php if($_SESSION['saveName']) { ?>
                            <input type="text" name="username" id="username" value="<?php echo Template::addquote($_SESSION['saveName']);?>"/>
                        <?php } else { ?>
                            <input type="text" name="username" id="username" placeholder="请输入用户名"/>
                        <?php } ?>
                            <span><i></i></span>
                        </div>
                        <p class="error_tips p1" style=" display: block;"></p>
                        <div class="inp_text pass_word" style="margin-top: 0px;">
                            <input type="password" name="password" id="password" value=""  />
                            <span><i></i></span>
                        </div>
                        <p class="error_tips p2" style=" display: block;"></p>
                        <div class="remember">
                            <span class="fl rem_user_n"><input type="checkbox" name="saveName" value="1" id="female" style="display:inline;" /> <label for="female">记住用户名</label></span>
                            <span class="fr">
                            <a href="/user/User/restPassword">忘记密码</a>
                            <em>|</em>
                            <a href="/user/User/register/groupid/24">免费注册</a>
                            </span>
                        </div>
                        <input type="button" id="huiche" value="立即登录" class="must_login"  onclick="login();" />
                        <div class="therr_dl">
                            <a href="###" class="qq_dl"></a>
                            <a href="javascript:;" class="wb_dl" onclick="show_child('weibo')"></a>
                            <a href="###" class="wx_dl"></a>
                        </div>
                    </div>
<!-- </form> -->

<!-- layer插件 -->
<link rel="stylesheet" href="/template/default/member/layer/skin/default/layer.css" type="text/css">
<script src="/template/default/member/layer/layer.js"></script>

<script>
  function show_child(lgtype) {
            if (lgtype == "weibo") {
                childUrl = "<?php echo $code_url;?>";
            }
            else if (lgtype == "qq") {
                childUrl = "https://graph.qq.com/oauth2.0/authorize?response_type=code&amp;client_id=101170610&amp;redirect_uri=http://user.tsingming.com/account/partner_unifiedThirdpartCallback?ThirdpartState=qq&amp;state=636191230419868750";
            }
            else if (lgtype == "weixin") {
                childUrl = "https://open.weixin.qq.com/connect/qrconnect?appid=wx0d8a0547087f8f0d&amp;redirect_uri=http%3a%2f%2fwechat.tsingming.com%2flogin&amp;response_type=code&amp;scope=snsapi_login&amp;state=02181DF1E4A3F89BEA09A47A8F249AA6A729C948847FA7C14DF15BF3D66B91A9";
                var child = window.open(childUrl.replace(/&amp;/g, "&"), "child", "height=600,width=600,status=yes,toolbar=no,menubar=no,location=no");
                return;
            }
            var child = window.open(childUrl.replace(/&amp;/g, "&"), "child", "height=400,width=600,status=yes,toolbar=no,menubar=no,location=no");
        }





    function ityzl_SHOW_LOAD_LAYER(){
                return index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
    }
    function ityzl_CLOSE_LOAD_LAYER(index){
            layer.close(index);
    }
$(function () {
    $("body").keydown(function() {
        if (event.keyCode == "13") {//keyCode=13是回车键
           login();
        }
    });
})


  function login()
    {
        var password = $("input[name='password']").val();
        var username = $("input[name='username']").val();
        var saveName = $('input[name="saveName"]:checked').val();

        //初始化
        $(".p1").html('');
        $(".p2").html('');
        if(username==""){
            $(".p1").html('用户名不能为空');
            $("#username").focus();
            return false;
        }
         if(password==""){
            $(".p2").html('密码不能为空');
            $("#password").focus();
            return false;
        }
        $.ajax({
                type: "Post",
                url: "/user/Login/login2",
                data: {'password':password,'username':username, 'saveName':saveName},
                dataType: "json",
                beforeSend: function () {
                    i =ityzl_SHOW_LOAD_LAYER();
                },
                complete: function () {
                    ityzl_CLOSE_LOAD_LAYER(i);
                },
                success: function(data) {
                    if (data.status == 1) {
                        $(".p2").html(data.msg);
                        setTimeout(function(){window.location="/";},1000);
                    }else{
                        $(".p2").html(data.msg);
                        return false;
                    }
                }
        });

    }
</script>
