<?php 
if( function_exists( 'cloudfw_quicktags' ) ):
	$cloudfw_quicktags = apply_filters( 'cloudfw_quicktags', cloudfw_quicktags() )	
?>
<script type="text/javascript">
    //<![CDATA[
   	var j, n,
	last = edButtons.length,
	tbar = '';
<?php 
	$i = 150;
	foreach( (array) $cloudfw_quicktags as $col_text => $col){
		echo "edButtons[edButtons.length] = new edButton('_$col_text','$col_text','".$col[0]."','".$col[1]."',1);";
		$i++;
	}
?>  
	for ( j = last; j < edButtons.length; j++) {
	 n = edButtons[j];
	 if (/<button>/g.test(n.display)) {
	  // matched opening tag => add a button
	  tbar += '<button id="' + n.id + '" type="button" class="ed_button" onclick="edInsertTag(edCanvas, ' + j + ');"><span></span></button>';
	 } else {
	  // add an input
	  tbar += '<input type="button" id="' + n.id + '" accesskey="' + n.access + '" class="ed_button" onclick="edInsertTag(edCanvas,' + j + ');" value="' + n.display.replace(/\"/g,'\"') + '" />';
	 }
	}
	document.getElementById('ed_toolbar').innerHTML += tbar;
 
    //]]>
</script>

<?php endif;