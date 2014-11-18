<?php
/**
 * online-statuses manage template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="modal-header">

	<button class="close" type="button"
			tooltip="<?php echo __d('net_commons', 'Close'); ?>"
			ng-click="cancel()">
		<span class="glyphicon glyphicon-remove small"></span>
	</button>

	<ul class="nav nav-pills">
		<li class="active">
			<a href="#nc-online-statuses-display-style-<?php echo $frameId; ?>"
					role="tab" data-toggle="tab" onclick="return false;">
				<?php echo __d('online_statuses', 'Select displaying item'); ?>
			</a>
		</li>
	</ul>
</div>

<div class="modal-body">
	<div class="tab-content">
		<div id="nc-online-statuses-display-style-<?php echo $frameId; ?>"
				class="tab-pane active">

			<?php echo $this->requestAction('/OnlineStatuses/OnlineStatusEdit/view/' . $frameId, array('return')); ?>
		</div>
	</div>
</div>