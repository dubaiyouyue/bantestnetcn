<!--<?php
$gz_foot_nav = methtml_footnav();//底部导航标签（次导航）
$gz_foot_txt = metlabel_foot();//底部信息标签
echo <<<EOT
-->
<footer class="tem_footer">
	<section class="tem_inner">
		<div class="tem_footer_nav">{$gz_foot_nav}</div>
		<div class="tem_footer_text">
		{$gz_foot_txt}
		</div>
	</section>
</footer>
<div class="powered_by_metinfo">Powered&nbsp;by&nbsp;<a href="http://www.resonance.com.cn" target="_blank" title="{$lang_Info1}">Resonance&nbsp;{$metcms_v}</a> &copy;2012-{$m_now_year}&nbsp;<a href="http://www.resonance.com.cn" target="_blank" title="{$lang_Info3}">www.resonance.com.cn</a></div>
<script src="{$navurl}public/ui/v1/js/sea.js" type="text/javascript"></script>
</body>
</html>
<!--
EOT;
?>-->