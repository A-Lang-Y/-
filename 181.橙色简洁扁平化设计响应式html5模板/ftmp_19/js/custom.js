
// Responsive Menu
jQuery(document).ready(function(){				
jQuery("<select />").appendTo(".jqueryslidemenu");
// Create default option "Go to..."
jQuery("<option />", {
	"selected": "selected",
	"value"   : "",
	"text"    : "Go to..."
	}).appendTo(".jqueryslidemenu select");

// Populate dropdowns with the first menu items
jQuery(".jqueryslidemenu ul li a").each(function() {
	var el = jQuery(this);
	jQuery("<option />", {
	"value"   : el.attr("href"),
	"text"    : el.text()
	}).appendTo(".jqueryslidemenu select");
});
//make responsive dropdown menu actually work			
jQuery(".jqueryslidemenu select").change(function() {
window.location = jQuery(this).find("option:selected").val();

});
});
	