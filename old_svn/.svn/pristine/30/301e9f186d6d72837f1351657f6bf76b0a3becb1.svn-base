snptips.onFirefoxLoad = function(event) {
  document.getElementById("contentAreaContextMenu")
          .addEventListener("popupshowing", function (e){ snptips.showFirefoxContextMenu(e); }, false);
};

snptips.showFirefoxContextMenu = function(event) {
  // show or hide the menuitem based on what the context menu is on
  document.getElementById("context-snptips").hidden = gContextMenu.onImage;
};

window.addEventListener("load", snptips.onFirefoxLoad, false);
