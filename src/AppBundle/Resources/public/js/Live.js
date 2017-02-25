var Live = Live || {};

Live.loadModule = function(name, context, options, callback) {
    require([name], function(Module) {
        var module = new Module(context, options);

        if (callback) {
            callback(module);
        }
    });
};

require.config({
    paths:
    {
        "LivePage": "/bundles/app/js/modules/LivePage",
        "LiveFrontPage": "/bundles/app/js/modules/LiveFrontPage"
    },
});
