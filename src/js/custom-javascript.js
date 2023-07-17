// Custom JavaScript
jQuery(document).ready(function($) {
		
	
	/**
	 * Team Members
	 */
	
	
	
	/**
	 * Pretty Dropdown
	 */
	 
	$dropdown = $('select').prettyDropdown({
		classic: true,
		height: 44,
		width: '100%'
	});	
	
	
	/**
	 * Resources
	 */
	 
	// Functions 
	function hideElements() {
		$('.not-found').hide();
		$('.pagination-row').remove();		
		$('#posts-ajax .item').remove();
		$('.spinner-row').addClass('visible');
	}
	
	function loadAjax(href) {
		
		console.log( href );
		$('#posts-ajax').load(href + ' #posts-ajax>*', function(){
			$('.spinner-row.visible').remove();
		});		
		
	}
	
	function buildHref(thisObj) {
		
		var url = [location.protocol, '//', location.host, location.pathname].join('');	 
		var href = url + '?';		  
		var queryParams = new URLSearchParams(window.location.search);
		
		// Taxonomy filters
		var taxonomies = thisObj.data('taxonomies');
		$.each( taxonomies, function(index, element) {
			var filter = $('#select-' + element ).val();
			if ( filter ) {
				href = href + element + '=' + filter + '&';		
				queryParams.set( element, filter);
			} else {
				queryParams.delete( element );	
			}
		});
		
		// Search query
		var post_type = thisObj.data('post_type');		
		var search_query = encodeURIComponent($('#' + post_type + '-search-query').val());		
		if ( search_query ) {
			href = href + 'search=' + search_query;		    
			queryParams.set('search', search_query);
		} else {
			queryParams.delete('search');	
		}
		
		// Update querystrings
		history.pushState(null, null, '?'+queryParams.toString());		
		
		return href;
	}
	 
	// AJAX pagination 
	$('#posts-ajax').on('click', '#pagination-ajax', function(e){
		
		e.preventDefault();
		$('.pagination-row').remove();
		$('.spinner-row').addClass('visible');
		
		var existinghtml = $('#posts-ajax').html();
		$('#posts-ajax').load($(this).attr('href') + ' #posts-ajax>*', function(){
			$('#posts-ajax').prepend(existinghtml);
			$('.spinner-row.visible').remove();
		});
		
	}); 	
	
	// Filters
	$(document).on('change', '.filter select', function() {
			
		hideElements();				
		if ( $(this).hasClass( 'cleared' )) {
			// "Clear filters" forces a "change" state for Pretty Dropdown. 
			// Prevent unnecessary AJAX reloads with the "cleared" class.
			$(this).removeClass( 'cleared' );
		} else {	
			href = buildHref( $(this) );
			loadAjax(href);
		}
	
	});
	
	// Search
	$('.filters .filters-search-form').submit(function( event ) {
		event.preventDefault();	
	
		hideElements();		
		
		href = buildHref( $(this) );
		loadAjax(href);
	});		
	
	// Clear filters
	$('.clear-filters').click(function() {
	
		hideElements();
		
		var post_type = $(this).data('post_type');
		var search_placeholder = $(this).data('search_placeholder');		
				
		var url = [location.protocol, '//', location.host, location.pathname].join('');	 
		var href = url;
		var queryParams = new URLSearchParams(window.location.search);		    		    		
		
		var taxonomies = $(this).data('taxonomies');
		$.each( taxonomies, function(index, element) {
			queryParams.delete( element );	
		});
		queryParams.delete( 'search' );			
		history.pushState(null, null, '?'+queryParams.toString());
	
		$('.filter select').val('').attr('selected','selected').addClass('cleared').change();
		$dropdown.refresh();
		
		$('#' + post_type + '-search-query').val('').attr('placeholder', search_placeholder );					
		
		loadAjax(href);
	});

	console.log( 'custom-javascript.js loaded' );
	
		
});


jQuery(function($) {
	$(window).on('resize', function() {	  
/*
		if ( Modernizr.mq('(min-width: 768px)')) {
		}
*/
		
	}).trigger('resize');
});