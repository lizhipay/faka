function initSparkline() {
    $(".sparkline").each(function () {
        var e = $(this);
        e.sparkline("html", e.data())
    }),
    $(".sparkbar").sparkline("html", {
        type: "bar"
    })
}
function skinChanger() {
    $(".choose-skin li").on("click",
    function () {
        var e = $("body"),
        t = $(this),
        a = $(".choose-skin li.active").data("theme");
        $(".choose-skin li").removeClass("active"),
        e.removeClass("theme-" + a),
        t.addClass("active");
        $(".choose-skin li.active").data("theme");
        e.addClass("theme-" + t.data("theme"));
        $("#left-sidebar .navbar-brand .logo").attr("src", "assets/images/icon.svg")
    })
}
$(function () {
    "use strict";
    skinChanger(),
    initSparkline(),
    setTimeout(function () {
        $(".page-loader-wrapper").fadeOut()
    },
    50);
    var e = function () {
        for (var e = new Array(20), t = 0; t < e.length; t++) e[t] = [5 + a(), 10 + a(), 15 + a(), 20 + a(), 30 + a(), 35 + a(), 40 + a(), 45 + a(), 50 + a()];
        return e
    }(),
    t = {
        type: "bar",
        barWidth: 3,
        height: 15,
        barColor: "#0E9BE2"
    };
    function a() {
        return Math.floor(80 * Math.random())
    }
    $("#mini-bar-chart1").sparkline(e[0], t),
    t.barColor = "#7CAC25",
    $("#mini-bar-chart2").sparkline(e[1], t),
    t.barColor = "#FF4402",
    $("#mini-bar-chart3").sparkline(e[2], t),
    t.barColor = "#ff9800"
}),
$(document).ready(function () {
    $("#main-menu").metisMenu(),
    $("#left-sidebar .sidebar-scroll").slimScroll({
        height: "calc(100vh - 65px)",
        wheelStep: 10,
        touchScrollStep: 50,
        color: "rgba(23,25,28,0.02",
        size: "3px",
        borderRadius: "3px",
        alwaysVisible: !1,
        position: "right"
    }),
    $(".btn-toggle-fullwidth").on("click",
    function () {
        $("body").hasClass("layout-fullwidth") ? $("body").removeClass("layout-fullwidth") : $("body").addClass("layout-fullwidth"),
        $(this).find(".fa").toggleClass("fa-arrow-left fa-arrow-right")
    }),
    $(".btn-toggle-offcanvas").on("click",
    function () {
        $("body").toggleClass("offcanvas-active")
    }),
    $("#main-content").on("click",
    function () {
        $("body").removeClass("offcanvas-active")
    }),
    $(".right_toggle, .overlay").on("click",
    function () {
        $("#rightbar").toggleClass("open"),
        $(".overlay").toggleClass("open")
    }),
    $(".megamenu_toggle").on("click",
    function () {
        $("#megamenu").toggleClass("open")
    }),
    $('.navbar-form.search-form input[type="text"]').on("focus",
    function () {
        $(this).animate({
            width: "+=50px"
        },
        300)
    }).on("focusout",
    function () {
        $(this).animate({
            width: "-=50px"
        },
        300)
    }),
    $(".rightbar .right_chat li a, .rightbar .back_btn").on("click",
    function () {
        $("#rightbar").toggleClass("detail")
    }),
    0 < $('[data-toggle="tooltip"]').length && $('[data-toggle="tooltip"]').tooltip(),
    0 < $('[data-toggle="popover"]').length && $('[data-toggle="popover"]').popover(),
    $(window).on("load",
    function () {
        $("#main-content").height() < $("#left-sidebar").height() && $("#main-content").css("min-height", $("#left-sidebar").innerHeight() - $("footer").innerHeight())
    }),
    $(window).on("load resize",
    function () {
        $(window).innerWidth() < 420 ? $(".navbar-brand logo.svg").attr("src", "../assets/images/icon.svg") : $(".navbar-brand icon-light.svg").attr("src", "../assets/images/logo.svg")
    }),
    $(".full-screen").on("click",
    function () {
        $(this).parents(".card").toggleClass("fullscreen")
    }),
    $(".progress .progress-bar").progressbar({
        display_text: "none"
    }),
    $(".themesetting .theme_btn").on("click",
    function () {
        $(".themesetting").toggleClass("open")
    }),
    $(".header-dropdown .dropdown-toggle").on("click",
    function () {
        $(".header-dropdown li .dropdown-menu").toggleClass("vivify fadeIn")
    }),
    $(".check-all").on("click",
    function () {
        this.checked ? $(this).parents(".check-all-parent").find(".checkbox-tick").each(function () {
            this.checked = !0
        }) : $(this).parents(".check-all-parent").find(".checkbox-tick").each(function () {
            this.checked = !1
        })
    }),
    $(".checkbox-tick").on("click",
    function () {
        $(this).parents(".check-all-parent").find(".checkbox-tick:checked").length == $(this).parents(".check-all-parent").find(".checkbox-tick").length ? $(this).parents(".check-all-parent").find(".check-all").prop("checked", !0) : $(this).parents(".check-all-parent").find(".check-all").prop("checked", !1)
    }),
    $("a.mail-star").on("click",
    function () {
        $(this).toggleClass("active")
    })
}),
$.fn.clickToggle = function (t, a) {
    return this.each(function () {
        var e = !1;
        $(this).bind("click",
        function () {
            return e ? (e = !1, a.apply(this, arguments)) : (e = !0, t.apply(this, arguments))
        })
    })
},
particlesJS("particles-js", {
    particles: {
        number: {
            value: 30,
            density: {
                enable: !0,
                value_area: 700
            }
        },
        color: {
            value: ["#fc3c5f", "#993cfc", "#3ca9fc", "#3cfc5f", "#fcdf3c"]
        },
        shape: {
            type: "circle",
            stroke: {
                width: 0,
                color: "#000000"
            },
            polygon: {
                nb_sides: 15
            }
        },
        opacity: {
            value: .5,
            random: !1,
            anim: {
                enable: !1,
                speed: 1.2,
                opacity_min: .15,
                sync: !1
            }
        },
        size: {
            value: 2.5,
            random: !1,
            anim: {
                enable: !0,
                speed: 2,
                size_min: .15,
                sync: !1
            }
        },
        line_linked: {
            enable: !0,
            distance: 110,
            color: "#d6d6d6",
            opacity: 1,
            width: 1
        },
        move: {
            enable: !0,
            speed: 1.6,
            direction: "none",
            random: !1,
            straight: !1,
            out_mode: "out",
            bounce: !1,
            attract: {
                enable: !1,
                rotateX: 600,
                rotateY: 1200
            }
        }
    },
    interactivity: {
        detect_on: "canvas",
        events: {
            onhover: {
                enable: !1,
                mode: "repulse"
            },
            onclick: {
                enable: !1,
                mode: "push"
            },
            resize: !0
        },
        modes: {
            grab: {
                distance: 400,
                line_linked: {
                    opacity: 1
                }
            },
            bubble: {
                distance: 400,
                size: 30,
                duration: 2,
                opacity: 8,
                speed: 3
            },
            repulse: {
                distance: 200,
                duration: .4
            },
            push: {
                particles_nb: 4
            },
            remove: {
                particles_nb: 2
            }
        }
    },
    retina_detect: !0
});