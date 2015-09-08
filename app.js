var ngRoute = require("angular-route");
var ipc = require('ipc');
var mm = require('musicmetadata');
var fs = require('fs');
var mime = require('mime');

var app = angular.module("Sona", [require('angular-ui-router')]);

app.config(['$stateProvider', '$urlRouterProvider',
	function($stateProvider, $urlRouterProvider) {
		$stateProvider
		.state('login', {
			url: "/login",
			templateUrl: "partials/login.html",
			controller: "LoginCtrl"
		})
		.state('logedIn', {
			url: "/",
			views: {
				'@': {
					templateUrl: "partials/home.html",
					controller: function($scope, auth, RequestSvc){
						console.log("voici l'user", auth);
					}
				},
				'playstream@logedIn': {
					templateUrl: "partials/playstream.html",
					controller: function($scope, PlaystreamSvc, $rootScope){
						$rootScope.$on("launch-playlist", function (e, playlist) {
							console.log("received");
							$scope.playstream = playlist;
						});
					}
				},
				'player@logedIn': {
					templateUrl: "partials/player.html",
					controller: function($scope, $rootScope, player, audio){

						$scope.player = player;
						audio.addEventListener('timeupdate', function(e) {
							$scope.time = audio.currentTime;
							$scope.duration = audio.duration;
//							console.log(e, audio.currentTime, audio.duration);
						}, false);
						$rootScope.$on("launch-playlist", function (e, playlist) {
							player.playlist.add(playlist.songs);
						});
					}
				}
			},
			resolve: {
				auth: function (UserSvc, $q) {
					var userInfo = UserSvc.get();
					if (userInfo) {
						return $q.when(userInfo);
					}
					return $q.reject();
				}
			}
		})
		.state('logedIn.main', {
			url: "/main",
			templateUrl: "partials/main.html"
		})
		.state('logedIn.playlists', {
			url: "/playlists",
			templateUrl: "partials/playlists.html",
			controller: "PlaylistsCtrl",
			resolve: {
				playlists: function (PlaylistSvc, $q) {
					return $q.when(PlaylistSvc.getAll());
				}
			}
		})
		.state('logedIn.playlist', {
			url: "/playlist/:name",
			templateUrl: "partials/playlist.html",
			controller: "PlaylistCtrl",
			resolve: {
				playlist: function (PlaylistSvc, $q, $stateParams) {
					return $q.when(PlaylistSvc.get($stateParams.name));
				}
			}
		})
}]);

app.run(['$rootScope', '$state',
	function($rootScope, $state){
		var appStarted = false;
		window.state = $state;
		$rootScope.$on('$stateChangeError',
			function (e, toS, toP, fromS, fromP, err) {
				e.preventDefault();
				$state.go("login");
		});
		$rootScope.$on('$stateChangeStart',
			function(e) {
				if(appStarted) return;
				appStarted = true;
				e.preventDefault();
				$state.go('logedIn.playlists');
		});
}]);


if (!Array.prototype.find) {
  Array.prototype.find = function(predicate) {
    if (this === null) {
      throw new TypeError('Array.prototype.find called on null or undefined');
    }
    if (typeof predicate !== 'function') {
      throw new TypeError('predicate must be a function');
    }
    var list = Object(this);
    var length = list.length >>> 0;
    var thisArg = arguments[1];
    var value;

    for (var i = 0; i < length; i++) {
      value = list[i];
      if (predicate.call(thisArg, value, i, list)) {
        return {value: value, index: i};
      }
    }
    return undefined;
  };
}
