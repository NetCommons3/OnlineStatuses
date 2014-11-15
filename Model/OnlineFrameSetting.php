<?php
/**
 * OnlineFrameSetting
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
App::uses('AppModel', 'Model');

class OnlineFrameSetting extends AppModel {

	/**
	 * Validation rules
	 *
	 * @var array
	 */
//	public $validate = array(
//	);

	/**
	 * get OnlineFrameSetting
	 *
	 * @param int $blockId blocks.id
	 * @param bool $contentEditable true can edit the content, false not can edit the content.
	 * @return array
	 */
//	public function getOnlineFrameSettings($blockId, $contentEditable) {
	public function getOnlineFrameSetting() {

		/*
				$conditions = array(
					'block_id' => $blockId,
				);
				if (! $contentEditable) {
					$conditions['status'] = NetCommonsBlockComponent::STATUS_PUBLISHED;
				}
		*/
		$conditions = array(
		);

		$online_frame_setting = $this->find('first', array(
				'conditions' => $conditions,
			)
		);

		if (! $online_frame_setting) {
			$online_frame_setting = $this->create();
			$online_frame_setting['OnlineFrameSetting']['display_visitor'] = '0';
			$online_frame_setting['OnlineFrameSetting']['display_login_user'] = '0';
			$online_frame_setting['OnlineFrameSetting']['display_registration_user'] = '0';
			$online_frame_setting['OnlineFrameSetting']['frame_key'] = '';
			$online_frame_setting['OnlineFrameSetting']['id'] = '0';
		}
//CakeLog::debug(print_r($online_frame_setting, true));
		return $online_frame_setting;
	}

	/**
	 * save OnlineFrameSetting
	 *
	 * @param array $postData received post data
	 * @return bool true success, false error
	 * @throws ForbiddenException
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

//CakeLog::debug(print_r($postData, true));
		//frame関連のセット
		$frame = $this->Frame->findById($postData['Frame']['id']);
//$sqlLog = $this->Frame->getDataSource()->getLog(false, false);
//CakeLog::debug(print_r($sqlLog, true));
//CakeLog::debug(print_r($frame, true));

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
			$online_frame_setting['OnlineFrameSetting'] = $postData['OnlineFrameSetting'];
			$online_frame_setting['OnlineFrameSetting']['block_id'] = $blockId;
			$online_frame_setting['OnlineFrameSetting']['created_user'] = CakeSession::read('Auth.User.id');

			// チェックボックスseve暫定対応
			$online_frame_setting['OnlineFrameSetting']['display_visitor'] = ($online_frame_setting['OnlineFrameSetting']['display_visitor'] == "false") ? 0 : 1;
			$online_frame_setting['OnlineFrameSetting']['display_login_user'] = ($online_frame_setting['OnlineFrameSetting']['display_login_user'] == "false") ? 0 : 1;
			$online_frame_setting['OnlineFrameSetting']['display_registration_user'] = ($online_frame_setting['OnlineFrameSetting']['display_registration_user'] == "false") ? 0 : 1;

	CakeLog::debug(print_r($online_frame_setting, true));
			$online_frame_setting = $this->save($online_frame_setting);
//$sqlLog = $this->Frame->getDataSource()->getLog(false, false);
//CakeLog::debug(print_r($sqlLog, true));
			if (! $online_frame_setting) {
				throw new ForbiddenException(serialize($this->validationErrors));
			}
			$dataSource->commit();
			return $online_frame_setting;

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
