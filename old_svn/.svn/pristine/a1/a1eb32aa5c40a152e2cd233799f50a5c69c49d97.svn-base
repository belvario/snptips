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

//lookups to the files are slow.  cache results from previous lookups
//SNP -> allele
var snpcache = {};

var snptips = {

    incSnptipCounter : function() {
        return ++snptipCounter;
    },

    onLoad : function() {
        // initialization code
        this.initialized = true;
        this.snptipCounter = 0;

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
        var doc = aEvent.originalTarget; // doc is document that triggered
                                         // "onload" event
        if (isSNPTipsEnabled()) {
            var snpsProcessed = highlightSNPs(doc, getGenomicDataFileContents());
            if(snpsProcessed) {
                // if SNP IDs are found set a resize handler to close any
                //  opened balloon when the browser window is being resized
                var self = this;
                var w = doc.defaultView ? doc.defaultView : doc.parent;
                var actualWindow = w.wrappedJSObject.window; 
                var previousWinResizeHandler = actualWindow.onresize; // save previous handler
                actualWindow.addEventListener('resize',function (e) {
                    // hide the balloon
                    Balloon.prototype.nukeTooltip();
                    actualWindow.Balloon.prototype.nukeTooltip();
                    // and if a previous resize handler was set invoke it
                    if(previousWinResizeHandler) {
                        previousWinResizeHandler(e);
                    }
                },false);
            }
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

//////////////////////////////////// Methods //////////////////////////////////

function injectCssAndJsFile(doc) {
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

///////////////////////////// SNP Highlighting..///////////////////////////////

function SnpTipNode(parentNode, node) {
    this.parentNode = parentNode;
    this.node = node;
}

function highlightSNPs(doc, snpdb) {
    if (!doc.body || typeof (doc.body.innerHTML) == "undefined") {
        // there's no document body so there's nothing to do
        return false;
    }
    var regExp = /[r,R]s[0-9]+/g;
    var walker = doc.createTreeWalker(doc.body, NodeFilter.SHOW_TEXT,
      function(node) {
          var matches = false;
        if(node.nodeValue) {
            matches = node.nodeValue.match(regExp);
        }
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
                if(isNodeAlreadyMarked(parentNode)) {
                    continue;
                }
            } else {
                if(isNodeAlreadyMarked(textNode)) {
                    continue;
                }
            }
            if (isAnchorNode) {
                handleAnchorNode(doc, parentNode, textNode, snpdb);
            } else {
                handleNonAnchorNode(doc, parentNode, textNode, snpdb);
            }
        }
        return true;
    }
    return false;
}

function handleAnchorNode(doc, anchorNode, textNode, snpdb) {
    // I am handling the anchors similarly to the text nodes by splitting the anchor into multiple ones
    var parentOfAnchorNode = anchorNode.parentNode;
    var rsExp = /(\b)([r,R]s[0-9]+)(\b)/g;
    var strs = textNode.nodeValue.split(rsExp);
    var arrNodesToInsert = [];
    for (var si = 0; si<strs.length; si++) {
        var substr = strs[si];
        if(substr.length == 0) {
            // don't create any node if the substring is empty
            continue;
        }
        var newSubstrTextNode = document.createTextNode(substr);
        var newAnchorNode = anchorNode.cloneNode(false);
        newAnchorNode.appendChild(newSubstrTextNode);
        if (substr.match(rsExp)) {
            var rsPattern = /([r,R]s[0-9]+)/;
            var rsIds = rsPattern.exec(substr);
            var rsId = rsIds[0];
            // this substring is an RSID
            var markedSnpNode = getOuterSpanAndAnchorImageNodes(doc, rsId, textNode, snpdb);
            markedSnpNode.outerSpanNode.appendChild(newAnchorNode);
            markedSnpNode.outerSpanNode.appendChild(markedSnpNode.anchorImageNode);
            parentOfAnchorNode.insertBefore(markedSnpNode.outerSpanNode, anchorNode);
        } else {
            // this substring is not an RSID
            parentOfAnchorNode.insertBefore(newAnchorNode,anchorNode);
        }
    }
    parentOfAnchorNode.removeChild(anchorNode);
}

function handleNonAnchorNode(doc, parentNode, textNode, snpdb) {
    var rsExp = /(\b)([r,R]s[0-9]+)(\b)/g;
    var strs = textNode.nodeValue.split(rsExp);
    var arrNodesToInsert = [];
    for (var x = 0; x<strs.length; x++) {
        var searchTerm = strs[x];
        if (searchTerm.length > 0) {
            var newTextNode = document.createTextNode(searchTerm);
            if (searchTerm.match(rsExp)) {
                var rsPattern = /([r,R]s[0-9]+)/;
                var rsIds = rsPattern.exec(searchTerm);
                var rsId = rsIds[0];
                var newNodes = getOuterSpanAndAnchorImageNodes(doc, rsId, textNode, snpdb);
                newNodes.outerSpanNode.appendChild(newTextNode);
                newNodes.outerSpanNode.appendChild(newNodes.anchorImageNode);
                arrNodesToInsert.push(newNodes.outerSpanNode);
            } else {
                arrNodesToInsert.push(newTextNode);
            }
        }
    }
    var rsIdsFound = false;
    for (var i=0; nodeToInsert=arrNodesToInsert[i] ; i++) {
        parentNode.insertBefore(nodeToInsert, textNode);
        rsIdsFound = true;
    }
    if(rsIdsFound) {
        parentNode.removeChild(textNode);
    }
}

function getOuterSpanAndAnchorImageNodes(doc, searchTerm, originalTextNode, snpdb) {
    var balloonMarkup = getBalloonMarkup(searchTerm, snpdb);
    // create the nodes.
    var outerSpanNode = getOuterSpanNode(doc, balloonMarkup.spanCssClassName);
    var defaultSnpTip = snptips.getPropertyString("snptips.defaultTooltip");
    var originalTextNodeTitle = originalTextNode.title;
    if(!originalTextNodeTitle) {
        originalTextNodeTitle = originalTextNode.parentNode.title;
    }
    if(originalTextNodeTitle) {
        var defaultSnpTipRegExp = new RegExp(defaultSnpTip,'g');
        originalTextNodeTitle = originalTextNodeTitle
        .replace(defaultSnpTipRegExp,'')
        .replace(/^\s\s*/, '')
        .replace(/\s\s*$/, '');
    }
    var outerSpanDefaultTitle = originalTextNodeTitle && originalTextNodeTitle != ''
                ? originalTextNodeTitle + '; ' + defaultSnpTip
                : defaultSnpTip;
    outerSpanNode.title = outerSpanDefaultTitle;
    var anchorImageNode = getAnchorImageNode(doc, balloonMarkup.snptipLinkClassName);
    var nodeAnchorOnClickEvent = "balloon.nukeTooltip(); balloon.showTooltip(event, '" + balloonMarkup.snptipBalloonText + "', 1); return false;";
    // add the onMouseEnter handler to the outerSpanNode
    outerSpanNode.addEventListener('mouseover',function (e) {
        outerSpanNode.title = originalTextNodeTitle 
                ? originalTextNodeTitle + '; ' + balloonMarkup.spanTitleText
                : balloonMarkup.spanTitleText;
        // this is an ugly hack because I don't know how to get an instance of the balloon variable
        // I think the problem is created due to a closure which doesn't have a proper
        // reference to the balloon variable when the closure is created
        // On a side note I was able to invoke the showTooltip using the wrappedJSObject.window.balloon
        // but that still created a problem with an access violation: 
        // "permission denied to get MouseEvent.view" so at this point
        // this might be the only alternative
        anchorImageNode.setAttribute("onclick", nodeAnchorOnClickEvent);
        return true;
    },true);
    
    outerSpanNode.addEventListener('mouseout',function (e) {
        outerSpanNode.title = outerSpanDefaultTitle;
        anchorImageNode.removeAttribute("onclick");
        return true;
    },true);

    return {outerSpanNode:outerSpanNode, anchorImageNode:anchorImageNode};
}

function getBalloonMarkup(searchTerm, snpdb) {
    var arrMessage = [];
    arrMessage.push(searchTerm);
    var alleleString = getAlleleString(searchTerm, snpdb);
    var spanCssClassName;
    var snptipKey;
    var snptipLinkClassName;
    var spanTitleText;
    if(alleleString == null) {
        // no data file has been loaded
        spanCssClassName = "snptipGenomicDataNotLoaded";
        snptipKey = "snptips.datafileNotLoaded";
        snptipLinkClassName = "snptipGenomicDataNotLoadedLink";
        spanTitleText = snptips.getPropertyString("snptips.span.title.datafileNotLoaded");
    } else if (alleleString == "") {
        // the datafile is present but the snp is not found in the datafile
        spanCssClassName = "snptipNotPresent";
        snptipKey = "snptips.alleleNotPresent";
        snptipLinkClassName = "snptipNotPresentLink";
        spanTitleText = snptips.getFormattedPropertyString("snptips.span.title.alleleNotPresent", [searchTerm]);
    } else {
        // the datafile is present and the snp was found in the datafile
        spanCssClassName = "snptipPresent";
        snptipKey = "snptips.allelePresent";
        snptipLinkClassName = "snptipPresentLink";
        spanTitleText = snptips.getFormattedPropertyString("snptips.span.title.allelePresent", [searchTerm, alleleString]);
        arrMessage.push(alleleString);
    }
    // Balloon tooltip text.
    var snptipBalloonText = getSnptipBalloonText("div_" + searchTerm, searchTerm, snptipKey, arrMessage);
    return {
        snptipBalloonText:snptipBalloonText, 
        spanTitleText:spanTitleText, 
        spanCssClassName:spanCssClassName, 
        snptipLinkClassName:snptipLinkClassName
    };
}

function getOuterSpanNode(doc, spanCssClassName) {
    var nodeSpan = doc.createElement("span");
    nodeSpan.className = spanCssClassName;
    return nodeSpan;
}

function getAnchorImageNode(doc, linkClassName) {
    var nodeAnchor = doc.createElement("a");
    nodeAnchor.id = "snp_" + snptips.incSnptipCounter();
    nodeAnchor.className = "snptip_icon";
    nodeAnchor.href = "#";
    
    var nodeLink = doc.createElement("span");
    nodeLink.className = linkClassName

    nodeAnchor.appendChild(nodeLink);
    return nodeAnchor;
}

function isNodeAlreadyMarked(snpNode) {
    var parentNode = snpNode.parentNode;
    if (parentNode.tagName.toLowerCase() == "span") {
        var style = parentNode.getAttribute("class");
        if(style && (style.toLowerCase() == "snptipPresent" || 
                     style == "snptipNotPresent" || 
                     style == "snptipGenomicDataNotLoaded")) {
            return true;
        }
    }
    return false;
}

function getSnptipBalloonText(divId, rsNumber, snptipKey, arrMessage) {
    var snptipText = snptips.getFormattedPropertyString(snptipKey, arrMessage);
    var arrBalloon = [divId, snptipText, rsNumber, rsNumber, rsNumber, rsNumber];
    return snptips.getFormattedPropertyString("snptips.balloonTooltip.text", arrBalloon);
}

function getAlleleString(snp, snpdb) {
    if(snpdb == null) {
        // no data file has been loaded
        return null;
    }
    return snpdb.alleleExtractor(snp,snpdb.content);
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
    var dataFileFound = false;
    
    if(filePath != null && filePath != "") {
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
            dataFileFound = true;
        }
    }
    return new snptipDatabase(output);
}

function snptipDatabase(content) {
    this.content = content;
    this.alleleExtractor = null;
    if(content == null) {
        this.alleleExtractor = emptyContentAlleleExtractor;
    } else if(content.indexOf(snptips.getPropertyString("snptips.23andMe.signature")) != -1) {
        this.alleleExtractor = _23andMeAlleleExtractor;
    } else if(content.indexOf(snptips.getPropertyString("snptips.deCODEme.signature")) != -1) {
        this.alleleExtractor = decodeMeAlleleExtractor;
    } else {
        // for now use an emptyContentAlleleExtractor
        this.alleleExtractor = emptyContentAlleleExtractor;
    }
    // need to clear the cache when file changes
    snpcache = {};
}

function emptyContentAlleleExtractor(snp, content) {
    return null;
}

function _23andMeAlleleExtractor(snp, content) {
    if(content == null) {
        // no data file has been loaded
        return null;
    }
    
    if (snpcache[snp] != null) {
        return snpcache[snp];
    }

    var alleleString = "";
    var snpPosition = content.search(snp.toLowerCase() + "\t");
    if (snpPosition != -1) {
        // Call found - find end of this line
        var eol = content.indexOf("\n", snpPosition);
        var allele = content.substr(eol - 3, 2);
        var strand = "+"; // 23andMe is always forward strand
        alleleString = snptips.getFormattedPropertyString("snptips.title.alleleString", [allele,strand]);
    }
    
    snpcache[snp] = alleleString;
    
    return alleleString;
}

function decodeMeAlleleExtractor(snp, content) {
    if(content == null) {
        // no data file has been loaded
        return null;
    }
    
    if (snpcache[snp] != null) {
        return snpcache[snp];
    }
    
    var alleleString = "";
    var snpPosition = content.search(snp.toLowerCase() + ",");
    if (snpPosition != -1) {
        // Call found - find end of this line
        var eol = content.indexOf("\n", snpPosition);
        var rsInfo;
        if(eol != -1) {
            rsInfo = content.substr(snpPosition,eol-snpPosition);
        } else {
            rsInfo = content.substr(snpPosition);
        }
        // trim the string to get rid of any \r at the end of the string
        rsInfo = rsInfo.replace(/^\s+/, '').replace(/\s+$/, '');
        var rsFields = rsInfo.split(/,/);
        var allele = rsFields[5];
        var strand = rsFields[4];
        alleleString = snptips.getFormattedPropertyString("snptips.title.alleleString", [allele,strand]);
    }
    
    snpcache[snp] = alleleString;
    
    return alleleString;
}

///////////////////////////// Preferences Listener ////////////////////////////

function PrefListener(branchName, func) {
    var prefService = Components.classes["@mozilla.org/preferences-service;1"]
                                .getService(Components.interfaces.nsIPrefService);
    var branch = prefService.getBranch(branchName);
    branch.QueryInterface(Components.interfaces.nsIPrefBranch2);

    this.register = function() {
        branch.addObserver("", this, false);
        branch.getChildList("", { })
              .forEach(function (name) { func(branch, name); });
    };

    this.unregister = function unregister() {
        if (branch) {
            branch.removeObserver("", this);
        }
    };

    this.observe = function(subject, topic, data) {
        if (topic == "nsPref:changed") {
            func(branch, data);
        }
    };
}

var myListener = new PrefListener("extensions.snptips.",
                                  function(branch, name) {
                                      switch (name) {
                                          case "dataFile":
                                              // Do anything specific to
                                                // datafile change
                                              break;
                                          case "snptipsEnabled":
                                              updateStatusBar();
                                              break;
                                      }
                                      // Refresh window
                                      content.document.location.reload();
                                  });
myListener.register();
