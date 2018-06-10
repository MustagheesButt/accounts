/*
 * NotesNetwork JavaScript SDK. Copyright, NotesNetwork 2017-2018. All rights reserved.
 *
 * This software comes with the login functionality provided by NotesNetwork, and is open source.
 * It may be modified for any purposes.
 */

var NN = {
	clientID: null,
	child_window: null,
	callback: null,
	login_callback: null,
	scope: null,

	base_url: 'http://localhost/accounts',
	access_token: null,

	init: function (initData) {
		this.clientID = initData.client_id;
		this.scope = initData.scope;
		this.login_callback = initData.loginCallback;
	},

	login: function () {
		if (this.login_callback == undefined || this.login_callback == null) {
			console.log("Callback function not given. Cannot perform login.");
			return -1;
		}

		if (this.access_token != undefined && this.access_token != null) {
			this.api('/user/' + this.scope + '?access_token=' + this.access_token, this.login_callback);
			return;
		}

		this.authenticate(true);
	},

	authenticate: function (has_callback) {
		this.child_window = window.open(this.base_url + '/ServiceLogin/' + this.clientID + '?callback=' + (has_callback == true ? 'true' : 'false'),
			'Login With Your NotesNetwork Account',
			'width=480,height=640'
		);
	},

	recieve_token: function (access_token, has_callback) {
		this.access_token = access_token;
		this.child_window.close();

		if (has_callback == true) {
			this.login();
		}
	},

	api: function (query, callback) {
		$.get(this.base_url + '/api' + query, callback);
	},

	/* Utility */
	non_standard_sess_id: function () {
		var regex = /PHPSESSID=[a-z0-9]+/gm;
		var sid = document.cookie.match(regex)[0];

		return sid.substr(sid.indexOf("PHPSESSID=") + 10);
	}
};