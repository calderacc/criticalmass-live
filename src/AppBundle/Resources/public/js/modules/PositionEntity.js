define(['leaflet', 'MarkerEntity'], function () {
    PositionEntity = function () {

    };

    PositionEntity.prototype = new MarkerEntity();
    PositionEntity.prototype.constructor = PositionEntity;

    PositionEntity.prototype._getProviderName = function() {
        return this._providerName;
    };

    PositionEntity.prototype._getHTML = function () {
        var backgroundImageUrl = '/bundles/app/img/providers/' + this._getProviderName() + '.png';

        return '<div class="user-position-inline" style="background-image: url(' + backgroundImageUrl + ');background-color: black; width: 50px; height: 50px; border-color: ' + this.getColorString() + '"></div>';
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
        var colorRed = this._rgbColor['red'];
        var colorGreen = this._rgbColor['green'];
        var colorBlue = this._rgbColor['blue'];

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