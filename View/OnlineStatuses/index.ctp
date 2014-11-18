<?php echo $this->Html->script('/online_statuses/js/online_statuses.js'); ?>

<div id="nc-online-statuses-container-<?php echo (int)$frameId; ?>"
	 ng-controller="OnlineStatuses"
	 ng-init="initialize(<?php echo (int)$frameId; ?>,
	 							<?php echo h(json_encode($onlineFrameSetting)); ?>)">

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
			<li class="col-sm-12" ng-show="online_status.OnlineFrameSetting.display_visitor">
				<?php echo __d('online_statuses', 'Online Users'); ?> <span class="badge pull-right">42</span>
			</li>
			<li class="col-sm-12" ng-show="online_status.OnlineFrameSetting.display_login_user">
				<?php echo __d('online_statuses', 'Login Users'); ?> <span class="badge pull-right">42</span>
			</li>
			<li class="col-sm-12" ng-show="online_status.OnlineFrameSetting.display_registration_user">
				<?php echo __d('online_statuses', 'Total Members'); ?> <span class="badge pull-right">42</span>
			</li>
		</ul>
	</div>
</div>