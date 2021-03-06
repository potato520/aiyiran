<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('head.html');?>

<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/jw.css"/>
<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/1.7.2/jquery.js" ></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>/public.js" ></script>
<!-- layer插件 -->
<link rel="stylesheet" href="/template/default/member/layer/skin/default/layer.css" type="text/css">
<script src="/template/default/member/layer/layer.js"></script>
<script type="text/javascript">
    $(function(){
        $(".rep").each(function(){
            $(this).click(function(){
                $(this).parents().next().next().slideToggle(200);

            });
        });
        $(".list_message ul li").hover(function(){
             $(this).addClass("active"); //回复的js
        },function(){
            $(this).removeClass("active");
        });
        $(".list_message ul li:last").css("border","none")

        $('.cancelinfo').click(function(){
           $(this).parent().parent().slideUp(200);
        });

    })
</script>


        <!--*****************************************************-->

        <div class="box_cont_w clearfix">
            <div class="w_1200 clearfix">
                <div class="fl conItem01 clearfix">
                   <div class="details">
                    <div class="top_title">
                        <!-- <a href="###">返回祭文列表页</a> -->
                        <h2><?php echo csubstr($content["title"],24,false);?></h2>
                        <p> 
            <?php if($content['source']!='') { ?>
            来源：<?php echo Template::addquote($content['source']);?>
            <?php } ?>  
            <?php if($content['username']!='') { ?>
            作者：<?php echo Template::addquote($content['username']);?>
            <?php } ?>  
            阅读(<?php echo Template::addquote($click['click']);?>) │ 发布时间：<?php echo date('Y-m-d H:i:s',$content['publishtime']);?> </p>
                    </div>
                    <div class="details_cont">
                          <?php echo Template::addquote($content['content']);?>
                    </div>
                    <p class="return_sx"><em class="prov fl" style="width: 45%; overflow: hidden; height: 84px;"><span>上一篇：</span><a href="###"><?php echo $preContent;?></a></em><em class="next fr" style="width: 45%; overflow: hidden; height: 84px;"><span>下一篇：</span><a href="###"><?php echo $nextContent;?></a></em></p>
                   </div>
                   <div class="leave_message clearfix">
                        <h4>追思留言/Message</h4>
                        <textarea id="content" name="comment_content"></textarea>
                       <input type="hidden" name="aid" id="aid" value="<?php echo $id;?>">
                       <input type="hidden" name="title" id="title" value="<?php echo Template::addquote($content["title"]);?>">
                       <input type="hidden" value="<?php echo $_token;?>" id="_token" name="_token"/>
                        <div class="add_face">
                            <span class="add fl emotion"><i></i>添加表情</span>
                            <span class="publish fr"><em class="fl">还可以输入<i>300</i>字符</em>
                                <?php if($_SESSION['front_login_info']['id']) { ?>
                                <input value="发表评论" class="fb" type="button" id="submit"/>
                                <?php } else { ?>
                                    <input value="发表评论" class="fb" type="button"  onclick="isLogin();"/>
                                <?php } ?>
                            </span>
                        </div>
                    </div>
                    <script>
                        $(function(){
                            function ityzl_SHOW_LOAD_LAYER(){
                                return index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
                            }
                            function ityzl_CLOSE_LOAD_LAYER(index){
                                layer.close(index);
                            }

                            $("#submit").click(function(){
                                var sign=0;
                                if(sign==0) {
                                    sign = 1;
                                    var title = $("#title").val();
                                    var content = $("#content").val();
                                    var aid = $("#aid").val();
                                    var _token = $("#_token").val();
                                    if(content ==""){
                                        layer.msg('内容不能为空', {icon: 2});return false;
                                    }
                                    $.ajax({
                                        type: "Post",
                                        url: "/comment/Comment/detail",
                                        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                                        data: {"comment_content": content, "aid": aid, "_token":_token, "title":title},
                                        dataType: "json",
                                        beforeSend: function () {
                                            $("#submit").attr("disabled","disabled");//按钮不可用
                                            i =ityzl_SHOW_LOAD_LAYER();
                                            // $('#sub').val('发表追思留言中...');
                                        },
                                        complete: function () {
                                            ityzl_CLOSE_LOAD_LAYER(i);
                                            // $('#sub').val('发表追思留言');
                                        },
                                        success: function (data) {
                                            if (data.status == 1) {
//                                                var str = "<li>";
//                                                str += "<h3><span>" + data.data.username + "</span></h3>";
//                                                str += "<p>" + data.data.content + "</p>";
//                                                str += "</li>";
//                                                $("#content").val('');
//                                                $("#ul1").prepend(str);
                                                layer.msg(data.msg, {icon: 1, offset: '40%'},function(){
                                                    location.reload();
                                                });
                                            } else {
                                                layer.msg(data.msg, {icon: 2, offset: '40%'},function(){
                                                    location.reload();
                                                });
                                            }
                                        }
                                    });
                                }else{
                                    alert('你已经提交了');
                                }
                            });
                        });
                    </script>
                <div class="list_message clearfix">
                <ul class="clearfix" id="ul1">
                    <?php $n=1;foreach($messageList['lists'] AS $key => $value) { $lastIndex= count($messageList['lists']) == $n;?>
                    <li>
                        <h3><span><?php echo Template::addquote($value['username']);?></span><i class="rep">回复</i></h3>
                        <p><?php echo ubbReplace($value['content']);?></p>
                        <div class="replys" style="display:none;">
                            <textarea class="form-control" id="conn_<?php echo Template::addquote($value['id']);?>"></textarea>
                            <div class="liu-icon"><a href="javascript:;" onclick="rep(<?php echo Template::addquote($value['id']);?>, <?php echo $id;?>, '<?php echo Template::addquote($content["title"]);?>')" class="btn btn-primary" id="stop_<?php echo Template::addquote($value['id']);?>">评论</a><a href="javascript:;" class="btn btn-default cancelinfo">取消</a></div>
                        </div>
                        <?php if($value['child']) { ?>
                            <?php $n=1;foreach($value['child'] AS $s => $b) { $lastIndex= count($value['child']) == $n;?>
                        <div class="my_message">
                            <p><?php echo Template::addquote($b['username']);?>：<?php echo Template::addquote($b['content']);?></p>
                        </div>
                            <?php $n++;} ?>
                        <?php } ?>
                    </li>
                    <?php $n++;} ?>
                </ul>
                <div class="page">
                    <?php echo Template::addquote($messageList['showPage']);?>
                </div>
                    <!-- 分页样式修改 -->
                    <script type="text/javascript">
                        $(".page_jump").remove();
                        $(".page a").css("width","50px");
                        $(".page .focus").addClass('active');
                    </script>
            </div>

                </div>
                <div class="fl conItem02 clearfix">
                             <!-- 亲情排行榜 -->
                        <?php include Template::t_include('inc/dearRankList.html');?>
                        <a href="###" class="double_j"><img src="<?php echo IMG_PATH;?>/jw_12.jpg" /></a>

                        <!-- 资讯推荐 -->
                        <?php include Template::t_include('inc/infoTop.html');?>
                        <!-- 纪念馆访问排行 -->
                        <?php include Template::t_include('inc/memorialRankList.html');?>
                        <a href="###" class="data_918"><img src="<?php echo IMG_PATH;?>/jw_30.jpg" /></a>
                </div>
            </div>
        </div>
        <!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>


<script>
    //回复文章留言
    function rep(pid, aid, title) {
//        留言的id 和文章aid
        var text = $('#conn_'+pid).val();
        if(text ==""){
            layer.msg('内容不能为空', {icon: 2});return false;
        }

        $.ajax({
            type: "Post",
            url: "/comment/Comment/ajaxwish",
            data: {'pid':pid,'aid':aid,'title':title,'content':text},
            dataType: "json",
            beforeSend: function () {
                $("#stop_"+pid).attr('onclick','');
                i =ityzl_SHOW_LOAD_LAYER();
            },
            complete: function () {
                ityzl_CLOSE_LOAD_LAYER(i);
            },
            success: function(data) {
                if (data.status == 1) {
                    layer.msg(data.msg, {icon: 1, offset: '40%'},function(){
                        location.reload();
                    });
                }else{
                    layer.msg(data.msg, {icon: 2, offset: '40%'},function(){
                        location.reload();
                    });
                    $("#sub").removeAttr("disabled");//按钮可用
                }
            }
        });
    }
</script>

<!--qq表情-->
<script src="/template/default/js/jquery.qqFace.js"></script>
<script>
$(function(){
$('.emotion').qqFace({

id : 'facebox',

assign:'content',

path:'/template/default/images/arclist/'	//表情存放的路径

});

$(".sub_btn").click(function(){

var str = $("#saytext").val();

$("#show").html(replace_em(str));

});

});

//查看结果

function replace_em(str){

str = str.replace(/\</g,'&lt;');

str = str.replace(/\>/g,'&gt;');

str = str.replace(/\n/g,'<br/>');

str = str.replace(/\[em_([0-9]*)\]/g,'<img src="arclist/$1.gif" border="0" />');

return str;

}
</script>
<!--qq表情结束-->

<script>
    //留言框剩余字数
    $(function(){
        $('.leave_message textarea ').keyup(function(){
            //输入字符后键盘up时触发事件
            var txtLeng = $('.leave_message textarea ').val().length;      //把输入字符的长度赋给txtLeng
            //拿输入的值做判断
            if( txtLeng>300 ){
                //输入长度大于300时span显示0
                $('.publish i').text(' 0 ');
                //截取输入内容的前300个字符，赋给fontsize
                var fontsize = $('.leave_message textarea ').val().substring(0,300);
                //显示到textarea上
                $('.leave_message textarea ').val( fontsize );
            }else{
                //输入长度小于300时span显示300减去长度
                $('.publish em i').text(300-txtLeng);
            }
        });
    });
</script>