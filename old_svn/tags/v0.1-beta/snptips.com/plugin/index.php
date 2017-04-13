<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head profile="http://gmpg.org/xfn/1">
	
		<meta name="generator" content="HTML Tidy for Linux/x86 (vers 11 February 2007), see www.w3.org" />
	
		<title>SNPTips Example Page</title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="snps_files/snptips.css" type="text/css" rel="stylesheet" />
		
		<script type="text/javascript" src="snps_files/snps.js"></script>
		<script src="snps_files/balloon_002.js" type="application/x-javascript"></script>
		<script src="snps_files/balloon.js" type="application/x-javascript"></script>
		<script src="snps_files/box.js" type="application/x-javascript"></script>
		<script src="snps_files/yahoo-dom-event.js" type="application/x-javascript"></script>
		<script src="snps_files/balloonTooltip.js" type="application/x-javascript"></script>

		<link rel="address bar icon" href="images/skin/snptips_enabled.png" />
		<link rel="icon" href="images/skin/snptips_enabled.png" type="image/x-icon" />
		<link rel="shortcut icon" href="images/skin/snptips_enabled.png" type="image/x-icon" />
	
	</head>
	
	<body style="font-family:'helvetica neue',verdana; font-size:86%;">

		<h1>SNPTips Example Page</h1>
		
		<p>
			Here's one that has matching SNP correlation data: <span onmouseover="balloon.showTooltip(event, 'load:div_rs12345', 1)" class="snptipPresent">rs12345</span>. Here's one that doesn't: <span onmouseover="balloon.showTooltip(event, 'load:div_rs12432432', 1)" class="snptipNotPresent">rs12432432</span>.
		</p>
		
		<p>
			Here's one that has matching data and a hyperlink: <a href="http://www.google.com"><span onmouseover="balloon.showTooltip(event, 'load:div_rs12345', 1)" class="snptipPresent">rs12345</span></a>. Note how we always underline hyperlinks.
		</p>

		<p>
			DTC genomics customers are in general very interested in following new research to see if their variants are implicated in disease. A year or so ago I built a little Firefox plugin, for my own use, to avoid the annoyance of looking up my specific genotype at different SNPs mentioned on blogs and in journal articles. It basically enhances any page that mentions SNPs by highlighting the SNP ID in the article text in red, and then adding a flyover tooltip - so I can just hover my mouse over the SNP name and see what my specific genotype is at that SNP. So if the article says "Individuals with one or two C's at <b><span onmouseover="balloon.showTooltip(event, 'load:div_rs12345', 1)" class="snptipPresent">rs12345</span></b> are at a 2.1x increased risk of brain cancer" - I can hover my mouse over the RS ID number and immediately see whether I'm personally in the risk group or not. Without this tool, it's a pain - I have to either login to 23andMe and search the raw data, or search myself in the local copy of my data. Some articles list big sets of SNPs, and having to look up each one is even more tedious. Since my plugin is very easy to set up (just install it by double-clicking the installer, and a one-time browse to your data file), it's much easier for novices to use. Since it uses a local copy of the raw data, there is no liability with moving confidential genotype information over the network.<br />
		</p>


		<div class="entry">
			<h2>SNPs associated with BMI</h2>
			
			<style type="text/css">TABLE {width:600px; border-collapse:collapse; border:1px solid #ccc;} TD, TH { padding:5px; border-bottom:1px solid #ccc; } TH { text-align:left; font-weight:bold; background:#eee; border-bottom:1px solid #ccc;}</style>
			
			<table>
				<tbody>
					<!-- Results table headers -->

					<tr>
						<th>SNP</th>

						<th>Nearest Gene</th>

						<th>Risk Version</th>
					</tr>

					<tr>
						<td><a href="https://www.23andme.com/you/explorer/snp/?snp_name=rs3101336" target="_blank"><span onmouseover="balloon.showTooltip(event, 'load:div_rs3101336', 1)" class="snptipPresent">rs3101336</span></a></td>

						<td>NEGRI</td>

						<td>C</td>
					</tr>

					<tr>
						<td><a href="https://www.23andme.com/you/explorer/snp/?snp_name=rs10913469" target="_blank"><span onmouseover="balloon.showTooltip(event, 'load:div_rs109134469', 1)" class="snptipNotPresent">rs109134469</span></a></td>

						<td>SEC16B</td>

						<td>C</td>
					</tr>

					<tr>
						<td><a href="https://www.23andme.com/you/explorer/snp/?snp_name=rs7647305" target="_blank"><span onmouseover="balloon.showTooltip(event, 'load:div_rs7647305', 1)" class="snptipPresent">rs7647305</span></a></td>

						<td>ETV5</td>

						<td>C</td>
					</tr>

					<tr>
						<td><a href="https://www.23andme.com/you/explorer/snp/?snp_name=rs13130484" target="_blank"><span onmouseover="balloon.showTooltip(event, 'load:div_rs13130484', 1)" class="snptipPresent">rs13130484</span></a> | 
						(<span onmouseover="balloon.showTooltip(event, 'load:div_rs10938397', 1)" class="snptipNotPresent">rs10938397</span>*)</td>

						<td>GNPDA2</td>

						<td>C</td>
					</tr>

					<tr>
						<td><a href="https://www.23andme.com/you/explorer/snp/?snp_name=rs925946" target="_blank"><span onmouseover="balloon.showTooltip(event, 'load:div_rs925946', 1)" class="snptipPresent">rs925946</span></a></td>

						<td>BDNFOS</td>

						<td>T</td>
					</tr>

					<tr>
						<td><a href="https://www.23andme.com/you/explorer/snp/?snp_name=rs10838738" target="_blank"><span onmouseover="balloon.showTooltip(event, 'load:div_rs10838738', 1)" class="snptipPresent">rs10838738</span></a></td>

						<td>MTCH2</td>

						<td>G</td>
					</tr>

					<tr>
						<td><a href="https://www.23andme.com/you/explorer/snp/?snp_name=rs4788102"><span onmouseover="balloon.showTooltip(event, 'load:div_rs4788102', 1)" class="snptipPresent">rs4788102</span></a> | 
						(<span onmouseover="balloon.showTooltip(event, 'load:div_rs7498665', 1)" class="snptipNotPresent">rs7498665</span>*)</td>

						<td>SH2B1</td>

						<td>A</td>
					</tr>

					<tr>
						<td><a href="https://www.23andme.com/you/explorer/snp/?snp_name=rs1121980" target="_blank"><span onmouseover="balloon.showTooltip(event, 'load:div_rs1121980', 1)" class="snptipPresent">rs1121980</span></a></td>

						<td>FTO</td>

						<td>A</td>
					</tr>

					<tr>
						<td><a href="https://www.23andme.com/you/explorer/snp/?snp_name=rs571312" target="_blank"><span onmouseover="balloon.showTooltip(event, 'load:div_rs571312', 1)" class="snptipPresent">rs571312</span></a> | 
						(<span onmouseover="balloon.showTooltip(event, 'load:div_rs17782313', 1)" class="snptipNotPresent">rs17782313</span>*)</td>

						<td>MC4R</td>

						<td>C</td>
					</tr>
				</tbody>
			</table>


	<div class="snptip" style="display:none;" id="div_rs12345">
		<div class="snptip_h1">Your genotype at <strong>rs12345</strong> is <strong>CC</strong>.</div>
		<div class="snptip_p"><strong>View this SNP at:</strong><br />
			<a href="http://www.23andme.com/" target="_blank">23andme.com</a><br />
			<a href="http://www.snpedia.com/" target="_blank">SNPedia.com</a><br />
			<a href="http://www.ncbi.nlm.nih.gov/projects/SNP/snp_ref.cgi?rs=rs3101336" target="_blank">dbSNP</a>
		</div>
	</div>

	<div class="snptip" style="display:none;" id="div_rs12432432">
		<div class="snptip_h1"><strong>rs12432432</strong> is not on your chip.</div>
		<div class="snptip_p"><strong>View this SNP at:</strong><br />
			<a href="http://www.23andme.com/" target="_blank">23andme.com</a><br />
			<a href="http://www.snpedia.com/" target="_blank">SNPedia.com</a><br />
			<a href="http://www.ncbi.nlm.nih.gov/projects/SNP/snp_ref.cgi?rs=rs12432432" target="_blank">dbSNP</a><br />
		</div>
	</div>

	<div class="snptip" style="display:none;" id="div_rs3101336">
		<div class="snptip_h1">Your genotype at <strong>rs3101336</strong> is <strong>CC</strong>.</div>
		<div class="snptip_p"><strong>View this SNP at:</strong><br />
			<a href="http://www.23andme.com/" target="_blank">23andme.com</a><br />
			<a href="http://www.snpedia.com/" target="_blank">SNPedia.com</a><br />
			<a href="http://www.ncbi.nlm.nih.gov/projects/SNP/snp_ref.cgi?rs=rs3101336" target="_blank">dbSNP</a>
		</div>
	</div>

	<div class="snptip" style="display:none;" id="div_rs109134469">
		<div class="snptip_h1"><strong>rs109134469</strong> is not on your chip.</div>
			<div class="snptip_p"><strong>View this SNP at:</strong><br />
			<a href="http://www.23andme.com/" target="_blank">23andme.com</a><br />
			<a href="http://www.snpedia.com/" target="_blank">SNPedia.com</a><br />
			<a href="http://www.ncbi.nlm.nih.gov/projects/SNP/snp_ref.cgi?rs=rs109134469" target="_blank">dbSNP</a>
		</div>
	</div>

	<div class="snptip" style="display:none;" id="div_rs7647305">
		<div class="snptip_h1">Your genotype at <strong>rs7647305</strong> is <strong>CT</strong>.</div>
			<div class="snptip_p"><strong>View this SNP at:</strong><br />
			<a href="http://www.23andme.com/" target="_blank">23andme.com</a><br />
			<a href="http://www.snpedia.com/" target="_blank">SNPedia.com</a><br />
			<a href="http://www.ncbi.nlm.nih.gov/projects/SNP/snp_ref.cgi?rs=rs7647305" target="_blank">dbSNP</a>
		</div>
	</div>

	<div class="snptip" style="display:none;" id="div_rs13130484">
		<div class="snptip_h1">Your genotype at <strong>rs13130484</strong> is <strong>CC</strong>.</div>
		<div class="snptip_p"><strong>View this SNP at:</strong><br />
			<a href="http://www.23andme.com/" target="_blank">23andme.com</a><br />
			<a href="http://www.snpedia.com/" target="_blank">SNPedia.com</a><br />
			<a href="http://www.ncbi.nlm.nih.gov/projects/SNP/snp_ref.cgi?rs=rs13130484" target="_blank">dbSNP</a>
		</div>
	</div>

	<div class="snptip" style="display:none;" id="div_rs10938397">
		<div class="snptip_h1"><strong>rs10938397</strong> is not on your chip.</div>
		<div class="snptip_p"><strong>View this SNP at:</strong><br />
			<a href="http://www.23andme.com/" target="_blank">23andme.com</a><br />
			<a href="http://www.snpedia.com/" target="_blank">SNPedia.com</a><br />
			<a href="http://www.ncbi.nlm.nih.gov/projects/SNP/snp_ref.cgi?rs=rs10938397" target="_blank" target="_blank">dbSNP</a>
		</div>
	</div>

	<div class="snptip" style="display:none;" id="div_rs925946">
		<div class="snptip_h1">Your genotype at <strong>rs925946</strong> is <strong>TT</strong>.</div>
		<div class="snptip_p"><strong>View this SNP at:</strong><br />
			<a href="http://www.23andme.com/" target="_blank">23andme.com</a><br />
			<a href="http://www.snpedia.com/" target="_blank">SNPedia.com</a><br />
			<a href="http://www.ncbi.nlm.nih.gov/projects/SNP/snp_ref.cgi?rs=rs925946" target="_blank">dbSNP</a>
		</div>
	</div>

	<div class="snptip" style="display:none;" id="div_rs10838738">
		<div class="snptip_h1">Your genotype at <strong>rs10838738</strong> is <strong>AA</strong>.</div>
		<div class="snptip_p"><strong>View this SNP at:</strong><br />
			<a href="http://www.23andme.com/" target="_blank">23andme.com</a><br />
			<a href="http://www.snpedia.com/" target="_blank">SNPedia.com</a><br />
			<a href="http://www.ncbi.nlm.nih.gov/projects/SNP/snp_ref.cgi?rs=rs10838738" target="_blank">dbSNP</a>
		</div>
	</div>

	<div class="snptip" style="display:none;" id="div_rs4788102">
		<div class="snptip_h1">Your genotype at <strong>rs4788102</strong> is <strong>AG</strong>.</div>
		<div class="snptip_p"><strong>View this SNP at:</strong><br />
			<a href="http://www.23andme.com/" target="_blank">23andme.com</a><br />
			<a href="http://www.snpedia.com/" target="_blank">SNPedia.com</a><br />
			<a href="http://www.ncbi.nlm.nih.gov/projects/SNP/snp_ref.cgi?rs=rs4788102" target="_blank">dbSNP</a>
		</div>
	</div>

	<div class="snptip" style="display:none;" id="div_rs7498665">
		<div class="snptip_h1"><strong>rs7498665</strong> is not on your chip.</div>
		<div class="snptip_p"><strong>View this SNP at:</strong><br />
			<a href="http://www.23andme.com/" target="_blank">23andme.com</a><br />
			<a href="http://www.snpedia.com/" target="_blank">SNPedia.com</a><br />
			<a href="http://www.ncbi.nlm.nih.gov/projects/SNP/snp_ref.cgi?rs=rs7498665" target="_blank">dbSNP</a>
		</div>
	</div>

	<div class="snptip" style="display:none;" id="div_rs1121980">
		<div class="snptip_h1">Your genotype at <strong>rs1121980</strong> is <strong>CT</strong>.</div>
		<div class="snptip_p"><strong>View this SNP at:</strong><br />
			<a href="http://www.23andme.com/" target="_blank">23andme.com</a><br />
			<a href="http://www.snpedia.com/" target="_blank">SNPedia.com</a><br />
			<a href="http://www.ncbi.nlm.nih.gov/projects/SNP/snp_ref.cgi?rs=rs1121980" target="_blank">dbSNP</a>
		</div>
	</div>

	<div class="snptip" style="display:none;" id="div_rs571312">
		<div class="snptip_h1">Your genotype at <strong>rs571312</strong> is <strong>AC</strong>.</div>
		<div class="snptip_p"><strong>View this SNP at:</strong><br />
			<a href="http://www.23andme.com/" target="_blank">23andme.com</a><br />
			<a href="http://www.snpedia.com/" target="_blank">SNPedia.com</a><br />
			<a href="http://www.ncbi.nlm.nih.gov/projects/SNP/snp_ref.cgi?rs=rs571312" target="_blank">dbSNP</a>
		</div>
	</div>

	<div class="snptip" style="display:none;" id="div_rs17782313">
		<div class="snptip_h1"><strong>rs17782313</strong> is not on your chip.</div>
		<div class="snptip_p"><strong>View this SNP at:</strong><br />
			<a href="http://www.23andme.com/" target="_blank">23andme.com</a><br />
			<a href="http://www.snpedia.com/" target="_blank">SNPedia.com</a><br />
			<a href="http://www.ncbi.nlm.nih.gov/projects/SNP/snp_ref.cgi?rs=rs17782313" target="_blank">dbSNP</a>
		</div>
	</div>
</body>
</html>
