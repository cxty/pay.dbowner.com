<?php /* Smarty version Smarty-3.0.8, created on 2013-08-23 17:45:39
         compiled from "./templates/assets/change.html" */ ?>
<?php /*%%SmartyHeaderCode:46264772552172f4392fbd4-47182414%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4961d84d53e0100813bde93aa43305b97301956b' => 
    array (
      0 => './templates/assets/change.html',
      1 => 1377249539,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '46264772552172f4392fbd4-47182414',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('header.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('__PUBLIC__')->value;?>
/js/DB.change.js"></script>

<div class="changedb_box">
	<ul class="chagedb_ul">
		<li style="display:none;">
			<div class="ch_ul_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['YourAccountBalance'];?>
：</div>
			<span class="c_y" id="change_money"><?php echo $_smarty_tpl->getVariable('account')->value['money'];?>
</span><?php echo $_smarty_tpl->getVariable('Lang')->value['AccountBalanceUnion'];?>

		</li>
		<li>
			<div class="ch_ul_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['YourIntegralBalance'];?>
：</div>
			<span class="c_y" id="change_db"><?php echo $_smarty_tpl->getVariable('account')->value['db'];?>
</span><?php echo $_smarty_tpl->getVariable('Lang')->value['IntegralBalanceUnion'];?>

		</li>
		<li>
			<div class="ch_ul_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['PayType'];?>
：</div>
			<div class="ch_ul_pay">
				<div class="changedb_payicon">
					<input type="radio" name="paytype" id="alipay_icon" value="alipay" checked />
					<label for="alipay_icon" class="alipay_icon b_r">&nbsp;</label>
				</div>
				<div class="changedb_payicon c_p_l">
					<input type="radio" name="paytype" id="paypal_icon" value="paypal" />
					<label for="paypal_icon" class="paypal_icon">&nbsp;</label>
				</div>
			</div>
		</li>
		<li>
			<div class="ch_ul_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['ChangeMoneyNum'];?>
：</div>
			<input type="text" class="input" name="coin" size="8" value="<?php echo $_smarty_tpl->getVariable('account')->value['coin_num'];?>
" <?php if ($_smarty_tpl->getVariable('account')->value['coin_num']){?>readonly<?php }?> /><?php echo $_smarty_tpl->getVariable('Lang')->value['AccountBalanceUnion'];?>

		</li>
		<li>
			<div class="ch_ul_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['ChangeDBNumber'];?>
：</div>
			<input type="text" class="input" name="db" size="8" value="<?php echo $_smarty_tpl->getVariable('account')->value['db_num'];?>
" <?php if ($_smarty_tpl->getVariable('account')->value['db_num']){?>readonly<?php }?> /><?php echo $_smarty_tpl->getVariable('Lang')->value['IntegralBalanceUnion'];?>

		</li>
		<li class="pay_btn">
			<div class="changedb_btn"><a id="sub_btn" class="btn" href="javascript:void(0);"><?php echo $_smarty_tpl->getVariable('Lang')->value['Buy'];?>
</a></div>
		</li>
	</ul>
</div>

<script type="text/javascript">
<!--
var change = new Tchange();
change.JS_LANG = <?php echo $_smarty_tpl->getVariable('JS_LANG')->value;?>
;
change.jsonData = <?php echo $_smarty_tpl->getVariable('jsonData')->value;?>
;
//页面完全再入后初始化
$(document).ready(function(){
	change.init();
});
//释放
$(window).unload(function(){
	change = null;
});
//-->
</script>

<?php $_template = new Smarty_Internal_Template('footer.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>