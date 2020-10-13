/**
 * Responsive javascript
 */ 
 
/**
 * jQuery Mobile Menu 
 * Turn unordered list menu into dropdown select menu
 * version 1.0(31-OCT-2011)
 * 
 * Built on top of the jQuery library
 *   http://jquery.com
 * 
 * Documentation
 * 	 http://github.com/mambows/mobilemenu
 */
(function(a){a.fn.mobileMenu=function(e){var b=a.extend({defaultText:"Navigate to...",className:"select-menu",subMenuClass:"sub-menu",subMenuDash:"&ndash;"},e),c=a(this);this.each(function(){c.find("ul").addClass(b.subMenuClass);a("<select />",{"class":b.className}).insertAfter(c);a("<option />",{value:"#",text:b.defaultText}).appendTo("."+b.className);c.find("a").each(function(){var d=a(this),c="&nbsp;"+d.text(),e=d.parents("."+b.subMenuClass).length;d.parents("ul").hasClass(b.subMenuClass)&&(d= Array(e+1).join(b.subMenuDash),c=d+c);a("<option />",{value:this.href,html:c,selected:this.href==window.location.href}).appendTo("."+b.className)});a("."+b.className).change(function(){"#"!==a(this).val()&&(window.location.href=a(this).val())})});return this}})(jQuery);