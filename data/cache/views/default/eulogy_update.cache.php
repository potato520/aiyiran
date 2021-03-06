<?php if(!defined('IN_MAINONE')) exit(); ?>

		<link rel="stylesheet" type="text/css" href="/template/default/member/css/Basc.css"/>
		<link rel="stylesheet" type="text/css" href="/template/default/member/css/manage_yc.css"/>
		<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->

<?php include Template::t_include('member/head_left.html');?>



		<!--编辑器-->
		<script type="text/javascript" charset="utf-8" src="/static/js/uediter/ueditor.config.js"></script>
		<script type="text/javascript" charset="utf-8" src="/static/js/uediter/ueditor.all.min.js"> </script>
		<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
		<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
		<script type="text/javascript" charset="utf-8" src="/static/js/uediter/lang/zh-cn/zh-cn.js"></script>
		<!--编辑器结束-->
		<script>
            var ue = UE.getEditor('editor',{
                toolbars: [
                    ['fullscreen', 'source', 'undo', 'redo'],
                    ['bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc']
                ],
                initialFrameWidth:600,
                initialFrameHeight:341,
                autoHeightEnabled: false, //滚动条
                elementPathEnabled: false, //删除元素路径
                wordCount: false,    //删除字数统计
                autosave: false
                
            });

		</script>

	
			<div class="conRig_yc">
				<h3 class="dwH3_yc">纪念祭文</h3>
                <form>
				<ul class="ediUl_yc">
					<li>
						<span class="spanT_yc">祭文标题：</span><input type="text" name="ename" value="<?php echo Template::addquote($info['ename']);?>" placeholder="祭文标题" class="inputCom_yc">
					</li>
					<li>
						<span class="spanT_yc">选择分类：</span>
						<select name="cid" class="deadSel_yc">
							<?php $n=1;foreach($catList AS $k => $v) { $lastIndex= count($catList) == $n;?>
							<option value="<?php echo Template::addquote($v['id']);?>" <?php if($info['cid']==$v['id']) { ?>selected=''<?php } ?>
							><?php echo Template::addquote($v['name']);?></option>
							<?php $n++;} ?>
						</select>


					</li>
					<li class="clearfix">
						<span class="fl spanT_yc">祭文详情：</span>
						<div class="fl ediBox_yc" >
							<textarea name="econtent" id="editor" style="width:600px; height: 400px; z-index: 0;"><?php echo Template::addquote($info['econtent']);?></textarea>
						</div>
						<input type="hidden" name="id" value="<?php echo Template::addquote($info['id']);?>">
						<div class="baoc_yc"><a href="javascript:;" class="success_yc" id="eulogy">保存</a></div>
					</li>
				</ul>
            </form>
			</div>
		</div>
		<div class="wrapS03_yc jbFT_yc">
			<p>Copyright &copy; <em>2015 - 2016</em> love still All Rights Reserved</p>
		</div>
	</body>

	<script type="text/javascript" src="/template/default/member/js/jquery-1.11.0.min.js" ></script>
	<script type="text/javascript" src="/template/default/member/js/html5shiv.js" ></script>
	<script type="text/javascript" src="/template/default/member/js/common.js" ></script>
		<script>
            $(function () {
                $("#eulogy").click(function () {
                    $.ajax({
                        type: "Post",
                        url: "/member/memorial/eulogyUpdate",
                        data: $("form").serialize(),
                        dataType: "json",
                        success: function(data) {
                            if (data.status == 1) {
                                var index = layer.msg(data.msg);
                        // setTimeout(function(){window.location="/member/memorial/lists";},2000); 
                            } else {
                                    layer.alert(data.msg, {icon: 2,offset: '40%'});
                                return false;
                            };
                        }
                    });
                });
            });
		</script>
</html>
