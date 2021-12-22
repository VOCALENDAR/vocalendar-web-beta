(function(e, t, n, r) {
    function o(r, i) {
        var o = this;
        o.options = e.extend({}, s, i);
        o.parent = r;
        o.wrapper = o.parent.children();
        o.slides = o.wrapper.children();
        o.currentSlide = 0;
        o.CSS3support = true;
        o.init();
        o.build();
        o.play();
        if (o.options.touchDistance) {
            o.swipe()
        }
        e(n).on("keyup", function(e) {
            if (e.keyCode === 39)
                o.slide(1);
            if (e.keyCode === 37)
                o.slide(-1)
        });
        o.parent.add(o.arrows).add(o.nav).on("mouseover mouseout", function(e) {
            o.pause();
            if (e.type === "mouseout")
                o.play()
        });
        e(t).on("resize", function() {
            o.init();
            o.slide(0)
        });
        return {
            current: function() {
                return - o.currentSlide + 1
            },
            play: function() {
                o.play()
            },
            pause: function() {
                o.pause()
            },
            next: function(e) {
                o.slide(1, false, e)
            },
            prev: function(e) {
                o.slide(-1, false, e)
            },
            jump: function(e, t) {
                o.slide(e-1, true, t)
            },
            nav: function(e) {
                if (o.navWrapper) {
                    o.navWrapper.remove()
                }
                o.options.nav = e ? e : o.options.nav;
                o.navigation()
            },
            arrows: function(e) {
                if (o.arrowsWrapper) {
                    o.arrowsWrapper.remove()
                }
                o.options.arrows = e ? e : o.options.arrows;
                o.arrows()
            }
        }
    }
    function u(e) {
        var i = false, s = "Khtml ms O Moz Webkit".split(" "), o = n.createElement("div"), u = null;
        e = e.toLowerCase();
        if (o.style[e] !== r)
            i = true;
        if (i === false) {
            u = e.charAt(0).toUpperCase() + e.substr(1);
            for (var a = 0; a < s.length; a++) {
                if (o.style[s[a] + u] !== r) {
                    i = true;
                    break
                }
            }
        }
        if (t.opera) {
            if (t.opera.version() < 13)
                i = false
        }
        return i
    }
    function a(e) {
        if (e !== "undefined" && typeof e === "function")
            return true;
        return false
    }
    var i = "glide", s = {
        autoplay: 4e3,
        animationTime: 500,
        arrows: true,
        arrowsWrapperClass: "slider-arrows",
        arrowMainClass: "slider-arrow",
        arrowRightClass: "slider-arrow--right",
        arrowRightText: "next",
        arrowLeftClass: "slider-arrow--left",
        arrowLeftText: "prev",
        nav: true,
        navCenter: true,
        navClass: "slider-nav",
        navItemClass: "slider-nav__item",
        navCurrentItemClass: "slider-nav__item--current",
        touchDistance: 60,
        beforeTransition: function() {},
        afterTransition: function() {}
    };
    o.prototype.build = function() {
        var e = this;
        if (e.options.arrows)
            e.arrows();
        if (e.options.nav)
            e.navigation()
    };
    o.prototype.navigation = function() {
        var t = this;
        if (t.slides.length > 1) {
            var n = t.options, r = t.options.nav === true ? t.parent: t.options.nav;
            t.navWrapper = e("<div />", {
                "class": n.navClass
            }).appendTo(r);
            var i = t.navWrapper, s;
            for (var o = 0; o < t.slides.length; o++) {
                s = e("<a />", {
                    href: "#",
                    "class": n.navItemClass,
                    "data-distance": o
                }).appendTo(i);
                i[o + 1] = s
            }
            var u = i.children();
            u.eq(0).addClass(n.navCurrentItemClass);
            if (n.navCenter) {
                i.css({
                    left: "50%",
                    width: u.outerWidth(true) * u.length,
                    "margin-left": - i.outerWidth(true) / 2
                })
            }
            u.on("click touchstart", function(n) {
                n.preventDefault();
                t.slide(e(this).data("distance"), true)
            })
        }
    };
    o.prototype.arrows = function() {
        var t = this;
        if (t.slides.length > 1) {
            var n = t.options, r = t.options.arrows === true ? t.parent: t.options.arrows;
            t.arrowsWrapper = e("<div />", {
                "class": n.arrowsWrapperClass
            }).appendTo(r);
            var i = t.arrowsWrapper;
            i.right = e("<a />", {
                href: "#",
                "class": n.arrowMainClass + " " + n.arrowRightClass,
                "data-distance": "1",
                html: n.arrowRightText
            }).appendTo(i);
            i.left = e("<a />", {
                href: "#",
                "class": n.arrowMainClass + " " + n.arrowLeftClass,
                "data-distance": "-1",
                html: n.arrowLeftText
            }).appendTo(i);
            i.children().on("click touchstart", function(n) {
                n.preventDefault();
                t.slide(e(this).data("distance"), false)
            })
        }
    };
    o.prototype.slide = function(e, t, n) {
        var r = this, i = t ? 0: r.currentSlide, s =- (r.slides.length-1), o = r.options.navCurrentItemClass, u = r.slides.spread;
        r.pause();
        if (a(r.options.beforeTransition))
            r.options.beforeTransition.call(r);
        if (i === 0 && e===-1) {
            i = s
        } else if (i === s && e === 1) {
            i = 0
        } else {
            i = i + - e
        }
        var f = u * i + "px";
        if (r.CSS3support) {
            r.wrapper.css({
                "-webkit-transform": "translate3d(" + f + ", 0px, 0px)",
                "-moz-transform": "translate3d(" + f + ", 0px, 0px)",
                "-ms-transform": "translate3d(" + f + ", 0px, 0px)",
                "-o-transform": "translate3d(" + f + ", 0px, 0px)",
                transform: "translate3d(" + f + ", 0px, 0px)"
            })
        } else {
            r.wrapper.stop().animate({
                "margin-left": f
            }, r.options.animationTime)
        }
        if (r.options.nav) {
            r.navWrapper.children().eq( - i).addClass(o).siblings().removeClass(o)
        }
        r.currentSlide = i;
        if (a(r.options.afterTransition))
            r.options.afterTransition.call(r);
        if (a(n))
            n();
        r.play()
    };
    o.prototype.play = function() {
        var e = this;
        if (e.options.autoplay) {
            e.auto = setInterval(function() {
                e.slide(1, false)
            }, e.options.autoplay)
        }
    };
    o.prototype.pause = function() {
        if (this.options.autoplay) {
            this.auto = clearInterval(this.auto)
        }
    };
    o.prototype.swipe = function() {
        var e = this, t, n, r, i, s, o, u, a, f, l = 180 / Math.PI, c, h, p, d;
        e.parent.on("touchstart", function(e) {
            t = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
            r = t.pageX;
            i = t.pageY
        });
        e.parent.on("touchmove", function(e) {
            t = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
            s = t.pageX;
            o = t.pageY;
            c = s - r;
            h = o - i;
            p = Math.abs(c<<2);
            d = Math.abs(h<<2);
            u = Math.sqrt(p + d);
            a = Math.sqrt(d);
            f = Math.asin(a / u);
            if (f * l < 32)
                e.preventDefault()
        });
        e.parent.on("touchend", function(i) {
            t = i.originalEvent.touches[0] || i.originalEvent.changedTouches[0];
            n = t.pageX - r;
            if (n > e.options.touchDistance) {
                e.slide(-1)
            } else if (n<-e.options.touchDistance) {
                e.slide(1)
            }
        })
    };
    o.prototype.init = function() {
        var e = this, t = e.parent.width();
        e.slides.spread = t;
        e.wrapper.width(t * e.slides.length);
        e.slides.width(e.slides.spread);
        if (!u("transition") ||!u("transform"))
            e.CSS3support = false
    };
    e.fn[i] = function(t) {
        return this.each(function() {
            if (!e.data(this, "api_" + i)) {
                e.data(this, "api_" + i, new o(e(this), t))
            }
        })
    }
})(jQuery, window, document)
