define(['leaflet', 'Factory', 'Container'], function (L, Factory) {
    MapPositions = function (context, options) {
        this._options = options;

        this._container = new Container();
    };

    MapPositions.prototype._options = null;
    MapPositions.prototype._map = null;
    MapPositions.prototype._timer = null;
    MapPositions.prototype._container = null;
    MapPositions.prototype._offlineCallback = null;

    MapPositions.prototype.addToMap = function (map) {
        this._map = map;

        this._container.addToMap(this._map);
    };

    MapPositions.prototype.start = function () {
        this._drawPositions();

        var that = this;
        this._timer = window.setInterval(function () {
            that._drawPositions();

        }, 15000);
    };

    MapPositions.prototype.setOfflineCallback = function (offlineCallback) {
        this._offlineCallback = offlineCallback;
    };

    MapPositions.prototype.addToControl = function (layerArray, title) {
        this._container.addToControl(layerArray, title);
    };

    MapPositions.prototype.getLayer = function () {
        return this._container.getLayer();
    };

    MapPositions.prototype._clearOldPositions = function (resultArray) {
        for (var existingIdentifier in this._container.getList()) {
            var found = false;

            for (var index in resultArray) {
                if (existingIdentifier == resultArray[index].id) {
                    found = true;
                    break;
                }
            }

            if (!found) {
                this._removeUsernamePosition(existingIdentifier);
            }
        }
    };

    MapPositions.prototype._removeUsernamePosition = function (id) {
        this._container.removeEntity(id);
    };

    MapPositions.prototype._createUsernamePosition = function (position) {
        var positionElement = Factory.createPosition(position);

        //positionElement.addToMap(this._map);
        positionElement.addToContainer(this._container, positionElement._id);
    };

    MapPositions.prototype._moveUsernamePosition = function (position) {
        this._container.getEntity(position.id).setLatLng([position.latitude, position.longitude]);
    };

    MapPositions.prototype._drawPositions = function () {
        var that = this;

        function successCallback(resultArray) {
            for (var index in resultArray) {
                var identifier = resultArray[index].id;

                if (!that._container.hasEntity(identifier)) {
                    that._createUsernamePosition(resultArray[index]);
                } else {
                    that._moveUsernamePosition(resultArray[index]);
                }
            }

            that._clearOldPositions(resultArray);
        }

        function errorCallback() {
            if (that._offlineCallback) {
                that._offlineCallback();
            }
        }
        $.support.cors = true;

        var route = Routing.generate('caldera_criticalmass_live_api_position');

        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: route,
            cache: false,
            success: successCallback,
            error: errorCallback
        });
    };

    MapPositions.prototype._isUserPositionColor = function (identifier, displayColor) {

        if (!this._container.hasEntity(identifier)) {
            return null;
        }

        return this._container.getEntity(identifier).getColorString()
            ==
            'rgb(' + displayColor.red + ', ' + displayColor.green + ', ' + displayColor.blue + ')';
    };

    MapPositions.prototype._setUserPositionColor = function (identifier, displayColor) {
        this._container.getEntity(identifier).setColor(displayColor);
    };

    MapPositions.prototype.countPositions = function () {
        return this._container.countEntities();
    };

    MapPositions.prototype.getLatestLatLng = function () {
        var positionList = this._container.getList();

        var latestPosition = positionList[0];

        if (latestPosition) {
            return latestPosition.getLatLng();
        }

        return null;
    };

    return MapPositions;
});
