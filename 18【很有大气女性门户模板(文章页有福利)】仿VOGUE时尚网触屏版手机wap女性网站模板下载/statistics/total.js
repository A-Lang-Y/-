if(!staimg)
{
	var staimg = 1;
	var refer=encodeURIComponent(document.referrer);
	hostnamereg=/.*[\.]?(vogue|gq|self|adstyle)\.com\.cn$/i;
	nicknamereg=/(;?)(\s?)(vogue|gq|self|adstyle)bbsnickname=([^;]*);?/;
	uidreg=/(;?)(\s?)(vogue|gq|self|adstyle)bbsuid=([^;]*);?/;

	condenastuid=0;
	condenastnickname="";
	condenasthost=location.hostname.replace(hostnamereg,"$1");
	$tempstr=document.cookie.replace(/(;?)(\s?)condetotalsession=([^;]*);?/);
	condenasthostsession=RegExp.$3;
	if(condenasthost != location.hostname)
	{
		tempstr=document.cookie.replace(nicknamereg);
		if(condenasthost == RegExp.$3)
		{
			condenastnickname=encodeURIComponent(RegExp.$4);
		}
		tempstr=document.cookie.replace(uidreg);
		if(condenasthost == RegExp.$3)
		{
			condenastuid=encodeURIComponent(RegExp.$4);
		}
	}
    document.write("<script language=\"javascript\" type=\"text/javascript\" src=\"../sdc.adstyle.cn/total.php@ref="+refer+"&u="+condenastuid+"&n="+condenastnickname+"&hs="+condenasthostsession+"\"></script>");
}
