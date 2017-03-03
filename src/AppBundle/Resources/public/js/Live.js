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
        'leaflet-hash': '/bundles/app/js/leaflet/leaflet-hash',
        'leaflet-locate': '/bundles/app/js/leaflet/L.Control.Locate',
        'leaflet-groupedlayer': '/bundles/app/js/leaflet/leaflet.groupedlayercontrol',
        'leaflet-extramarkers': '/bundles/app/js/leaflet/ExtraMarkers',
        'dateformat': '/bundles/app/js/dateformat/dateformat'
    },
    shim: {
        'leaflet-hash': {
            deps: ['leaflet'],
            exports: 'L.Hash'
        },
        'leaflet-locate': {
            deps: ['leaflet'],
            exports: 'L.Control.Locate'
        },
        'leaflet-groupedlayer': {
            deps: ['leaflet'],
            exports: 'L.Control.GroupedLayers'
        },
        'leaflet-extramarkers': {
            deps: ['leaflet'],
            exports: 'L.ExtraMarkers'
        }
    }
});
