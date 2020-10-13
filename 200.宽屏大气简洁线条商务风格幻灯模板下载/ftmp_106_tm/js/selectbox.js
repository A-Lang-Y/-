$(window).load(function() {
	// Create the dropdown base
	$("<select />").appendTo(".menu");

	// Create default option "Go to..."
	$("<option />", {
	 "selected": "selected",
	 "value"   : "",
	 "text"    : "Select Page"
	}).appendTo(".menu select");

	// Populate dropdown with menu items
	$(".menu a").each(function() {
	var el = $(this);

	$("<option />", {
	   "class"	: "dropdown",
	   "value"   : el.attr("href"),
	   "text"    : el.text()
	}).appendTo(".menu select");
	});

	// To make dropdown actually work
	// To make more unobtrusive: http://css-tricks.com/4064-unobtrusive-page-changer/
	$(".menu select").change(function() {
	window.location = $(this).find("option:selected").val();
	});
});