var app = require('app');
var ipc = require('ipc');
var dialog = require('dialog');
var BrowserWindow = require('browser-window');

var win = null;
function getJsonFromUrl(url) {
  var query = url.substr(1);
  var result = {};
  query.split(new RegExp("\#|\&")).forEach(function(part) {
    var item = part.split("=");
    result[item[0]] = decodeURIComponent(item[1]);
  });
  return result;
}

app.on('ready', function () {
	win = new BrowserWindow({
		width: 1200
		, height: 780
		, icon: 'sona_square.png'
	});
	win.setMenu(null);
	win.loadUrl('file://' + __dirname + '/index.html');
	win.openDevTools();


	win.on('closed', function (){
		win = null;
	});

	ipc.on('open-file-dialog', function () {
		var files = dialog.showOpenDialog({ properties: [ 'openFile', 'multiSelections' ]})
		if (files) win.send('add-to-playlist', files)
	});

	ipc.on('open-child-window-facebook', function (event, arg) {

		var child = new BrowserWindow({
			width: 1000,
			height: 1000,
			"node-integration": false, // and this line
			    "web-preferences": {
			      "web-security": false
			    }
		});
		child.loadUrl(arg.url);
		child.webContents.on('did-finish-load', function (e, n) {
			var res = getJsonFromUrl(child.webContents.getUrl());
			console.log("\n\n", res, "\n\n");
			if (res.access_token || res.error) {
				win.send("facebook-login", res);
				child.close();
			}
		});
	});
	ipc.on('open-child-window-google', function (event, arg) {
		var child = new BrowserWindow({
			width: 1000,
			height: 1000
		});
		child.loadUrl("https://sona-api.herokuapp.com/auth/google");
		child.webContents.on('dom-ready', function (e, n) {
			child.webContents.executeJavaScript(
				'(' + googleLoginInsider + ')();'
			);
		});
		ipc.on('google-callback', function (event, arg) {
			win.send('google-login', arg);
			child.close();
		});
	});

	function googleLoginInsider() {
		var ipc = require('ipc');
		//ipc.send('google-callback');
		var user = document.getElementById('sona-user');
		if (user) {
			ipc.send('google-callback', JSON.parse(user.innerHTML));
		}
	}

});
