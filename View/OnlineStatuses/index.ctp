<?php echo $this->Html->script('/online_statuses/js/online_statuses.js'); ?>

<div id="nc-online-statuses-container-<?php echo (int)$frameId; ?>"
	 ng-controller="OnlineStatuses"
	 ng-init="initialize(<?php echo (int)$frameId; ?>,
	 							<?php echo h(json_encode($online_frame_setting)); ?>)">

	<?php if (Page::isSetting()) : ?>
		<p class="text-right">
			<button class="btn btn-primary"
					tooltip="<?php echo __d('net_commons', 'Manage'); ?>"
					ng-click="showManage()">

				<span class="glyphicon glyphicon-cog"> </span>
			</button>
		</p>
	<?php endif; ?>

	<div id="nc-online-statuses-container-<?php echo (int)$frameId; ?>" class="row">
		<ul class="nav nav-pills nav-stacked">
			<li class="col-sm-12" ng-show="online_status.OnlineFrameSetting.display_visitor">オンラインユーザ <span class="badge pull-right">42</span></li>
			<li class="col-sm-12" ng-show="online_status.OnlineFrameSetting.display_login_user">ログインユーザ <span class="badge pull-right">42</span></li>
			<li class="col-sm-12" ng-show="online_status.OnlineFrameSetting.display_registration_user">登録ユーザ <span class="badge pull-right">42</span></li>
		</ul>
	</div>
</div>