function badBrowser(){
	if($.browser.msie && parseInt($.browser.version) <= 8){ return true;}
	if($.browser.mozilla && parseInt($.browser.version) <= 4){ return true;}
	if($.browser.opera && parseInt($.browser.version) <= 11){ return true;}
	if($.browser.webkit && parseInt($.browser.version) <= 5){ return true;}
	if($.browser.chrome && parseInt($.browser.version) <= 5){ return true;}
	return false;
}

function getBadBrowser(c_name)
{
	if (document.cookie.length>0)
	{
	c_start=document.cookie.indexOf(c_name + "=");
	if (c_start!=-1)
		{ 
		c_start=c_start + c_name.length+1; 
		c_end=document.cookie.indexOf(";",c_start);
		if (c_end==-1) c_end=document.cookie.length;
		return unescape(document.cookie.substring(c_start,c_end));
		} 
	}
	return "";
}	

function setBadBrowser(c_name,value,expiredays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie=c_name+ "=" +escape(value) + ((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}

if(badBrowser() && getBadBrowser('browserWarning') != 'seen' ){
	$(function(){
		$("<div id='browserWarning'><p style='font-weight:bold;'>You browser is outdated &amp; doesn't fully support our website, to get the most out of our site please update your browser here:</p><p><a style='color:red;' target='_blank' rel='nofollow' target='_blank' rel='nofollow' href='http://getfirefox.com'>FireFox</a>, <a style='color:red;' target='_blank' rel='nofollow' href='http://www.opera.com/download/'>Opera</a>, <a style='color:red;' target='_blank' rel='nofollow' href='http://www.apple.com/safari/'>Safari</a>, <a style='color:red;' target='_blank' rel='nofollow' href='https://www.google.com/intl/en/chrome/browser/'>Chrome</a> or <a style='color:red;' target='_blank' rel='nofollow' href='http://www.microsoft.com/windows/downloads/ie/getitnow.mspx'>Internet Explorer</a>.</p><p>Thanks!&nbsp;&nbsp;&nbsp;[<a style='color:#FFFFFF;' href='#' id='warningClose'>Hide Message</a>]</p></div> ")
			.css({
				 position: 'fixed',
				 top: '0',
				 left: '0',
				 Color: '#FFFFFF',
				backgroundColor: '#000000',
				'width': '100%',
				'text-align': 'center',
				padding:'20px 0',
				zIndex:'999'
			})
			.prependTo("body");
		
		$('#warningClose').click(function(){
			setBadBrowser('browserWarning','seen');
			$('#browserWarning').slideUp('slow');
			return false;
		});
	});	
}