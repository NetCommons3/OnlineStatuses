<?php
/**
 * OnlineStatusesController Test Case
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('OnlineStatusesController', 'OnlineStatuses.Controller');
App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');

/**
 * OnlineStatusesController Test Case
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\OnlineStatuses\Test\Case\Controller
 */
class OnlineStatusesControllerTest extends ControllerTestCase {

/**
 * mock controller object
 *
 * @var null
 */
	public $Controller = null;

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'site_setting',
		'plugin.OnlineStatuses.OnlineFrameSetting',
		'plugin.OnlineStatuses.block',
		'plugin.frames.box',
		'plugin.frames.language',
		'plugin.OnlineStatuses.frame',
		'plugin.OnlineStatuses.plugin',
		'plugin.rooms.room',
		'plugin.rooms.roles_rooms_user',
		'plugin.roles.default_role_permission',
		'plugin.rooms.roles_room',
		'plugin.rooms.room_role_permission',
		'plugin.rooms.user',
	);

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		Configure::write('Config.language', 'ja');
		$this->login();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		$this->logout();
		Configure::write('Config.language', null);
		parent::tearDown();
	}

/**
 * login　method
 *
 * @return void
 */
	public function login() {
		//ログイン処理
		$this->Controller = $this->generate('OnlineStatuses.OnlineStatuses', array(
			'components' => array(
				'Auth' => array('user'),
				'Session',
				'Security',
				'RequestHandler',
			),
		));

		$this->Controller->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnCallback(array($this, 'authUserCallback')));

		$this->Controller->Auth->login(array(
				'username' => 'system_administrator',
				'password' => 'system_administrator',
				'role_key' => 'system_administrator',
			)
		);
		$this->assertTrue($this->Controller->Auth->loggedIn(), 'login');
	}

/**
 * logout method
 *
 * @return void
 */
	public function logout() {
		//ログアウト処理
		$this->Controller->Auth->logout();
		$this->assertFalse($this->Controller->Auth->loggedIn(), 'logout');

		CakeSession::write('Auth.User', null);
		unset($this->Controller);
	}

/**
 * authUserCallback method
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return array user
 */
	public function authUserCallback() {
		$user = array(
			'id' => 1,
			'username' => 'system_administrator',
			'role_key' => 'system_administrator',
		);
		CakeSession::write('Auth.User', $user);
		return $user;
	}

/**
 * testBeforeFilterByNoSetFrameId method
 *
 * @return void
 */
	public function testBeforeFilterByNoSetFrameId() {
		$this->setExpectedException('ForbiddenException');
		$this->testAction('/OnlineStatuses/OnlineStatuses/index', array('method' => 'get'));

		$this->assertEmpty(trim($this->view));
	}

/**
 * testIndexByAllNoDisplay method
 *
 * @return void
 */
	public function testIndexByAllNoDisplay() {
		$this->testAction('/OnlineStatuses/OnlineStatuses/index/1', array('method' => 'get'));

		// jsで表示非表示を制御しているため、設定値は全部非表示だが、HTMLには全部表示されている。
		$this->assertTextContains('オンラインユーザー', $this->view);
		$this->assertTextContains('ログインユーザー', $this->view);
		$this->assertTextContains('登録ユーザー', $this->view);
	}

/**
 * testIndexByAllDisplay method
 *
 * @return void
 */
	public function testIndexByAllDisplay() {
		$this->testAction('/OnlineStatuses/OnlineStatuses/index/2', array('method' => 'get'));

		$this->assertTextContains('オンラインユーザー', $this->view);
		$this->assertTextContains('ログインユーザー', $this->view);
		$this->assertTextContains('登録ユーザー', $this->view);
	}

/**
 * testView method
 *
 * @return void
 */
	public function testManage() {
		$this->testAction('/OnlineStatuses/OnlineStatuses/manage/1', array('method' => 'get'));

		$this->assertTextContains('表示方法変更', $this->view);
	}
}
