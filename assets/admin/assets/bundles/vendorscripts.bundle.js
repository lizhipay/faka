function hexToRgb(t) {
    t = t.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i, function (t, e, i, s) {
        return e + e + i + i + s + s
    });
    var e = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(t);
    return e ? {r: parseInt(e[1], 16), g: parseInt(e[2], 16), b: parseInt(e[3], 16)} : null
}

function clamp(t, e, i) {
    return Math.min(Math.max(t, e), i)
}

function isInArray(t, e) {
    return -1 < e.indexOf(t)
}

!function (t, e) {
    if ("function" == typeof define && define.amd) define(["jquery"], e); else if ("undefined" != typeof exports) e(require("jquery")); else {
        e(t.jquery), t.metisMenu = {}
    }
}(this, function (t) {
    "use strict";
    var e;
    (e = t) && e.__esModule;
    var n = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) {
        return typeof t
    } : function (t) {
        return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
    };
    var r, i, o, s, a, l, h, c, p = function (s) {
        var e = !1, i = {
            WebkitTransition: "webkitTransitionEnd",
            MozTransition: "transitionend",
            OTransition: "oTransitionEnd otransitionend",
            transition: "transitionend"
        };

        function t(t) {
            var e = this, i = !1;
            return s(this).one(a.TRANSITION_END, function () {
                i = !0
            }), setTimeout(function () {
                i || a.triggerTransitionEnd(e)
            }, t), this
        }

        var a = {
            TRANSITION_END: "mmTransitionEnd", triggerTransitionEnd: function (t) {
                s(t).trigger(e.end)
            }, supportsTransitionEnd: function () {
                return Boolean(e)
            }
        };
        return e = function () {
            if (window.QUnit) return !1;
            var t = document.createElement("mm");
            for (var e in i) if (void 0 !== t.style[e]) return {end: i[e]};
            return !1
        }(), s.fn.emulateTransitionEnd = t, a.supportsTransitionEnd() && (s.event.special[a.TRANSITION_END] = {
            bindType: e.end,
            delegateType: e.end,
            handle: function (t) {
                if (s(t.target).is(this)) return t.handleObj.handler.apply(this, arguments)
            }
        }), a
    }(jQuery);
    r = jQuery, s = "." + (o = i = "metisMenu"), a = r.fn[i], l = {
        toggle: !0,
        preventDefault: !0,
        activeClass: "active",
        collapseClass: "collapse",
        collapseInClass: "in",
        collapsingClass: "collapsing",
        triggerElement: "a",
        parentTrigger: "li",
        subMenu: "ul"
    }, h = {
        SHOW: "show" + s,
        SHOWN: "shown" + s,
        HIDE: "hide" + s,
        HIDDEN: "hidden" + s,
        CLICK_DATA_API: "click" + s + ".data-api"
    }, c = function () {
        function a(t, e) {
            !function (t, e) {
                if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
            }(this, a), this._element = t, this._config = this._getConfig(e), this._transitioning = null, this.init()
        }

        return a.prototype.init = function () {
            var n = this;
            r(this._element).find(this._config.parentTrigger + "." + this._config.activeClass).has(this._config.subMenu).children(this._config.subMenu).attr("aria-expanded", !0).addClass(this._config.collapseClass + " " + this._config.collapseInClass), r(this._element).find(this._config.parentTrigger).not("." + this._config.activeClass).has(this._config.subMenu).children(this._config.subMenu).attr("aria-expanded", !1).addClass(this._config.collapseClass), r(this._element).find(this._config.parentTrigger).has(this._config.subMenu).children(this._config.triggerElement).on(h.CLICK_DATA_API, function (t) {
                var e = r(this), i = e.parent(n._config.parentTrigger),
                    s = i.siblings(n._config.parentTrigger).children(n._config.triggerElement),
                    a = i.children(n._config.subMenu);
                n._config.preventDefault && t.preventDefault(), "true" !== e.attr("aria-disabled") && (i.hasClass(n._config.activeClass) ? (e.attr("aria-expanded", !1), n._hide(a)) : (n._show(a), e.attr("aria-expanded", !0), n._config.toggle && s.attr("aria-expanded", !1)), n._config.onTransitionStart && n._config.onTransitionStart(t))
            })
        }, a.prototype._show = function (t) {
            if (!this._transitioning && !r(t).hasClass(this._config.collapsingClass)) {
                var e = this, i = r(t), s = r.Event(h.SHOW);
                if (i.trigger(s), !s.isDefaultPrevented()) {
                    i.parent(this._config.parentTrigger).addClass(this._config.activeClass), this._config.toggle && this._hide(i.parent(this._config.parentTrigger).siblings().children(this._config.subMenu + "." + this._config.collapseInClass).attr("aria-expanded", !1)), i.removeClass(this._config.collapseClass).addClass(this._config.collapsingClass).height(0), this.setTransitioning(!0);
                    var a = function () {
                        i.removeClass(e._config.collapsingClass).addClass(e._config.collapseClass + " " + e._config.collapseInClass).height("").attr("aria-expanded", !0), e.setTransitioning(!1), i.trigger(h.SHOWN)
                    };
                    p.supportsTransitionEnd() ? i.height(i[0].scrollHeight).one(p.TRANSITION_END, a).emulateTransitionEnd(350) : a()
                }
            }
        }, a.prototype._hide = function (t) {
            if (!this._transitioning && r(t).hasClass(this._config.collapseInClass)) {
                var e = this, i = r(t), s = r.Event(h.HIDE);
                if (i.trigger(s), !s.isDefaultPrevented()) {
                    i.parent(this._config.parentTrigger).removeClass(this._config.activeClass), i.height(i.height())[0].offsetHeight, i.addClass(this._config.collapsingClass).removeClass(this._config.collapseClass).removeClass(this._config.collapseInClass), this.setTransitioning(!0);
                    var a = function () {
                        e._transitioning && e._config.onTransitionEnd && e._config.onTransitionEnd(), e.setTransitioning(!1), i.trigger(h.HIDDEN), i.removeClass(e._config.collapsingClass).addClass(e._config.collapseClass).attr("aria-expanded", !1)
                    };
                    p.supportsTransitionEnd() ? 0 == i.height() || "none" == i.css("display") ? a() : i.height(0).one(p.TRANSITION_END, a).emulateTransitionEnd(350) : a()
                }
            }
        }, a.prototype.setTransitioning = function (t) {
            this._transitioning = t
        }, a.prototype.dispose = function () {
            r.removeData(this._element, o), r(this._element).find(this._config.parentTrigger).has(this._config.subMenu).children(this._config.triggerElement).off("click"), this._transitioning = null, this._config = null, this._element = null
        }, a.prototype._getConfig = function (t) {
            return t = r.extend({}, l, t)
        }, a._jQueryInterface = function (s) {
            return this.each(function () {
                var t = r(this), e = t.data(o),
                    i = r.extend({}, l, t.data(), "object" === (void 0 === s ? "undefined" : n(s)) && s);
                if (!e && /dispose/.test(s) && this.dispose(), e || (e = new a(this, i), t.data(o, e)), "string" == typeof s) {
                    if (void 0 === e[s]) throw new Error('No method named "' + s + '"');
                    e[s]()
                }
            })
        }, a
    }(), r.fn[i] = c._jQueryInterface, r.fn[i].Constructor = c, r.fn[i].noConflict = function () {
        return r.fn[i] = a, c._jQueryInterface
    }
}), function (w) {
    w.fn.extend({
        slimScroll: function (x) {
            var _ = w.extend({
                width: "auto",
                height: "250px",
                size: "7px",
                color: "#000",
                position: "right",
                distance: "1px",
                start: "top",
                opacity: .4,
                alwaysVisible: !1,
                disableFadeOut: !1,
                railVisible: !1,
                railColor: "#333",
                railOpacity: .2,
                railDraggable: !0,
                railClass: "slimScrollRail",
                barClass: "slimScrollBar",
                wrapperClass: "slimScrollDiv",
                allowPageScroll: !1,
                wheelStep: 20,
                touchScrollStep: 200,
                borderRadius: "7px",
                railBorderRadius: "7px"
            }, x);
            return this.each(function () {
                function e(t) {
                    if (r) {
                        var e = 0;
                        (t = t || window.event).wheelDelta && (e = -t.wheelDelta / 120), t.detail && (e = t.detail / 3), w(t.target || t.srcTarget || t.srcElement).closest("." + _.wrapperClass).is(f.parent()) && s(e, !0), t.preventDefault && !g && t.preventDefault(), g || (t.returnValue = !1)
                    }
                }

                function s(t, e, i) {
                    g = !1;
                    var s = f.outerHeight() - m.outerHeight();
                    e && (e = parseInt(m.css("top")) + t * parseInt(_.wheelStep) / 100 * m.outerHeight(), e = Math.min(Math.max(e, 0), s), e = 0 < t ? Math.ceil(e) : Math.floor(e), m.css({top: e + "px"})), e = (u = parseInt(m.css("top")) / (f.outerHeight() - m.outerHeight())) * (f[0].scrollHeight - f.outerHeight()), i && (t = (e = t) / f[0].scrollHeight * f.outerHeight(), t = Math.min(Math.max(t, 0), s), m.css({top: t + "px"})), f.scrollTop(e), f.trigger("slimscrolling", ~~e), a(), n()
                }

                function i() {
                    p = Math.max(f.outerHeight() / f[0].scrollHeight * f.outerHeight(), 30), m.css({height: p + "px"});
                    var t = p == f.outerHeight() ? "none" : "block";
                    m.css({display: t})
                }

                function a() {
                    i(), clearTimeout(h), u == ~~u ? (g = _.allowPageScroll, d != u && f.trigger("slimscroll", 0 == ~~u ? "top" : "bottom")) : g = !1, d = u, p >= f.outerHeight() ? g = !0 : (m.stop(!0, !0).fadeIn("fast"), _.railVisible && y.stop(!0, !0).fadeIn("fast"))
                }

                function n() {
                    _.alwaysVisible || (h = setTimeout(function () {
                        _.disableFadeOut && r || o || l || (m.fadeOut("slow"), y.fadeOut("slow"))
                    }, 1e3))
                }

                var r, o, l, h, c, p, u, d, g = !1, f = w(this);
                if (f.parent().hasClass(_.wrapperClass)) {
                    var v = f.scrollTop(), m = f.siblings("." + _.barClass), y = f.siblings("." + _.railClass);
                    if (i(), w.isPlainObject(x)) {
                        if ("height" in x && "auto" == x.height) {
                            f.parent().css("height", "auto"), f.css("height", "auto");
                            var b = f.parent().parent().height();
                            f.parent().css("height", b), f.css("height", b)
                        } else "height" in x && (b = x.height, f.parent().css("height", b), f.css("height", b));
                        if ("scrollTo" in x) v = parseInt(_.scrollTo); else if ("scrollBy" in x) v += parseInt(_.scrollBy); else if ("destroy" in x) return m.remove(), y.remove(), void f.unwrap();
                        s(v, !1, !0)
                    }
                } else if (!(w.isPlainObject(x) && "destroy" in x)) {
                    _.height = "auto" == _.height ? f.parent().height() : _.height, v = w("<div></div>").addClass(_.wrapperClass).css({
                        position: "relative",
                        overflow: "hidden",
                        width: _.width,
                        height: _.height
                    }), f.css({overflow: "hidden", width: _.width, height: _.height});
                    y = w("<div></div>").addClass(_.railClass).css({
                        width: _.size,
                        height: "100%",
                        position: "absolute",
                        top: 0,
                        display: _.alwaysVisible && _.railVisible ? "block" : "none",
                        "border-radius": _.railBorderRadius,
                        background: _.railColor,
                        opacity: _.railOpacity,
                        zIndex: 90
                    }), m = w("<div></div>").addClass(_.barClass).css({
                        background: _.color,
                        width: _.size,
                        position: "absolute",
                        top: 0,
                        opacity: _.opacity,
                        display: _.alwaysVisible ? "block" : "none",
                        "border-radius": _.borderRadius,
                        BorderRadius: _.borderRadius,
                        MozBorderRadius: _.borderRadius,
                        WebkitBorderRadius: _.borderRadius,
                        zIndex: 99
                    }), b = "right" == _.position ? {right: _.distance} : {left: _.distance};
                    y.css(b), m.css(b), f.wrap(v), f.parent().append(m), f.parent().append(y), _.railDraggable && m.bind("mousedown", function (e) {
                        var i = w(document);
                        return l = !0, t = parseFloat(m.css("top")), pageY = e.pageY, i.bind("mousemove.slimscroll", function (e) {
                            currTop = t + e.pageY - pageY, m.css("top", currTop), s(0, m.position().top, !1)
                        }), i.bind("mouseup.slimscroll", function (t) {
                            l = !1, n(), i.unbind(".slimscroll")
                        }), !1
                    }).bind("selectstart.slimscroll", function (t) {
                        return t.stopPropagation(), t.preventDefault(), !1
                    }), y.hover(function () {
                        a()
                    }, function () {
                        n()
                    }), m.hover(function () {
                        o = !0
                    }, function () {
                        o = !1
                    }), f.hover(function () {
                        r = !0, a(), n()
                    }, function () {
                        r = !1, n()
                    }), f.bind("touchstart", function (t, e) {
                        t.originalEvent.touches.length && (c = t.originalEvent.touches[0].pageY)
                    }), f.bind("touchmove", function (t) {
                        g || t.originalEvent.preventDefault(), t.originalEvent.touches.length && (s((c - t.originalEvent.touches[0].pageY) / _.touchScrollStep, !0), c = t.originalEvent.touches[0].pageY)
                    }), i(), "bottom" === _.start ? (m.css({top: f.outerHeight() - m.outerHeight()}), s(0, !0)) : "top" !== _.start && (s(w(_.start).position().top, null, !0), _.alwaysVisible || m.hide()), window.addEventListener ? (this.addEventListener("DOMMouseScroll", e, !1), this.addEventListener("mousewheel", e, !1)) : document.attachEvent("onmousewheel", e)
                }
            }), this
        }
    }), w.fn.extend({slimscroll: w.fn.slimScroll})
}(jQuery), function (a) {
    "use strict";
    var n = function (t, e) {
        this.$element = a(t), this.options = a.extend({}, n.defaults, e)
    };
    n.defaults = {
        transition_delay: 300,
        refresh_speed: 50,
        display_text: "none",
        use_percentage: !0,
        percent_format: function (t) {
            return t + "%"
        },
        amount_format: function (t, e) {
            return t + " / " + e
        },
        update: a.noop,
        done: a.noop,
        fail: a.noop
    }, n.prototype.transition = function () {
        var r = this.$element, o = r.parent(), l = this.$back_text, h = this.$front_text, c = this.options,
            p = parseInt(r.attr("data-transitiongoal")), u = parseInt(r.attr("aria-valuemin")) || 0,
            d = parseInt(r.attr("aria-valuemax")) || 100, g = o.hasClass("vertical"),
            f = c.update && "function" == typeof c.update ? c.update : n.defaults.update,
            v = c.done && "function" == typeof c.done ? c.done : n.defaults.done,
            t = c.fail && "function" == typeof c.fail ? c.fail : n.defaults.fail;
        if (isNaN(p)) t("data-transitiongoal not set"); else {
            var e, m = Math.round(100 * (p - u) / (d - u));
            if ("center" === c.display_text && !l && !h) this.$back_text = l = a("<span>").addClass("progressbar-back-text").prependTo(o), this.$front_text = h = a("<span>").addClass("progressbar-front-text").prependTo(r), g ? (e = o.css("height"), l.css({
                height: e,
                "line-height": e
            }), h.css({height: e, "line-height": e}), a(window).resize(function () {
                e = o.css("height"), l.css({height: e, "line-height": e}), h.css({height: e, "line-height": e})
            })) : (e = o.css("width"), h.css({width: e}), a(window).resize(function () {
                e = o.css("width"), h.css({width: e})
            }));
            setTimeout(function () {
                var t, e, i, s, a;
                g ? r.css("height", m + "%") : r.css("width", m + "%");
                var n = setInterval(function () {
                    g ? (i = r.height(), s = o.height()) : (i = r.width(), s = o.width()), t = Math.round(100 * i / s), e = Math.round(u + i / s * (d - u)), m <= t && (t = m, e = p, v(r), clearInterval(n)), "none" !== c.display_text && (a = c.use_percentage ? c.percent_format(t) : c.amount_format(e, d, u), "fill" === c.display_text ? r.text(a) : "center" === c.display_text && (l.text(a), h.text(a))), r.attr("aria-valuenow", e), f(t, r)
                }, c.refresh_speed)
            }, c.transition_delay)
        }
    };
    var t = a.fn.progressbar;
    a.fn.progressbar = function (s) {
        return this.each(function () {
            var t = a(this), e = t.data("bs.progressbar"), i = "object" == typeof s && s;
            e && i && a.extend(e.options, i), e || t.data("bs.progressbar", e = new n(this, i)), e.transition()
        })
    }, a.fn.progressbar.Constructor = n, a.fn.progressbar.noConflict = function () {
        return a.fn.progressbar = t, this
    }
}(window.jQuery), function (k, B, N) {
    var t;
    t = function (z) {
        "use strict";
        var t, e, m, E, x, F, W, L, c, w, i, n, p, D, u, s, a, A, O, o, r, l, h, _, d, g, f, v, y, b = {}, C = 0;
        t = function () {
            return {
                common: {
                    type: "line",
                    lineColor: "#00f",
                    fillColor: "#cdf",
                    defaultPixelsPerValue: 3,
                    width: "auto",
                    height: "auto",
                    composite: !1,
                    tagValuesAttribute: "values",
                    tagOptionsPrefix: "spark",
                    enableTagOptions: !1,
                    enableHighlight: !0,
                    highlightLighten: 1.4,
                    tooltipSkipNull: !0,
                    tooltipPrefix: "",
                    tooltipSuffix: "",
                    disableHiddenCheck: !1,
                    numberFormatter: !1,
                    numberDigitGroupCount: 3,
                    numberDigitGroupSep: ",",
                    numberDecimalMark: ".",
                    disableTooltips: !1,
                    disableInteraction: !1
                },
                line: {
                    spotColor: "#f80",
                    highlightSpotColor: "#5f5",
                    highlightLineColor: "#f22",
                    spotRadius: 1.5,
                    minSpotColor: "#f80",
                    maxSpotColor: "#f80",
                    lineWidth: 1,
                    normalRangeMin: N,
                    normalRangeMax: N,
                    normalRangeColor: "#ccc",
                    drawNormalOnTop: !1,
                    chartRangeMin: N,
                    chartRangeMax: N,
                    chartRangeMinX: N,
                    chartRangeMaxX: N,
                    tooltipFormat: new m('<span style="color: {{color}}">&#9679;</span> {{prefix}}{{y}}{{suffix}}')
                },
                bar: {
                    barColor: "#3366cc",
                    negBarColor: "#f44",
                    stackedBarColor: ["#3366cc", "#dc3912", "#ff9900", "#109618", "#66aa00", "#dd4477", "#0099c6", "#990099"],
                    zeroColor: N,
                    nullColor: N,
                    zeroAxis: !0,
                    barWidth: 4,
                    barSpacing: 1,
                    chartRangeMax: N,
                    chartRangeMin: N,
                    chartRangeClip: !1,
                    colorMap: N,
                    tooltipFormat: new m('<span style="color: {{color}}">&#9679;</span> {{prefix}}{{value}}{{suffix}}')
                },
                tristate: {
                    barWidth: 4,
                    barSpacing: 1,
                    posBarColor: "#6f6",
                    negBarColor: "#f44",
                    zeroBarColor: "#999",
                    colorMap: {},
                    tooltipFormat: new m('<span style="color: {{color}}">&#9679;</span> {{value:map}}'),
                    tooltipValueLookups: {map: {"-1": "Loss", 0: "Draw", 1: "Win"}}
                },
                discrete: {
                    lineHeight: "auto",
                    thresholdColor: N,
                    thresholdValue: 0,
                    chartRangeMax: N,
                    chartRangeMin: N,
                    chartRangeClip: !1,
                    tooltipFormat: new m("{{prefix}}{{value}}{{suffix}}")
                },
                bullet: {
                    targetColor: "#f33",
                    targetWidth: 3,
                    performanceColor: "#33f",
                    rangeColors: ["#d3dafe", "#a8b6ff", "#7f94ff"],
                    base: N,
                    tooltipFormat: new m("{{fieldkey:fields}} - {{value}}"),
                    tooltipValueLookups: {fields: {r: "Range", p: "Performance", t: "Target"}}
                },
                pie: {
                    offset: 0,
                    sliceColors: ["#3366cc", "#dc3912", "#ff9900", "#109618", "#66aa00", "#dd4477", "#0099c6", "#990099"],
                    borderWidth: 0,
                    borderColor: "#000",
                    tooltipFormat: new m('<span style="color: {{color}}">&#9679;</span> {{value}} ({{percent.1}}%)')
                },
                box: {
                    raw: !1,
                    boxLineColor: "#000",
                    boxFillColor: "#cdf",
                    whiskerColor: "#000",
                    outlierLineColor: "#333",
                    outlierFillColor: "#fff",
                    medianColor: "#f00",
                    showOutliers: !0,
                    outlierIQR: 1.5,
                    spotRadius: 1.5,
                    target: N,
                    targetColor: "#4a2",
                    chartRangeMax: N,
                    chartRangeMin: N,
                    tooltipFormat: new m("{{field:fields}}: {{value}}"),
                    tooltipFormatFieldlistKey: "field",
                    tooltipValueLookups: {
                        fields: {
                            lq: "Lower Quartile",
                            med: "Median",
                            uq: "Upper Quartile",
                            lo: "Left Outlier",
                            ro: "Right Outlier",
                            lw: "Left Whisker",
                            rw: "Right Whisker"
                        }
                    }
                }
            }
        }, e = function () {
            var t, e;
            return t = function () {
                this.init.apply(this, arguments)
            }, 1 < arguments.length ? (arguments[0] ? (t.prototype = z.extend(new arguments[0], arguments[arguments.length - 1]), t._super = arguments[0].prototype) : t.prototype = arguments[arguments.length - 1], 2 < arguments.length && ((e = Array.prototype.slice.call(arguments, 1, -1)).unshift(t.prototype), z.extend.apply(z, e))) : t.prototype = arguments[0], t.prototype.cls = t
        }, z.SPFormatClass = m = e({
            fre: /\{\{([\w.]+?)(:(.+?))?\}\}/g, precre: /(\w+)\.(\d+)/, init: function (t, e) {
                this.format = t, this.fclass = e
            }, render: function (t, e, i) {
                var s, a, n, r, o, l = this, h = t;
                return this.format.replace(this.fre, function () {
                    return a = arguments[1], n = arguments[3], (s = l.precre.exec(a)) ? (o = s[2], a = s[1]) : o = !1, (r = h[a]) === N ? "" : n && e && e[n] ? e[n].get ? e[n].get(r) || r : e[n][r] || r : (c(r) && (r = i.get("numberFormatter") ? i.get("numberFormatter")(r) : p(r, o, i.get("numberDigitGroupCount"), i.get("numberDigitGroupSep"), i.get("numberDecimalMark"))), r)
                })
            }
        }), z.spformat = function (t, e) {
            return new m(t, e)
        }, E = function (t, e, i) {
            return t < e ? e : i < t ? i : t
        }, x = function (t, e) {
            var i;
            return 2 === e ? (i = B.floor(t.length / 2), t.length % 2 ? t[i] : (t[i - 1] + t[i]) / 2) : t.length % 2 ? (i = (t.length * e + e) / 4) % 1 ? (t[B.floor(i)] + t[B.floor(i) - 1]) / 2 : t[i - 1] : (i = (t.length * e + 2) / 4) % 1 ? (t[B.floor(i)] + t[B.floor(i) - 1]) / 2 : t[i - 1]
        }, F = function (t) {
            var e;
            switch (t) {
                case"undefined":
                    t = N;
                    break;
                case"null":
                    t = null;
                    break;
                case"true":
                    t = !0;
                    break;
                case"false":
                    t = !1;
                    break;
                default:
                    t == (e = parseFloat(t)) && (t = e)
            }
            return t
        }, W = function (t) {
            var e, i = [];
            for (e = t.length; e--;) i[e] = F(t[e]);
            return i
        }, L = function (t, e) {
            var i, s, a = [];
            for (i = 0, s = t.length; i < s; i++) t[i] !== e && a.push(t[i]);
            return a
        }, c = function (t) {
            return !isNaN(parseFloat(t)) && isFinite(t)
        }, p = function (t, e, i, s, a) {
            var n, r;
            for (t = (!1 === e ? parseFloat(t).toString() : t.toFixed(e)).split(""), (n = (n = z.inArray(".", t)) < 0 ? t.length : n) < t.length && (t[n] = a), r = n - i; 0 < r; r -= i) t.splice(r, 0, s);
            return t.join("")
        }, w = function (t, e, i) {
            var s;
            for (s = e.length; s--;) if ((!i || null !== e[s]) && e[s] !== t) return !1;
            return !0
        }, n = function (t) {
            return z.isArray(t) ? t : [t]
        }, i = function (t) {
            var e, i;
            if (k.createStyleSheet) try {
                return void (k.createStyleSheet().cssText = t)
            } catch (t) {
                i = !0
            }
            (e = k.createElement("style")).type = "text/css", k.getElementsByTagName("head")[0].appendChild(e), i ? k.styleSheets[k.styleSheets.length - 1].cssText = t : e["string" == typeof k.body.style.WebkitAppearance ? "innerText" : "innerHTML"] = t
        }, z.fn.simpledraw = function (t, e, i, s) {
            var a, n;
            if (i && (a = this.data("_jqs_vcanvas"))) return a;
            if (!1 === z.fn.sparkline.canvas) return !1;
            if (z.fn.sparkline.canvas === N) {
                var r = k.createElement("canvas");
                if (r.getContext && r.getContext("2d")) z.fn.sparkline.canvas = function (t, e, i, s) {
                    return new f(t, e, i, s)
                }; else {
                    if (!k.namespaces || k.namespaces.v) return z.fn.sparkline.canvas = !1;
                    k.namespaces.add("v", "urn:schemas-microsoft-com:vml", "#default#VML"), z.fn.sparkline.canvas = function (t, e, i, s) {
                        return new v(t, e, i)
                    }
                }
            }
            return t === N && (t = z(this).innerWidth()), e === N && (e = z(this).innerHeight()), a = z.fn.sparkline.canvas(t, e, this, s), (n = z(this).data("_jqs_mhandler")) && n.registerCanvas(a), a
        }, z.fn.cleardraw = function () {
            var t = this.data("_jqs_vcanvas");
            t && t.reset()
        }, z.RangeMapClass = D = e({
            init: function (t) {
                var e, i, s = [];
                for (e in t) t.hasOwnProperty(e) && "string" == typeof e && -1 < e.indexOf(":") && ((i = e.split(":"))[0] = 0 === i[0].length ? -1 / 0 : parseFloat(i[0]), i[1] = 0 === i[1].length ? 1 / 0 : parseFloat(i[1]), i[2] = t[e], s.push(i));
                this.map = t, this.rangelist = s || !1
            }, get: function (t) {
                var e, i, s, a = this.rangelist;
                if ((s = this.map[t]) !== N) return s;
                if (a) for (e = a.length; e--;) if ((i = a[e])[0] <= t && i[1] >= t) return i[2];
                return N
            }
        }), z.range_map = function (t) {
            return new D(t)
        }, u = e({
            init: function (t, e) {
                var i = z(t);
                this.$el = i, this.options = e, this.currentPageX = 0, this.currentPageY = 0, this.el = t, this.splist = [], this.tooltip = null, this.over = !1, this.displayTooltips = !e.get("disableTooltips"), this.highlightEnabled = !e.get("disableHighlight")
            }, registerSparkline: function (t) {
                this.splist.push(t), this.over && this.updateDisplay()
            }, registerCanvas: function (t) {
                var e = z(t.canvas);
                this.canvas = t, (this.$canvas = e).mouseenter(z.proxy(this.mouseenter, this)), e.mouseleave(z.proxy(this.mouseleave, this)), e.click(z.proxy(this.mouseclick, this))
            }, reset: function (t) {
                this.splist = [], this.tooltip && t && (this.tooltip.remove(), this.tooltip = N)
            }, mouseclick: function (t) {
                var e = z.Event("sparklineClick");
                e.originalEvent = t, e.sparklines = this.splist, this.$el.trigger(e)
            }, mouseenter: function (t) {
                z(k.body).unbind("mousemove.jqs"), z(k.body).bind("mousemove.jqs", z.proxy(this.mousemove, this)), this.over = !0, this.currentPageX = t.pageX, this.currentPageY = t.pageY, this.currentEl = t.target, !this.tooltip && this.displayTooltips && (this.tooltip = new s(this.options), this.tooltip.updatePosition(t.pageX, t.pageY)), this.updateDisplay()
            }, mouseleave: function () {
                z(k.body).unbind("mousemove.jqs");
                var t, e = this.splist, i = e.length, s = !1;
                for (this.over = !1, this.currentEl = null, this.tooltip && (this.tooltip.remove(), this.tooltip = null), t = 0; t < i; t++) e[t].clearRegionHighlight() && (s = !0);
                s && this.canvas.render()
            }, mousemove: function (t) {
                this.currentPageX = t.pageX, this.currentPageY = t.pageY, this.currentEl = t.target, this.tooltip && this.tooltip.updatePosition(t.pageX, t.pageY), this.updateDisplay()
            }, updateDisplay: function () {
                var t, e, i, s, a = this.splist, n = a.length, r = !1, o = this.$canvas.offset(),
                    l = this.currentPageX - o.left, h = this.currentPageY - o.top;
                if (this.over) {
                    for (e = 0; e < n; e++) (i = a[e].setRegionHighlight(this.currentEl, l, h)) && (r = !0);
                    if (r) {
                        if ((s = z.Event("sparklineRegionChange")).sparklines = this.splist, this.$el.trigger(s), this.tooltip) {
                            for (t = "", e = 0; e < n; e++) t += a[e].getCurrentRegionTooltip();
                            this.tooltip.setContent(t)
                        }
                        this.disableHighlight || this.canvas.render()
                    }
                    null === i && this.mouseleave()
                }
            }
        }), s = e({
            sizeStyle: "position: static !important;display: block !important;visibility: hidden !important;float: left !important;",
            init: function (t) {
                var e, i = t.get("tooltipClassname", "jqstooltip"), s = this.sizeStyle;
                this.container = t.get("tooltipContainer") || k.body, this.tooltipOffsetX = t.get("tooltipOffsetX", 10), this.tooltipOffsetY = t.get("tooltipOffsetY", 12), z("#jqssizetip").remove(), z("#jqstooltip").remove(), this.sizetip = z("<div/>", {
                    id: "jqssizetip",
                    style: s,
                    class: i
                }), this.tooltip = z("<div/>", {
                    id: "jqstooltip",
                    class: i
                }).appendTo(this.container), e = this.tooltip.offset(), this.offsetLeft = e.left, this.offsetTop = e.top, this.hidden = !0, z(window).unbind("resize.jqs scroll.jqs"), z(window).bind("resize.jqs scroll.jqs", z.proxy(this.updateWindowDims, this)), this.updateWindowDims()
            },
            updateWindowDims: function () {
                this.scrollTop = z(window).scrollTop(), this.scrollLeft = z(window).scrollLeft(), this.scrollRight = this.scrollLeft + z(window).width(), this.updatePosition()
            },
            getSize: function (t) {
                this.sizetip.html(t).appendTo(this.container), this.width = this.sizetip.width() + 1, this.height = this.sizetip.height(), this.sizetip.remove()
            },
            setContent: function (t) {
                if (!t) return this.tooltip.css("visibility", "hidden"), void (this.hidden = !0);
                this.getSize(t), this.tooltip.html(t).css({
                    width: this.width,
                    height: this.height,
                    visibility: "visible"
                }), this.hidden && (this.hidden = !1, this.updatePosition())
            },
            updatePosition: function (t, e) {
                if (t === N) {
                    if (this.mousex === N) return;
                    t = this.mousex - this.offsetLeft, e = this.mousey - this.offsetTop
                } else this.mousex = t -= this.offsetLeft, this.mousey = e -= this.offsetTop;
                this.height && this.width && !this.hidden && (e -= this.height + this.tooltipOffsetY, t += this.tooltipOffsetX, e < this.scrollTop && (e = this.scrollTop), t < this.scrollLeft ? t = this.scrollLeft : t + this.width > this.scrollRight && (t = this.scrollRight - this.width), this.tooltip.css({
                    left: t,
                    top: e
                }))
            },
            remove: function () {
                this.tooltip.remove(), this.sizetip.remove(), this.sizetip = this.tooltip = N, z(window).unbind("resize.jqs scroll.jqs")
            }
        }), z(function () {
            i('.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;box-sizing: content-box;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}')
        }), y = [], z.fn.sparkline = function (h, i) {
            return this.each(function () {
                var t, e, o = new z.fn.sparkline.options(this, i), l = z(this);
                if (t = function () {
                    var t, e, i, s, a, n, r;
                    "html" === h || h === N ? ((r = this.getAttribute(o.get("tagValuesAttribute"))) !== N && null !== r || (r = l.html()), t = r.replace(/(^\s*<!--)|(-->\s*$)|\s+/g, "").split(",")) : t = h, e = "auto" === o.get("width") ? t.length * o.get("defaultPixelsPerValue") : o.get("width"), "auto" === o.get("height") ? o.get("composite") && z.data(this, "_jqs_vcanvas") || ((s = k.createElement("span")).innerHTML = "a", l.html(s), i = z(s).innerHeight() || z(s).height(), z(s).remove(), s = null) : i = o.get("height"), o.get("disableInteraction") ? a = !1 : (a = z.data(this, "_jqs_mhandler")) ? o.get("composite") || a.reset() : (a = new u(this, o), z.data(this, "_jqs_mhandler", a)), !o.get("composite") || z.data(this, "_jqs_vcanvas") ? ((n = new (z.fn.sparkline[o.get("type")])(this, t, o, e, i)).render(), a && a.registerSparkline(n)) : z.data(this, "_jqs_errnotify") || (alert("Attempted to attach a composite sparkline to an element with no existing sparkline"), z.data(this, "_jqs_errnotify", !0))
                }, z(this).html() && !o.get("disableHiddenCheck") && z(this).is(":hidden") || !z(this).parents("body").length) {
                    if (!o.get("composite") && z.data(this, "_jqs_pending")) for (e = y.length; e; e--) y[e - 1][0] == this && y.splice(e - 1, 1);
                    y.push([this, t]), z.data(this, "_jqs_pending", !0)
                } else t.call(this)
            })
        }, z.fn.sparkline.defaults = t(), z.sparkline_display_visible = function () {
            var t, e, i, s = [];
            for (e = 0, i = y.length; e < i; e++) t = y[e][0], z(t).is(":visible") && !z(t).parents().is(":hidden") ? (y[e][1].call(t), z.data(y[e][0], "_jqs_pending", !1), s.push(e)) : z(t).closest("html").length || z.data(t, "_jqs_pending") || (z.data(y[e][0], "_jqs_pending", !1), s.push(e));
            for (e = s.length; e; e--) y.splice(s[e - 1], 1)
        }, z.fn.sparkline.options = e({
            init: function (t, e) {
                var i, s, a, n;
                this.userOptions = e = e || {}, this.tag = t, this.tagValCache = {}, a = (s = z.fn.sparkline.defaults).common, this.tagOptionsPrefix = e.enableTagOptions && (e.tagOptionsPrefix || a.tagOptionsPrefix), i = (n = this.getTagSetting("type")) === b ? s[e.type || a.type] : s[n], this.mergedOptions = z.extend({}, a, i, e)
            }, getTagSetting: function (t) {
                var e, i, s, a, n = this.tagOptionsPrefix;
                if (!1 === n || n === N) return b;
                if (this.tagValCache.hasOwnProperty(t)) e = this.tagValCache.key; else {
                    if ((e = this.tag.getAttribute(n + t)) === N || null === e) e = b; else if ("[" === e.substr(0, 1)) for (i = (e = e.substr(1, e.length - 2).split(",")).length; i--;) e[i] = F(e[i].replace(/(^\s*)|(\s*$)/g, "")); else if ("{" === e.substr(0, 1)) for (s = e.substr(1, e.length - 2).split(","), e = {}, i = s.length; i--;) e[(a = s[i].split(":", 2))[0].replace(/(^\s*)|(\s*$)/g, "")] = F(a[1].replace(/(^\s*)|(\s*$)/g, "")); else e = F(e);
                    this.tagValCache.key = e
                }
                return e
            }, get: function (t, e) {
                var i, s = this.getTagSetting(t);
                return s !== b ? s : (i = this.mergedOptions[t]) === N ? e : i
            }
        }), z.fn.sparkline._base = e({
            disabled: !1, init: function (t, e, i, s, a) {
                this.el = t, this.$el = z(t), this.values = e, this.options = i, this.width = s, this.height = a, this.currentRegion = N
            }, initTarget: function () {
                var t = !this.options.get("disableInteraction");
                (this.target = this.$el.simpledraw(this.width, this.height, this.options.get("composite"), t)) ? (this.canvasWidth = this.target.pixelWidth, this.canvasHeight = this.target.pixelHeight) : this.disabled = !0
            }, render: function () {
                return !this.disabled || (this.el.innerHTML = "", !1)
            }, getRegion: function (t, e) {
            }, setRegionHighlight: function (t, e, i) {
                var s, a = this.currentRegion, n = !this.options.get("disableHighlight");
                return e > this.canvasWidth || i > this.canvasHeight || e < 0 || i < 0 ? null : a !== (s = this.getRegion(t, e, i)) && (a !== N && n && this.removeHighlight(), (this.currentRegion = s) !== N && n && this.renderHighlight(), !0)
            }, clearRegionHighlight: function () {
                return this.currentRegion !== N && (this.removeHighlight(), !(this.currentRegion = N))
            }, renderHighlight: function () {
                this.changeHighlight(!0)
            }, removeHighlight: function () {
                this.changeHighlight(!1)
            }, changeHighlight: function (t) {
            }, getCurrentRegionTooltip: function () {
                var t, e, i, s, a, n, r, o, l, h, c, p, u, d, g = this.options, f = "", v = [];
                if (this.currentRegion === N) return "";
                if (t = this.getCurrentRegionFields(), c = g.get("tooltipFormatter")) return c(this, g, t);
                if (g.get("tooltipChartTitle") && (f += '<div class="jqs jqstitle">' + g.get("tooltipChartTitle") + "</div>\n"), !(e = this.options.get("tooltipFormat"))) return "";
                if (z.isArray(e) || (e = [e]), z.isArray(t) || (t = [t]), r = this.options.get("tooltipFormatFieldlist"), o = this.options.get("tooltipFormatFieldlistKey"), r && o) {
                    for (l = [], n = t.length; n--;) h = t[n][o], -1 != (d = z.inArray(h, r)) && (l[d] = t[n]);
                    t = l
                }
                for (i = e.length, u = t.length, n = 0; n < i; n++) for ("string" == typeof (p = e[n]) && (p = new m(p)), s = p.fclass || "jqsfield", d = 0; d < u; d++) t[d].isNull && g.get("tooltipSkipNull") || (z.extend(t[d], {
                    prefix: g.get("tooltipPrefix"),
                    suffix: g.get("tooltipSuffix")
                }), a = p.render(t[d], g.get("tooltipValueLookups"), g), v.push('<div class="' + s + '">' + a + "</div>"));
                return v.length ? f + v.join("\n") : ""
            }, getCurrentRegionFields: function () {
            }, calcHighlightColor: function (t, e) {
                var i, s, a, n, r = e.get("highlightColor"), o = e.get("highlightLighten");
                if (r) return r;
                if (o && (i = /^#([0-9a-f])([0-9a-f])([0-9a-f])$/i.exec(t) || /^#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i.exec(t))) {
                    for (a = [], s = 4 === t.length ? 16 : 1, n = 0; n < 3; n++) a[n] = E(B.round(parseInt(i[n + 1], 16) * s * o), 0, 255);
                    return "rgb(" + a.join(",") + ")"
                }
                return t
            }
        }), a = {
            changeHighlight: function (t) {
                var e, i = this.currentRegion, s = this.target, a = this.regionShapes[i];
                a && (e = this.renderRegion(i, t), z.isArray(e) || z.isArray(a) ? (s.replaceWithShapes(a, e), this.regionShapes[i] = z.map(e, function (t) {
                    return t.id
                })) : (s.replaceWithShape(a, e), this.regionShapes[i] = e.id))
            }, render: function () {
                var t, e, i, s, a = this.values, n = this.target, r = this.regionShapes;
                if (this.cls._super.render.call(this)) {
                    for (i = a.length; i--;) if (t = this.renderRegion(i)) if (z.isArray(t)) {
                        for (e = [], s = t.length; s--;) t[s].append(), e.push(t[s].id);
                        r[i] = e
                    } else t.append(), r[i] = t.id; else r[i] = null;
                    n.render()
                }
            }
        }, z.fn.sparkline.line = A = e(z.fn.sparkline._base, {
            type: "line", init: function (t, e, i, s, a) {
                A._super.init.call(this, t, e, i, s, a), this.vertices = [], this.regionMap = [], this.xvalues = [], this.yvalues = [], this.yminmax = [], this.hightlightSpotId = null, this.lastShapeId = null, this.initTarget()
            }, getRegion: function (t, e, i) {
                var s, a = this.regionMap;
                for (s = a.length; s--;) if (null !== a[s] && e >= a[s][0] && e <= a[s][1]) return a[s][2];
                return N
            }, getCurrentRegionFields: function () {
                var t = this.currentRegion;
                return {
                    isNull: null === this.yvalues[t],
                    x: this.xvalues[t],
                    y: this.yvalues[t],
                    color: this.options.get("lineColor"),
                    fillColor: this.options.get("fillColor"),
                    offset: t
                }
            }, renderHighlight: function () {
                var t, e, i = this.currentRegion, s = this.target, a = this.vertices[i], n = this.options,
                    r = n.get("spotRadius"), o = n.get("highlightSpotColor"), l = n.get("highlightLineColor");
                a && (r && o && (t = s.drawCircle(a[0], a[1], r, N, o), this.highlightSpotId = t.id, s.insertAfterShape(this.lastShapeId, t)), l && (e = s.drawLine(a[0], this.canvasTop, a[0], this.canvasTop + this.canvasHeight, l), this.highlightLineId = e.id, s.insertAfterShape(this.lastShapeId, e)))
            }, removeHighlight: function () {
                var t = this.target;
                this.highlightSpotId && (t.removeShapeId(this.highlightSpotId), this.highlightSpotId = null), this.highlightLineId && (t.removeShapeId(this.highlightLineId), this.highlightLineId = null)
            }, scanValues: function () {
                var t, e, i, s, a, n = this.values, r = n.length, o = this.xvalues, l = this.yvalues, h = this.yminmax;
                for (t = 0; t < r; t++) e = n[t], i = "string" == typeof n[t], s = "object" == typeof n[t] && n[t] instanceof Array, a = i && n[t].split(":"), i && 2 === a.length ? (o.push(Number(a[0])), l.push(Number(a[1])), h.push(Number(a[1]))) : s ? (o.push(e[0]), l.push(e[1]), h.push(e[1])) : (o.push(t), null === n[t] || "null" === n[t] ? l.push(null) : (l.push(Number(e)), h.push(Number(e))));
                this.options.get("xvalues") && (o = this.options.get("xvalues")), this.maxy = this.maxyorg = B.max.apply(B, h), this.miny = this.minyorg = B.min.apply(B, h), this.maxx = B.max.apply(B, o), this.minx = B.min.apply(B, o), this.xvalues = o, this.yvalues = l, this.yminmax = h
            }, processRangeOptions: function () {
                var t = this.options, e = t.get("normalRangeMin"), i = t.get("normalRangeMax");
                e !== N && (e < this.miny && (this.miny = e), i > this.maxy && (this.maxy = i)), t.get("chartRangeMin") !== N && (t.get("chartRangeClip") || t.get("chartRangeMin") < this.miny) && (this.miny = t.get("chartRangeMin")), t.get("chartRangeMax") !== N && (t.get("chartRangeClip") || t.get("chartRangeMax") > this.maxy) && (this.maxy = t.get("chartRangeMax")), t.get("chartRangeMinX") !== N && (t.get("chartRangeClipX") || t.get("chartRangeMinX") < this.minx) && (this.minx = t.get("chartRangeMinX")), t.get("chartRangeMaxX") !== N && (t.get("chartRangeClipX") || t.get("chartRangeMaxX") > this.maxx) && (this.maxx = t.get("chartRangeMaxX"))
            }, drawNormalRange: function (t, e, i, s, a) {
                var n = this.options.get("normalRangeMin"), r = this.options.get("normalRangeMax"),
                    o = e + B.round(i - i * ((r - this.miny) / a)), l = B.round(i * (r - n) / a);
                this.target.drawRect(t, o, s, l, N, this.options.get("normalRangeColor")).append()
            }, render: function () {
                var t, e, i, s, a, n, r, o, l, h, c, p, u, d, g, f, v, m, y, b, x, _, w, C, k = this.options,
                    S = this.target, R = this.canvasWidth, M = this.canvasHeight, T = this.vertices,
                    I = k.get("spotRadius"), H = this.regionMap;
                if (A._super.render.call(this) && (this.scanValues(), this.processRangeOptions(), _ = this.xvalues, w = this.yvalues, this.yminmax.length && !(this.yvalues.length < 2))) {
                    for (s = a = 0, t = this.maxx - this.minx == 0 ? 1 : this.maxx - this.minx, e = this.maxy - this.miny == 0 ? 1 : this.maxy - this.miny, i = this.yvalues.length - 1, I && (R < 4 * I || M < 4 * I) && (I = 0), I && (((b = k.get("highlightSpotColor") && !k.get("disableInteraction")) || k.get("minSpotColor") || k.get("spotColor") && w[i] === this.miny) && (M -= B.ceil(I)), (b || k.get("maxSpotColor") || k.get("spotColor") && w[i] === this.maxy) && (M -= B.ceil(I), s += B.ceil(I)), (b || (k.get("minSpotColor") || k.get("maxSpotColor")) && (w[0] === this.miny || w[0] === this.maxy)) && (a += B.ceil(I), R -= B.ceil(I)), (b || k.get("spotColor") || k.get("minSpotColor") || k.get("maxSpotColor") && (w[i] === this.miny || w[i] === this.maxy)) && (R -= B.ceil(I))), M--, k.get("normalRangeMin") === N || k.get("drawNormalOnTop") || this.drawNormalRange(a, s, M, R, e), o = [r = []], u = d = null, g = w.length, C = 0; C < g; C++) l = _[C], c = _[C + 1], h = w[C], d = (p = a + B.round((l - this.minx) * (R / t))) + ((C < g - 1 ? a + B.round((c - this.minx) * (R / t)) : R) - p) / 2, H[C] = [u || 0, d, C], u = d, null === h ? C && (null !== w[C - 1] && (r = [], o.push(r)), T.push(null)) : (h < this.miny && (h = this.miny), h > this.maxy && (h = this.maxy), r.length || r.push([p, s + M]), n = [p, s + B.round(M - M * ((h - this.miny) / e))], r.push(n), T.push(n));
                    for (f = [], v = [], m = o.length, C = 0; C < m; C++) (r = o[C]).length && (k.get("fillColor") && (r.push([r[r.length - 1][0], s + M]), v.push(r.slice(0)), r.pop()), 2 < r.length && (r[0] = [r[0][0], r[1][1]]), f.push(r));
                    for (m = v.length, C = 0; C < m; C++) S.drawShape(v[C], k.get("fillColor"), k.get("fillColor")).append();
                    for (k.get("normalRangeMin") !== N && k.get("drawNormalOnTop") && this.drawNormalRange(a, s, M, R, e), m = f.length, C = 0; C < m; C++) S.drawShape(f[C], k.get("lineColor"), N, k.get("lineWidth")).append();
                    if (I && k.get("valueSpots")) for ((y = k.get("valueSpots")).get === N && (y = new D(y)), C = 0; C < g; C++) (x = y.get(w[C])) && S.drawCircle(a + B.round((_[C] - this.minx) * (R / t)), s + B.round(M - M * ((w[C] - this.miny) / e)), I, N, x).append();
                    I && k.get("spotColor") && null !== w[i] && S.drawCircle(a + B.round((_[_.length - 1] - this.minx) * (R / t)), s + B.round(M - M * ((w[i] - this.miny) / e)), I, N, k.get("spotColor")).append(), this.maxy !== this.minyorg && (I && k.get("minSpotColor") && (l = _[z.inArray(this.minyorg, w)], S.drawCircle(a + B.round((l - this.minx) * (R / t)), s + B.round(M - M * ((this.minyorg - this.miny) / e)), I, N, k.get("minSpotColor")).append()), I && k.get("maxSpotColor") && (l = _[z.inArray(this.maxyorg, w)], S.drawCircle(a + B.round((l - this.minx) * (R / t)), s + B.round(M - M * ((this.maxyorg - this.miny) / e)), I, N, k.get("maxSpotColor")).append())), this.lastShapeId = S.getLastShapeId(), this.canvasTop = s, S.render()
                }
            }
        }), z.fn.sparkline.bar = O = e(z.fn.sparkline._base, a, {
            type: "bar", init: function (t, e, i, s, a) {
                var n, r, o, l, h, c, p, u, d, g, f, v, m, y, b, x, _, w, C, k, S, R = parseInt(i.get("barWidth"), 10),
                    M = parseInt(i.get("barSpacing"), 10), T = i.get("chartRangeMin"), I = i.get("chartRangeMax"),
                    H = i.get("chartRangeClip"), A = 1 / 0, P = -1 / 0;
                for (O._super.init.call(this, t, e, i, s, a), c = 0, p = e.length; c < p; c++) ((n = "string" == typeof (k = e[c]) && -1 < k.indexOf(":")) || z.isArray(k)) && (b = !0, n && (k = e[c] = W(k.split(":"))), k = L(k, null), (r = B.min.apply(B, k)) < A && (A = r), P < (o = B.max.apply(B, k)) && (P = o));
                this.stacked = b, this.regionShapes = {}, this.barWidth = R, this.barSpacing = M, this.totalBarWidth = R + M, this.width = s = e.length * R + (e.length - 1) * M, this.initTarget(), H && (m = T === N ? -1 / 0 : T, y = I === N ? 1 / 0 : I), h = [], l = b ? [] : h;
                var q = [], j = [];
                for (c = 0, p = e.length; c < p; c++) if (b) for (x = e[c], e[c] = C = [], q[c] = 0, l[c] = j[c] = 0, _ = 0, w = x.length; _ < w; _++) null !== (k = C[_] = H ? E(x[_], m, y) : x[_]) && (0 < k && (q[c] += k), A < 0 && 0 < P ? k < 0 ? j[c] += B.abs(k) : l[c] += k : l[c] += B.abs(k - (k < 0 ? P : A)), h.push(k)); else k = H ? E(e[c], m, y) : e[c], null !== (k = e[c] = F(k)) && h.push(k);
                this.max = v = B.max.apply(B, h), this.min = f = B.min.apply(B, h), this.stackMax = P = b ? B.max.apply(B, q) : v, this.stackMin = A = b ? B.min.apply(B, h) : f, i.get("chartRangeMin") !== N && (i.get("chartRangeClip") || i.get("chartRangeMin") < f) && (f = i.get("chartRangeMin")), i.get("chartRangeMax") !== N && (i.get("chartRangeClip") || i.get("chartRangeMax") > v) && (v = i.get("chartRangeMax")), this.zeroAxis = d = i.get("zeroAxis", !0), g = f <= 0 && 0 <= v && d ? 0 : 0 == d ? f : 0 < f ? f : v, this.xaxisOffset = g, u = b ? B.max.apply(B, l) + B.max.apply(B, j) : v - f, this.canvasHeightEf = d && f < 0 ? this.canvasHeight - 2 : this.canvasHeight - 1, f < g ? (S = ((b && 0 <= v ? P : v) - g) / u * this.canvasHeight) !== B.ceil(S) && (this.canvasHeightEf -= 2, S = B.ceil(S)) : S = this.canvasHeight, this.yoffset = S, z.isArray(i.get("colorMap")) ? (this.colorMapByIndex = i.get("colorMap"), this.colorMapByValue = null) : (this.colorMapByIndex = null, this.colorMapByValue = i.get("colorMap"), this.colorMapByValue && this.colorMapByValue.get === N && (this.colorMapByValue = new D(this.colorMapByValue))), this.range = u
            }, getRegion: function (t, e, i) {
                var s = B.floor(e / this.totalBarWidth);
                return s < 0 || s >= this.values.length ? N : s
            }, getCurrentRegionFields: function () {
                var t, e, i = this.currentRegion, s = n(this.values[i]), a = [];
                for (e = s.length; e--;) t = s[e], a.push({
                    isNull: null === t,
                    value: t,
                    color: this.calcColor(e, t, i),
                    offset: i
                });
                return a
            }, calcColor: function (t, e, i) {
                var s, a, n = this.colorMapByIndex, r = this.colorMapByValue, o = this.options;
                return s = this.stacked ? o.get("stackedBarColor") : e < 0 ? o.get("negBarColor") : o.get("barColor"), 0 === e && o.get("zeroColor") !== N && (s = o.get("zeroColor")), r && (a = r.get(e)) ? s = a : n && n.length > i && (s = n[i]), z.isArray(s) ? s[t % s.length] : s
            }, renderRegion: function (t, e) {
                var i, s, a, n, r, o, l, h, c, p, u = this.values[t], d = this.options, g = this.xaxisOffset, f = [],
                    v = this.range, m = this.stacked, y = this.target, b = t * this.totalBarWidth,
                    x = this.canvasHeightEf, _ = this.yoffset;
                if (l = (u = z.isArray(u) ? u : [u]).length, h = u[0], n = w(null, u), p = w(g, u, !0), n) return d.get("nullColor") ? (a = e ? d.get("nullColor") : this.calcHighlightColor(d.get("nullColor"), d), i = 0 < _ ? _ - 1 : _, y.drawRect(b, i, this.barWidth - 1, 0, a, a)) : N;
                for (r = _, o = 0; o < l; o++) {
                    if (h = u[o], m && h === g) {
                        if (!p || c) continue;
                        c = !0
                    }
                    s = 0 < v ? B.floor(x * (B.abs(h - g) / v)) + 1 : 1, h < g || h === g && 0 === _ ? (i = r, r += s) : (i = _ - s, _ -= s), a = this.calcColor(o, h, t), e && (a = this.calcHighlightColor(a, d)), f.push(y.drawRect(b, i, this.barWidth - 1, s - 1, a, a))
                }
                return 1 === f.length ? f[0] : f
            }
        }), z.fn.sparkline.tristate = o = e(z.fn.sparkline._base, a, {
            type: "tristate", init: function (t, e, i, s, a) {
                var n = parseInt(i.get("barWidth"), 10), r = parseInt(i.get("barSpacing"), 10);
                o._super.init.call(this, t, e, i, s, a), this.regionShapes = {}, this.barWidth = n, this.barSpacing = r, this.totalBarWidth = n + r, this.values = z.map(e, Number), this.width = s = e.length * n + (e.length - 1) * r, z.isArray(i.get("colorMap")) ? (this.colorMapByIndex = i.get("colorMap"), this.colorMapByValue = null) : (this.colorMapByIndex = null, this.colorMapByValue = i.get("colorMap"), this.colorMapByValue && this.colorMapByValue.get === N && (this.colorMapByValue = new D(this.colorMapByValue))), this.initTarget()
            }, getRegion: function (t, e, i) {
                return B.floor(e / this.totalBarWidth)
            }, getCurrentRegionFields: function () {
                var t = this.currentRegion;
                return {
                    isNull: this.values[t] === N,
                    value: this.values[t],
                    color: this.calcColor(this.values[t], t),
                    offset: t
                }
            }, calcColor: function (t, e) {
                var i, s = this.values, a = this.options, n = this.colorMapByIndex, r = this.colorMapByValue;
                return r && (i = r.get(t)) ? i : n && n.length > e ? n[e] : s[e] < 0 ? a.get("negBarColor") : 0 < s[e] ? a.get("posBarColor") : a.get("zeroBarColor")
            }, renderRegion: function (t, e) {
                var i, s, a, n, r, o, l = this.values, h = this.options, c = this.target;
                if (i = c.pixelHeight, a = B.round(i / 2), n = t * this.totalBarWidth, l[t] < 0 ? s = (r = a) - 1 : 0 < l[t] ? (r = 0, s = a - 1) : (r = a - 1, s = 2), null !== (o = this.calcColor(l[t], t))) return e && (o = this.calcHighlightColor(o, h)), c.drawRect(n, r, this.barWidth - 1, s - 1, o, o)
            }
        }), z.fn.sparkline.discrete = r = e(z.fn.sparkline._base, a, {
            type: "discrete", init: function (t, e, i, s, a) {
                r._super.init.call(this, t, e, i, s, a), this.regionShapes = {}, this.values = e = z.map(e, Number), this.min = B.min.apply(B, e), this.max = B.max.apply(B, e), this.range = this.max - this.min, this.width = s = "auto" === i.get("width") ? 2 * e.length : this.width, this.interval = B.floor(s / e.length), this.itemWidth = s / e.length, i.get("chartRangeMin") !== N && (i.get("chartRangeClip") || i.get("chartRangeMin") < this.min) && (this.min = i.get("chartRangeMin")), i.get("chartRangeMax") !== N && (i.get("chartRangeClip") || i.get("chartRangeMax") > this.max) && (this.max = i.get("chartRangeMax")), this.initTarget(), this.target && (this.lineHeight = "auto" === i.get("lineHeight") ? B.round(.3 * this.canvasHeight) : i.get("lineHeight"))
            }, getRegion: function (t, e, i) {
                return B.floor(e / this.itemWidth)
            }, getCurrentRegionFields: function () {
                var t = this.currentRegion;
                return {isNull: this.values[t] === N, value: this.values[t], offset: t}
            }, renderRegion: function (t, e) {
                var i, s, a, n, r = this.values, o = this.options, l = this.min, h = this.max, c = this.range,
                    p = this.interval, u = this.target, d = this.canvasHeight, g = this.lineHeight, f = d - g;
                return s = E(r[t], l, h), n = t * p, i = B.round(f - f * ((s - l) / c)), a = o.get("thresholdColor") && s < o.get("thresholdValue") ? o.get("thresholdColor") : o.get("lineColor"), e && (a = this.calcHighlightColor(a, o)), u.drawLine(n, i, n, i + g, a)
            }
        }), z.fn.sparkline.bullet = l = e(z.fn.sparkline._base, {
            type: "bullet", init: function (t, e, i, s, a) {
                var n, r, o;
                l._super.init.call(this, t, e, i, s, a), this.values = e = W(e), (o = e.slice())[0] = null === o[0] ? o[2] : o[0], o[1] = null === e[1] ? o[2] : o[1], n = B.min.apply(B, e), r = B.max.apply(B, e), n = i.get("base") === N ? n < 0 ? n : 0 : i.get("base"), this.min = n, this.max = r, this.range = r - n, this.shapes = {}, this.valueShapes = {}, this.regiondata = {}, this.width = s = "auto" === i.get("width") ? "4.0em" : s, this.target = this.$el.simpledraw(s, a, i.get("composite")), e.length || (this.disabled = !0), this.initTarget()
            }, getRegion: function (t, e, i) {
                var s = this.target.getShapeAt(t, e, i);
                return s !== N && this.shapes[s] !== N ? this.shapes[s] : N
            }, getCurrentRegionFields: function () {
                var t = this.currentRegion;
                return {fieldkey: t.substr(0, 1), value: this.values[t.substr(1)], region: t}
            }, changeHighlight: function (t) {
                var e, i = this.currentRegion, s = this.valueShapes[i];
                switch (delete this.shapes[s], i.substr(0, 1)) {
                    case"r":
                        e = this.renderRange(i.substr(1), t);
                        break;
                    case"p":
                        e = this.renderPerformance(t);
                        break;
                    case"t":
                        e = this.renderTarget(t)
                }
                this.valueShapes[i] = e.id, this.shapes[e.id] = i, this.target.replaceWithShape(s, e)
            }, renderRange: function (t, e) {
                var i = this.values[t], s = B.round(this.canvasWidth * ((i - this.min) / this.range)),
                    a = this.options.get("rangeColors")[t - 2];
                return e && (a = this.calcHighlightColor(a, this.options)), this.target.drawRect(0, 0, s - 1, this.canvasHeight - 1, a, a)
            }, renderPerformance: function (t) {
                var e = this.values[1], i = B.round(this.canvasWidth * ((e - this.min) / this.range)),
                    s = this.options.get("performanceColor");
                return t && (s = this.calcHighlightColor(s, this.options)), this.target.drawRect(0, B.round(.3 * this.canvasHeight), i - 1, B.round(.4 * this.canvasHeight) - 1, s, s)
            }, renderTarget: function (t) {
                var e = this.values[0],
                    i = B.round(this.canvasWidth * ((e - this.min) / this.range) - this.options.get("targetWidth") / 2),
                    s = B.round(.1 * this.canvasHeight), a = this.canvasHeight - 2 * s,
                    n = this.options.get("targetColor");
                return t && (n = this.calcHighlightColor(n, this.options)), this.target.drawRect(i, s, this.options.get("targetWidth") - 1, a - 1, n, n)
            }, render: function () {
                var t, e, i = this.values.length, s = this.target;
                if (l._super.render.call(this)) {
                    for (t = 2; t < i; t++) e = this.renderRange(t).append(), this.shapes[e.id] = "r" + t, this.valueShapes["r" + t] = e.id;
                    null !== this.values[1] && (e = this.renderPerformance().append(), this.shapes[e.id] = "p1", this.valueShapes.p1 = e.id), null !== this.values[0] && (e = this.renderTarget().append(), this.shapes[e.id] = "t0", this.valueShapes.t0 = e.id), s.render()
                }
            }
        }), z.fn.sparkline.pie = h = e(z.fn.sparkline._base, {
            type: "pie", init: function (t, e, i, s, a) {
                var n, r = 0;
                if (h._super.init.call(this, t, e, i, s, a), this.shapes = {}, this.valueShapes = {}, this.values = e = z.map(e, Number), "auto" === i.get("width") && (this.width = this.height), 0 < e.length) for (n = e.length; n--;) r += e[n];
                this.total = r, this.initTarget(), this.radius = B.floor(B.min(this.canvasWidth, this.canvasHeight) / 2)
            }, getRegion: function (t, e, i) {
                var s = this.target.getShapeAt(t, e, i);
                return s !== N && this.shapes[s] !== N ? this.shapes[s] : N
            }, getCurrentRegionFields: function () {
                var t = this.currentRegion;
                return {
                    isNull: this.values[t] === N,
                    value: this.values[t],
                    percent: this.values[t] / this.total * 100,
                    color: this.options.get("sliceColors")[t % this.options.get("sliceColors").length],
                    offset: t
                }
            }, changeHighlight: function (t) {
                var e = this.currentRegion, i = this.renderSlice(e, t), s = this.valueShapes[e];
                delete this.shapes[s], this.target.replaceWithShape(s, i), this.valueShapes[e] = i.id, this.shapes[i.id] = e
            }, renderSlice: function (t, e) {
                var i, s, a, n, r, o = this.target, l = this.options, h = this.radius, c = l.get("borderWidth"),
                    p = l.get("offset"), u = 2 * B.PI, d = this.values, g = this.total,
                    f = p ? 2 * B.PI * (p / 360) : 0;
                for (n = d.length, a = 0; a < n; a++) {
                    if (s = i = f, 0 < g && (s = f + u * (d[a] / g)), t === a) return r = l.get("sliceColors")[a % l.get("sliceColors").length], e && (r = this.calcHighlightColor(r, l)), o.drawPieSlice(h, h, h - c, i, s, N, r);
                    f = s
                }
            }, render: function () {
                var t, e, i = this.target, s = this.values, a = this.options, n = this.radius, r = a.get("borderWidth");
                if (h._super.render.call(this)) {
                    for (r && i.drawCircle(n, n, B.floor(n - r / 2), a.get("borderColor"), N, r).append(), e = s.length; e--;) s[e] && (t = this.renderSlice(e).append(), this.valueShapes[e] = t.id, this.shapes[t.id] = e);
                    i.render()
                }
            }
        }), z.fn.sparkline.box = _ = e(z.fn.sparkline._base, {
            type: "box", init: function (t, e, i, s, a) {
                _._super.init.call(this, t, e, i, s, a), this.values = z.map(e, Number), this.width = "auto" === i.get("width") ? "4.0em" : s, this.initTarget(), this.values.length || (this.disabled = 1)
            }, getRegion: function () {
                return 1
            }, getCurrentRegionFields: function () {
                var t = [{field: "lq", value: this.quartiles[0]}, {
                    field: "med",
                    value: this.quartiles[1]
                }, {field: "uq", value: this.quartiles[2]}];
                return this.loutlier !== N && t.push({
                    field: "lo",
                    value: this.loutlier
                }), this.routlier !== N && t.push({
                    field: "ro",
                    value: this.routlier
                }), this.lwhisker !== N && t.push({
                    field: "lw",
                    value: this.lwhisker
                }), this.rwhisker !== N && t.push({field: "rw", value: this.rwhisker}), t
            }, render: function () {
                var t, e, i, s, a, n, r, o, l, h, c, p = this.target, u = this.values, d = u.length, g = this.options,
                    f = this.canvasWidth, v = this.canvasHeight,
                    m = g.get("chartRangeMin") === N ? B.min.apply(B, u) : g.get("chartRangeMin"),
                    y = g.get("chartRangeMax") === N ? B.max.apply(B, u) : g.get("chartRangeMax"), b = 0;
                if (_._super.render.call(this)) {
                    if (g.get("raw")) g.get("showOutliers") && 5 < u.length ? (e = u[0], t = u[1], s = u[2], a = u[3], n = u[4], r = u[5], o = u[6]) : (t = u[0], s = u[1], a = u[2], n = u[3], r = u[4]); else if (u.sort(function (t, e) {
                        return t - e
                    }), s = x(u, 1), a = x(u, 2), i = (n = x(u, 3)) - s, g.get("showOutliers")) {
                        for (t = r = N, l = 0; l < d; l++) t === N && u[l] > s - i * g.get("outlierIQR") && (t = u[l]), u[l] < n + i * g.get("outlierIQR") && (r = u[l]);
                        e = u[0], o = u[d - 1]
                    } else t = u[0], r = u[d - 1];
                    this.quartiles = [s, a, n], this.lwhisker = t, this.rwhisker = r, this.loutlier = e, this.routlier = o, c = f / (y - m + 1), g.get("showOutliers") && (b = B.ceil(g.get("spotRadius")), c = (f -= 2 * B.ceil(g.get("spotRadius"))) / (y - m + 1), e < t && p.drawCircle((e - m) * c + b, v / 2, g.get("spotRadius"), g.get("outlierLineColor"), g.get("outlierFillColor")).append(), r < o && p.drawCircle((o - m) * c + b, v / 2, g.get("spotRadius"), g.get("outlierLineColor"), g.get("outlierFillColor")).append()), p.drawRect(B.round((s - m) * c + b), B.round(.1 * v), B.round((n - s) * c), B.round(.8 * v), g.get("boxLineColor"), g.get("boxFillColor")).append(), p.drawLine(B.round((t - m) * c + b), B.round(v / 2), B.round((s - m) * c + b), B.round(v / 2), g.get("lineColor")).append(), p.drawLine(B.round((t - m) * c + b), B.round(v / 4), B.round((t - m) * c + b), B.round(v - v / 4), g.get("whiskerColor")).append(), p.drawLine(B.round((r - m) * c + b), B.round(v / 2), B.round((n - m) * c + b), B.round(v / 2), g.get("lineColor")).append(), p.drawLine(B.round((r - m) * c + b), B.round(v / 4), B.round((r - m) * c + b), B.round(v - v / 4), g.get("whiskerColor")).append(), p.drawLine(B.round((a - m) * c + b), B.round(.1 * v), B.round((a - m) * c + b), B.round(.9 * v), g.get("medianColor")).append(), g.get("target") && (h = B.ceil(g.get("spotRadius")), p.drawLine(B.round((g.get("target") - m) * c + b), B.round(v / 2 - h), B.round((g.get("target") - m) * c + b), B.round(v / 2 + h), g.get("targetColor")).append(), p.drawLine(B.round((g.get("target") - m) * c + b - h), B.round(v / 2), B.round((g.get("target") - m) * c + b + h), B.round(v / 2), g.get("targetColor")).append()), p.render()
                }
            }
        }), d = e({
            init: function (t, e, i, s) {
                this.target = t, this.id = e, this.type = i, this.args = s
            }, append: function () {
                return this.target.appendShape(this), this
            }
        }), g = e({
            _pxregex: /(\d+)(px)?\s*$/i, init: function (t, e, i) {
                t && (this.width = t, this.height = e, this.target = i, this.lastShapeId = null, i[0] && (i = i[0]), z.data(i, "_jqs_vcanvas", this))
            }, drawLine: function (t, e, i, s, a, n) {
                return this.drawShape([[t, e], [i, s]], a, n)
            }, drawShape: function (t, e, i, s) {
                return this._genShape("Shape", [t, e, i, s])
            }, drawCircle: function (t, e, i, s, a, n) {
                return this._genShape("Circle", [t, e, i, s, a, n])
            }, drawPieSlice: function (t, e, i, s, a, n, r) {
                return this._genShape("PieSlice", [t, e, i, s, a, n, r])
            }, drawRect: function (t, e, i, s, a, n) {
                return this._genShape("Rect", [t, e, i, s, a, n])
            }, getElement: function () {
                return this.canvas
            }, getLastShapeId: function () {
                return this.lastShapeId
            }, reset: function () {
                alert("reset not implemented")
            }, _insert: function (t, e) {
                z(e).html(t)
            }, _calculatePixelDims: function (t, e, i) {
                var s;
                s = this._pxregex.exec(e), this.pixelHeight = s ? s[1] : z(i).height(), s = this._pxregex.exec(t), this.pixelWidth = s ? s[1] : z(i).width()
            }, _genShape: function (t, e) {
                var i = C++;
                return e.unshift(i), new d(this, i, t, e)
            }, appendShape: function (t) {
                alert("appendShape not implemented")
            }, replaceWithShape: function (t, e) {
                alert("replaceWithShape not implemented")
            }, insertAfterShape: function (t, e) {
                alert("insertAfterShape not implemented")
            }, removeShapeId: function (t) {
                alert("removeShapeId not implemented")
            }, getShapeAt: function (t, e, i) {
                alert("getShapeAt not implemented")
            }, render: function () {
                alert("render not implemented")
            }
        }), f = e(g, {
            init: function (t, e, i, s) {
                f._super.init.call(this, t, e, i), this.canvas = k.createElement("canvas"), i[0] && (i = i[0]), z.data(i, "_jqs_vcanvas", this), z(this.canvas).css({
                    display: "inline-block",
                    width: t,
                    height: e,
                    verticalAlign: "top"
                }), this._insert(this.canvas, i), this._calculatePixelDims(t, e, this.canvas), this.canvas.width = this.pixelWidth, this.canvas.height = this.pixelHeight, this.interact = s, this.shapes = {}, this.shapeseq = [], this.currentTargetShapeId = N, z(this.canvas).css({
                    width: this.pixelWidth,
                    height: this.pixelHeight
                })
            }, _getContext: function (t, e, i) {
                var s = this.canvas.getContext("2d");
                return t !== N && (s.strokeStyle = t), s.lineWidth = i === N ? 1 : i, e !== N && (s.fillStyle = e), s
            }, reset: function () {
                this._getContext().clearRect(0, 0, this.pixelWidth, this.pixelHeight), this.shapes = {}, this.shapeseq = [], this.currentTargetShapeId = N
            }, _drawShape: function (t, e, i, s, a) {
                var n, r, o = this._getContext(i, s, a);
                for (o.beginPath(), o.moveTo(e[0][0] + .5, e[0][1] + .5), n = 1, r = e.length; n < r; n++) o.lineTo(e[n][0] + .5, e[n][1] + .5);
                i !== N && o.stroke(), s !== N && o.fill(), this.targetX !== N && this.targetY !== N && o.isPointInPath(this.targetX, this.targetY) && (this.currentTargetShapeId = t)
            }, _drawCircle: function (t, e, i, s, a, n, r) {
                var o = this._getContext(a, n, r);
                o.beginPath(), o.arc(e, i, s, 0, 2 * B.PI, !1), this.targetX !== N && this.targetY !== N && o.isPointInPath(this.targetX, this.targetY) && (this.currentTargetShapeId = t), a !== N && o.stroke(), n !== N && o.fill()
            }, _drawPieSlice: function (t, e, i, s, a, n, r, o) {
                var l = this._getContext(r, o);
                l.beginPath(), l.moveTo(e, i), l.arc(e, i, s, a, n, !1), l.lineTo(e, i), l.closePath(), r !== N && l.stroke(), o && l.fill(), this.targetX !== N && this.targetY !== N && l.isPointInPath(this.targetX, this.targetY) && (this.currentTargetShapeId = t)
            }, _drawRect: function (t, e, i, s, a, n, r) {
                return this._drawShape(t, [[e, i], [e + s, i], [e + s, i + a], [e, i + a], [e, i]], n, r)
            }, appendShape: function (t) {
                return this.shapes[t.id] = t, this.shapeseq.push(t.id), this.lastShapeId = t.id, t.id
            }, replaceWithShape: function (t, e) {
                var i, s = this.shapeseq;
                for (this.shapes[e.id] = e, i = s.length; i--;) s[i] == t && (s[i] = e.id);
                delete this.shapes[t]
            }, replaceWithShapes: function (t, e) {
                var i, s, a, n = this.shapeseq, r = {};
                for (s = t.length; s--;) r[t[s]] = !0;
                for (s = n.length; s--;) r[i = n[s]] && (n.splice(s, 1), delete this.shapes[i], a = s);
                for (s = e.length; s--;) n.splice(a, 0, e[s].id), this.shapes[e[s].id] = e[s]
            }, insertAfterShape: function (t, e) {
                var i, s = this.shapeseq;
                for (i = s.length; i--;) if (s[i] === t) return s.splice(i + 1, 0, e.id), void (this.shapes[e.id] = e)
            }, removeShapeId: function (t) {
                var e, i = this.shapeseq;
                for (e = i.length; e--;) if (i[e] === t) {
                    i.splice(e, 1);
                    break
                }
                delete this.shapes[t]
            }, getShapeAt: function (t, e, i) {
                return this.targetX = e, this.targetY = i, this.render(), this.currentTargetShapeId
            }, render: function () {
                var t, e, i = this.shapeseq, s = this.shapes, a = i.length;
                for (this._getContext().clearRect(0, 0, this.pixelWidth, this.pixelHeight), e = 0; e < a; e++) this["_draw" + (t = s[i[e]]).type].apply(this, t.args);
                this.interact || (this.shapes = {}, this.shapeseq = [])
            }
        }), v = e(g, {
            init: function (t, e, i) {
                var s;
                v._super.init.call(this, t, e, i), i[0] && (i = i[0]), z.data(i, "_jqs_vcanvas", this), this.canvas = k.createElement("span"), z(this.canvas).css({
                    display: "inline-block",
                    position: "relative",
                    overflow: "hidden",
                    width: t,
                    height: e,
                    margin: "0px",
                    padding: "0px",
                    verticalAlign: "top"
                }), this._insert(this.canvas, i), this._calculatePixelDims(t, e, this.canvas), this.canvas.width = this.pixelWidth, this.canvas.height = this.pixelHeight, s = '<v:group coordorigin="0 0" coordsize="' + this.pixelWidth + " " + this.pixelHeight + '" style="position:absolute;top:0;left:0;width:' + this.pixelWidth + "px;height=" + this.pixelHeight + 'px;"></v:group>', this.canvas.insertAdjacentHTML("beforeEnd", s), this.group = z(this.canvas).children()[0], this.rendered = !1, this.prerender = ""
            }, _drawShape: function (t, e, i, s, a) {
                var n, r, o, l, h, c, p = [];
                for (c = 0, h = e.length; c < h; c++) p[c] = e[c][0] + "," + e[c][1];
                return n = p.splice(0, 1), a = a === N ? 1 : a, r = i === N ? ' stroked="false" ' : ' strokeWeight="' + a + 'px" strokeColor="' + i + '" ', o = s === N ? ' filled="false"' : ' fillColor="' + s + '" filled="true" ', l = p[0] === p[p.length - 1] ? "x " : "", '<v:shape coordorigin="0 0" coordsize="' + this.pixelWidth + " " + this.pixelHeight + '"  id="jqsshape' + t + '" ' + r + o + ' style="position:absolute;left:0px;top:0px;height:' + this.pixelHeight + "px;width:" + this.pixelWidth + 'px;padding:0px;margin:0px;"  path="m ' + n + " l " + p.join(", ") + " " + l + 'e"> </v:shape>'
            }, _drawCircle: function (t, e, i, s, a, n, r) {
                return '<v:oval  id="jqsshape' + t + '" ' + (a === N ? ' stroked="false" ' : ' strokeWeight="' + r + 'px" strokeColor="' + a + '" ') + (n === N ? ' filled="false"' : ' fillColor="' + n + '" filled="true" ') + ' style="position:absolute;top:' + (i -= s) + "px; left:" + (e -= s) + "px; width:" + 2 * s + "px; height:" + 2 * s + 'px"></v:oval>'
            }, _drawPieSlice: function (t, e, i, s, a, n, r, o) {
                var l, h, c, p, u, d, g;
                if (a === n) return "";
                if (n - a == 2 * B.PI && (a = 0, n = 2 * B.PI), h = e + B.round(B.cos(a) * s), c = i + B.round(B.sin(a) * s), p = e + B.round(B.cos(n) * s), u = i + B.round(B.sin(n) * s), h === p && c === u) {
                    if (n - a < B.PI) return "";
                    h = p = e + s, c = u = i
                }
                return h === p && c === u && n - a < B.PI ? "" : (l = [e - s, i - s, e + s, i + s, h, c, p, u], d = r === N ? ' stroked="false" ' : ' strokeWeight="1px" strokeColor="' + r + '" ', g = o === N ? ' filled="false"' : ' fillColor="' + o + '" filled="true" ', '<v:shape coordorigin="0 0" coordsize="' + this.pixelWidth + " " + this.pixelHeight + '"  id="jqsshape' + t + '" ' + d + g + ' style="position:absolute;left:0px;top:0px;height:' + this.pixelHeight + "px;width:" + this.pixelWidth + 'px;padding:0px;margin:0px;"  path="m ' + e + "," + i + " wa " + l.join(", ") + ' x e"> </v:shape>')
            }, _drawRect: function (t, e, i, s, a, n, r) {
                return this._drawShape(t, [[e, i], [e, i + a], [e + s, i + a], [e + s, i], [e, i]], n, r)
            }, reset: function () {
                this.group.innerHTML = ""
            }, appendShape: function (t) {
                var e = this["_draw" + t.type].apply(this, t.args);
                return this.rendered ? this.group.insertAdjacentHTML("beforeEnd", e) : this.prerender += e, this.lastShapeId = t.id, t.id
            }, replaceWithShape: function (t, e) {
                var i = z("#jqsshape" + t), s = this["_draw" + e.type].apply(this, e.args);
                i[0].outerHTML = s
            }, replaceWithShapes: function (t, e) {
                var i, s = z("#jqsshape" + t[0]), a = "", n = e.length;
                for (i = 0; i < n; i++) a += this["_draw" + e[i].type].apply(this, e[i].args);
                for (s[0].outerHTML = a, i = 1; i < t.length; i++) z("#jqsshape" + t[i]).remove()
            }, insertAfterShape: function (t, e) {
                var i = z("#jqsshape" + t), s = this["_draw" + e.type].apply(this, e.args);
                i[0].insertAdjacentHTML("afterEnd", s)
            }, removeShapeId: function (t) {
                var e = z("#jqsshape" + t);
                this.group.removeChild(e[0])
            }, getShapeAt: function (t, e, i) {
                return t.id.substr(8)
            }, render: function () {
                this.rendered || (this.group.innerHTML = this.prerender, this.rendered = !0)
            }
        })
    }, "function" == typeof define && define.amd ? define(["jquery"], t) : jQuery && !jQuery.fn.sparkline && t(jQuery)
}(document, Math);
var pJS = function (t, e) {
    var i = document.querySelector("#" + t + " > .particles-js-canvas-el");
    this.pJS = {
        canvas: {el: i, w: i.offsetWidth, h: i.offsetHeight},
        particles: {
            number: {value: 400, density: {enable: !0, value_area: 800}},
            color: {value: "#fff"},
            shape: {
                type: "circle",
                stroke: {width: 0, color: "#ff0000"},
                polygon: {nb_sides: 5},
                image: {src: "", width: 100, height: 100}
            },
            opacity: {value: 1, random: !1, anim: {enable: !1, speed: 2, opacity_min: 0, sync: !1}},
            size: {value: 20, random: !1, anim: {enable: !1, speed: 20, size_min: 0, sync: !1}},
            line_linked: {enable: !0, distance: 100, color: "#fff", opacity: 1, width: 1},
            move: {
                enable: !0,
                speed: 2,
                direction: "none",
                random: !1,
                straight: !1,
                out_mode: "out",
                bounce: !1,
                attract: {enable: !1, rotateX: 3e3, rotateY: 3e3}
            },
            array: []
        },
        interactivity: {
            detect_on: "canvas",
            events: {onhover: {enable: !0, mode: "grab"}, onclick: {enable: !0, mode: "push"}, resize: !0},
            modes: {
                grab: {distance: 100, line_linked: {opacity: 1}},
                bubble: {distance: 200, size: 80, duration: .4},
                repulse: {distance: 200, duration: .4},
                push: {particles_nb: 4},
                remove: {particles_nb: 2}
            },
            mouse: {}
        },
        retina_detect: !1,
        fn: {interact: {}, modes: {}, vendors: {}},
        tmp: {}
    };
    var d = this.pJS;
    e && Object.deepExtend(d, e), d.tmp.obj = {
        size_value: d.particles.size.value,
        size_anim_speed: d.particles.size.anim.speed,
        move_speed: d.particles.move.speed,
        line_linked_distance: d.particles.line_linked.distance,
        line_linked_width: d.particles.line_linked.width,
        mode_grab_distance: d.interactivity.modes.grab.distance,
        mode_bubble_distance: d.interactivity.modes.bubble.distance,
        mode_bubble_size: d.interactivity.modes.bubble.size,
        mode_repulse_distance: d.interactivity.modes.repulse.distance
    }, d.fn.retinaInit = function () {
        d.retina_detect && 1 < window.devicePixelRatio ? (d.canvas.pxratio = window.devicePixelRatio, d.tmp.retina = !0) : (d.canvas.pxratio = 1, d.tmp.retina = !1), d.canvas.w = d.canvas.el.offsetWidth * d.canvas.pxratio, d.canvas.h = d.canvas.el.offsetHeight * d.canvas.pxratio, d.particles.size.value = d.tmp.obj.size_value * d.canvas.pxratio, d.particles.size.anim.speed = d.tmp.obj.size_anim_speed * d.canvas.pxratio, d.particles.move.speed = d.tmp.obj.move_speed * d.canvas.pxratio, d.particles.line_linked.distance = d.tmp.obj.line_linked_distance * d.canvas.pxratio, d.interactivity.modes.grab.distance = d.tmp.obj.mode_grab_distance * d.canvas.pxratio, d.interactivity.modes.bubble.distance = d.tmp.obj.mode_bubble_distance * d.canvas.pxratio, d.particles.line_linked.width = d.tmp.obj.line_linked_width * d.canvas.pxratio, d.interactivity.modes.bubble.size = d.tmp.obj.mode_bubble_size * d.canvas.pxratio, d.interactivity.modes.repulse.distance = d.tmp.obj.mode_repulse_distance * d.canvas.pxratio
    }, d.fn.canvasInit = function () {
        d.canvas.ctx = d.canvas.el.getContext("2d")
    }, d.fn.canvasSize = function () {
        d.canvas.el.width = d.canvas.w, d.canvas.el.height = d.canvas.h, d && d.interactivity.events.resize && window.addEventListener("resize", function () {
            d.canvas.w = d.canvas.el.offsetWidth, d.canvas.h = d.canvas.el.offsetHeight, d.tmp.retina && (d.canvas.w *= d.canvas.pxratio, d.canvas.h *= d.canvas.pxratio), d.canvas.el.width = d.canvas.w, d.canvas.el.height = d.canvas.h, d.particles.move.enable || (d.fn.particlesEmpty(), d.fn.particlesCreate(), d.fn.particlesDraw(), d.fn.vendors.densityAutoParticles()), d.fn.vendors.densityAutoParticles()
        })
    }, d.fn.canvasPaint = function () {
        d.canvas.ctx.fillRect(0, 0, d.canvas.w, d.canvas.h)
    }, d.fn.canvasClear = function () {
        d.canvas.ctx.clearRect(0, 0, d.canvas.w, d.canvas.h)
    }, d.fn.particle = function (t, e, i) {
        if (this.radius = (d.particles.size.random ? Math.random() : 1) * d.particles.size.value, d.particles.size.anim.enable && (this.size_status = !1, this.vs = d.particles.size.anim.speed / 100, d.particles.size.anim.sync || (this.vs = this.vs * Math.random())), this.x = i ? i.x : Math.random() * d.canvas.w, this.y = i ? i.y : Math.random() * d.canvas.h, this.x > d.canvas.w - 2 * this.radius ? this.x = this.x - this.radius : this.x < 2 * this.radius && (this.x = this.x + this.radius), this.y > d.canvas.h - 2 * this.radius ? this.y = this.y - this.radius : this.y < 2 * this.radius && (this.y = this.y + this.radius), d.particles.move.bounce && d.fn.vendors.checkOverlap(this, i), this.color = {}, "object" == typeof t.value) if (t.value instanceof Array) {
            var s = t.value[Math.floor(Math.random() * d.particles.color.value.length)];
            this.color.rgb = hexToRgb(s)
        } else null != t.value.r && null != t.value.g && null != t.value.b && (this.color.rgb = {
            r: t.value.r,
            g: t.value.g,
            b: t.value.b
        }), null != t.value.h && null != t.value.s && null != t.value.l && (this.color.hsl = {
            h: t.value.h,
            s: t.value.s,
            l: t.value.l
        }); else "random" == t.value ? this.color.rgb = {
            r: Math.floor(256 * Math.random()) + 0,
            g: Math.floor(256 * Math.random()) + 0,
            b: Math.floor(256 * Math.random()) + 0
        } : "string" == typeof t.value && (this.color = t, this.color.rgb = hexToRgb(this.color.value));
        this.opacity = (d.particles.opacity.random ? Math.random() : 1) * d.particles.opacity.value, d.particles.opacity.anim.enable && (this.opacity_status = !1, this.vo = d.particles.opacity.anim.speed / 100, d.particles.opacity.anim.sync || (this.vo = this.vo * Math.random()));
        var a = {};
        switch (d.particles.move.direction) {
            case"top":
                a = {x: 0, y: -1};
                break;
            case"top-right":
                a = {x: .5, y: -.5};
                break;
            case"right":
                a = {x: 1, y: -0};
                break;
            case"bottom-right":
                a = {x: .5, y: .5};
                break;
            case"bottom":
                a = {x: 0, y: 1};
                break;
            case"bottom-left":
                a = {x: -.5, y: 1};
                break;
            case"left":
                a = {x: -1, y: 0};
                break;
            case"top-left":
                a = {x: -.5, y: -.5};
                break;
            default:
                a = {x: 0, y: 0}
        }
        d.particles.move.straight ? (this.vx = a.x, this.vy = a.y, d.particles.move.random && (this.vx = this.vx * Math.random(), this.vy = this.vy * Math.random())) : (this.vx = a.x + Math.random() - .5, this.vy = a.y + Math.random() - .5), this.vx_i = this.vx, this.vy_i = this.vy;
        var n = d.particles.shape.type;
        if ("object" == typeof n) {
            if (n instanceof Array) {
                var r = n[Math.floor(Math.random() * n.length)];
                this.shape = r
            }
        } else this.shape = n;
        if ("image" == this.shape) {
            var o = d.particles.shape;
            this.img = {
                src: o.image.src,
                ratio: o.image.width / o.image.height
            }, this.img.ratio || (this.img.ratio = 1), "svg" == d.tmp.img_type && null != d.tmp.source_svg && (d.fn.vendors.createSvgImg(this), d.tmp.pushing && (this.img.loaded = !1))
        }
    }, d.fn.particle.prototype.draw = function () {
        var t = this;
        if (null != t.radius_bubble) var e = t.radius_bubble; else e = t.radius;
        if (null != t.opacity_bubble) var i = t.opacity_bubble; else i = t.opacity;
        if (t.color.rgb) var s = "rgba(" + t.color.rgb.r + "," + t.color.rgb.g + "," + t.color.rgb.b + "," + i + ")"; else s = "hsla(" + t.color.hsl.h + "," + t.color.hsl.s + "%," + t.color.hsl.l + "%," + i + ")";
        switch (d.canvas.ctx.fillStyle = s, d.canvas.ctx.beginPath(), t.shape) {
            case"circle":
                d.canvas.ctx.arc(t.x, t.y, e, 0, 2 * Math.PI, !1);
                break;
            case"edge":
                d.canvas.ctx.rect(t.x - e, t.y - e, 2 * e, 2 * e);
                break;
            case"triangle":
                d.fn.vendors.drawShape(d.canvas.ctx, t.x - e, t.y + e / 1.66, 2 * e, 3, 2);
                break;
            case"polygon":
                d.fn.vendors.drawShape(d.canvas.ctx, t.x - e / (d.particles.shape.polygon.nb_sides / 3.5), t.y - e / .76, 2.66 * e / (d.particles.shape.polygon.nb_sides / 3), d.particles.shape.polygon.nb_sides, 1);
                break;
            case"star":
                d.fn.vendors.drawShape(d.canvas.ctx, t.x - 2 * e / (d.particles.shape.polygon.nb_sides / 4), t.y - e / 1.52, 2 * e * 2.66 / (d.particles.shape.polygon.nb_sides / 3), d.particles.shape.polygon.nb_sides, 2);
                break;
            case"image":
                if ("svg" == d.tmp.img_type) var a = t.img.obj; else a = d.tmp.img_obj;
                a && d.canvas.ctx.drawImage(a, t.x - e, t.y - e, 2 * e, 2 * e / t.img.ratio)
        }
        d.canvas.ctx.closePath(), 0 < d.particles.shape.stroke.width && (d.canvas.ctx.strokeStyle = d.particles.shape.stroke.color, d.canvas.ctx.lineWidth = d.particles.shape.stroke.width, d.canvas.ctx.stroke()), d.canvas.ctx.fill()
    }, d.fn.particlesCreate = function () {
        for (var t = 0; t < d.particles.number.value; t++) d.particles.array.push(new d.fn.particle(d.particles.color, d.particles.opacity.value))
    }, d.fn.particlesUpdate = function () {
        for (var t = 0; t < d.particles.array.length; t++) {
            var e = d.particles.array[t];
            if (d.particles.move.enable) {
                var i = d.particles.move.speed / 2;
                e.x += e.vx * i, e.y += e.vy * i
            }
            if (d.particles.opacity.anim.enable && (1 == e.opacity_status ? (e.opacity >= d.particles.opacity.value && (e.opacity_status = !1), e.opacity += e.vo) : (e.opacity <= d.particles.opacity.anim.opacity_min && (e.opacity_status = !0), e.opacity -= e.vo), e.opacity < 0 && (e.opacity = 0)), d.particles.size.anim.enable && (1 == e.size_status ? (e.radius >= d.particles.size.value && (e.size_status = !1), e.radius += e.vs) : (e.radius <= d.particles.size.anim.size_min && (e.size_status = !0), e.radius -= e.vs), e.radius < 0 && (e.radius = 0)), "bounce" == d.particles.move.out_mode) var s = {
                x_left: e.radius,
                x_right: d.canvas.w,
                y_top: e.radius,
                y_bottom: d.canvas.h
            }; else s = {
                x_left: -e.radius,
                x_right: d.canvas.w + e.radius,
                y_top: -e.radius,
                y_bottom: d.canvas.h + e.radius
            };
            switch (e.x - e.radius > d.canvas.w ? (e.x = s.x_left, e.y = Math.random() * d.canvas.h) : e.x + e.radius < 0 && (e.x = s.x_right, e.y = Math.random() * d.canvas.h), e.y - e.radius > d.canvas.h ? (e.y = s.y_top, e.x = Math.random() * d.canvas.w) : e.y + e.radius < 0 && (e.y = s.y_bottom, e.x = Math.random() * d.canvas.w), d.particles.move.out_mode) {
                case"bounce":
                    e.x + e.radius > d.canvas.w ? e.vx = -e.vx : e.x - e.radius < 0 && (e.vx = -e.vx), e.y + e.radius > d.canvas.h ? e.vy = -e.vy : e.y - e.radius < 0 && (e.vy = -e.vy)
            }
            if (isInArray("grab", d.interactivity.events.onhover.mode) && d.fn.modes.grabParticle(e), (isInArray("bubble", d.interactivity.events.onhover.mode) || isInArray("bubble", d.interactivity.events.onclick.mode)) && d.fn.modes.bubbleParticle(e), (isInArray("repulse", d.interactivity.events.onhover.mode) || isInArray("repulse", d.interactivity.events.onclick.mode)) && d.fn.modes.repulseParticle(e), d.particles.line_linked.enable || d.particles.move.attract.enable) for (var a = t + 1; a < d.particles.array.length; a++) {
                var n = d.particles.array[a];
                d.particles.line_linked.enable && d.fn.interact.linkParticles(e, n), d.particles.move.attract.enable && d.fn.interact.attractParticles(e, n), d.particles.move.bounce && d.fn.interact.bounceParticles(e, n)
            }
        }
    }, d.fn.particlesDraw = function () {
        d.canvas.ctx.clearRect(0, 0, d.canvas.w, d.canvas.h), d.fn.particlesUpdate();
        for (var t = 0; t < d.particles.array.length; t++) {
            d.particles.array[t].draw()
        }
    }, d.fn.particlesEmpty = function () {
        d.particles.array = []
    }, d.fn.particlesRefresh = function () {
        cancelRequestAnimFrame(d.fn.checkAnimFrame), cancelRequestAnimFrame(d.fn.drawAnimFrame), d.tmp.source_svg = void 0, d.tmp.img_obj = void 0, d.tmp.count_svg = 0, d.fn.particlesEmpty(), d.fn.canvasClear(), d.fn.vendors.start()
    }, d.fn.interact.linkParticles = function (t, e) {
        var i = t.x - e.x, s = t.y - e.y, a = Math.sqrt(i * i + s * s);
        if (a <= d.particles.line_linked.distance) {
            var n = d.particles.line_linked.opacity - a / (1 / d.particles.line_linked.opacity) / d.particles.line_linked.distance;
            if (0 < n) {
                var r = d.particles.line_linked.color_rgb_line;
                d.canvas.ctx.strokeStyle = "rgba(" + r.r + "," + r.g + "," + r.b + "," + n + ")", d.canvas.ctx.lineWidth = d.particles.line_linked.width, d.canvas.ctx.beginPath(), d.canvas.ctx.moveTo(t.x, t.y), d.canvas.ctx.lineTo(e.x, e.y), d.canvas.ctx.stroke(), d.canvas.ctx.closePath()
            }
        }
    }, d.fn.interact.attractParticles = function (t, e) {
        var i = t.x - e.x, s = t.y - e.y;
        if (Math.sqrt(i * i + s * s) <= d.particles.line_linked.distance) {
            var a = i / (1e3 * d.particles.move.attract.rotateX), n = s / (1e3 * d.particles.move.attract.rotateY);
            t.vx -= a, t.vy -= n, e.vx += a, e.vy += n
        }
    }, d.fn.interact.bounceParticles = function (t, e) {
        var i = t.x - e.x, s = t.y - e.y;
        Math.sqrt(i * i + s * s) <= t.radius + e.radius && (t.vx = -t.vx, t.vy = -t.vy, e.vx = -e.vx, e.vy = -e.vy)
    }, d.fn.modes.pushParticles = function (t, e) {
        d.tmp.pushing = !0;
        for (var i = 0; i < t; i++) d.particles.array.push(new d.fn.particle(d.particles.color, d.particles.opacity.value, {
            x: e ? e.pos_x : Math.random() * d.canvas.w,
            y: e ? e.pos_y : Math.random() * d.canvas.h
        })), i == t - 1 && (d.particles.move.enable || d.fn.particlesDraw(), d.tmp.pushing = !1)
    }, d.fn.modes.removeParticles = function (t) {
        d.particles.array.splice(0, t), d.particles.move.enable || d.fn.particlesDraw()
    }, d.fn.modes.bubbleParticle = function (o) {
        function t() {
            o.opacity_bubble = o.opacity, o.radius_bubble = o.radius
        }

        function e(t, e, i, s, a) {
            if (t != e) if (d.tmp.bubble_duration_end) {
                if (null != i) r = t + (t - (s - c * (s - t) / d.interactivity.modes.bubble.duration)), "size" == a && (o.radius_bubble = r), "opacity" == a && (o.opacity_bubble = r)
            } else if (h <= d.interactivity.modes.bubble.distance) {
                if (null != i) var n = i; else n = s;
                if (n != t) {
                    var r = s - c * (s - t) / d.interactivity.modes.bubble.duration;
                    "size" == a && (o.radius_bubble = r), "opacity" == a && (o.opacity_bubble = r)
                }
            } else "size" == a && (o.radius_bubble = void 0), "opacity" == a && (o.opacity_bubble = void 0)
        }

        if (d.interactivity.events.onhover.enable && isInArray("bubble", d.interactivity.events.onhover.mode)) {
            var i = o.x - d.interactivity.mouse.pos_x, s = o.y - d.interactivity.mouse.pos_y,
                a = 1 - (h = Math.sqrt(i * i + s * s)) / d.interactivity.modes.bubble.distance;
            if (h <= d.interactivity.modes.bubble.distance) {
                if (0 <= a && "mousemove" == d.interactivity.status) {
                    if (d.interactivity.modes.bubble.size != d.particles.size.value) if (d.interactivity.modes.bubble.size > d.particles.size.value) {
                        0 <= (r = o.radius + d.interactivity.modes.bubble.size * a) && (o.radius_bubble = r)
                    } else {
                        var n = o.radius - d.interactivity.modes.bubble.size, r = o.radius - n * a;
                        o.radius_bubble = 0 < r ? r : 0
                    }
                    if (d.interactivity.modes.bubble.opacity != d.particles.opacity.value) if (d.interactivity.modes.bubble.opacity > d.particles.opacity.value) {
                        (l = d.interactivity.modes.bubble.opacity * a) > o.opacity && l <= d.interactivity.modes.bubble.opacity && (o.opacity_bubble = l)
                    } else {
                        var l;
                        (l = o.opacity - (d.particles.opacity.value - d.interactivity.modes.bubble.opacity) * a) < o.opacity && l >= d.interactivity.modes.bubble.opacity && (o.opacity_bubble = l)
                    }
                }
            } else t();
            "mouseleave" == d.interactivity.status && t()
        } else if (d.interactivity.events.onclick.enable && isInArray("bubble", d.interactivity.events.onclick.mode)) {
            if (d.tmp.bubble_clicking) {
                i = o.x - d.interactivity.mouse.click_pos_x, s = o.y - d.interactivity.mouse.click_pos_y;
                var h = Math.sqrt(i * i + s * s), c = ((new Date).getTime() - d.interactivity.mouse.click_time) / 1e3;
                c > d.interactivity.modes.bubble.duration && (d.tmp.bubble_duration_end = !0), c > 2 * d.interactivity.modes.bubble.duration && (d.tmp.bubble_clicking = !1, d.tmp.bubble_duration_end = !1)
            }
            d.tmp.bubble_clicking && (e(d.interactivity.modes.bubble.size, d.particles.size.value, o.radius_bubble, o.radius, "size"), e(d.interactivity.modes.bubble.opacity, d.particles.opacity.value, o.opacity_bubble, o.opacity, "opacity"))
        }
    }, d.fn.modes.repulseParticle = function (s) {
        if (d.interactivity.events.onhover.enable && isInArray("repulse", d.interactivity.events.onhover.mode) && "mousemove" == d.interactivity.status) {
            var t = s.x - d.interactivity.mouse.pos_x, e = s.y - d.interactivity.mouse.pos_y,
                i = Math.sqrt(t * t + e * e), a = t / i, n = e / i,
                r = clamp(1 / (l = d.interactivity.modes.repulse.distance) * (-1 * Math.pow(i / l, 2) + 1) * l * 100, 0, 50),
                o = {x: s.x + a * r, y: s.y + n * r};
            "bounce" == d.particles.move.out_mode ? (0 < o.x - s.radius && o.x + s.radius < d.canvas.w && (s.x = o.x), 0 < o.y - s.radius && o.y + s.radius < d.canvas.h && (s.y = o.y)) : (s.x = o.x, s.y = o.y)
        } else if (d.interactivity.events.onclick.enable && isInArray("repulse", d.interactivity.events.onclick.mode)) if (d.tmp.repulse_finish || (d.tmp.repulse_count++, d.tmp.repulse_count == d.particles.array.length && (d.tmp.repulse_finish = !0)), d.tmp.repulse_clicking) {
            var l = Math.pow(d.interactivity.modes.repulse.distance / 6, 3),
                h = d.interactivity.mouse.click_pos_x - s.x, c = d.interactivity.mouse.click_pos_y - s.y,
                p = h * h + c * c, u = -l / p * 1;
            p <= l && function () {
                var t = Math.atan2(c, h);
                if (s.vx = u * Math.cos(t), s.vy = u * Math.sin(t), "bounce" == d.particles.move.out_mode) {
                    var e = s.x + s.vx, i = s.y + s.vy;
                    e + s.radius > d.canvas.w ? s.vx = -s.vx : e - s.radius < 0 && (s.vx = -s.vx), i + s.radius > d.canvas.h ? s.vy = -s.vy : i - s.radius < 0 && (s.vy = -s.vy)
                }
            }()
        } else 0 == d.tmp.repulse_clicking && (s.vx = s.vx_i, s.vy = s.vy_i)
    }, d.fn.modes.grabParticle = function (t) {
        if (d.interactivity.events.onhover.enable && "mousemove" == d.interactivity.status) {
            var e = t.x - d.interactivity.mouse.pos_x, i = t.y - d.interactivity.mouse.pos_y,
                s = Math.sqrt(e * e + i * i);
            if (s <= d.interactivity.modes.grab.distance) {
                var a = d.interactivity.modes.grab.line_linked.opacity - s / (1 / d.interactivity.modes.grab.line_linked.opacity) / d.interactivity.modes.grab.distance;
                if (0 < a) {
                    var n = d.particles.line_linked.color_rgb_line;
                    d.canvas.ctx.strokeStyle = "rgba(" + n.r + "," + n.g + "," + n.b + "," + a + ")", d.canvas.ctx.lineWidth = d.particles.line_linked.width, d.canvas.ctx.beginPath(), d.canvas.ctx.moveTo(t.x, t.y), d.canvas.ctx.lineTo(d.interactivity.mouse.pos_x, d.interactivity.mouse.pos_y), d.canvas.ctx.stroke(), d.canvas.ctx.closePath()
                }
            }
        }
    }, d.fn.vendors.eventsListeners = function () {
        "window" == d.interactivity.detect_on ? d.interactivity.el = window : d.interactivity.el = d.canvas.el, (d.interactivity.events.onhover.enable || d.interactivity.events.onclick.enable) && (d.interactivity.el.addEventListener("mousemove", function (t) {
            if (d.interactivity.el == window) var e = t.clientX,
                i = t.clientY; else e = t.offsetX || t.clientX, i = t.offsetY || t.clientY;
            d.interactivity.mouse.pos_x = e, d.interactivity.mouse.pos_y = i, d.tmp.retina && (d.interactivity.mouse.pos_x *= d.canvas.pxratio, d.interactivity.mouse.pos_y *= d.canvas.pxratio), d.interactivity.status = "mousemove"
        }), d.interactivity.el.addEventListener("mouseleave", function (t) {
            d.interactivity.mouse.pos_x = null, d.interactivity.mouse.pos_y = null, d.interactivity.status = "mouseleave"
        })), d.interactivity.events.onclick.enable && d.interactivity.el.addEventListener("click", function () {
            if (d.interactivity.mouse.click_pos_x = d.interactivity.mouse.pos_x, d.interactivity.mouse.click_pos_y = d.interactivity.mouse.pos_y, d.interactivity.mouse.click_time = (new Date).getTime(), d.interactivity.events.onclick.enable) switch (d.interactivity.events.onclick.mode) {
                case"push":
                    d.particles.move.enable ? d.fn.modes.pushParticles(d.interactivity.modes.push.particles_nb, d.interactivity.mouse) : 1 == d.interactivity.modes.push.particles_nb ? d.fn.modes.pushParticles(d.interactivity.modes.push.particles_nb, d.interactivity.mouse) : 1 < d.interactivity.modes.push.particles_nb && d.fn.modes.pushParticles(d.interactivity.modes.push.particles_nb);
                    break;
                case"remove":
                    d.fn.modes.removeParticles(d.interactivity.modes.remove.particles_nb);
                    break;
                case"bubble":
                    d.tmp.bubble_clicking = !0;
                    break;
                case"repulse":
                    d.tmp.repulse_clicking = !0, d.tmp.repulse_count = 0, d.tmp.repulse_finish = !1, setTimeout(function () {
                        d.tmp.repulse_clicking = !1
                    }, 1e3 * d.interactivity.modes.repulse.duration)
            }
        })
    }, d.fn.vendors.densityAutoParticles = function () {
        if (d.particles.number.density.enable) {
            var t = d.canvas.el.width * d.canvas.el.height / 1e3;
            d.tmp.retina && (t /= 2 * d.canvas.pxratio);
            var e = t * d.particles.number.value / d.particles.number.density.value_area,
                i = d.particles.array.length - e;
            i < 0 ? d.fn.modes.pushParticles(Math.abs(i)) : d.fn.modes.removeParticles(i)
        }
    }, d.fn.vendors.checkOverlap = function (t, e) {
        for (var i = 0; i < d.particles.array.length; i++) {
            var s = d.particles.array[i], a = t.x - s.x, n = t.y - s.y;
            Math.sqrt(a * a + n * n) <= t.radius + s.radius && (t.x = e ? e.x : Math.random() * d.canvas.w, t.y = e ? e.y : Math.random() * d.canvas.h, d.fn.vendors.checkOverlap(t))
        }
    }, d.fn.vendors.createSvgImg = function (n) {
        var t = d.tmp.source_svg.replace(/#([0-9A-F]{3,6})/gi, function (t, e, i, s) {
                if (n.color.rgb) var a = "rgba(" + n.color.rgb.r + "," + n.color.rgb.g + "," + n.color.rgb.b + "," + n.opacity + ")"; else a = "hsla(" + n.color.hsl.h + "," + n.color.hsl.s + "%," + n.color.hsl.l + "%," + n.opacity + ")";
                return a
            }), e = new Blob([t], {type: "image/svg+xml;charset=utf-8"}), i = window.URL || window.webkitURL || window,
            s = i.createObjectURL(e), a = new Image;
        a.addEventListener("load", function () {
            n.img.obj = a, n.img.loaded = !0, i.revokeObjectURL(s), d.tmp.count_svg++
        }), a.src = s
    }, d.fn.vendors.destroypJS = function () {
        cancelAnimationFrame(d.fn.drawAnimFrame), i.remove(), pJSDom = null
    }, d.fn.vendors.drawShape = function (t, e, i, s, a, n) {
        var r = a * n, o = a / n, l = 180 * (o - 2) / o, h = Math.PI - Math.PI * l / 180;
        t.save(), t.beginPath(), t.translate(e, i), t.moveTo(0, 0);
        for (var c = 0; c < r; c++) t.lineTo(s, 0), t.translate(s, 0), t.rotate(h);
        t.fill(), t.restore()
    }, d.fn.vendors.exportImg = function () {
        window.open(d.canvas.el.toDataURL("image/png"), "_blank")
    }, d.fn.vendors.loadImg = function (t) {
        if (d.tmp.img_error = void 0, "" != d.particles.shape.image.src) if ("svg" == t) {
            var e = new XMLHttpRequest;
            e.open("GET", d.particles.shape.image.src), e.onreadystatechange = function (t) {
                4 == e.readyState && (200 == e.status ? (d.tmp.source_svg = t.currentTarget.response, d.fn.vendors.checkBeforeDraw()) : (console.log("Error pJS - Image not found"), d.tmp.img_error = !0))
            }, e.send()
        } else {
            var i = new Image;
            i.addEventListener("load", function () {
                d.tmp.img_obj = i, d.fn.vendors.checkBeforeDraw()
            }), i.src = d.particles.shape.image.src
        } else console.log("Error pJS - No image.src"), d.tmp.img_error = !0
    }, d.fn.vendors.draw = function () {
        "image" == d.particles.shape.type ? "svg" == d.tmp.img_type ? d.tmp.count_svg >= d.particles.number.value ? (d.fn.particlesDraw(), d.particles.move.enable ? d.fn.drawAnimFrame = requestAnimFrame(d.fn.vendors.draw) : cancelRequestAnimFrame(d.fn.drawAnimFrame)) : d.tmp.img_error || (d.fn.drawAnimFrame = requestAnimFrame(d.fn.vendors.draw)) : null != d.tmp.img_obj ? (d.fn.particlesDraw(), d.particles.move.enable ? d.fn.drawAnimFrame = requestAnimFrame(d.fn.vendors.draw) : cancelRequestAnimFrame(d.fn.drawAnimFrame)) : d.tmp.img_error || (d.fn.drawAnimFrame = requestAnimFrame(d.fn.vendors.draw)) : (d.fn.particlesDraw(), d.particles.move.enable ? d.fn.drawAnimFrame = requestAnimFrame(d.fn.vendors.draw) : cancelRequestAnimFrame(d.fn.drawAnimFrame))
    }, d.fn.vendors.checkBeforeDraw = function () {
        "image" == d.particles.shape.type ? "svg" == d.tmp.img_type && null == d.tmp.source_svg ? d.tmp.checkAnimFrame = requestAnimFrame(check) : (cancelRequestAnimFrame(d.tmp.checkAnimFrame), d.tmp.img_error || (d.fn.vendors.init(), d.fn.vendors.draw())) : (d.fn.vendors.init(), d.fn.vendors.draw())
    }, d.fn.vendors.init = function () {
        d.fn.retinaInit(), d.fn.canvasInit(), d.fn.canvasSize(), d.fn.canvasPaint(), d.fn.particlesCreate(), d.fn.vendors.densityAutoParticles(), d.particles.line_linked.color_rgb_line = hexToRgb(d.particles.line_linked.color)
    }, d.fn.vendors.start = function () {
        isInArray("image", d.particles.shape.type) ? (d.tmp.img_type = d.particles.shape.image.src.substr(d.particles.shape.image.src.length - 3), d.fn.vendors.loadImg(d.tmp.img_type)) : d.fn.vendors.checkBeforeDraw()
    }, d.fn.vendors.eventsListeners(), d.fn.vendors.start()
};
Object.deepExtend = function (t, e) {
    for (var i in e) e[i] && e[i].constructor && e[i].constructor === Object ? (t[i] = t[i] || {}, arguments.callee(t[i], e[i])) : t[i] = e[i];
    return t
}, window.requestAnimFrame = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function (t) {
    window.setTimeout(t, 1e3 / 60)
}, window.cancelRequestAnimFrame = window.cancelAnimationFrame || window.webkitCancelRequestAnimationFrame || window.mozCancelRequestAnimationFrame || window.oCancelRequestAnimationFrame || window.msCancelRequestAnimationFrame || clearTimeout, window.pJSDom = [], window.particlesJS = function (t, e) {
    "string" != typeof t && (e = t, t = "particles-js"), t || (t = "particles-js");
    if (s == undefined){
        return;
    }
    var i = document.getElementById(t), s = "particles-js-canvas-el", a = i.getElementsByClassName(s);
    if (a.length) for (; 0 < a.length;) i.removeChild(a[0]);
    var n = document.createElement("canvas");
    n.className = s, n.style.width = "100%", n.style.height = "100%", null != document.getElementById(t).appendChild(n) && pJSDom.push(new pJS(t, e))
}, window.particlesJS.load = function (i, t, s) {
    var a = new XMLHttpRequest;
    a.open("GET", t), a.onreadystatechange = function (t) {
        if (4 == a.readyState) if (200 == a.status) {
            var e = JSON.parse(t.currentTarget.response);
            window.particlesJS(i, e), s && s()
        } else console.log("Error pJS - XMLHttpRequest status: " + a.status), console.log("Error pJS - File config not found")
    }, a.send()
};