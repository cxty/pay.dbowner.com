<?php /* Smarty version Smarty-3.0.8, created on 2013-08-24 03:44:09
         compiled from "./templates/index/index.html" */ ?>
<?php /*%%SmartyHeaderCode:14955684245217bb893e3267-45732355%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd5896ff9b68bada854e9212253a28cc640b1c5ce' => 
    array (
      0 => './templates/index/index.html',
      1 => 1377250185,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14955684245217bb893e3267-45732355',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/www/web/pay_dbowner_com/public_html/include/ext/smarty/plugins/modifier.date_format.php';
?><?php $_template = new Smarty_Internal_Template('header.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('__PUBLIC__')->value;?>
/js/DB.authAccount.js" ></script>

<div class="index_box">
	<div class="id_up_box">
		<div class="id_up_left">
			<div class="id_u_l_up">
				<img src="<?php echo $_smarty_tpl->getVariable('ckInfo')->value['ico'];?>
" />
				<div class="id_up_left_title word">
					<span class="font_20"><?php echo $_smarty_tpl->getVariable('greetings')->value;?>
</span>&nbsp;&nbsp;
					<?php echo $_smarty_tpl->getVariable('ckInfo')->value['uName'];?>

				</div>
			</div>
			<div class="id_u_l_down">
				<div class="id_u_l_d_exp r_n"><a href="<?php echo $_smarty_tpl->getVariable('platform_auth')->value;?>
/main/index-u_safe"><?php if ($_smarty_tpl->getVariable('auth')->value['realName']==1){?><?php echo $_smarty_tpl->getVariable('Lang')->value['CheckRealName'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('Lang')->value['NotCheckRealName'];?>
<?php }?></a></div>
				<div class="id_u_l_d_exp c_m"><a href="<?php echo $_smarty_tpl->getVariable('platform_auth')->value;?>
/main/index-u_safe"><?php if ($_smarty_tpl->getVariable('auth')->value['safeEmail']){?><?php echo $_smarty_tpl->getVariable('auth')->value['safeEmail'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('Lang')->value['CheckMail'];?>
<?php }?></a></div>
				<div class="id_u_l_d_exp c_p" style="display:none;"><a href="<?php echo $_smarty_tpl->getVariable('platform_auth')->value;?>
/main/index-u_safe"><?php if ($_smarty_tpl->getVariable('auth')->value['safePhone']){?><?php echo $_smarty_tpl->getVariable('auth')->value['safePhone'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('Lang')->value['CheckPhone'];?>
<?php }?></a></div>
				<div class="id_u_l_d_exp c_p"><a href="javascript:alert('<?php echo $_smarty_tpl->getVariable('Lang')->value['AuthPhoneNotSupport'];?>
')"><?php if ($_smarty_tpl->getVariable('auth')->value['safePhone']){?><?php echo $_smarty_tpl->getVariable('auth')->value['safePhone'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('Lang')->value['CheckPhone'];?>
<?php }?></a></div>
			</div>
		</div>
		<div class="v_line_200_l"></div>
		<div class="id_up_right">
			<div class="id_mi_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['IntegralBalance'];?>
</div>
			<div class="id_mi_balance"><?php echo $_smarty_tpl->getVariable('account')->value['db'];?>
</div>
			<div class="id_mi_btn">
				<a class="btn_b" href="/assets/change"><?php echo $_smarty_tpl->getVariable('Lang')->value['DBChange'];?>
</a>
				<a class="btnb_b mg_left_30" href="/assets/discounting"><?php echo $_smarty_tpl->getVariable('Lang')->value['DBDiscounting'];?>
</a>
			</div>
		</div>
	</div>
	<div class="id_middle_box">
		<div class="id_m_show">
			<div class="id_m_s_cont"><?php echo $_smarty_tpl->getVariable('Lang')->value['ServerType'];?>
：<?php echo $_smarty_tpl->getVariable('Lang')->value['HighVisitInterface'];?>
</div>
			<div class="id_m_s_cont"><?php echo $_smarty_tpl->getVariable('Lang')->value['FeeStandard'];?>
：<?php echo $_smarty_tpl->getVariable('jData')->value['fee'];?>
<?php echo $_smarty_tpl->getVariable('Lang')->value['IntegralBalanceUnion'];?>
</div>
			<div class="id_m_s_btn"><a class="btn_b" href="/assets/change-interface"><?php echo $_smarty_tpl->getVariable('Lang')->value['Buy'];?>
</a></div>
		</div>
		<div class="v_line_150_l"></div>
		<div class="id_m_show">
			<div class="id_m_s_cont"><?php echo $_smarty_tpl->getVariable('Lang')->value['ServerType'];?>
：<?php echo $_smarty_tpl->getVariable('Lang')->value['AdvertiseFee'];?>
</div>
			<div class="id_m_s_cont"><?php echo $_smarty_tpl->getVariable('Lang')->value['FeeStandard'];?>
：<?php echo $_smarty_tpl->getVariable('jData')->value['fee'];?>
<?php echo $_smarty_tpl->getVariable('Lang')->value['IntegralBalanceUnion'];?>
</div>
			<div class="id_m_s_btn"><a class="btn_b" href="/assets/change-ads"><?php echo $_smarty_tpl->getVariable('Lang')->value['Buy'];?>
</a></div>
		</div>
		<div class="v_line_150_l"></div>
		<div class="id_m_show">
			<div class="id_m_s_cont"><?php echo $_smarty_tpl->getVariable('Lang')->value['ServerType'];?>
：<?php echo $_smarty_tpl->getVariable('Lang')->value['PushFee'];?>
</div>
			<div class="id_m_s_cont"><?php echo $_smarty_tpl->getVariable('Lang')->value['FeeStandard'];?>
：<?php echo $_smarty_tpl->getVariable('jData')->value['fee'];?>
<?php echo $_smarty_tpl->getVariable('Lang')->value['IntegralBalanceUnion'];?>
</div>
			<div class="id_m_s_btn"><a class="btn_b" href="/assets/change-push"><?php echo $_smarty_tpl->getVariable('Lang')->value['Buy'];?>
</a></div>
		</div>
	</div>
	<div class="id_down_box">
		<div class="id_td_left">
			<div class="id_td_title_box">
				<div class="id_td_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['CommonProblem'];?>
</div>
				<ul class="id_td_ul">
					<li><a class="cb" href="/trade/db"></a></li>
				</ul>
			</div>
			<?php if ($_smarty_tpl->getVariable('qlist')->value){?>
				<ul class="id_ul_list_row" >
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('qlist')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<li class="l_w_300 t_i_8"><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['href'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</a></li>			
				<?php }} ?>
				</ul>
			<?php }?>
		</div>
		<div class="id_td_right">
			<div class="id_td_title_box">
				<div class="id_td_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['RecentDBTrade'];?>
</div>
				<ul class="id_td_ul">
					<li><a class="cb" href="/trade/db"><?php echo $_smarty_tpl->getVariable('Lang')->value['DetailTradeDB'];?>
</a></li>
				</ul>
			</div>
			<?php if ($_smarty_tpl->getVariable('listCoin')->value){?>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listCoin')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<ul class="id_ul_tb_row <?php if ((1 & $_smarty_tpl->tpl_vars['key']->value)){?>id_ul_tb_select<?php }?>" >	
						<li class="l_w_130 t_i_8"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['AppendTime'],"%Y-%m-%d %H:%M");?>
</li>	
						<li class="l_w_400"><?php echo $_smarty_tpl->tpl_vars['item']->value['dState'];?>
</li>
						<li class="l_w_80"><span class="<?php if ($_smarty_tpl->tpl_vars['item']->value['dType']==1||$_smarty_tpl->tpl_vars['item']->value['dType']==3){?>c_y<?php }else{ ?>c_b<?php }?>"><?php if ($_smarty_tpl->tpl_vars['item']->value['dType']==2||$_smarty_tpl->tpl_vars['item']->value['dType']==4){?>-<?php }?><?php echo $_smarty_tpl->tpl_vars['item']->value['CoinDB'];?>
</span></li>
					</ul>
				<?php }} ?>
			<?php }?>
		</div>
	</div>
</div>

<div class="index_box" style="display:none;">
	<div class="id_left_box">
		<div class="id_l_up_box">
			<div class="id_up_left_up">
				<img src="<?php echo $_smarty_tpl->getVariable('ckInfo')->value['ico'];?>
" />
				<div class="id_up_left_title word"><span class="font_30"><?php echo $_smarty_tpl->getVariable('greetings')->value;?>
</span>&nbsp;&nbsp;<?php echo $_smarty_tpl->getVariable('ckInfo')->value['uName'];?>
</div>
				<div class="id_up_left_exp r_n"><a href="<?php echo $_smarty_tpl->getVariable('platform_auth')->value;?>
/main/index-u_safe"><?php if ($_smarty_tpl->getVariable('auth')->value['realName']==1){?><?php echo $_smarty_tpl->getVariable('Lang')->value['CheckRealName'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('Lang')->value['NotCheckRealName'];?>
<?php }?></a></div>
			</div>
			<div class="id_up_left_down">			
				
			</div>
		</div>
		<div class="v_line_400_l"></div>
		<div class="id_l_down_box">
			<div class="id_mi_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['IntegralBalance'];?>
</div>
			<div class="id_mi_balance"><?php echo $_smarty_tpl->getVariable('account')->value['db'];?>
</div>
			<div class="id_mi_btn">
				<a class="btn_b" href="/assets/change"><?php echo $_smarty_tpl->getVariable('Lang')->value['DBChange'];?>
</a>
				<a class="btnb_b mg_left_30" href="/assets/discounting"><?php echo $_smarty_tpl->getVariable('Lang')->value['DBDiscounting'];?>
</a>
			</div>
		</div>
	</div>
	<div class="id_right_box">
		<div class="id_td_right">
			<div class="id_td_title_box">
				<div class="id_td_title"><?php echo $_smarty_tpl->getVariable('Lang')->value['RecentDBTrade'];?>
</div>
				<ul class="id_td_ul">
					<li><a class="cb" href="/trade/db"><?php echo $_smarty_tpl->getVariable('Lang')->value['DetailTradeDB'];?>
</a></li>
				</ul>
			</div>
			<?php if ($_smarty_tpl->getVariable('listCoin')->value){?>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listCoin')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<ul class="id_ul_tb_row <?php if ((1 & $_smarty_tpl->tpl_vars['key']->value)){?>id_ul_tb_select<?php }?>" >	
						<li class="l_w_130 t_i_8"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['AppendTime'],"%Y-%m-%d %H:%M");?>
</li>	
						<li class="l_w_300"><?php echo $_smarty_tpl->tpl_vars['item']->value['dState'];?>
</li>
						<li class="l_w_80"><span class="<?php if ($_smarty_tpl->tpl_vars['item']->value['dType']==1||$_smarty_tpl->tpl_vars['item']->value['dType']==3){?>c_y<?php }else{ ?>c_b<?php }?>"><?php if ($_smarty_tpl->tpl_vars['item']->value['dType']==2||$_smarty_tpl->tpl_vars['item']->value['dType']==4){?>-<?php }?><?php echo $_smarty_tpl->tpl_vars['item']->value['CoinDB'];?>
</span></li>
					</ul>
				<?php }} ?>
			<?php }?>
		</div>
	</div>
</div>

<script type="text/javascript">
<!--
var authAccount = new TauthAccount();
authAccount.JS_LANG = <?php echo $_smarty_tpl->getVariable('JS_LANG')->value;?>
;
//页面完全再入后初始化
$(document).ready(function(){
	authAccount.init();
});
//释放
$(window).unload(function(){
	authAccount = null;
});
//-->
</script>

<?php $_template = new Smarty_Internal_Template('footer.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>