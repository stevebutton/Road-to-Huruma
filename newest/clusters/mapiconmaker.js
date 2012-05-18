var MapIconMaker = {};

/**
 * Creates an icon based on the specified options in the 
 *   {@link MarkerIconOptions} argument.
 *   Supported options are: width, height, primaryColor, 
 *   strokeColor, and cornerColor.
 * @param {MarkerIconOptions} [opts]
 * @return {GIcon}
 */
MapIconMaker.createMarkerIcon = function (opts) {
  var width = opts.width || 32;
  var height = opts.height || 32;
  var primaryColor = opts.primaryColor || "#ff0000";
  var strokeColor = opts.strokeColor || "#000000";
  var cornerColor = opts.cornerColor || "#ffffff";
   
  var baseUrl = "http://chart.apis.google.com/chart?cht=mm";
  var iconUrl = baseUrl + "&chs=" + width + "x" + height + 
      "&chco=" + cornerColor.replace("#", "") + "," + 
      primaryColor.replace("#", "") + "," + 
      strokeColor.replace("#", "") + "&ext=.png";
  var icon = new GIcon(G_DEFAULT_ICON);
  icon.image = iconUrl;
  icon.iconSize = new GSize(width, height);
  icon.shadowSize = new GSize(Math.floor(width * 1.6), height);
  icon.iconAnchor = new GPoint(width / 2, height);
  icon.infoWindowAnchor = new GPoint(width / 2, Math.floor(height / 12));
  icon.printImage = iconUrl + "&chof=gif";
  icon.mozPrintImage = iconUrl + "&chf=bg,s,ECECD8" + "&chof=gif";
  iconUrl = baseUrl + "&chs=" + width + "x" + height + 
      "&chco=" + cornerColor.replace("#", "") + "," + 
      primaryColor.replace("#", "") + "," + 
      strokeColor.replace("#", "");
  icon.transparent = iconUrl + "&chf=a,s,ffffff11&ext=.png";

  icon.imageMap = [
    width / 2, height,
    (7 / 16) * width, (5 / 8) * height,
    (5 / 16) * width, (7 / 16) * height,
    (7 / 32) * width, (5 / 16) * height,
    (5 / 16) * width, (1 / 8) * height,
    (1 / 2) * width, 0,
    (11 / 16) * width, (1 / 8) * height,
    (25 / 32) * width, (5 / 16) * height,
    (11 / 16) * width, (7 / 16) * height,
    (9 / 16) * width, (5 / 8) * height
  ];
  for (var i = 0; i < icon.imageMap.length; i++) {
    icon.imageMap[i] = parseInt(icon.imageMap[i]);
  }

  return icon;
};


/**
 * Creates a flat icon based on the specified options in the 
 *     {@link MarkerIconOptions} argument.
 *     Supported options are: width, height, primaryColor,
 *     shadowColor, label, labelColor, labelSize, and shape..
 * @param {MarkerIconOptions} [opts]
 * @return {GIcon}
 */
MapIconMaker.createFlatIcon = function (opts) {
  var width = opts.width || 32;
  var height = opts.height || 32;
  var primaryColor = opts.primaryColor || "#ff0000";
  var shadowColor = opts.shadowColor || "#000000";
  var label = MapIconMaker.escapeUserText_(opts.label) || "";
  var labelColor = opts.labelColor || "#000000";
  var labelSize = opts.labelSize || 0;
  var shape = opts.shape ||  "circle";
  var shapeCode = (shape === "circle") ? "it" : "itr";

//chco=FF0000ff,ffffff01,ffffff01
//chf=bg,s,ffffff00
  var baseUrl = "http://chart.apis.google.com/chart?cht=" + shapeCode;
  var iconUrl = baseUrl + "&chs=" + width + "x" + height + 
      "&chco=" + primaryColor.replace("#", "") + "af,ffffff01,ffffff01" +
      "&chl=" + label + "&chx=" + labelColor.replace("#", "") + 
      "," + labelSize;
  var icon = new GIcon(G_DEFAULT_ICON);
  icon.image = iconUrl + "&chf=bg,s,ffffff00" + "&ext=.png";
  icon.iconSize = new GSize(width, height);
  icon.shadowSize = new GSize(0, 0);
  icon.iconAnchor = new GPoint(width / 2, height / 2);
  icon.infoWindowAnchor = new GPoint(width / 2, height / 2);
  icon.printImage = iconUrl + "&chof=gif";
  icon.mozPrintImage = iconUrl + "&chf=bg,s,ECECD8" + "&chof=gif";
  icon.transparent = iconUrl + "&chf=a,s,ffffff01&ext=.png";
  icon.imageMap = []; 
  if (shapeCode === "itr") {
    icon.imageMap = [0, 0, width, 0, width, height, 0, height];
  } else {
    var polyNumSides = 8;
    var polySideLength = 360 / polyNumSides;
    var polyRadius = Math.min(width, height) / 2;
    for (var a = 0; a < (polyNumSides + 1); a++) {
      var aRad = polySideLength * a * (Math.PI / 180);
      var pixelX = polyRadius + polyRadius * Math.cos(aRad);
      var pixelY = polyRadius + polyRadius * Math.sin(aRad);
      icon.imageMap.push(parseInt(pixelX), parseInt(pixelY));
    }
  }

  return icon;
};


/**
 * Creates a labeled marker icon based on the specified options in the 
 *     {@link MarkerIconOptions} argument.
 *     Supported options are: primaryColor, strokeColor, 
 *     starPrimaryColor, starStrokeColor, label, labelColor, and addStar.
 * @param {MarkerIconOptions} [opts]
 * @return {GIcon}
 */
MapIconMaker.createLabeledMarkerIcon = function (opts) {
  var primaryColor = opts.primaryColor || "#DA7187";
  var strokeColor = opts.strokeColor || "#000000";
  var starPrimaryColor = opts.starPrimaryColor || "#FFFF00";
  var starStrokeColor = opts.starStrokeColor || "#0000FF";
  var label = MapIconMaker.escapeUserText_(opts.label) || "";
  var labelColor = opts.labelColor || "#000000";
  var addStar = opts.addStar || false;
  
  var pinProgram = (addStar) ? "pin_star" : "pin";
  var baseUrl = "http://chart.apis.google.com/chart?cht=d&chdp=mapsapi&chl=";
  var iconUrl = baseUrl + pinProgram + "'i\\" + "'[" + label + 
      "'-2'f\\"  + "hv'a\\]" + "h\\]o\\" + 
      primaryColor.replace("#", "")  + "'fC\\" + 
      labelColor.replace("#", "")  + "'tC\\" + 
      strokeColor.replace("#", "")  + "'eC\\";
  if (addStar) {
    iconUrl += starPrimaryColor.replace("#", "") + "'1C\\" + 
        starStrokeColor.replace("#", "") + "'0C\\";
  }
  iconUrl += "Lauto'f\\";

  var icon = new GIcon(G_DEFAULT_ICON);
  icon.image = iconUrl + "&ext=.png";
  icon.iconSize = (addStar) ? new GSize(23, 39) : new GSize(21, 34);
  return icon;
};


/**
 * Utility function for doing special chart API escaping first,
 *  and then typical URL escaping. Must be applied to user-supplied text.
 * @private
 */
MapIconMaker.escapeUserText_ = function (text) {
  if (text === undefined) {
    return null;
  }
  text = text.replace(/@/, "@@");
  text = text.replace(/\\/, "@\\");
  text = text.replace(/'/, "@'");
  text = text.replace(/\[/, "@[");
  text = text.replace(/\]/, "@]");
  return encodeURIComponent(text);
};

