
var customizeURL = '/demo/incv/customize/api/',
    customizeHTML = '\
    <div id="wrap-customize"><div id="customize">\
        <a href="#" class="action" id="customize-show">&lsaquo; Show</a>\
        <span class="label title">InCV</span>\
        <span class="label">Select skin</span>\
        <ul id="skin-list">\
        </ul>\
        <a href="#" class="action" id="customize-hide">Hide &rsaquo;</a>\
    </div></div>\
';

Modernizr.load([
    'customize/customize.css',
    {
        'load': ['customize/underscore-min.js', 'customize/backbone.js'],
        'complete': function() {

            init_customize();

        }
    }
]);

function init_customize() {

    $('body').prepend($(customizeHTML));

    /* Skins */

    window.Pattern = Backbone.Model.extend({});

    window.PatternList = Backbone.Collection.extend({
        model: Pattern,
        url: customizeURL + 'patterns'
    })

    window.Patterns = new PatternList;

    window.PatternView = Backbone.View.extend({
        active: -1,
        selector: null,
        name: '',

        activate: function () {
            var newPattern = Patterns.at(this.active);
            if (newPattern) {
                $(this.selector).css({
                    backgroundImage: 'url(' + newPattern.get('url') + ')',
                    backgroundRepeat: 'repeat'
                })
                Router.navigate("pattern/" + this.name + "/" + this.active);
            }
        },

        deactivate: function () {

            $(this.selector).css({
                backgroundImage: 'none'
            })

        },

        next: function () {
            if ((this.active + 1) != Patterns.length) {
                this.active++;
            } else {
                this.active = 0;
            }
        },

        prev: function () {
            if (this.active == 0) {
                this.active = Patterns.length - 1;
            } else {
                this.active--;
            }
        },

        initialize: function (args) {
            if (args.selector) {
                this.selector = args.selector;
                this.name = args.name;
            }
        }
    });

    /* Skins */

    window.Skin = Backbone.Model.extend({
        defaults: function () {

            return {
                link: ''
            }

        }
    });

    window.SkinList = Backbone.Collection.extend({
        model: Skin,
        url: customizeURL + 'skins'
    });

    window.Skins = new SkinList;

    window.SkinView = Backbone.View.extend({
        tagName: "li",

        template: _.template('<a href="<%= url %>" class="skin <% if (active) { %>active<% } %>"><%- name %></a>'),
        cssLinkElement: null, // !!! this may be DOM object, or styleSheet object in IE case

        events: {
            'click .skin': 'activateOnClick'
        },

        initialize: function() {
            var widget = this;
            this.model.bind('change', this.render, this);

        },

        render: function() {

            var data = this.model.toJSON(),
                activeFile = $(App.activeSkin).attr('href').match(/^.+\/(.+)$/)[1];

            if (data.file == activeFile) {
                data.active = true;
                this.cssLinkElement = App.activeSkin;
            } else {
                data.active = false;
            }

            $(this.el).html(this.template(data));


            return this;

        },

        activateOnClick: function () {

            Router.navigate("skin/" + this.model.id);
            this.activate();

            return false;

        },

        activate: function (e) {

            // standard dom stuff

            if ($(this.el).is('.active')) {
                return false;
            }

            $("#skin-list .active").removeClass('active');

            // deactivate current css

            App.activeSkin.disabled = true;

            if (this.cssLinkElement != null) {

                this.cssLinkElement.disabled = false;

            } else {

                if (document.createStyleSheet) {
                    // IE case
                    try {
                        this.cssLinkElement = document.createStyleSheet(this.model.get('url'));
                    } catch (e) { }
                } else {
                    this.cssLinkElement = $('<link type="text/css" rel="stylesheet" href="' + this.model.get('url') + '" />').
                                          appendTo($('head'))[0];
                }

            }

            App.activeSkin = this.cssLinkElement;

            $(this.el).find('.skin').addClass('active');

            $(window).resize();

        }

    })

    window.AppView = Backbone.View.extend({

        el: $("#customize"),
        activeSkin: $('link[rel="stylesheet"][href*=skin]')[0],
        skinViewList: {},
        patternList: [],

        initialize: function() {

            _.bindAll(this);

            var widget = this;

            $(window).bind('keydown', function (e) {
                if (e.which == 72) { // 'h'
                    widget.toggle();
                }
            });


            Skins.bind('add', this.addSkin, this);
            Skins.bind('reset', this.addAllSkins, this);
            Skins.fetch({
                success: this.initializeRoutes
            });

            $('#customize-hide').click(function () {

                App.hide();

                return false;

            });

            $('#customize-show').click(function () {

                App.show();

                return false;

            });

            $('body').addClass('customize-visible');

        },

        initializeRoutes: function () {

            var ourAppView = this;

            Patterns.bind('add', this.addPattern, this);
            Patterns.bind('reset', this.addAllPatterns, this);
            Patterns.fetch({ success: function () {

                // patterns fetched, now bind keybord events

                var BodyPattern = PatternView.extend({});
                window.bodyPatternView = new BodyPattern({
                    'selector': 'body',
                    'name': 'bodyPatternView'
                });

                var HeaderPattern = PatternView.extend({});
                window.headerPatternView = new HeaderPattern({
                    'selector': '.row-inversed',
                    'name': 'headerPatternView'
                });

                $(window).bind('keypress', function (e) {

                    if (e.which == 105) { // 'i'
                        headerPatternView.deactivate();
                    }

                    if (e.which == 111) { // 'o'
                        headerPatternView.prev();
                        headerPatternView.activate();
                    }

                    if (e.which == 112) { // 'p'
                        headerPatternView.next();
                        headerPatternView.activate();
                    }

                    // ---

                    if (e.which == 106) { // 'j'
                        bodyPatternView.deactivate();
                    }

                    if (e.which == 107) { // 'k'
                        bodyPatternView.prev();
                        bodyPatternView.activate();
                    }

                    if (e.which == 108) { // 'l'
                        bodyPatternView.next();
                        bodyPatternView.activate();
                    }

                });

                $(function() {
                    window.Router = new AppRouter;
                    Backbone.history.start();
                });

            }});

        },

        toggle: function () {
            if ($("#customize").is(':visible')) {
                $("#customize").hide();
            } else {
                $("#customize").show();
            }
        },

        hide: function () {

            $('#customize-hide').hide();
            $('#customize-show').show();

            $('#customize').css({
                left: '100%',
                marginLeft: '-62px'
            });

            $('body').addClass('customize-hidden');
            $('body').removeClass('customize-visible');

        },

        show: function () {

            $('#customize-show').hide();
            $('#customize-hide').show();

            $('#customize').css({
                left: '0',
                marginLeft: '0'
            });

            $('body').removeClass('customize-hidden');
            $('body').addClass('customize-visible');

        },

        addSkin: function (skin) {
            var view = new SkinView({model: skin});
            this.$("#skin-list").append(view.render().el);
            this.skinViewList[skin.id] = view;
        },

        addAllSkins: function () {
            Skins.each(this.addSkin);
        },

        addPattern: function (pattern) {
            this.patternList.push(pattern);
        },

        addAllPatterns: function () {
            Patterns.each(this.addPattern);
        }

    });

    var AppRouter = Backbone.Router.extend({

        routes: {
            "skin/:query": "skin",
            "demoskin/:query": "demoskin",
            "pattern/:pattern/:id": "pattern"
        },

        pattern: function (pattern, id) {

            var variable = window[pattern];

            if (variable) {

                variable.active = id;
                variable.activate();

            }

        },

        demoskin: function (query) {

            App.hide();
            App.el.hide();
            this.skin(query);

        },

        skin: function (query) {

            var activateSkin = Skins.get(query);

            if (activateSkin) {

                App.skinViewList[query].activate();

            }

        }

    });

    window.App = new AppView;

}

