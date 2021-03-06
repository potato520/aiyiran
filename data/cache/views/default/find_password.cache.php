<?php if(!defined('IN_MAINONE')) exit(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>重置密码</title>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/login2.css"/>
    </head>
    <body>
        <div class="login_top">
            <div class="login_cont">
                <a href="###" class="logo fl"><img src="<?php echo IMG_PATH;?>/login_02.jpg"/></a>
                <span class=" fl">重置密码</span>
            </div>
        </div>
        <form action="" method="post">
          <div class="set_box">
            <div class="set_cont">
                <ul class="three_step">
                    <li class="active">
                        <span>
                            <i>1</i>
                            <b>安全验证</b>
                        </span>
                        <em></em>
                    </li>
                    <li>
                        <span>
                            <i>2</i>
                            <b>安全验证</b>
                        </span>
                        <em></em>
                    </li>
                    <li>
                        <span>
                            <i>3</i>
                            <b>安全验证</b>
                        </span>
                    </li>
                </ul>
                <div class="find_mm">
                    <label>
                        <span><b>*</b>手机号/邮箱：</span>
                        <input type="text" name="username" id="username" value="" />
                        <p class="p1"></p>
                    </label>
                    <label>
                        <span><b>*</b>验证码：</span>
                        <input type="text" name="code" id="code" value="" class="code_t" />
                        <a href="javascript:;" class="hove_code" onclick="getCode();">获取验证码</a>
                        <p class="p2"></p>
                    </label>
                    <input type="button" id="sub" value="验证" class="verify" onclick="checkCode();" />
                </div>
            </div>
          </div>
          </form>
          
        <div class="footer">
        <p>Copyright © 2016爱依然纪念网. All Rights Reserved  </p>    
        </div>
    </body>
</html>
<script type="text/javascript" src="/template/default/member/js/jq.js" ></script>

<!-- layer插件 -->
<link rel="stylesheet" href="/template/default/member/layer/skin/default/layer.css" type="text/css">
<script src="/template/default/member/layer/layer.js"></script>


<script>

    function ityzl_SHOW_LOAD_LAYER(){  
                return index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
    }  
    function ityzl_CLOSE_LOAD_LAYER(index){  
            layer.close(index);  
    }

    function getCode(){
        var username = $("input[name='username']").val();
        if(username==""){
            $(".p1").html('用户名不能为空');
            $("#username").focus();
            return false;
        }
        $.ajax({
                type: "Post",
                url: "/user/User/restPass",
                data: {'username':username},
                dataType: "json",
                beforeSend: function () {
                    i =ityzl_SHOW_LOAD_LAYER();
                },
                complete: function () {
                    ityzl_CLOSE_LOAD_LAYER(i);  
                },
                success: function(data) {
                    if (data.status == 1) {
                        $(".p1").html(data.msg);
                    }else{
                        $(".p1").html(data.msg);
                        return false;
                    }
                }
        });
    }

    //验证邮箱验证码
    function checkCode()
    {
        var code = $("input[name='code']").val();
        var username = $("input[name='username']").val();
        //初始化
        $(".p1").html('');
        $(".p2").html('');
        if(username==""){
            $(".p1").html('用户名不能为空');
            $("#username").focus();
            return false;
        }
        if(code==""){
            $(".p2").html('验证码不能为空');
            $("#code").focus();
            return false;
        }
        $.ajax({
                type: "Post",
                url: "/user/User/checkEmailCode",
                data: {'code':code,'username':username},
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
                        setTimeout(function(){window.location="/user/User/setPassword";},2000); 
                    }else{
                        $(".p2").html(data.msg);
                        return false;
                    }
                }
        });

    }
</script>
