/*
 * 発生箇所 : プレビューを閉じる。
 * 編集 閉じる 編集 --- で発生。
 *
 * */

NetCommonsApp.controller('OnlineStatuses', function($scope, $http, $modal) {

	$scope.frameId = 0;
	$scope.visibleManage = false;
	//$scope.visibleVisitor = true;
	//$scope.visibleLoginUser = true;
	//$scope.visibleRegistrationUser = true;
	$scope.PLUGIN_MANAGE_URL = '/online_statuses/online_statuses/manage/';

	/**
	 * OnlineStatuses edit url
	 *
	 * @const
	 */
	$scope.PLUGIN_EDIT_URL = '/online_statuses/online_status_edit/';

	/**
	 * OnlineStatus
	 *
	 * @type {Object.<string>}
	 */
	$scope.online_status = {};

	/**
	 * Initialize
	 *
	 * @return {void}
	 */
	$scope.initialize = function(frameId, online_status) {
		$scope.frameId = frameId;
		$scope.visibleManage = false;
		$scope.online_status = online_status;
//console.debug(online_status);
	};

	$scope.showManage = function() {
		//管理ダイアログ取得のURL
		var url = $scope.PLUGIN_MANAGE_URL + $scope.frameId;
		//ダイアログで使用するJSコントローラ
		var controller = 'OnlineStatuses.edit';

		$modal.open({
			templateUrl: url,
			controller: controller,
			backdrop: 'static',
			scope: $scope
		});
	};

});

NetCommonsApp.controller('OnlineStatuses.edit', function($scope, $http, $modalStack) {

	/**
	 * sending
	 *
	 * @type {string}
	 */
	$scope.sending = false;

	/**
	 * edit object
	 *
	 * @type {Object.<string>}
	 */
	$scope.edit = {
		_method: 'POST',
		data: {}
	};

	/**
	 * iframe tab parent class
	 *
	 * @const
	 */
//	$scope.IFRAME_TAG_PARENT_CLASS = 'nc-online-statuses-container-';

	/**
	 * dialog initialize
	 *
	 * @return {void}
	 */
	$scope.initialize = function() {
		$scope.edit.data = {
			OnlineFrameSetting: {
				id: $scope.online_status.OnlineFrameSetting.id,
				display_visitor: $scope.online_status.OnlineFrameSetting.display_visitor,
				display_login_user: $scope.online_status.OnlineFrameSetting.display_login_user,
				display_registration_user: $scope.online_status.OnlineFrameSetting.display_registration_user
			},
			Frame: {
				id: $scope.frameId
			},
			_Token: {
				key: '',
				fields: '',
				unlocked: ''
			}
		};
	};
	// initialize()
	$scope.initialize();

	$scope.cancel = function(){
		$modalStack.dismissAll('canceled');
	};

	/**
	 * dialog save
	 *
	 * @param {number} status
	 * - 1: Publish
	 * - 2: Approve
	 * - 3: Draft
	 * - 4: Disapprove
	 * @return {void}
	 */
//	$scope.save = function(status) {
	$scope.save = function() {
		$scope.sending = true;

		$http.get($scope.PLUGIN_EDIT_URL + 'form/' +
		$scope.frameId + '/' + Math.random() + '.json')
			.success(function(data) {
				//フォームエレメント生成
				var form = $('<div>').html(data);

				//セキュリティキーセット
				$scope.edit.data._Token.key =
					$(form).find('input[name="data[_Token][key]"]').val();
				$scope.edit.data._Token.fields =
					$(form).find('input[name="data[_Token][fields]"]').val();
				$scope.edit.data._Token.unlocked =
					$(form).find('input[name="data[_Token][unlocked]"]').val();

				//idセット
//				$scope.edit.data.OnlineFrameSetting.id = 1;

				//登録情報をPOST
				$scope.sendPost($scope.edit);
			})
			.error(function(data, status) {
				//keyの取得に失敗
				$scope.flash.danger(status + ' ' + data.name);
				$scope.sending = false;
			});
	};

	/**
	 * send post
	 *
	 * @param {Object.<string>} postParams
	 * @return {void}
	 */
	$scope.sendPost = function(postParams) {
//console.log(postParams);
//		$http.post($scope.PLUGIN_EDIT_URL + 'edit/' + Math.random() + '.json',
		$http.post($scope.PLUGIN_EDIT_URL + 'edit/' + Math.random() + '.json',
			$.param(postParams),
			{headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
			.success(function(data) {
//				console.log('success!!!');
				angular.copy(data.online_frame_setting, $scope.online_status);
//console.log($scope.online_status);
				$scope.flash.success(data.name);
				$scope.sending = false;

//				// 表示切替
//				$scope.visibleVisitor          = $scope.online_status.OnlineFrameSetting.display_visitor;
//				$scope.visibleLoginUser        = $scope.online_status.OnlineFrameSetting.display_login_user;
//				$scope.visibleRegistrationUser = $scope.online_status.OnlineFrameSetting.display_registration_user;
//console.log($scope.visibleVisitor);
//console.log($scope.visibleLoginUser);
//console.log($scope.visibleRegistrationUser);

				$modalStack.dismissAll('saved');
			})
			.error(function(data, status) {
//				console.log('error!!!');
				$scope.flash.danger(status + ' ' + data.name);
				$scope.sending = false;
			});
			//.error(function(data, status, headers, config) {
			//	$scope.flash.danger(status + ' ' + data.name + ' ' + headers + ' ' + config.baseUrl );
			//	$scope.sending = false;
			//});
	};

	//$scope.changeDisplay = function(online_status) {
	//	$scope.visibleVisitor          = $scope.online_status.OnlineFrameSetting.display_visitor;
	//	$scope.visibleLoginUser        = $scope.online_status.OnlineFrameSetting.display_login_user;
	//	$scope.visibleRegistrationUser = $scope.online_status.OnlineFrameSetting.display_registration_user;
	//};

});
