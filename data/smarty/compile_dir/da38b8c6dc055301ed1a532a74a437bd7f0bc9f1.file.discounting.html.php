<?php /* Smarty version Smarty-3.0.8, created on 2013-09-05 15:42:40
         compiled from "./templates/assets/discounting.html" */ ?>
<?php /*%%SmartyHeaderCode:1898156429522835f08da500-36909949%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'da38b8c6dc055301ed1a532a74a437bd7f0bc9f1' => 
    array (
      0 => './templates/assets/discounting.html',
      1 => 1377249540,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1898156429522835f08da500-36909949',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('header.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('__PUBLIC__')->value;?>
/js/DB.discount.js"></script>

<div class="changedb_box">
	<ul class="chagedb_ul">
		<li class="rmd_msg">
			<?php echo $_smarty_tpl->getVariable('Lang')->value['WithrawRemind'];?>

		</li>
		<li>
			<div class="ch_ul_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['YourIntegralBalance'];?>
：</div>
			<span class="c_y" id="change_db"><?php echo $_smarty_tpl->getVariable('account')->value['db'];?>
</span><?php echo $_smarty_tpl->getVariable('Lang')->value['IntegralBalanceUnion'];?>

		</li>
		<li style="display:none;">
			<div class="ch_ul_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['YourAccountBalance'];?>
：</div>
			<span class="c_y" id="change_money"><?php echo $_smarty_tpl->getVariable('account')->value['money'];?>
</span><?php echo $_smarty_tpl->getVariable('Lang')->value['AccountBalanceUnion'];?>

		</li>
		<li style="display:none;">
			<div class="ch_ul_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['TakeMoneyAccount'];?>
：</div>
			<div class="ch_ul_pay">
				<div class="changedb_payicon">
					<input type="radio" name="paytype" id="alipay_icon" value="alipay" checked />
					<label for="alipay_icon" class="alipay_icon b_r">&nbsp;</label>
				</div>
			</div>
		</li>
		<li>
			<div class="ch_ul_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['DBToMoneyRate'];?>
：</div>1/<?php echo $_smarty_tpl->getVariable('account')->value['rate'];?>

		</li>
		<li>
			<div class="ch_ul_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['ChangeDBNum'];?>
：</div>
			<input type="text" class="input" name="coin" size="8" /><?php echo $_smarty_tpl->getVariable('Lang')->value['IntegralBalanceUnion'];?>

		</li>
		<li class="pay_btn">
			<div class="changedb_btn"><a id="sub_btn" class="btn" href="javascript:void(0);"><?php echo $_smarty_tpl->getVariable('Lang')->value['ChangeToMoney'];?>
</a></div>
		</li>
	</ul>
</div>

<script type="text/javascript">
<!--
var discount = new Tdiscount();
discount.JS_LANG = <?php echo $_smarty_tpl->getVariable('JS_LANG')->value;?>
;
discount.jsonData = <?php echo $_smarty_tpl->getVariable('jsonData')->value;?>
;
//页面完全再入后初始化
$(document).ready(function(){
	discount.init();
});
//释放
$(window).unload(function(){
	discount = null;
});
//-->
</script>

<?php $_template = new Smarty_Internal_Template('footer.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>