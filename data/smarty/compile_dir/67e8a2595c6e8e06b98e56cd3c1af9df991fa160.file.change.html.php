<?php /* Smarty version Smarty-3.0.8, created on 2014-11-07 15:49:07
         compiled from "./templates/mobile/change.html" */ ?>
<?php /*%%SmartyHeaderCode:155753194545c7973758335-88460149%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '67e8a2595c6e8e06b98e56cd3c1af9df991fa160' => 
    array (
      0 => './templates/mobile/change.html',
      1 => 1415346544,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '155753194545c7973758335-88460149',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('header_wap.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
 
<script type="text/javascript" language="javascript" src="<?php echo $_smarty_tpl->getVariable('__PUBLIC__')->value;?>
/js/DB.mochange.js" ></script>

<div class="ct_exp" style="display:none;"><?php echo $_smarty_tpl->getVariable('Lang')->value['YourIntegralBalance'];?>
：<span class="c_y" id="change_db"><?php echo $_smarty_tpl->getVariable('account')->value['db'];?>
</span><?php echo $_smarty_tpl->getVariable('Lang')->value['IntegralBalanceUnion'];?>
</div>
<ul class="ct_box m_t_20">
	<li style="display:none;">
		<div class="ct_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['YourAccountBalance'];?>
：</div>
		<div class="ct_cont"><span class="c_y" id="change_money"><?php echo $_smarty_tpl->getVariable('account')->value['money'];?>
</span><?php echo $_smarty_tpl->getVariable('Lang')->value['AccountBalanceUnion'];?>
</div>
	</li>
	<li class="ct_line_bd">
		<div class="ct_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['YourIntegralBalance'];?>
：</div>
		<div class="ct_cont"><span class="c_y" id="change_db"><?php echo $_smarty_tpl->getVariable('account')->value['db'];?>
</span><?php echo $_smarty_tpl->getVariable('Lang')->value['IntegralBalanceUnion'];?>
</div>
	</li>
	<li>
		<div class="ct_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['ChangeMoneyNum'];?>
：</div>
		<div class="ct_cont"><input type="text" class="input" name="coin" size="14" value="<?php echo $_smarty_tpl->getVariable('account')->value['coin_num'];?>
" <?php if ($_smarty_tpl->getVariable('account')->value['coin_num']){?>readonly<?php }?> /><?php echo $_smarty_tpl->getVariable('Lang')->value['AccountBalanceUnion'];?>
</div>
	</li>
	<li>
		<div class="ct_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['ChangeDBNumber'];?>
：</div>
		<div class="ct_cont"><input type="text" class="input" name="db" size="14" value="<?php echo $_smarty_tpl->getVariable('account')->value['db_num'];?>
" <?php if ($_smarty_tpl->getVariable('account')->value['db_num']){?>readonly<?php }?> /><?php echo $_smarty_tpl->getVariable('Lang')->value['IntegralBalanceUnion'];?>
</div>
	</li>
</ul>
	
<div class="ct_exp"><?php echo $_smarty_tpl->getVariable('Lang')->value['ChoosePayWay'];?>
</div>	
<ul class="ct_box ct_ti" id="payway">
	<li class="ct_line_bd" vtype="alipay">
		<?php echo $_smarty_tpl->getVariable('Lang')->value['WayAlipay'];?>
<span class="ct_go">></span>
	</li>
	<li vtype="paypal">
		<?php echo $_smarty_tpl->getVariable('Lang')->value['WayPaypal'];?>
<span class="ct_go">></span>
	</li>
</ul>

<script type="text/javascript">
var JS_LANG = <?php echo $_smarty_tpl->getVariable('JS_LANG')->value;?>
;
var jsonData = <?php echo $_smarty_tpl->getVariable('jsonData')->value;?>
;
</script>

<?php $_template = new Smarty_Internal_Template('footer_wap.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>