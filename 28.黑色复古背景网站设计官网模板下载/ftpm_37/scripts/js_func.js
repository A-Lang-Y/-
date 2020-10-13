$(function() {
	var myName = $('#name');
	myName.focus(function() { if ($(this).val() == 'Full Name') {$(this).val('');} });
	myName.blur(function() { if ($(this).val() == '') {$(this).val('Full Name');} });		
	var myEmail = $('#email');
	myEmail.focus(function() { if ($(this).val() == 'Email') {$(this).val('');} });
	myEmail.blur(function() { if ($(this).val() == '') {$(this).val('Email');} });		
	var myMsg = $('#message');
	myMsg.focus(function() { if ($(this).val() == 'Comment') {$(this).val('');} });
	myMsg.blur(function() { if ($(this).val() == '') {$(this).val('Comment');} });	
	$('.portfolio_list a[rel=portfolio_group]').fancybox();
}); 