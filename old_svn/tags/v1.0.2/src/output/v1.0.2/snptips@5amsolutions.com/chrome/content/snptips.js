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

    getFormattedPropertyStringFromBundle : function (key, arrayString) {
    	var bundle = srGetStrBundle(SNPTipsConstants.snptipsPropertiesFile);
    	return bundle.formatStringFromName(key, arrayString, arrayString.length);
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

function SnpTipNode(parentNode, node) {
	this.parentNode = parentNode;
	this.node = node;
}

function highlightSNPs(doc, snpdb) {
	if (!doc.body || typeof (doc.body.innerHTML) == "undefined" || snpdb == null) {
		return false;
	}
	
	var regExp = new RegExp();
	regExp.compile("([r,R]s[0-9]+)");
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
	
	var arrSnptipNodes = [];
	while(walker.nextNode()) {
		var snptipNode = new SnpTipNode(walker.currentNode.parentNode, walker.currentNode);
		arrSnptipNodes.push(snptipNode);
	}
	
	if (arrSnptipNodes.length > 0) {
		injectCssAndJsFile(doc);
		for (var i=0; snptipNode=arrSnptipNodes[i] ; i++) {
			var parentNode = snptipNode.parentNode;
			var textNode = snptipNode.node;
			
			var isAnchorNode = false;
			if (parentNode.tagName.toLowerCase() == "a") {
				isAnchorNode = true;
			}
			
			if (isAnchorNode) {
				handleAnchorNode(doc, parentNode, textNode, snpdb);
			} else {
				handleNonAnchorNode(doc, parentNode, textNode, snpdb);
			}
		}
	}
	
	return true;
}

function handleAnchorNode(doc, parentNode, textNode, snpdb) {
	var searchTerm = getSearchTermFromAnchorElement(textNode);
	if (searchTerm != null) {
		var newNodes = getOuterSpanAndAnchorImageNodes(doc, searchTerm, snpdb);
		var newAnchorNode = parentNode.cloneNode(true);
		newNodes.outerSpanNode.appendChild(newAnchorNode);
		newNodes.outerSpanNode.appendChild(newNodes.anchorImageNode);
		parentNode.parentNode.insertBefore(newNodes.outerSpanNode, parentNode);
		parentNode.parentNode.removeChild(parentNode);
	}
}

function getSearchTermFromAnchorElement(textNode) {
	var searchTerm = null;
	var strs = textNode.nodeValue.split(/(\b[r,R]s[0-9]+\b)/);
	for (var x = 0; x<strs.length; x++) {
		if (searchTerm == null && strs[x].match(/(\b[r,R]s[0-9]+\b)/)) {
			searchTerm = strs[x];
		}
	}
	return searchTerm;
}

function handleNonAnchorNode(doc, parentNode, textNode, snpdb) {
	var strs = textNode.nodeValue.split(/(\b[r,R]s[0-9]+\b)/);
	var arrNodesToInsert = [];
	for (var x = 0; x<strs.length; x++) {
		var searchTerm = strs[x];
		if (searchTerm.length > 0) {
			var newTextNode = document.createTextNode(searchTerm);
			if (searchTerm.match(/(\b[r,R]s[0-9]+\b)/)) {
				var newNodes = getOuterSpanAndAnchorImageNodes(doc, searchTerm, snpdb);
				newNodes.outerSpanNode.appendChild(newTextNode);
				newNodes.outerSpanNode.appendChild(newNodes.anchorImageNode);
				arrNodesToInsert.push(newNodes.outerSpanNode);
			} else {
				arrNodesToInsert.push(newTextNode);
			}
		}
	}
	for (var i=0; nodeToInsert=arrNodesToInsert[i] ; i++) {
		parentNode.insertBefore(nodeToInsert, textNode);
	}
	parentNode.removeChild(textNode);
}

function getOuterSpanAndAnchorImageNodes(doc, searchTerm, snpdb) {
	var balloonMarkup = getBalloonMarkup(searchTerm, snpdb);
	var nodeAnchorOnClickEvent = "balloon.nukeTooltip(); balloon.showTooltip(event, '" + balloonMarkup.snptipBalloonText + "', 1)";
	// get the nodes.
	var outerSpanNode = getOuterSpanNode(doc, balloonMarkup.spanTitleText, balloonMarkup.spanCssClassName);
	var anchorImageNode = getAnchorImageNode(doc, nodeAnchorOnClickEvent, balloonMarkup.nodeImgUrl);
	
	return {outerSpanNode:outerSpanNode, anchorImageNode:anchorImageNode};
}

function getBalloonMarkup(searchTerm, snpdb) {
	var arrMessage = [];
	arrMessage.push(searchTerm);
	var alleleString = getAlleleString(searchTerm, snpdb);
	
	var spanCssClassName = "snptipPresent";
	var snptipKey = "snptips.allelePresent";
	var nodeImgUrl = "chrome://snptips/skin/snp_present.png";
	var spanTitleText = "";
	if (alleleString != "") {
		arrMessage.push(alleleString);
		spanTitleText = snptips.getFormattedPropertyString("snptips.span.title.allelePresent", [searchTerm, alleleString]);
	} else {
		spanCssClassName = "snptipNotPresent";
		snptipKey = "snptips.alleleNotPresent";
		nodeImgUrl = "chrome://snptips/skin/snp_not_present.png";
		spanTitleText = snptips.getFormattedPropertyString("snptips.span.title.alleleNotPresent", [searchTerm]);
	}
	// Balloon tooltip text.
	var snptipBalloonText = getSnptipBalloonText("div_" + searchTerm, searchTerm, snptipKey, arrMessage);
	return {snptipBalloonText:snptipBalloonText, spanTitleText:spanTitleText, spanCssClassName:spanCssClassName, nodeImgUrl:nodeImgUrl};
}


function getOuterSpanNode(doc, spanTitleText, spanCssClassName) {
	var nodeSpan = doc.createElement("span");
	nodeSpan.className = spanCssClassName;
	nodeSpan.setAttribute("title", spanTitleText);
	return nodeSpan;
}

function getAnchorImageNode(doc, anchorOnClickEvent, imgUrl) {
	var nodeAnchor = doc.createElement("a");
	nodeAnchor.className = "snptip_icon";
	nodeAnchor.setAttribute("onclick", anchorOnClickEvent);

	var nodeImg = new Image();
	nodeImg.setAttribute("src", imgUrl);
	nodeImg.setAttribute("border", "0");

	nodeAnchor.appendChild(nodeImg);
	return nodeAnchor;
}

function getSnptipBalloonText(divId, rsNumber, snptipKey, arrMessage) {
	var snptipText = snptips.getFormattedPropertyString(snptipKey, arrMessage);
	var arrBalloon = [divId, snptipText, rsNumber, rsNumber, rsNumber, rsNumber];
	return snptips.getFormattedPropertyString("snptips.balloonTooltip.text", arrBalloon);
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


