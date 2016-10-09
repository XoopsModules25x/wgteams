// Jquery function for order fields
// When the page is loaded define the current order and items to reorder
$(document).ready( function(){
	/* Call the container items to reorder teams */
	$('#teams-list').sortable({ 
			opacity: 0.6, 
			cursor: 'move',
			connectWith: '#teams-list',
			update: function(event, ui) {
				var list = $(this).sortable( 'serialize');
				$.post( 'teams.php?op=order', list );
			},
			receive: function(event, ui) {
				var list = $(this).sortable( 'serialize');                    
				$.post( 'teams.php?op=order', list );                      
			}
		}
	).disableSelection();
});