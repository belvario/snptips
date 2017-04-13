function findsnps() {
	var regExp = new RegExp();
	regExp.compile("rs[0-9]+");
	var walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT,
	  function(node) {
	  //  var matches = node.textContent.match(regExp);
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

	for(var i = 0; node=nodes[i] ; i++) {
		var strs = node.nodeValue.split(/(rs[0-9]+)/) ;//.split(regExp); string.split(/(0x0){1}/)
		for (var x = 0; x<strs.length; x++) {
			var parentNode = node.parentNode;
			var nodeText = document.createTextNode(strs[x]);
			if (strs[x].match(/(rs[0-9]+)/)) { // rs# match
				var nodeSpan = document.createElement("span");
				nodeSpan.className = "snptip";
				nodeSpan.appendChild(nodeText);
				parentNode.insertBefore(nodeSpan, node);
			} else { // not rs# match
				parentNode.insertBefore(nodeText, node);
			}
		}
		parentNode.removeChild(node);
	  }
}


/*

for (i=0; i<matches.length; i++)
				{
				var term = matches[i];
				if(!term)continue;
				var displayTerm = term.replace(/_/g, " ");
				term = normalizedTerms[term.toLowerCase()];
				var termIndex = textNode.nodeValue.indexOf(displayTerm);
				var preTermNode = document.createTextNode(
				textNode.nodeValue.substring(0, termIndex));
				textNode.nodeValue = textNode.nodeValue.substring(
				termIndex+displayTerm.length);
				var anchor = document.createElement("a");
				anchor.className = "wikilink";
				anchor.addEventListener('mousemove', function () {
				this.className = 'wikilink_over';
				}, true);
				anchor.addEventListener('mouseout', function () {
				this.className = 'wikilink';
				}, true);
				anchor.href = integrationWikipedia linkswikipediaUrlPrefix + term;
				var termNode = document.createTextNode(displayTerm);
				anchor.insertBefore(termNode, anchor.firstChild);
				textNode.parentNode.insertBefore(preTermNode, textNode);
				textNode.parentNode.insertBefore(anchor, textNode);
				}







for (var i = 0, len = selectedTextNodes.length; i < len; ++i) {
textNode = selectedTextNodes[i];
span = document.createElement("span");
span.className = cssClass + " " + uniqueCssClass;
textNode.parentNode.insertBefore(span, textNode);
span.appendChild(textNode);
}
*/