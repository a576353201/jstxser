DrawLine = {
    AttributeGroup: [],
    LineGroup: [],
    table: false,
    check: function(a) {
        return /^(charball|cbg)/i.test(a.className)
    },
    on_off: true,
    bind: function(b, a) {
        this.table = b;
        this.on_off = a;
        return this
    },
    color: function(a) {
        LG.color = a;
        return this
    },
    draw: function(e) {
        if (!this.table) {
            return
        }
        if (e) {
            var d = this.AttributeGroup.length;
            for (var a = 0; a < d; a++) {
                var b = this.AttributeGroup[a];
                LG.color = b.color;
                JoinLine.indent = b.indent;
                this.LineGroup.push(new LG(this.table, b[0], b[1], b[2], b[3], this.check))
            }
        }
        if (this.on_off) {
            var f = this;
            var c = document.getElementById(this.on_off);
            if (c) {
                c.onclick = function() {
                    f.show(this.checked)
                }
            }
        }
        return this
    },
    show: function(c) {
        var b = this.LineGroup.length;
        for (var a = 0; a < b; a++) {
            this.LineGroup[a].show(c)
        }
    },
    add: function(a, d, b, c) {
        this.AttributeGroup.push([a, d, b, c]);
        this.AttributeGroup[this.AttributeGroup.length - 1].color = LG.color;
        this.AttributeGroup[this.AttributeGroup.length - 1].indent = JoinLine.indent;
        return this
    }
};
JoinLine = function(a, b) {
    this.color = a || "#000000";
    this.size = b || 1;
    this.lines = [];
    this.tmpDom = null;
    this.visible = true;
    this.box = document.body
};
JoinLine.prototype = {
    show: function(b) {
        for (var a = 0; a < this.lines.length; a++) {
            this.lines[a].style.visibility = b ? "visible": "hidden"
        }
    },
    remove: function() {
        for (var a = 0; a < this.lines.length; a++) {
            this.lines[a].parentNode.removeChild(this.lines[a])
        }
        this.lines = []
    },
    join: function(g, f) {
        this.remove();
        this.visible = f ? "visible": "hidden";
        this.tmpDom = document.createDocumentFragment();
        for (var e = 0; e < g.length - 1; e++) {
            var d = this.pos(g[e]);
            var c = this.pos(g[e + 1]);
            if (document.all) {
                this.IELine(d.x, d.y, c.x, c.y)
            } else {
                this.FFLine(d.x, d.y, c.x, c.y)
            }
        }
        document.body.appendChild(this.tmpDom)
    },
    pos: function(c) {
        if (c.nodeType == undefined) {
            return c
        }
        var d = {
                x: 0,
                y: 0
            },
            b = c;
        for (; b; b = b.offsetParent) {
            d.x += b.offsetLeft;
            d.y += b.offsetTop;
            if (this.wrap && b.offsetParent === this.wrap) {
                break
            }
        }
        d.x += parseInt(c.offsetWidth / 2);
        d.y += parseInt(c.offsetHeight / 2);
        return d
    },
    FFLine: function(c, g, b, f) {
        if (Math.abs(g - f) < (JoinLine.indent * 2) && c == b) {
            return
        }
        var h = this.nPos(c, g, b, f, JoinLine.indent);
        c = h[0];
        g = h[1];
        b = h[2];
        f = h[3];
        var d = document.createElement("canvas");
        d.style.position = "absolute";
        d.style.visibility = this.visible;
        d.width = Math.abs(c - b) || this.size;
        d.height = Math.abs(g - f) || this.size;
        var i = Math.min(g, f);
        var a = Math.min(c, b);
        d.style.top = i + "px";
        d.style.left = a + "px";
        var e = d.getContext("2d");
        e.save();
        e.strokeStyle = this.color;
        e.lineWidth = this.size;
        e.globalAlpha = 1;
        e.beginPath();
        e.moveTo(c - a, g - i);
        e.lineTo(b - a, f - i);
        e.closePath();
        e.stroke();
        e.restore();
        this.lines.push(d);
        this.tmpDom.appendChild(d)
    },
    IELine: function(c, e, b, d) {
        if (Math.abs(e - d) < (JoinLine.indent * 2) && c == b) {
            return
        }
        var f = this.nPos(c, e, b, d, JoinLine.indent);
        c = f[0];
        e = f[1];
        b = f[2];
        d = f[3];
        var a = document.createElement("<esun:line></esun:line>");
        a.from = c + "," + e;
        a.to = b + "," + d;
        a.strokeColor = this.color;
        a.strokeWeight = this.size + "px";
        a.style.cssText = "position:absolute;z-index:999;top:0;left:0";
        a.style.visibility = this.visible;
        a.coordOrigin = "0,0";
        this.lines.push(a);
        this.tmpDom.appendChild(a)
    },
    nPos: function(g, o, f, m, e) {
        var p = g - f,
            n = o - m;
        var k = Math.round(Math.sqrt(Math.pow(p, 2) + Math.pow(n, 2)));
        var d, j, q, h;
        var l = Math.round((p * e) / k);
        var i = Math.round((n * e) / k);
        return [f + l, m + i, g - l, o - i]
    }
};
JoinLine.indent = 8;
LG = function(r, o, m, b, p, h) {
    var n = {
        x: o || 0,
        y: m || 0,
        w: b || 0,
        oh: p || 0
    };
    var g = document.getElementById(r).rows;
    var c = n.y < 0 ? (g.length + n.y) : n.y;
    var a = g.length - n.oh;
    var l = n.x < 0 ? (g[c].cells.length + n.x) : n.x;
    var q = l + n.w;
    if (q > g[c].cells.length) {
        q = g[c].cells.length
    }
    if (n.w == 0) {
        q = g[c].cells.length
    }
    this.g = [];
    for (var f = c; f < a; f++) {
        var k = g[f].cells;
        for (var e = l; e < q; e++) {
            var d = k[e];
            if (d) {
                if (h(d, e, f) === true) {
                    this.g.push(d)
                }
            }
        }
    }
    if (LG.autoDraw) {
        this.draw()
    }
};
LG.color = "#E4A8A8";
LG.size = 2;
LG.autoDraw = true;
LG.isShow = true;
LG.prototype = {
    draw: function() {
        this.line = new JoinLine(LG.color, LG.size);
        this.line.join(this.g, LG.isShow)
    },
    show: function(a) {
        this.line.show(a)
    }
};
Chart = {};
Chart.on = function(c, b, a) {
    c.attachEvent ? c.attachEvent("on" + b,
        function() {
            a.call(c)
        }) : c.addEventListener(b, a, false)
};
Chart.ini = {
    default_has_line: true
};
Chart.init = function() {

    if (!Chart.ini.default_has_line) {
        return
    }
    var a = document.getElementById("has_line");
    if (!a) {
        return
    }
    a.checked = "checked"
};
fw = {};
fw.onReady = function(a) {
    Chart.on(window, "load", a)
};