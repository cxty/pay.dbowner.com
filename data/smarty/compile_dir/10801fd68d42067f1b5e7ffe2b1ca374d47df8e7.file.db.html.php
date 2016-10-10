<?php /* Smarty version Smarty-3.0.8, created on 2013-08-23 17:25:20
         compiled from "./templates/trade/db.html" */ ?>
<?php /*%%SmartyHeaderCode:131116816752172a80ccd022-01487674%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '10801fd68d42067f1b5e7ffe2b1ca374d47df8e7' => 
    array (
      0 => './templates/trade/db.html',
      1 => 1376363183,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '131116816752172a80ccd022-01487674',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/www/web/pay_dbowner_com/public_html/include/ext/smarty/plugins/modifier.date_format.php';
?><?php $_template = new Smarty_Internal_Template('header.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

<?php $_template = new Smarty_Internal_Template('datepicker.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('__PUBLIC__')->value;?>
/js/DB.navinit.js"></script>

<div class="trade_box">
	<?php $_template = new Smarty_Internal_Template("trade/nav.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
	<div class="trade_right">
		<div class="trade_content">
			<div class="trade_cont_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['DetailTradeDB'];?>
</div>
			<form id="myform" method="get" action="/trade/db">
			<div class="trade_cont_search">
				<?php echo $_smarty_tpl->getVariable('Lang')->value['StartTime'];?>
：<input type="text" name="startTime" id="startTime" value="<?php echo $_GET['startTime'];?>
" size="10"/>&nbsp;&nbsp;
				<?php echo $_smarty_tpl->getVariable('Lang')->value['EndTime'];?>
：<input type="text" name="endTime" id="endTime" size="10" value="<?php echo $_GET['endTime'];?>
" />&nbsp;&nbsp;
				<?php echo $_smarty_tpl->getVariable('Lang')->value['TradeType'];?>
：<?php echo $_smarty_tpl->getVariable('Lang')->value['TradeIncome'];?>
<input type="radio" name="tradeType" value="1" <?php if ($_GET['tradeType']==1){?>checked<?php }?> />
							       <?php echo $_smarty_tpl->getVariable('Lang')->value['TradePay'];?>
<input type="radio" name="tradeType" value="2" <?php if ($_GET['tradeType']==2){?>checked<?php }?> />&nbsp;&nbsp;
				<a id="sub_btn" class="btn_small" href="javascript:void(0);"><?php echo $_smarty_tpl->getVariable('Lang')->value['Search'];?>
</a>
			</div>
			</form>
			<ul class="trade_cont_header_ul">
				<li class="l_w_250 t_i_8"><?php echo $_smarty_tpl->getVariable('Lang')->value['SerialCode'];?>
</li>
				<li class="l_w_220"><?php echo $_smarty_tpl->getVariable('Lang')->value['State'];?>
</li>
				<li class="l_w_100 t_i_8"><?php echo $_smarty_tpl->getVariable('Lang')->value['Amount'];?>
<?php echo $_smarty_tpl->getVariable('Lang')->value['DB'];?>
</li>
				<li class="l_w_130"><?php echo $_smarty_tpl->getVariable('Lang')->value['Time'];?>
</li>
			</ul>
			<?php if ($_smarty_tpl->getVariable('listInfo')->value){?>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listInfo')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<ul class="trade_cont_ul <?php if ((1 & $_smarty_tpl->tpl_vars['key']->value)){?>id_ul_tb_select<?php }?>">
						<li class="l_w_250 t_i_8"><?php echo $_smarty_tpl->tpl_vars['item']->value['dSerialCode'];?>
</li>
						<li class="l_w_220"><?php echo $_smarty_tpl->tpl_vars['item']->value['dState'];?>
</li>
						<li class="l_w_100 t_i_8">			
							<span class="<?php if ($_smarty_tpl->tpl_vars['item']->value['dType']==1||$_smarty_tpl->tpl_vars['item']->value['dType']==3){?>c_y<?php }else{ ?>c_b<?php }?>"><?php if ($_smarty_tpl->tpl_vars['item']->value['dType']==2||$_smarty_tpl->tpl_vars['item']->value['dType']==4){?>-<?php }?><?php echo $_smarty_tpl->tpl_vars['item']->value['CoinDB'];?>
</span>
						</li>
						<li class="l_w_130"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['AppendTime'],"%Y-%m-%d %H:%M");?>
</li>
					</ul>
				<?php }} ?>
			<?php }?>
			<div class="showpage"><?php echo $_smarty_tpl->getVariable('showpage')->value;?>
</div>
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
//-->
</script>

<?php $_template = new Smarty_Internal_Template('footer.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>