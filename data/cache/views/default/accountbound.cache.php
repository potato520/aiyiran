<?php if(!defined('IN_MAINONE')) exit(); ?>

        <link rel="stylesheet" type="text/css" href="/template/default/member/css/Basc.css"/>
        <link rel="stylesheet" type="text/css" href="/template/default/member/css/manage_yc.css"/>
        <link rel="stylesheet" type="text/css" href="/template/default/member/css/account_yc.css"/>
        <?php include Template::t_include('member/head_top.html');?>
        <div class="wrapW">

    <?php include Template::t_include('member/user_view/user_inc.html');?>
           
            <div class="conRig_yc">
                <h3 class="dwH3_yc">第三方账号绑定</h3>
                <ul class="accoUl_yc">
                    <li>
                        <div class="liDC_yc">
                            <div class="accItem01">
                                <i class="thirdIcon01"></i><span>绑定QQ账号</span>
                            </div>
                            <div class="accItem02">未绑定</div>
                            <div class="accItem03">
                                <a href="javascript:;" class="accAc">绑定</a>
                            </div>
                            <div class="accItem04">
                                <em class="emSel_yc"></em>
                            </div>
                        </div>
                        <div class="thirdM">
                            <p>绑定后，可以使用QQ帐号登录</p>
                            <a href="javascript:;" class="success_yc">立即绑定</a>
                        </div>
                    </li>
                    <li>
                        <div class="liDC_yc">
                            <div class="accItem01">
                                <i class="thirdIcon02"></i><span>绑定微信账号</span>
                            </div>
                            <div class="accItem02">
                                <strong>未绑定</strong>
                            </div>
                            <div class="accItem03">
                                <a href="javascript:;" class="accAc">绑定</a>
                            </div>
                            <div class="accItem04">
                                <em class="emSel_yc"></em>
                            </div>
                        </div>
                        <div class="thirdM">
                            <p>绑定后，可以使用微信帐号登录</p>
                            <a href="javascript:;" class="success_yc">立即绑定</a>
                        </div>
                    </li>
                    <?php if($info_wb) { ?>
                        <li>
                            <div class="liDC_yc">
                                <div class="accItem01">
                                    <i class="thirdIcon03 active"></i><span>绑定微博账号</span>
                                </div>
                                <div class="accItem02">
                                    <strong>已绑定</strong>
                                </div>
                                <div class="accItem03">
                                    <a href="javascript:;" class="accAc">解除绑定</a>
                                </div>
                                <div class="accItem04">
                                    <em class="emSel_yc"></em>
                                </div>
                            </div>
                            <div class="thirdM">
                                <p>绑定后，可以使用微博帐号登录</p>
                                <a href="javascript:;" class="success_yc" id="clearBild">解除绑定</a>
                            </div>
                        </li>
                    <?php } else { ?>
                      <li>
                        <div class="liDC_yc">
                            <div class="accItem01">
                                <i class="thirdIcon03 active"></i><span>绑定微博账号</span>
                            </div>
                            <div class="accItem02">
                                <strong>未绑定</strong>
                            </div>
                            <div class="accItem03">
                                <a href="javascript:;" class="accAc">绑定</a>
                            </div>
                            <div class="accItem04">
                                <em class="emSel_yc"></em>
                            </div>
                        </div>
                        <div class="thirdM">
                            <p>绑定后，可以使用微博帐号登录</p>
                            <a href="<?php echo $code_url;?>" class="success_yc" id="">立即绑定</a>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="wrapS03_yc jbFT_yc">
            <p>Copyright &copy; <em>2015 - 2016</em> love still All Rights Reserved</p>
        </div>
    </body>
    <script type="text/javascript" src="/template/default/member/js/jquery-1.11.0.min.js" ></script>
    <script type="text/javascript" src="/template/default/member/js/html5shiv.js" ></script>
    <script type="text/javascript" src="/template/default/member/js/common.js" ></script>
    <script type="text/javascript">
        $(function(){
            $(".emSel_yc,.accAc").click(function(){
                var $parL=$(this).parents(".liDC_yc");
                var $parM=$(this).parents(".liDC_yc").siblings(".thirdM");
                var $parMD=$parM.css("display");
                $(".liDC_yc").removeClass("active");
                $parL.addClass("active");
                $(".thirdM").stop().slideUp();
                $parM.stop().slideDown();
                if($parMD=="none"){
                    $parM.stop().slideDown();
                }else{
                    $parM.stop().slideUp();
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(function () {

            //新浪微博绑定
            $("#weibo_bild").click(function () {
                    $.ajax({
                        type: "get",
                        url: "<?php echo $code_url;?>",
                        dataType: "json",
                        success: function(data) {
                            alert(data);
                            if (data.status == 1) {
                                layer.msg(data.msg, {icon: 1, offset: '40%'},function(){
                                    $this.parent().parent().remove();
                                });
                            }else{
                                layer.msg(data.msg, {icon: 2, offset: '40%'});
                            }
                        }
                    });
            });

            // 新浪微博解除绑定
            $("#clearBild").click(function () {
                var $this=$(this);
                var id = $(this).attr('data');
                layer.confirm('确认解除绑定吗？', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    $.ajax({
                        type: "Post",
                        url: "/member/User/clearBild",
                        data: {'id':id},
                        dataType: "json",
                        success: function(data) {
                            if (data.status == 1) {
                                layer.msg(data.msg, {icon: 1, offset: '40%'},function(){
                                     location.reload();
                                });
                            }else{
                                layer.msg(data.msg, {icon: 2, offset: '40%'});
                            }
                        }
                    });
                }, function(){
                    layer.closeAll();
                });

            });
        });
    </script>
</html>
