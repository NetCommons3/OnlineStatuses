<?php
/**
 * OnlineFrameSetting Model
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');

/**
 * OnlineFrameSetting Model
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package app.Plugin.OnlineStatuses.Model
 */
class OnlineFrameSetting extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
	);

/**
 * get OnlineFrameSetting
 *
 * @return array
 */
	public function getOnlineFrameSetting() {
		$conditions = array(
		);

		$onlineFrameSetting = $this->find('first', array(
				'conditions' => $conditions,
			)
		);

		if (! $onlineFrameSetting) {
			$onlineFrameSetting = $this->create();
			$onlineFrameSetting['OnlineFrameSetting']['display_visitor'] = '0';
			$onlineFrameSetting['OnlineFrameSetting']['display_login_user'] = '0';
			$onlineFrameSetting['OnlineFrameSetting']['display_registration_user'] = '0';
			$onlineFrameSetting['OnlineFrameSetting']['frame_key'] = '';
			$onlineFrameSetting['OnlineFrameSetting']['id'] = '0';
		}
		return $onlineFrameSetting;
	}

/**
 * save OnlineFrameSetting
 *
 * @param array $postData received post data
 * @return bool true success, false error
 * @throws ForbiddenException
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
	public function saveOnlineFrameSetting($postData) {
		$models = array(
			'Frame' => 'Frames.Frame',
			'Block' => 'Blocks.Block',
		);
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class);
			$this->$model->setDataSource('master');
		}

		//frame関連のセット
		$frame = $this->Frame->findById($postData['Frame']['id']);

		if (! $frame) {
			return false;
		}
		if (! isset($frame['Frame']['block_id']) ||
			$frame['Frame']['block_id'] === '0') {
			//テーブルのkey生成
			$postData['OnlineFrameSetting']['frame_key'] = hash('sha256', 'online_frame_setting_' . microtime());
		}

		//DBへの登録
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {
			$blockId = $this->__saveBlock($frame);

			//OnlineFrameSettingsテーブル登録
			$onlineFrameSetting['OnlineFrameSetting'] = $postData['OnlineFrameSetting'];
			$onlineFrameSetting['OnlineFrameSetting']['block_id'] = $blockId;
			$onlineFrameSetting['OnlineFrameSetting']['created_user'] = CakeSession::read('Auth.User.id');

			// チェックボックスseve暫定対応 SuppressWarnings適用箇所
			$onlineFrameSetting['OnlineFrameSetting']['display_visitor'] = $onlineFrameSetting['OnlineFrameSetting']['display_visitor'] == "false" ? 0 : 1;
			$onlineFrameSetting['OnlineFrameSetting']['display_login_user'] = $onlineFrameSetting['OnlineFrameSetting']['display_login_user'] == "false" ? 0 : 1;
			$onlineFrameSetting['OnlineFrameSetting']['display_registration_user'] = $onlineFrameSetting['OnlineFrameSetting']['display_registration_user'] == "false" ? 0 : 1;

			$onlineFrameSetting = $this->save($onlineFrameSetting);
			if (! $onlineFrameSetting) {
				throw new ForbiddenException(serialize($this->validationErrors));
			}
			$dataSource->commit();
			return $onlineFrameSetting;

		} catch (Exception $ex) {
			CakeLog::error($ex->getTraceAsString());
			$dataSource->rollback();
			return false;
		}
	}

/**
 * save block
 *
 * @param array $frame frame data
 * @return int blocks.id
 * @throws ForbiddenException
 */
	private function __saveBlock($frame) {
		if (! isset($frame['Frame']['block_id']) ||
			$frame['Frame']['block_id'] === '0') {
			//blocksテーブル登録
			$block = array();
			$block['Block']['room_id'] = $frame['Frame']['room_id'];
			$block['Block']['language_id'] = $frame['Frame']['language_id'];
			$block = $this->Block->save($block);
			if (! $block) {
				throw new ForbiddenException(serialize($this->Block->validationErrors));
			}
			$blockId = (int)$block['Block']['id'];

			//framesテーブル更新
			$frame['Frame']['block_id'] = $blockId;
			if (! $this->Frame->save($frame)) {
				throw new ForbiddenException(serialize($this->Frame->validationErrors));
			}
		}

		return (int)$frame['Frame']['block_id'];
	}

}
