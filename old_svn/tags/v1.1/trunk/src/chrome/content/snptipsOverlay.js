// SNPTips(tm) by 5AM Solutions, Inc.
// 
// This work is licensed under the Creative Commons 
// Attribution-ShareAlike 3.0 Unported License. To view a copy of 
// this license, visit http://creativecommons.org/licenses/by-sa/3.0/ 
// or send a letter to Creative Commons, 171 Second Street, Suite 300, 
// San Francisco, California, 94105, USA.
// See LICENSE.txt for more information.

snptips.onFirefoxLoad = function(event) {
  document.getElementById("contentAreaContextMenu")
          .addEventListener("popupshowing", function (e){ snptips.showFirefoxContextMenu(e); }, false);
};

snptips.showFirefoxContextMenu = function(event) {
  // show or hide the menuitem based on what the context menu is on
  document.getElementById("context-snptips").hidden = gContextMenu.onImage;
};

window.addEventListener("load", snptips.onFirefoxLoad, false);
