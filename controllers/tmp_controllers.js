app.controller('LoginCtrl',
	['$scope', 'FacebookService', 'GoogleService', 'UserSvc',
	function ($scope, Facebook, Google, UserSvc) {
		/* tmp */ /* form default values */
		$scope.email = "gatoyu@gmail.com"
		$scope.password = "patate"
		/* /tmp */

		$scope.login = function (email, password) {
			console.log("je suis la");
			UserSvc.login(email, password);
		};

		$scope.facebookLogin = function () {
			Facebook.login();
		};

		$scope.googleLogin = function () {
			Google.login();
		};
	}
]);

app.controller('PlaylistsCtrl',
	['$scope', 'UserSvc', 'playlists', 'PlaylistSvc',
	function ($scope, UserSvc, playlists, PlaylistSvc) {
		console.log("DA playlists: ", playlists);
		$scope.playlists = playlists;

		$scope.addPlaylist = function (newPlaylistName) {
			$scope.playlists = PlaylistSvc.add(newPlaylistName);
		}
	}
]);

app.controller('PlaylistCtrl',
	['$scope', '$stateParams', 'playlist', 'PlaylistSvc', 'PlaystreamSvc', '$rootScope',
	function ($scope, $stateParams, playlist, PlaylistSvc, PlaystreamSvc, $rootScope) {
		console.log("basic pl:", playlist);
		$scope.playlist = playlist.value;

		var listener = function (links) {
			console.log("add files:", links);
			ipc.removeListener('add-to-playlist', listener);
			$scope.playlist = PlaylistSvc.addTo($stateParams.name, links);
		}

		$scope.add = function () {
			ipc.on('add-to-playlist', listener);
			ipc.send('open-file-dialog');
		}

		$scope.launch = function () {
			$rootScope.$emit("launch-playlist", $scope.playlist);
		}


	}
]);
