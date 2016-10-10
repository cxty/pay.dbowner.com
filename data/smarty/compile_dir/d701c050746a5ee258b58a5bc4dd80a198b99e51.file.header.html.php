<?php /* Smarty version Smarty-3.0.8, created on 2013-09-05 10:52:59
         compiled from "./templates/header.html" */ ?>
<?php /*%%SmartyHeaderCode:7750581925227f20b19dbc7-52987162%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd701c050746a5ee258b58a5bc4dd80a198b99e51' => 
    array (
      0 => './templates/header.html',
      1 => 1378349291,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7750581925227f20b19dbc7-52987162',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->getVariable('title')->value;?>
</title>
<?php $_template = new Smarty_Internal_Template('link.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

</head>
<script language="javascript" type="text/javascript">
var Common = new TCommon();
//页面完全再入后初始化
$(document).ready(function(){
	Common.init();
});
//释放
$(window).unload(function(){
	Common = null;
});
var nav = new Tnav();
nav.JS_LANG = <?php echo $_smarty_tpl->getVariable('JS_LANG')->value;?>
;
nav.navData = <?php echo $_smarty_tpl->getVariable('navData')->value;?>
;
//页面完全再入后初始化
$(document).ready(function(){
	nav.init();
});
//释放
$(window).unload(function(){
	nav = null;
});
</script>
<body>
<div class="header">
	<div id="top" >
		<div class="top_box">
			<div class="top_left">		
			</div>
			<div class="top_right">
				<?php if ($_smarty_tpl->getVariable('ckInfo')->value['uName']){?>					
					<div id="login_info">
						<div id="login_name"><?php echo $_smarty_tpl->getVariable('ckInfo')->value['uName'];?>
</div>
						<div id="loginOut" style="display:none">
							<div class="login_left"><img src="<?php echo $_smarty_tpl->getVariable('ckInfo')->value['ico'];?>
" /></div>
							<ul>
								<li><a href="/"><?php echo $_smarty_tpl->getVariable('Lang')->value['HBackIndex'];?>
</a></li>
								<li><a href="<?php echo $_smarty_tpl->getVariable('ckInfo')->value['account'];?>
" target="_black"><?php echo $_smarty_tpl->getVariable('Lang')->value['PensonalPage'];?>
</a></li>								
								<li><a href="javascript:nav.loginOut()"><?php echo $_smarty_tpl->getVariable('Lang')->value['LoginOut'];?>
</a></li>
							</ul>
						</div>
					</div>
				<?php }else{ ?>
					<div class="top_login"><a href="<?php echo $_smarty_tpl->getVariable('loginUrl')->value;?>
"><?php echo $_smarty_tpl->getVariable('Lang')->value['Login'];?>
</a></div>
				<?php }?>		
				<div class="top_login"><span id="lang_box"></span></div>		
			</div>	
		</div>		
	</div>
	<div id="logo">
		<div class="logo_box">
			<div class="logo_box_href">
				<a href="/"><img src="<?php echo $_smarty_tpl->getVariable('__PUBLIC__')->value;?>
/images/pay_ico.png" /></a>
			</div>
		</div>	
	</div>
	<div id="top_nav">
		<div id="nav_box" class="nav_box" >
			<?php if ($_smarty_tpl->getVariable('hnav')->value){?>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('hnav')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<div class="nav_row <?php if ($_smarty_tpl->tpl_vars['item']->value['ename']!='index'){?>mg_left_10<?php }?>"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</div>
				<?php }} ?>
			<?php }?>
		</div>
	</div>
</div>
<div class="containers_box">