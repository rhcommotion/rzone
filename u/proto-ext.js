(function() {
'use strict';

//
this.assert = function (cond) {
	if (!cond) {
		console.trace();
		console.assert.apply(console, arguments);
		debugger;
	}
};

//
Object.prototype.mixin({
	get upper_proto() {
		return Object.getPrototypeOf(this);
	}, 
	locate_proto: function (prop_name) {
		var proto = this;
		while (proto !== null) {
			if (proto.hasOwnProperty(prop_name))
				return proto;
			proto = proto.upper_proto;
		}
		return null;
	}
});

//
var true_substring = String.prototype.substring;
Object.prototype.mixin({
	is_string: function () {return (this.substring === true_substring)}, 
	is_array: function () {return Array.isArray(this)}
});

//
var array_like = {
	for_each: function (f) {
		var len = this.length;
		for (var i = 0; i < len; i++)
			f(this[i], i, this);
		return this;
	}
};
Array.prototype.mixin(array_like);
String.prototype.mixin(array_like);
document.getElementsByTagName("body").locate_proto("item").mixin(array_like);

}).call_global();

