<?php
App::uses('OnlineStatusesAppController', 'OnlineStatuses.Controller');

/**
 * OnlineStatuses Controller
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
class OnlineStatusesController extends OnlineStatusesAppController {

/**
 * use model
 *
 * @var array
 */
	//public $uses = array();
	public $uses = array(
		'OnlineStatuses.OnlineFrameSetting',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole',
	);

/**
 * beforeFilter
 *
 * @return void
 **/
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();

		$frameId = (isset($this->params['pass'][0]) ? (int)$this->params['pass'][0] : 0);
		//Frameのデータをviewにセット
		if (! $this->NetCommonsFrame->setView($this, $frameId)) {
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
		}
		//Roleのデータをviewにセット
		if (! $this->NetCommonsRoomRole->setView($this)) {
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
		}
	}

/**
 * index
 *
 * @return void
 **/
	public function index($frameId = 0, $lang = '') {
		//取得
		$online_frame_setting = $this->OnlineFrameSetting->getOnlineFrameSetting();

		//データをviewにセット
		$this->set('online_frame_setting', $online_frame_setting);
//CakeLog::debug(print_r($online_frame_setting, true));

		return $this->render('OnlineStatuses/index');
	}

/**
 * show manage method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function manage($frameId = 0) {
		if ($this->response->statusCode() !== 200) {
			return $this->render(false);
		}
		//編集権限チェック
		if (! $this->viewVars['contentEditable']) {
			$this->response->statusCode(403);
			return $this->render(false);
		}

		return $this->render('OnlineStatuses/manage', false);
	}

	public function afterFilter() {

//CakeLog::debug(print_r("----afterFilter---------", true));
//CakeLog::debug(print_r($this->viewVars['online_frame_setting'], true));
	}

}
