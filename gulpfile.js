var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.less(['custom.less'],  'public/css/all.css');

    mix.less(["admin/admin.less"], "public/css/admin/all.css");

    mix.version(['public/css/all.css', "public/css/admin/all.css"]);

    mix.scripts(["jquery.min.js", "bootstrap.min.js", "jquery.easing.min.js", "classie.js", "cbpAnimatedHeader.js", "jqBootstrapValidation.js", "contact_me.js", "agency.js", "sweetalert.min.js", "jquery.validate.js"], "public/js", "resources/assets/js");

    mix.copy('resources/assets/js/admin/custom.js', 'public/js/admin/custom.js');

    mix.copy('resources/assets/js/admin/vendor.js', 'public/js/admin/vendor.js');
});
