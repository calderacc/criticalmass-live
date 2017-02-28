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
    baseUrl: '/bundles/app/js/modules',
    paths:
    {
        'leaflet': '/bundles/app/js/leaflet/leaflet',
        'leaflet-hash': '/bundles/app/js/leaflet/leaflet-hash'
    },
    shim: {
        'leaflet-hash': {
            deps: ['leaflet'],
            exports: 'L.Hash'
        }
    }
});
