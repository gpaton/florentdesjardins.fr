jQuery(function ($) {

    var App = {
        init: function () {
            this.cacheElements();
            this.bindEvents();
        },
        cacheElements: function () {
            this.$mobile_nav = $("nav").find('select');
        },
        bindEvents: function () {
            this.$mobile_nav.change('click', this.mobileNavigation);
        },
        mobileNavigation: function (event) {
            event.preventDefault();
            window.location.href = $(this).find("option:selected").val();
        }
    };

    App.init();

});