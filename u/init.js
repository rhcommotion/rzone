(function () {
'use strict';

//
Object.prototype.mixin = function (obj) {
	var props = {};
	Object.getOwnPropertyNames(obj).forEach(function (name) {
		props[name] = Object.getOwnPropertyDescriptor(obj, name);
	})
	Object.defineProperties(this, props);
	return this;
};

//
Function.prototype.mixin({
	bind_global: (function() {
		var global = this;
		return function() {
			return this.bind(global);
		};
	}).call(this), 
	call_global: (function() {
		var global = this;
		return function() {
			return this.apply(global, arguments);
		};
	}).call(this)
});

}).call(this);
