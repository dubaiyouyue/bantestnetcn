<!--<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.resonance.com.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

require $this->template('tem/head');
echo <<<EOT
-->
<div class="appbox_left">
<div class="appbox_left_box">
	<section class="hotapplist hotlist">
		<h3>{$_M['word']['popular_application']}</h3>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="media">
						<div class="media-left">
							<a href="#">
								<img class="media-object" src="" width="80">
							</a>
						</div>
						<div class="media-body">
							<span class="label label-success"></span>
							<a href="#">
								<h4 class="media-heading"><span class="text-danger"></span></h4>
								<p></p>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="media">
						<div class="media-left">
							<a href="#">
								<img class="media-object" src="" width="80">
							</a>
						</div>
						<div class="media-body">
							<span class="label label-success"></span>
							<a href="#">
								<h4 class="media-heading"><span class="text-danger"></span></h4>
								<p></p>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="media">
						<div class="media-left">
							<a href="#">
								<img class="media-object" src="" width="80">
							</a>
						</div>
						<div class="media-body">
							<span class="label label-success"></span>
							<a href="#">
								<h4 class="media-heading"><span class="text-danger"></span></h4>
								<p></p>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="media">
						<div class="media-left">
							<a href="#">
								<img class="media-object" src="" width="80">
							</a>
						</div>
						<div class="media-body">
							<span class="label label-success"></span>
							<a href="#">
								<h4 class="media-heading"><span class="text-danger"></span></h4>
								<p></p>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="media">
						<div class="media-left">
							<a href="#">
								<img class="media-object" src="" width="80">
							</a>
						</div>
						<div class="media-body">
							<span class="label label-success"></span>
							<a href="#">
								<h4 class="media-heading"><span class="text-danger"></span></h4>
								<p></p>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="media">
						<div class="media-left">
							<a href="#">
								<img class="media-object" src="" width="80">
							</a>
						</div>
						<div class="media-body">
							<span class="label label-success"></span>
							<a href="#">
								<h4 class="media-heading"><span class="text-danger"></span></h4>
								<p></p>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="media">
						<div class="media-left">
							<a href="#">
								<img class="media-object" src="" width="80">
							</a>
						</div>
						<div class="media-body">
							<span class="label label-success"></span>
							<a href="#">
								<h4 class="media-heading"><span class="text-danger"></span></h4>
								<p></p>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="media">
						<div class="media-left">
							<a href="#">
								<img class="media-object" src="" width="80">
							</a>
						</div>
						<div class="media-body">
							<span class="label label-success"></span>
							<a href="#">
								<h4 class="media-heading"><span class="text-danger"></span></h4>
								<p></p>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="media">
						<div class="media-left">
							<a href="{$_M[url][adminurl]}anyid=65&n=appstore&c=appstore&a=doservice">
								<img class="media-object" src="http://app.resonance.com.cn/file/serviceicon/tempservice.png" width="80">
							</a>
						</div>
						<div class="media-body">
							<span class="label label-info">为你定制</span>
							<a href="{$_M[url][adminurl]}anyid=65&n=appstore&c=appstore&a=doservice">
								<h4 class="media-heading">模板制作/修改/二次开发<span class="text-danger"></span></h4>
								<p>模板制作与修改/二次开发 ，精选优秀服务商为您提供个性化服务。</p>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="hotmblist hotlist">
		<h3>{$_M['word']['popular_template']}</h3>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-6 hotmblist-md">
					<a href="#">
						<div class="hotmblist-md-img"></div>
						<p class="text-danger price"></p>
						<p class="eye"></p>
					</a>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6 hotmblist-md">
					<a href="#">
						<div class="hotmblist-md-img"></div>
						<p class="text-danger price"></p>
						<p class="eye"></p>
					</a>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6 hotmblist-md">
					<a href="#">
						<div class="hotmblist-md-img"></div>
						<p class="text-danger price"></p>
						<p class="eye"></p>
					</a>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6 hotmblist-md">
					<a href="#">
						<div class="hotmblist-md-img"></div>
						<p class="text-danger price"></p>
						<p class="eye"></p>
					</a>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6 hotmblist-md">
					<a href="#">
						<div class="hotmblist-md-img"></div>
						<p class="text-danger price"></p>
						<p class="eye"></p>
					</a>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6 hotmblist-md">
					<a href="#">
						<div class="hotmblist-md-img"></div>
						<p class="text-danger price"></p>
						<p class="eye"></p>
					</a>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6 hotmblist-md">
					<a href="#">
						<div class="hotmblist-md-img"></div>
						<p class="text-danger price"></p>
						<p class="eye"></p>
					</a>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6 hotmblist-md">
					<a href="#">
						<div class="hotmblist-md-img"></div>
						<p class="text-danger price"></p>
						<p class="eye"></p>
					</a>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6 hotmblist-md">
					<a href="#">
						<div class="hotmblist-md-img"></div>
						<p class="text-danger price"></p>
						<p class="eye"></p>
					</a>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6 hotmblist-md">
					<a href="#">
						<div class="hotmblist-md-img"></div>
						<p class="text-danger price"></p>
						<p class="eye"></p>
					</a>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6 hotmblist-md">
					<a href="#">
						<div class="hotmblist-md-img"></div>
						<p class="text-danger price"></p>
						<p class="eye"></p>
					</a>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6 hotmblist-md">
					<a href="#">
						<div class="hotmblist-md-img"></div>
						<p class="text-danger price"></p>
						<p class="eye"></p>
					</a>
				</div>
			</div>
		</div>
	</section>
</div>
</div>
<!--
EOT;
require $this->template('ui/foot');
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.resonance.com.cn). All rights reserved.
?>