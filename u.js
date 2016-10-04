(function() {
'use strict';

this.net = {
	get_content: function (url) {
		var xhr = new XMLHttpRequest();
		xhr.open('GET', url, false);
		xhr.send();
		if (xhr.status === 200) {
			return xhr.responseText;
		} else {
			throw 'xhr failed.';
		}
	}
};

function include_js(url) {
	var content = net.get_content(url);
	document.write('<script>' + content + '</script>');
}
function include_css(url) {
	document.write('<link href="' + url + '" type="text/css" rel="stylesheet">');
}
this.lang = {
	include_js: function () {
		var len = arguments.length;
		for (var i = 0; i < len; i++) {
			var arg = arguments[i];
			if (Array.isArray(arg)) {
				arg.forEach(include_js);
			} else {
				include_js(arg);
			}
		}
	}, 
	include_css: function (url) {
		var len = arguments.length;
		for (var i = 0; i < len; i++) {
			var arg = arguments[i];
			if (Array.isArray(arg)) {
				arg.forEach(include_css);
			} else {
				include_css(arg);
			}
		}
	}
};

lang.include_js('u/init.js', 'u/proto-ext.js', 'u/geom.js', 'u/dom-ext.js', 'u/table.js');

}).call(this);

if (Array.from === void 0) {
  Array.from = function(arr, f, this_arg) {
    var len = arr.length;
    var r = [];
    if (f === void 0) {
      for (var i = 0; i < len; i++)
        r.push(arr[i]);
    } else {
      for (var i = 0; i < len; i++)
        r.push(f.call(this_arg, arr[i]));
    }
    return r;
  }
}

function xhr_post(url, obj, cb) {
  var xhr = new XMLHttpRequest();
  if (cb === void 0) {
    xhr.open('POST', url, false);
  } else {
    xhr.onload = cb;
    xhr.open("POST", url, true);
  }
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  var str = Object.keys(obj).map(function (k) {
    return k + '=' + encodeURIComponent(obj[k]);
  }).join('&');
  xhr.send(str);
  return xhr;
};

/*
 *
window.wnd = {
	init: function (cb) {init_cbs.push(cb)}, 
	preventdefault: function (e) {e.preventDefault()},
	switch_class: function (cls, old_elem, new_elem) {
		if (old_elem !== new_elem) {
			old_elem.classList.remove(cls);
			new_elem.classList.add(cls);
		}
	}
};

var init_cbs = [];
function init_dom() {
	init_cbs.for_each(function (cb) {cb()});
	document.remove_cb("DOMContentLoaded", init_dom);
	init_cbs = null;
}
document.add_cb("DOMContentLoaded", init_dom);

// workaround chrome bug: sometimes touch events are not fired.
init_cbs.push(function() {
	document.body.add_cb(["touchstart", "touchend", "touchcancel"], function() {});
});

*/
