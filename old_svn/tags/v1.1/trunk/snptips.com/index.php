<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
	
		<title>SNPTips: Personal genomic tooltips browser extension for FireFox</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link rel="icon" href="http://snptips.5amsolutions.com/favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="http://snptips.5amsolutions.com/favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="common/snptips-web.css" />
		
		<!-- JS and CSS for Example -->
		
		<link rel="stylesheet" type="text/css" href="plugin/snps_files/snptips-web-version.css" />
		
		<script type="text/javascript" src="plugin/snps_files/snps.js"></script>
		<script src="plugin/snps_files/balloon_002.js" type="application/x-javascript"></script>
		<script src="plugin/snps_files/balloon.js" type="application/x-javascript"></script>
		<script src="plugin/snps_files/box.js" type="application/x-javascript"></script>
		<script src="plugin/snps_files/yahoo-dom-event.js" type="application/x-javascript"></script>
		<script src="plugin/snps_files/balloonTooltip.js" type="application/x-javascript"></script>
		
		<style type="text/css">
			
			.browser_error
			{ float:left; color:#fff; margin:0 auto; width:100%; height:366px; background:url("images/bg_focus.png") repeat-x; position:absolute; top:103px; left:0; z-index:10000; text-align:center; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; color:#505050; font-size:120%; -webkit-box-shadow: 0 2px 5px rgba(0,0,0,0.8); }
			.browser_error P
			{ padding-top:120px; color:#fff; }
			.browser_error A
			{ color:#333; font-weight:bold; }
			.newsbanner_wrapper
			{ background:#c6c6c6; }
			.newsbanner
			{ width:833px; margin:0 auto; }
			
		</style
		
	</head>

	
	<body id="home">
		
		<script type="text/javascript">
			if (navigator.userAgent.indexOf("Firefox")!=-1) { document.write("") } else { document.write("<div class='browser_error'><p>Sorry! SNPTips is currently an Add-on for the <a href='http://www.firefox.com'>Firefox</a> browser only.<br />Please return to this site in Firefox and try again!</p></div>") }
		</script>
		
		<div id="wrapper">
		
			<div id="wrapper_inner"><a href="#main" id="navskip">Skip to Page Content</a>
			
				<!--Header-->
				
				<div id="header">
				
					<div id="logo"><a href="./"><img src="images/logo_snptips.png" alt="SNPTips" /></a></div>
					
					<div id="tagline"><a href="http://www.5amsolutions.com" target="_blank"><img src="images/tagline_snptips.png" alt="Personal genomic tooltips browser extension. Powered by 5AM Solutions" /></a></div>
					
					<div id="primary_nav">

						<!--Primary Navigation-->

						
						<!--/Primary Navigation-->

					</div><div class="clear"></div>
					
				</div>
				
				<!--/Header-->
				
			</div>
			
		</div>
									
		<div class="newsbanner_wrapper"><div class="newsbanner"><a href="http://www.twitter.com/snptips"><img src="images/banner_ff4.png" alt="Firefox 4-compatible version out soon! Follow @snptips on Twitter for the latest news" /></a></div><div class="clear"></div></div>
								
		<!--Main-->
		
		<div id="main">
			
			<div id="main_inner">
		
				<!--Focus Image-->
					
				<div id="focus">
	
					<h1>Easily, privately cross-reference your SNP data.</h1>
					
					<h2>Got a 23andMe data file? SNPTips&trade; allows you to instantly see how SNPs on web pages match your personal genotype.*</h2>
					
					<div id="install">
					
						<div id="btn_install">
							
							<a href="https://svn.5amsolutions.com/opensource/snptips/releases/latest/SNPTips.xpi" onClick="_gaq.push(['_trackEvent', 'xpi', 'download', '/xpi/1.0.2-xpi'])"><img src="images/btn_install.png" alt="Install SNPTips Add-on for Firefox" /></a>
						
						</div>
							
						<div id="install_info">
						
							<p><strong>SNPTips v1.0.2</strong></p>
	
							<p>Click the button above to install the SNPTips extension in Firefox 3.6 +</p>
							
						</div>
						
						<div id="license_info">
							
							<div id="cc_text">Attribution-ShareAlike 3.0 Unported**</div>
							
							<div class="clear"></div>
							
						</div>
						
					</div>
					
				</div>
				
				<div id="focus_example">
					
					<div id="rsids">
					
						<p class="hidden">Try an example...Hover over these SNP RSIDs:</p>
					
						<span title="Your genotype at rs17822931 is CT - click icon for more info" class="snptipPresent2"><span>rs<span></span>17822931<a class="snptip_icon" onclick="balloon.showTooltip(event, 'load:div_rs_17822931', 1)"><img src="plugin/images/skin/snp_present.png" /></a></span></span>
						&nbsp;&nbsp;
						<span title="rs713598 is not on your chip - click icon for more info" class="snptipNotPresent2">rs<span></span>713598<a class="snptip_icon" onclick="balloon.showTooltip(event, 'load:div_rs_713598', 1)"><img src="plugin/images/skin/snp_not_present.png" /></a></span>
					
					</div>
	
					
				</div>
					
				<!--/Focus Image-->
				
				<!--Content-->
				
				<div id="content_col">
				
					<div id="content">
						
						<h3>What is SNPTips&trade;?</h3>
						
						<p>SNPTips is a Firefox browser extension that allows customers of the <a href="http://www.23andme.com" target="_blank">23andMe</a> personal genomics service to access their SNP genotype information without leaving the web page they're reading.  Ever read a blog post or journal article that mentions a particular SNP, and immediately wonder what your genotype is at that SNP?  Rather than opening another browser window or tab, logging in to 23andMe, and searching for the SNP in your data, SNPTips allows you to simply hover your mouse cursor over the SNP RSID in the article text, and a tooltip displays your genotype information immediately! Click the icon next to an RS ID, and a popup also provides smart links to common reference websites, like <a href="http://www.snpedia.com" target="_blank">SNPedia</a>,  <a href="http://scholar.google.com/" target="_blank">Google Scholar</a> and <a href="http://www.ncbi.nlm.nih.gov/projects/SNP/" target="_blank">dbSNP</a>, so you can research the SNP further.</p>
						
						<h3>Getting Started with SNPTips</h3>
						
						<p>Before you can use SNPTips, you will need to download your 23andMe raw data, if you have not already done so.  SNPTips requires you to have your raw data on your local machine so we don't need to log in to your 23andMe account, and so we can search the 600,000+ SNPs quickly.</p>
						
						<h3>To download your raw data:</h3>
						
						
						<ol>
							<li>Log in to your 23andMe.com account.</li>
							<li>Choose "Browse Raw Data" from the Account dropdown in the upper right part of the 23andMe page.</li>
							<li>Click the "download raw data" link in the upper right of the Browse Raw Data page.</li>
							<li>Follow the instructions on this page, and be sure "All DNA" is selected in the "Data set" dropdown.</li>
							<li>Click the Download Data button to initiate the download.</li>
							<li>The file is ~14MB and may take a while to download, depending on your connection speed.</li>
							<li>The file will download as a ZIP-formatted file &ndash; double-click it to unzip it.</li>
							<li>Note the location of the unzipped text (.txt) file - this is the file you need for SNPTips - move it to a desired permanent location before using it with SNPTips, since you will have to point SNPTips to its location.</li>
						</ol> 
						
						<p class="callout">
							<em><strong>NOTE</strong>: your raw data is your complete 23andMe SNP profile, and you should take care to safeguard it &ndash; don't download it to a machine you don't control, etc.  If this makes you uncomfortable, SNPTips may not be for you.</em>
						</p>
						
						<h3>Configuring SNPTips</h3>
						
						<p>Before you can enable SNPTips, you must point it to your 23andMe raw data (.txt) file - see above for instructions on how to obtain your raw data file.</p>
						
						<ol>
							<li>From either the Firefox Tools > SNPTips menu, or the SNPTips menu accessed by clicking the SNPTips status bar icon, select Preferences.</li>
							<li>Click the Browse... button next to the Data File: field, and browse to the location of your 23andMe raw data (.txt) file.  The filename will start with genome_&lt;your name&gt; and end with a .txt extension.</li>
							<li>Check the "Enable SNPTips" checkbox to turn on SNPTips.</li>
							<li>Click the OK button to save changes.</li>
						</ol>
						
						<p>You're now ready to browse SNPs! To try it out, reload this page and look at the text below &ndash; you should see a green box around the SNP RSID:</p>
						
						<p class="callout">
							Click on the icon next to rs17822931 to see if your earwax is wet (CC or CT).  TT's at rs17822931 have dry earwax!
						</p>
						
						<p>To give it a real-world test, go to <a href="http://spittoon.23andme.com/category/snpwatch/" target="_blank">the SNPWatch section of The Spittoon</a> (23andMe's blog) and select any article - these articles generally mention various SNPs by RSID, and describe the implications of different alleles (versions).  You'll be able to see your alleles at a glance!</p>  
		  			
		  			</div>
	  			
	  			</div>
	  			
				<!--/Content-->
				
				<!--Right Column-->
				
				<div id="right_col">
				
					<p style="text-indent:-.4em; padding-left:10px;">*SNPTips is not affiliated with 23andMe. SNPTips is a product and a trademark of 5AM Solutions, Inc. 5AM Solutions makes no claims regarding, and is not responsible for, 23andMe&#8217;s content, products, or services.</p>
	
					<p style="text-indent:-.7em; padding-left:10px;">**SNPTips is made available under the <a href="http://creativecommons.org/licenses/by-sa/3.0/">Creative Commons &ndash; Attribution-ShareAlike 3.0 Unported</a> license. By downloading and installing SNPTips, you agree to be bound by this license.</p>
					
					<p style="padding-left:10px;">Visit <a href="http://www.5amsolutions.com">www.5amsolutions.com</a> for more information on life sciences software.</p>
					
					<div class="line"></div>
					
					<h4 style="padding-left:10px;">Got Feedback?</h4>
					
					<p style="padding-left:10px;">Please let us know if you encounter issues with SNPTips: <a href="mailto:snptips@5amsolutions.com">snptips@5amsolutions.com</a></p>
	
				</div>			
					
				<!--/Right Column-->
				
				<div class="clear"></div>
				
			</div>
				
		</div>
				
		<!--/Main-->


		<div class="clear"></div>

		
		<!--Footer-->
		
		<div id="footer">			
			
			<div id="address">
			
				SNPTips by <a href="http://www.5amsolutions.com" target="_blank">5AM Solutions</a> <span class="lite bar">|</span>  11710 Plaza America Drive  <span class="lite bar">|</span>  Suite 2000  <span class="lite bar">|</span>  Reston, VA  20190
			
			</div>
			
			<div id="copyright">
				
				Copyright &copy; 5AM Solutions, Inc. All Rights Reserved.
				
			</div>

			
		</div>
		
		<!--/Footer-->
		
		<div class="snptip" style="display:none;" id="div_rs_17822931">
			<div class="snptip_h1">Your genotype at <strong>rs<span></span>17822931</strong> is <strong>CC</strong>.</div>
			<div class="snptip_p"><strong>View this SNP at:</strong><br />
				<a href="https://www.23andme.com/you/explorer/snp/?snp_name=rs17822931" target="_blank">23andme.com</a><br />
				<a href="http://www.snpedia.com/index.php/rs17822931" target="_blank">SNPedia.com</a><br />
				<a href="http://www.ncbi.nlm.nih.gov/projects/SNP/snp_ref.cgi?rs=rs17822931" target="_blank">dbSNP</a><br />
				<a href="http://scholar.google.com/scholar?q=rs17822931" target="_blank">Google Scholar</a>
			</div>
		</div>
	
		<div class="snptip" style="display:none;" id="div_rs_713598">
			<div class="snptip_h1"><strong>rs<span></span>713598</strong> is not on your chip.</div>
			<div class="snptip_p"><strong>View this SNP at:</strong><br />
				<a href="https://www.23andme.com/you/explorer/snp/?snp_name=rs713598" target="_blank">23andme.com</a><br />
				<a href="http://www.snpedia.com/index.php/rs713598" target="_blank">SNPedia.com</a><br />
				<a href="http://www.ncbi.nlm.nih.gov/projects/SNP/snp_ref.cgi?rs=rs713598" target="_blank">dbSNP</a><br />
				<a href="http://scholar.google.com/scholar?q=rs713598" target="_blank">Google Scholar</a>
			</div>
		</div>
		
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-20551251-1']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		
		</script>
			
	</body>
	
</html>
