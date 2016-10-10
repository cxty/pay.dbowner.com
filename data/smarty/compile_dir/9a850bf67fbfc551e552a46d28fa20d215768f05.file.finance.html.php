<?php /* Smarty version Smarty-3.0.8, created on 2013-08-23 17:25:24
         compiled from "./templates/account/finance.html" */ ?>
<?php /*%%SmartyHeaderCode:7513121552172a846167e4-75204368%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9a850bf67fbfc551e552a46d28fa20d215768f05' => 
    array (
      0 => './templates/account/finance.html',
      1 => 1376363211,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7513121552172a846167e4-75204368',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('header.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

<?php $_template = new Smarty_Internal_Template('datepicker.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('__PUBLIC__')->value;?>
/js/DB.navinit.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('__PUBLIC__')->value;?>
/js/DB.accountFinance.js"></script>

<div class="trade_box">
	<?php $_template = new Smarty_Internal_Template("account/nav.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
	<div class="trade_right">
		<div class="trade_content">
			<div class="trade_cont_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['DetailAccountFinance'];?>
</div>
			<form id="myform" method="post" action="/account/add">
				<input type="hidden" name="AutoID" value="<?php echo $_smarty_tpl->getVariable('listInfo')->value['AutoID'];?>
" />
				<div class="account_cont_box">
					<div class="account_cont_row rmd_msg"><?php echo $_smarty_tpl->getVariable('Lang')->value['AccountState'];?>
</div>					
					<span id="show_msg">
						<div class="account_cont_row md_btn"><a id="modify" href="javascript:void(0);"><?php if ($_smarty_tpl->getVariable('listInfo')->value){?><?php echo $_smarty_tpl->getVariable('Lang')->value['Modify'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('Lang')->value['Add'];?>
<?php }?></a></div>
						<div class="account_cont_row">
							<div class="account_c_r_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['PayType'];?>
：</div>
							<div class="account_c_r_cont">
								<div class="changedb_payicon">
									<label for="alipay_icon" class="alipay_icon b_r">&nbsp;</label>
								</div>
							</div>
						</div>
						<div class="account_cont_row">
							<div class="account_c_r_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['AccountName'];?>
：</div>
							<div class="account_c_r_cont"><?php echo $_smarty_tpl->getVariable('listInfo')->value['aUserName'];?>
</div>
						</div>
						<div class="account_cont_row">
							<div class="account_c_r_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['AccountNum'];?>
：</div>
							<div class="account_c_r_cont"><?php echo $_smarty_tpl->getVariable('listInfo')->value['aAccountNumber'];?>
</div>
						</div>
					</span>
					<span id="modify_msg">
						<div class="account_cont_row">
							<div class="account_c_r_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['PayType'];?>
：</div>
							<div class="account_c_r_cont">
								<div class="changedb_payicon">
									<input type="radio" name="aType" id="alipay_icon" value="1" checked />
									<label for="alipay_icon" class="alipay_icon b_r">&nbsp;</label>
								</div>
							</div>
						</div>
						<div class="account_cont_row">
							<div class="account_c_r_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['AccountName'];?>
：</div>
							<div class="account_c_r_cont">
								<input type="text" name="aUserName" value="<?php echo $_smarty_tpl->getVariable('listInfo')->value['aUserName'];?>
" />
							</div>
						</div>
						<div class="account_cont_row">
							<div class="account_c_r_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['AccountNum'];?>
：</div>
							<div class="account_c_r_cont">
								<input type="text" name="aAccountNumber" value="<?php echo $_smarty_tpl->getVariable('listInfo')->value['aAccountNumber'];?>
" />
							</div>
						</div>
						<div class="account_cont_row">
							<div class="accountdb_btn">
								<a id="sub_btn" class="btn_small" href="javascript:void(0);"><?php echo $_smarty_tpl->getVariable('Lang')->value['ConfirmSubmit'];?>
</a>
							</div>
						</div>
					</span>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
<!--
var navinit = new Tnavinit();
navinit.JS_LANG = <?php echo $_smarty_tpl->getVariable('JS_LANG')->value;?>
;
navinit.jsonData = <?php echo $_smarty_tpl->getVariable('jsonData')->value;?>
;
//页面完全再入后初始化
$(document).ready(function(){
	navinit.init();
});
//释放
$(window).unload(function(){
	navinit = null;
});

var accountFinance = new TaccountFinance();
accountFinance.JS_LANG = <?php echo $_smarty_tpl->getVariable('JS_LANG')->value;?>
;
accountFinance.jsonData = <?php echo $_smarty_tpl->getVariable('jsonData')->value;?>
;
//页面完全再入后初始化
$(document).ready(function(){
	accountFinance.init();
});
//释放
$(window).unload(function(){
	accountFinance = null;
});
//-->
</script>

<?php $_template = new Smarty_Internal_Template('footer.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>