define(['leaflet', 'MarkerEntity'], function () {
    PositionEntity = function () {

    };

    PositionEntity.prototype = new MarkerEntity();
    PositionEntity.prototype.constructor = PositionEntity;

    PositionEntity.prototype._getHTML = function () {
        return '<div class="user-position-inline" style="background-color: black; width: 50px; height: 50px; border-color: ' + this.getColorString() + '"></div>';
    };

    PositionEntity.prototype._initIcon = function () {
        this._icon = L.divIcon({
            iconSize: new L.Point(50, 50),
            className: 'user-position',
            html: this._getHTML()
        });
    };

    PositionEntity.prototype.buildPopup = function () {
        var html = '<h5>' + this._title + '</h5>';
        html += '<p>' + this._description + '</p>';

        return html;
    };

    PositionEntity.prototype.getColorString = function () {
        var colorRed = 255;//this._glympseTicket._colorRed;
        var colorGreen = 127;//this._glympseTicket._colorGreen;
        var colorBlue = 0;//this._glympseTicket._colorBlue;

        return 'rgb(' + Math.round(colorRed) + ', ' + Math.round(colorGreen) + ', ' + Math.round(colorBlue) + ')';
    };

    PositionEntity.prototype.setColor = function (color) {
        this._colorRed = color.red;
        this._colorGreen = color.green;
        this._colorBlue = color.blue;

        this._initIcon();
    };

    PositionEntity.prototype._initPopup = function () {

    };

    return PositionEntity;
});