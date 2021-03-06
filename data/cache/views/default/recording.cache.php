<?php if(!defined('IN_MAINONE')) exit(); ?>

		<meta charset="UTF-8">
		<title>资金管理--充值记录</title>
		<link rel="stylesheet" type="text/css" href="/template/default/member/css/Basc.css"/>
		<link rel="stylesheet" type="text/css" href="/template/default/member/css/manage_yc.css"/>
		<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
	<?php include Template::t_include('member/head_top.html');?>
	
		<div class="wrapW">
			<?php include Template::t_include('member/money_view/money_inc.html');?>
		
			<div class="conRig_yc">
				<h3 class="dwH3_yc">充值记录</h3>
				<!-- <div class="timeBox">
					<span>选择日期：</span>
					<strong><input type="text" class="moneyIn"><i class="timeIcon"></i></strong>
					<span class="ml6">到</span>
					<strong class="ml6"><input type="text" class="moneyIn"><i class="timeIcon"></i></strong>
					<a href="javascript:;" class="timeA ml6">全部</a>
					<a href="javascript:;" class="timeA ml18">最近一周</a>
					<a href="javascript:;" class="timeA ml18">最近一个月</a>
					<a href="javascript:;" class="timeCX ml6">查询</a>
				</div> -->
				<table class="table_yc">
					<thead>
						<tr>
							<td><span>订单编号</span></td>
							<td><span>订单日期</span></td>
							<td><span>元宝数量</span></td>
							<td><span>支付金额</span></td>
							<td><span>订单状态</span></td>
							<!-- <td><span>详情</span></td> -->
						</tr>
					</thead>
					<tbody>
					<?php $n=1;foreach($lists AS $k => $v) { $lastIndex= count($lists) == $n;?>
						<tr>
							<td><span><?php echo Template::addquote($v['ordersn']);?></span></td>
							<td><span><?php echo date('Y-m-d h:i:s', $v['ordertime']);?></span></td>
							<td><span><?php echo Template::addquote($v['goods_name']);?></span></td>
							<td><span><?php echo Template::addquote($v['money']);?></span></td>
							<td><span>
									<?php if($v['status']==1) { ?>
										待付款
									<?php } elseif ($v['status']==2) { ?>
										已完成
									<?php } else { ?>
										已取消
									<?php } ?>
							</span></td>
							<td>
								
							</td>
						</tr>
					<?php $n++;} ?>
					</tbody>
				</table>
				<div class="pageF_yc">
					<?php echo $pagestr;?>
				</div>
			</div>
		</div>
		<div class="wrapS03_yc jbFT_yc">
			<p>Copyright &copy; <em>2015 - 2016</em> love still All Rights Reserved</p>
		</div>
	</body>
	<script type="text/javascript" src="/template/default/member/js/jquery-1.11.0.min.js" ></script>
	<script type="text/javascript" src="/template/default/member/js/html5shiv.js" ></script>
	<script type="text/javascript" src="/template/default/member/js/common.js" ></script>
</html>
