app.factory('UserSvc',
	['$http', '$state',
	function ($http, $state) {
		var service = {};
		var user = null;

		service.get = function () {
			user = user || JSON.parse(window.localStorage.getItem('sona-user'))
			return user;
		}
		service.set = function (datas) {
			user = datas;
			window.localStorage.setItem('sona-user', angular.toJson(datas));
			return user;
		}

		service.login = function (email, password) {
			var datas = {
				"email": email,
				"password": password
			};
			$http.post("https://sona-api.herokuapp.com/auth", datas)
			.then(function (res) {
				service.set(res.data);
				$state.go("logedIn.main");
			}, function (err) {
				console.log("err: ", err);
			});
		}

		return service;
}]);

app.factory('FacebookService',
	['$http', '$state', 'UserSvc',
	function ($http, $state, UserSvc) {
		var service = {};

		service.login = function () {
			ipc.send('open-child-window-facebook', {
				url:'https://www.facebook.com/dialog/oauth?client_id=672669452811477&redirect_uri=https://www.facebook.com/connect/login_success.html&response_type=token&scope=email'
			});
			ipc.on("facebook-login", function (res) {
				$http.post("https://sona-api.herokuapp.com/auth/facebook", res)
				.then(function (res) {
					UserSvc.set(res.data);
					$state.go("logedIn.main");
				}, function (err) {
					console.log("err: ", err);
				});
			});
		};

		return service;
}]);

app.factory('GoogleService',
	['$http', '$state', 'UserSvc',
	function ($http, $state, UserSvc) {
		var service = {};

		service.login = function () {
			ipc.send('open-child-window-google');
			ipc.on("google-login", function (res) {
				UserSvc.set(res);
				$state.go("logedIn.main");
			});
		};

		return service;
}]);

app.factory('RequestSvc',
	['$http', 'UserSvc',
	function ($http, UserSvc) {
		var service = {};

		service.renew = function () {
			$http.post("https://sona-api.herokuapp.com/auth/tokens", {},
					{headers: {
						'X-SONA-AUTHENTICATION': UserSvc.get().tokens.authentication,
						'X-SONA-RENEW': UserSvc.get().tokens.renew
					}
				}).then(function (res) {
					console.log("res: ", res);
				}, function (err) {
					console.log("err", err);
				});
		}

		service.postPlaylist = function () {
			$http.post("https://sona-api.herokuapp.com/places/55c07cd6917cb41200b68b92/playlist",
				{toto:"200"}, {
					headers: {'X-SONA-AUTHENTICATION': UserSvc.get().tokens.authentication}
				}).then(function (res) {
					console.log("res: ", res);
				}, function (err) {
					if (err.status == 401) {
						service.renew();
					}
					console.log("err", err);
				});
		};

		return service;
}]);

/*app.factory('PlaylistsSvc',
	['UserSvc',
	function (UserSvc) {
		var service = {};
		var playlists = null;

		service.get = function () {
			playlists = playlists || JSON.parse(window.localStorage.getItem('sona-playlists'))
			return playlists;
		};

		service.add = function (name) {
			if (!name || (playlists && playlists.indexOf(name) >= 0)) {return playlists}

			if (!playlists) {playlists = []}
			playlists.push(name);
			window.localStorage.setItem('sona-playlists', angular.toJson(playlists));
			return playlists;
		}

		return service;
}]);
*/
app.factory('PlaylistSvc',
	['UserSvc', '$q',
	function (UserSvc, $q) {
		var service = {};
		var playlists = JSON.parse(window.localStorage.getItem('sona-playlists'));
		var findName = function(element) {
			return element.name == this;
		};

		service.getAll = function () {
			return playlists;
		};

		service.get = function (name) {
			return playlists.find(findName, name);
		};

		service.add = function (name) {
			if (!name || (playlists && playlists.find(findName, name))) {return playlists}

			if (!playlists) {playlists = []}
			playlists.push({name: name, songs: []});
			window.localStorage.setItem('sona-playlists', angular.toJson(playlists));
			return playlists;
		};

		service.addTo = function (name, files) {
			var index = playlists.find(findName, name);
			index = index.index;

			var getMetadata = function (file) {
				return $q(function (resolve, reject) {
					mm(fs.createReadStream(file), function (err, metadata) {
						if (err) {
							reject(err);
						}
						resolve(metadata);
					});
				}).then(function (metadata) {
					playlists[index].songs.push({
						url: file
						, album: metadata.album
						, artists: metadata.albumartist.concat(metadata.artist)
						, title: metadata.title
						, artist: metadata.artist
//						, id: playlists[index].songs.length
					});
				});
			};

			$q.all(files.map(getMetadata)).then(function () {
				window.localStorage.setItem('sona-playlists', angular.toJson(playlists));
			}, function (err) {
				console.log(err);
			});

			return playlists[index];
		};

		return service;
}]);

app.factory('PlaystreamSvc',
	['$http',
	function ($http) {
		var service = {};
		var playstream = null;

		service.get = function () {
			return playstream;
		}

		service.launch = function (playlist) {
			playstream = playlist;
		}
		return service;
}]);

app.factory('player', function(audio, $rootScope) {
    var player,
        playlist = [],
        paused = false,
        current = {
          track: 0
        };

    player = {
      playlist: playlist,

      current: current,

      playing: false,

      play: function(track) {
      	console.log("errge", playlist);
        if (!playlist.length) return;

        if (angular.isDefined(track)) current.track = track;

        if (!paused) audio.src = playlist[current.track].url;
        console.log("try to play", playlist, current.track, playlist[current.track].url);
        audio.play();
        player.playing = true;
        paused = false;
      },

      pause: function() {
        if (player.playing) {
          audio.pause();
          player.playing = false;
          paused = true;
        }
      },

      reset: function() {
        player.pause();
        current.track = 0;
      },

      next: function() {
        if (!playlist.length) return;
        paused = false;
        if (playlist.length > (current.track + 1)) {
          current.track++;
        } else {
          current.track = 0;
        }
        if (player.playing) player.play();
      },

      previous: function() {
        if (!playlist.length) return;
        paused = false;
        if (current.track > 0) {
          current.track--;
        } else {
          current.track = playlist.length - 1;
        }
        if (player.playing) player.play();
      }
    };

    playlist.add = function(album) {
      playlist = album;
    };

    playlist.remove = function(album) {
/*      var index = playlist.indexOf(album);
      if (index == current.album) player.reset();
      playlist.splice(index, 1);
*/    };

	audio.addEventListener('ended', function() {
	  $rootScope.$apply(player.next);
	}, false);

    return player;
  });


  // extract the audio for making the player easier to test
  app.factory('audio', function($document) {
    var audio = $document[0].createElement('audio');
    return audio;
  });
