<?php
/**
 * OnlineStatuses Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('OnlineStatusesAppController', 'OnlineStatuses.Controller');

/**
 * OnlineStatuses Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\OnlineStatuses\Controller
 */
class OnlineStatusesController extends OnlineStatusesAppController {

/**
 * use model
 *
 * @var array
 */
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
 * @throws ForbiddenException
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
 * @param int $frameId frames.id
 * @return void
 **/
	public function index($frameId = 0) {
		//取得
		$onlineFrameSetting = $this->OnlineFrameSetting->getOnlineFrameSetting($frameId);

		//データをviewにセット
		$this->set('onlineFrameSetting', $onlineFrameSetting);

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
		if (! $this->viewVars['pageEditable']) {
			$this->response->statusCode(403);
			return $this->render(false);
		}

		return $this->render('OnlineStatuses/manage', false);
	}

}
