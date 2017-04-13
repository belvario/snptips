// ***********************************************************
// SNPTips(tm) by 5AM Solutions, Inc.
// 
// This work is licensed under the Creative Commons 
// Attribution-ShareAlike 3.0 Unported License. To view a copy of 
// this license, visit http://creativecommons.org/licenses/by-sa/3.0/ 
// or send a letter to Creative Commons, 171 Second Street, Suite 300, 
// San Francisco, California, 94105, USA.
// See LICENSE.txt for more information.


const SNPTipsConstants = {
    homeUrl: "http://www.snptips.com",
    prefSnpTipsEnabled: "extensions.snptips.snptipsEnabled",
    prefDataFile: "extensions.snptips.dataFile",
    elemSnpTipsEnabled: "snptipsEnabled",
    elemDataFile: "snptipsDataFile",
    imgSnptips: "chrome://snptips/skin/snptips.png",
    imgEnabled: "chrome://snptips/skin/snptips_enabled.png",
    imgDisabled: "chrome://snptips/skin/snptips_disabled.png",
    snptipsCssFile: "chrome://snptips/skin/snptips.css",
    snptipsPropertiesFile: "chrome://snptips/locale/snptips.properties"
};

var prefManager = Components.classes["@mozilla.org/preferences-service;1"].getService(Components.interfaces.nsIPrefBranch);

var snptips = {
	onLoad : function() {
		// initialization code
		this.initialized = true;

		var appcontent = document.getElementById("appcontent"); // browser
		if (appcontent) {
			appcontent.addEventListener("DOMContentLoaded", snptips.onPageLoad, true);
		}

		// Variables
		var enableDisableSnpTips = true;
		var dataFilePath = "";

		updateStatusBar();
	},

	onLoadPreferences : function(event) {
		loadPreferences();
	},

	onSavePreferences : function(event) {
		savePreferences();
	},

	onToggleSNPTips : function() {
		toggleEnabledState();
	},

	onPageLoad : function(aEvent) {
		var doc = aEvent.originalTarget; // doc is document that triggered "onload" event
		injectCssAndJsFile(doc);

		if (isSNPTipsEnabled()) {
			highlightSNPs(doc, getGenomicDataFileContents());
		}
	},

	onVisitWebsite : function(url) {
        openNewTab(SNPTipsConstants[url]);
    },

    getPropertyString : function (key) {
    	return document.getElementById("snptips_properties").getString(key);
    },

    getFormattedPropertyString : function (key, arrayString) {
    	return document.getElementById("snptips_properties").getFormattedString(key, arrayString);
    },

    getPropertyStringFromBundle : function (key) {
    	var bundle = srGetStrBundle(SNPTipsConstants.snptipsPropertiesFile);
    	return bundle.GetStringFromName(key);
    },

    getFormattedPropertyStringFromBundle : function (key, arrayString, len) {
    	var bundle = srGetStrBundle(SNPTipsConstants.snptipsPropertiesFile);
    	return bundle.formatStringFromName(key, arrayString, len);
    }
};

window.addEventListener("load", snptips.onLoad, false);

///////////////////////////////////////////////////// Methods /////////////////////////////////////////////////////////////

function injectCssAndJsFile(doc)
{
	var head = doc.getElementsByTagName("head")[0];

	var link = doc.createElement("link");
	link.setAttribute("rel", "stylesheet");
	link.setAttribute("type", "text/css");
	link.setAttribute("href", SNPTipsConstants.snptipsCssFile);
	head.appendChild(link);

	var jssFiles = ["balloon.config.js", "balloon.js", "box.js", "yahoo-dom-event.js", "balloonTooltip.js"];
	for(var i=0; i<jssFiles.length; i++) {
		var script = doc.createElement("script");
		script.setAttribute("type", "application/x-javascript");
		script.setAttribute("src", "chrome://snptips/content/balloon/js/" + jssFiles[i]);
		head.appendChild(script);
	}
}

function loadPreferences() {
	document.getElementById(SNPTipsConstants.elemSnpTipsEnabled).checked = this.isSNPTipsEnabled();
	document.getElementById(SNPTipsConstants.elemDataFile).value = this.getDataFilePath();
}

function savePreferences() {
	setSNPTipsEnabled(document.getElementById(SNPTipsConstants.elemSnpTipsEnabled).checked);
	setDataFilePath(document.getElementById(SNPTipsConstants.elemDataFile).value);
}

function isSNPTipsEnabled() {
	return prefManager.getBoolPref(SNPTipsConstants.prefSnpTipsEnabled);
}

function setSNPTipsEnabled(flag) {
	prefManager.setBoolPref(SNPTipsConstants.prefSnpTipsEnabled, flag);
}

function getDataFilePath() {
	return prefManager.getCharPref(SNPTipsConstants.prefDataFile);
}

function setDataFilePath(filePath) {
	prefManager.setCharPref(SNPTipsConstants.prefDataFile, filePath);
}

function toggleEnabledState() {
	setSNPTipsEnabled(!isSNPTipsEnabled());
}

function openNewTab(url) {
	if (!url) {
		return;
	}
	gBrowser.selectedTab = gBrowser.addTab(url, null, null, null);
}

function updateStatusBar() {
	var elemStatusBarPanel = document.getElementById("snptipsStatusBarPanel");

	var statusBarPanelImage = SNPTipsConstants["imgSnptips"];
	var statusBarPanelTooltip = snptips.getPropertyString("snptips.statusBar.tooltip");
	var statusText = "";

	if (elemStatusBarPanel != null) {
		if (isSNPTipsEnabled()) {
			statusBarPanelImage = SNPTipsConstants["imgEnabled"];
			statusText = snptips.getPropertyString("snptips.statusBar.tooltipEnabledText");
		} else {
			statusBarPanelImage = SNPTipsConstants["imgDisabled"];
			statusText = snptips.getPropertyString("snptips.statusBar.tooltipDisabledText");
		}

		elemStatusBarPanel.image = statusBarPanelImage;
		elemStatusBarPanel.tooltipText = statusBarPanelTooltip + "-" + statusText;
	}
}

/////////////////////////////// SNP Highlighting..////////////////////////////////////////////////////////

function highlightSNPs(doc, snpdb) {
	if (!doc.body || typeof (doc.body.innerHTML) == "undefined" || snpdb == null) {
		return false;
	}

	var regExp = new RegExp();
	regExp.compile("[r,R]s[0-9]+");
	var walker = doc.createTreeWalker(doc.body, NodeFilter.SHOW_TEXT,
	  function(node) {
	    var matches = node.nodeValue.match(regExp);
	    if(matches) {
	      return NodeFilter.FILTER_ACCEPT;
	    } else {
	      return NodeFilter.FILTER_SKIP;
	    }
	  },
	  false);

	var nodes = [];
	while(walker.nextNode()) {
	  nodes.push(walker.currentNode);
	}
	// if nodes[] contains just the rs#, simply wrap it in a <span> element.
	// if not, we need to split the entire text node into multiple elements, and
	// re-insert the text nodes and rs#s to the dom.
	for(var i = 0; node=nodes[i] ; i++) {
		var strs = node.nodeValue.split(/([r,R]s[0-9]+)/);
		for (var x = 0; x<strs.length; x++) {
			var searchTerm = strs[x];
			if (searchTerm.length > 0) {
				var parentNode = node.parentNode;
				var nodeText = document.createTextNode(searchTerm);
				if (searchTerm.match(/([r,R]s[0-9]+)/)) { // rs# match
					var arrMessage = [];
					var paramLen = 1;
					arrMessage.push(searchTerm);
					var spanCssClassName = "snptipNotPresent";
					var snptipKey = "snptips.alleleNotPresent";

					var alleleString = getAlleleString(searchTerm, snpdb);
					if (alleleString != "") {
						spanCssClassName = "snptipPresent";
						snptipKey = "snptips.allelePresent";
						arrMessage.push(alleleString);
						paramLen = 2;
					}

					var snptipBalloonText = getSnptipBalloonText("div_" + searchTerm, searchTerm, snptipKey, arrMessage, paramLen);
					var mouseoverEvent = "balloon.showTooltip(event, '" + snptipBalloonText + "', 1)";
					var nodeSpan = document.createElement("span");
					nodeSpan.className = spanCssClassName;
					nodeSpan.setAttribute("onmouseover", mouseoverEvent);
					nodeSpan.appendChild(nodeText);
					parentNode.insertBefore(nodeSpan, node);
				} else {
					parentNode.insertBefore(nodeText, node);
				}
			}
		}
		parentNode.removeChild(node);
	}
	return true;
}

function getSnptipBalloonText(divId, rsNumber, snptipKey, arrMessage, paramLen) {
	var snptipText = snptips.getFormattedPropertyString(snptipKey, arrMessage, paramLen);
	var arrBalloon = [divId, snptipText, rsNumber, rsNumber, rsNumber, rsNumber];
	return snptips.getFormattedPropertyString("snptips.tooltip.text", arrBalloon, 6);
}

function getAlleleString(snp, snpdb) {
	var alleleString = "";
	var snpPosition = snpdb.indexOf(snp.toLowerCase() + "\t");
	if (snpPosition != -1) {
		// Call found - find end of this line
		var eol = snpdb.indexOf("\n", snpPosition);
		alleleString = snpdb.substr(eol - 3, 2);
	}

	return alleleString;
}

function onFileOpen() {
	  var nsIFilePicker = Components.interfaces.nsIFilePicker;
	  var fp = Components.classes["@mozilla.org/filepicker;1"].createInstance(nsIFilePicker);
	  fp.init(window, snptips.getPropertyString("snptips.selectDataFile"), nsIFilePicker.modeOpen);
	  fp.appendFilters(nsIFilePicker.filterText | nsIFilePicker.filterAll);

	  var res = fp.show();
	  if (res == nsIFilePicker.returnOK) {
		  document.getElementById(SNPTipsConstants.elemDataFile).value = fp.file.path;
	  }
}

function getGenomicDataFileContents() {
	var output = null;
	var filePath = getDataFilePath();
	var file = Components.classes["@mozilla.org/file/local;1"].createInstance(Components.interfaces.nsILocalFile);
	var fstream = Components.classes["@mozilla.org/network/file-input-stream;1"].createInstance(Components.interfaces.nsIFileInputStream);
	var sstream = Components.classes["@mozilla.org/scriptableinputstream;1"].createInstance(Components.interfaces.nsIScriptableInputStream);

	file.initWithPath(filePath);
	if (file.exists() && file.isFile()) {
		fstream.init(file, 0x01, 00004, null);
		sstream.init(fstream);
		output = sstream.read(sstream.available());
		sstream.close();
		fstream.close();
	} else {
		setSNPTipsEnabled(false);
		alert(snptips.getPropertyString("snptips.dataFile.notExists"));
	}

	return output;
}


////////////////////////////////////////// Preferences Listener /////////////////////////////////////////////////////////////////

function PrefListener(branchName, func)
{
    var prefService = Components.classes["@mozilla.org/preferences-service;1"]
                                .getService(Components.interfaces.nsIPrefService);
    var branch = prefService.getBranch(branchName);
    branch.QueryInterface(Components.interfaces.nsIPrefBranch2);

    this.register = function()
    {
        branch.addObserver("", this, false);
        branch.getChildList("", { })
              .forEach(function (name) { func(branch, name); });
    };

    this.unregister = function unregister()
    {
        if (branch)
            branch.removeObserver("", this);
    };

    this.observe = function(subject, topic, data)
    {
        if (topic == "nsPref:changed")
            func(branch, data);
    };
}

var myListener = new PrefListener("extensions.snptips.",
                                  function(branch, name)
                                  {
                                      switch (name)
                                      {
                                          case "dataFile":
                                              // Do anything specific to datafile change
                                              break;
                                          case "snptipsEnabled":
                                        	  updateStatusBar();
                                              break;
                                      }
									  // Refresh window
								      content.document.location.reload();
                                  });
myListener.register();


