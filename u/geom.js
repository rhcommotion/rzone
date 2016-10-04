(function() {
'use strict';

//
if (Math.sign === void 0) {
	Math.sign = function (x) {
		x = +x; // convert to a number
		if (x === 0 || isNaN(x)) {
			return x;
		}
		return x > 0 ? 1 : -1;
	};
}

//
this.geom = {
	vec: function(x, y) {
		switch (arguments.length) {
			case 1:
				var v = x;
				this[0] = v[0]; this[1] = v[1];
				break;
			case 2:
				this[0] = x; this[1] = y;
				break;
		}
	}, 
	line: function(p1, p2) {
		switch (arguments.length) {
			case 1:
				var obj = p1;
				this.p1 = obj.p1; this.p2 = obj.p2;
				break;
			case 2:
				this.p1 = new geom.vec(p1); this.p2 = new geom.vec(p2);
				break;
		}
	}, 
	rect: function(p1, p2) {
		geom.line.apply(this, arguments);
	}
};
geom.vec.prototype.mixin({
	0: 0, 1: 0, 
	get x() {return this[0]}, set x(val) {this[0] = val}, 
	get y() {return this[1]}, set y(val) {this[1] = val}, 
	add: function (v2) {
		var v1 = this;
		return new geom.vec(v1[0] + v2[0], v1[1] + v2[1]);
	}, 
	sub: function (v2) {
		var v1 = this;
		return new geom.vec(v1[0] - v2[0], v1[1] - v2[1]);
	}, 
	dot: function (v2) {
		var v1 = this;
		return v1[0] * v2[0] + v1[1] * v2[1];
	}, 
	get length() {
		return Math.sqrt(this.dot(this));
	}, 
	get angle() {
		return Math.atan2(this[1], this[0]);
	}
});
geom.line.prototype.mixin({
	p1: new geom.vec(), p2: new geom.vec(), 
	get length() {
		return this.p1.sub(this.p2).length;
	}, 
	get angle() {
		var v1 = this.p2.sub(this.p1);
		return v1.angle;
	}
});
geom.rect.prototype.mixin({
	p1: new geom.vec(), p2: new geom.vec(), 
	get left() {return this.p1[0]}, get top() {return this.p1[1]}, 
	get right() {return this.p2[0]}, get bottom() {return this.p2[1]}, 
	get width() {return Math.abs(this.right - this.left)}, 
	get height() {return Math.abs(this.bottom - this.top)}, 
	is_pt_inside: function (p) {
		var d1 = this.p1.sub(p), d2 = this.p2.sub(p);
		var x = d1.x * d2.x, y = d1.y * d2.y;
		return x <= 0 && y <= 0;
	}
});

}).call_global();

