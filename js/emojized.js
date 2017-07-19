jQuery(document).ready(function() {
 jQuery('.emojized').click(function(){
	
	
	var id =jQuery(this).data("id") ;
	
	jQuery.get( site_url + "/wp-json/emojized/v1/count/"+id, function( data ) {
  	jQuery('.emojized-count-'+id).html(data); 
	});
	
 });
});