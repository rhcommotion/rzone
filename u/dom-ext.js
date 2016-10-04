(function() {
'use strict';

//
var query_func_dict = {
	'class': 'getElementsByClassName', 
	'tag': 'getElementsByTagName', 
	'id': 'getElementById'
};
var dom_query = {
	query: function(mode, arg1) {
		if (arguments.length === 1) {
			return this.querySelectorAll(mode);
		} else {
			return this[query_func_dict[mode]](arg1);
		}
	}, 
	query1: function(mode, arg1) {
		if (arguments.length === 1) {
			return this.querySelector(mode);
		} else {
			return this.query(mode, arg1)[0];
		}
	}
};
document.locate_proto("getElementsByClassName").mixin(dom_query);
document.documentElement.locate_proto("getElementsByClassName").mixin(dom_query);
// in fact, there's no get-by-id in element prototype.

//
document.documentElement.locate_proto("getBoundingClientRect").mixin({
	get layout_rect() {
		var r = this.getBoundingClientRect();
		return new geom.rect([r.left, r.top], [r.right, r.bottom]);
	}
});

//
var event_handler = {
	add_cb: function(e, cb, cap) {
		if (e.is_string()) {
			this.addEventListener(e, cb, cap);
		} else {
			var elem = this;
			e.for_each(function (str) {
				elem.addEventListener(str, cb, cap);
			});
		}
		return this;
	}, 
	remove_cb: function(e, cb, cap) {
		if (e.is_string()) {
			this.removeEventListener(e, cb, cap);
		} else {
			var elem = this;
			e.for_each(function (str) {
				elem.removeEventListener(str, cb, cap);
			});
		}
		return this;
	}
};
window.locate_proto("addEventListener").mixin(event_handler);
if (document.documentElement.add_cb !== window.add_cb) {
	document.documentElement.locate_proto("addEventListener").mixin(event_handler);
}

}).call_global();

