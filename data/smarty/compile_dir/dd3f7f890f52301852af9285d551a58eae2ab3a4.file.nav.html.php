<?php /* Smarty version Smarty-3.0.8, created on 2013-08-23 17:25:20
         compiled from "./templates/trade/nav.html" */ ?>
<?php /*%%SmartyHeaderCode:210470324452172a80e49e22-13057494%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dd3f7f890f52301852af9285d551a58eae2ab3a4' => 
    array (
      0 => './templates/trade/nav.html',
      1 => 1376363184,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '210470324452172a80e49e22-13057494',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('__PUBLIC__')->value;?>
/js/DB.navtrade.js"></script>

<div class="trade_left">
	<div class="td_left_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['HTradeManage'];?>
</div>
	<ul class="td_ul_left">
		<?php if ($_smarty_tpl->getVariable('tradeNav')->value){?>
			<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('tradeNav')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
				<li class="<?php if ($_smarty_tpl->tpl_vars['item']->value['view']==$_GET['_action']){?>td_ul_select<?php }?>"><b class="td_left_c">&nbsp;</b><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</li>
			<?php }} ?>
		<?php }?>
	</ul>
</div>

<script type="text/javascript">
<!--
var navtrade = new Tnavtrade();
navtrade.JS_LANG = <?php echo $_smarty_tpl->getVariable('JS_LANG')->value;?>
;
navtrade.jsonData = <?php echo $_smarty_tpl->getVariable('jsonData')->value;?>
;
//页面完全再入后初始化
$(document).ready(function(){
	navtrade.init();
});
//释放
$(window).unload(function(){
	navtrade = null;
});
//-->
</script>