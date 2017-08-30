define(['leaflet'], function () {
    LiveFrontPage = function (context, options) {
        this._options = options;

        this._init();
    };

    LiveFrontPage.prototype._init = function () {
        var that = this;

        $('button#ride-on').on('click', function (event) {
            event.preventDefault();

            that._selectRide();
        });

        $('button#auto-select').on('click', function (event) {
            event.preventDefault();

            that._autoSelectRide();
        });
    };

    LiveFrontPage.prototype._selectRide = function () {
        var citySlug = $('select#select-ride option:selected').data('city-slug');

        this._forwardToLive(citySlug);
    };

    LiveFrontPage.prototype._forwardToLive = function (citySlug) {
        var url = Routing.generate('live_city', {citySlug: citySlug}, true);

        window.location.replace(url);
    };

    LiveFrontPage.prototype._autoSelectRide = function () {
        var that = this;

        var minDistance = null;
        var minSlug = null;

        function successCallback(geolocationResult) {
            var userPosition = new L.LatLng(geolocationResult.coords.latitude, geolocationResult.coords.longitude);

            $('select > option').each(function () {
                var cityLatLng = new L.LatLng($(this).data('latitude'), $(this).data('longitude'));

                var distance = userPosition.distanceTo(cityLatLng);

                if (distance < minDistance || !minDistance) {
                    minDistance = distance;
                    minSlug = $(this).data('city-slug');
                }
            });

            that._forwardToLive(minSlug);
        }

        navigator.geolocation.getCurrentPosition(successCallback);
    };

    return LiveFrontPage;
});
