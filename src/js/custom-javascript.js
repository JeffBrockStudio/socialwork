// Custom JavaScript
jQuery(document).ready(function($) {
		
	
	/**
	 * Accordion
	 */

	"use strict";

	var UWAccordion = function() {
		// Add unique IDs to each accordion
		var accordions = document.querySelectorAll("#accessible-accordion");
		console.log( 'accordions' + accordions );

		if (accordions.length > 1) {
			for (var i = 0; i < accordions.length; i++) {
				accordions[i].id = "accordion-" + i;
			}
		}

		// Add unique IDs to each collapse
		var collapses = document.querySelectorAll(".accordion #collapse");
		if (collapses.length > 0) {
			for (var j = 0; j < collapses.length; j++) {
				collapses[j].id = "collapse-" + j;
				collapses[j].parentElement.getElementsByClassName("btn-link")[0].dataset.target = "#" + collapses[j].id;
				collapses[j].parentElement.getElementsByClassName("btn-link")[0].setAttribute("aria-controls", collapses[j].id);
				collapses[j].dataset.parent = "#" + collapses[j].parentElement.parentElement.id;
				collapses[j].previousElementSibling.id = collapses[j].id + "-header";
				collapses[j].setAttribute("aria-labelledby", collapses[j].previousElementSibling.id);
			}
		}

		// Add role="region" to the collapse when it is shown
		var collapsesArray = Array.prototype.slice.call(document.querySelectorAll(".card .collapse"));
		if (collapsesArray.length > 1) {
			for (var k = 0; k < collapsesArray.length; k++) {
				var isCollapsed = collapsesArray[k].classList.contains("collapse");
				new MutationObserver(function(mutations) {
					mutations.forEach(function(mutation) {
						if (mutation.attributeName === "class") {
							var isShown = mutation.target.classList.contains("show");
							if (isCollapsed !== isShown) {
								if (isShown) {
									collapsesArray[k].setAttribute("role", "region");
								} else {
									collapsesArray[k].removeAttribute("role", "region");
								}
							}
						}
					});
				}).observe(collapsesArray[k], { attributes: true });
			}
		}

		// Add focus class to the accordion when a button is focused
		document.querySelectorAll(".card .card-header button").forEach(function(button) {
			button.addEventListener("focus", function(event) {
				button.parentElement.parentElement.parentElement.parentElement.classList.add("focus");
			});
			button.addEventListener("blur", function(event) {
				button.parentElement.parentElement.parentElement.parentElement.classList.remove("focus");
			});
		});

		// Keyboard navigation for the accordion
		document.querySelectorAll(".accordion").forEach(function(accordion) {
			var buttons = Array.prototype.slice.call(accordion.querySelectorAll(".card-header button"));
			accordion.addEventListener("keydown", function(event) {
				var target = event.target;
				var key = event.which.toString();
				var ctrl = event.ctrlKey && key.match(/33|34/);
				if (target.classList.contains("btn-link")) {
					if (key.match(/38|40/) || ctrl) {
						var index = buttons.indexOf(target);
						var direction = key.match(/34|40/) ? 1 : -1;
						var length = buttons.length;
						buttons[(index + length + direction) % length].focus();
						event.preventDefault();
					} else if (key.match(/35|36/)) {
						switch (key) {
							case "36":
								buttons[0].focus();
								break;
							case "35":
								buttons[buttons.length - 1].focus();
								break;
						}
						event.preventDefault();
					}
				}
			});
		});
	};

	new UWAccordion;

	
	
	/**
	 * Pretty Dropdown
	 */
	 
	var $dropdown = $('.filter-wrapper select').prettyDropdown({
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
		$('.results-found').hide();
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

		// Clear search text input
		$('#team-search-query').val('');
		$('#team-search-query').attr('placeholder', 'Search All Faculty & Staff');
		
		// Reset all other filters, and force Pretty Dropdown to update
		$('.filter select').not(this).val('').attr('selected','');
		$dropdown.refresh();
			
		hideElements();				
		if ( $(this).hasClass( 'cleared' )) {
			// "Clear filters" forces a "change" state for Pretty Dropdown. 
			// Prevent unnecessary AJAX reloads with the "cleared" class.
			$(this).removeClass( 'cleared' );
		} else {	
			var href = buildHref( $(this) );
			loadAjax(href);
		}
	
	});
	
	// Search
	$('.filters .filters-search-form').submit(function( event ) {
		event.preventDefault();	
	
		hideElements();		

		var href = buildHref( $(this) );
		loadAjax(href);
	});		

	// On focus of search input, clear all filters
	$('#team-search-query').focus(function() {

		// If any '.filter select' has a value, clear it
		var filters = false;
		$('.filter select').each(function() {
			if ( $(this).val() ) {
				filters = true;
			}
		});

		if ( filters ) {
			hideElements();		
		};
		
		var url = [location.protocol, '//', location.host, location.pathname].join('');	 
		var href = url;
		var queryParams = new URLSearchParams(window.location.search);		    		    		
		
		queryParams.delete( 'search' );			
		history.pushState(null, null, '?'+queryParams.toString());
		
		// Reset all filters, and force Pretty Dropdown to update
		$('.filter select').val('').attr('selected','');
		$dropdown.refresh();
		
		href = href + '?view=list';
		loadAjax(href);

	});
	
	// Clear filters
	$(document).on('click', '.clear-filters', function(event) {

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
	
		if ( $('.filter select').length) {
			$('.filter select').val('').attr('selected','selected').addClass('cleared').change();
			$dropdown.refresh();
		}
		
		$('#' + post_type + '-search-query').val('').attr('placeholder', search_placeholder );					
		
		loadAjax(href);
	});

		
});


jQuery(function($) {
	$(window).on('resize', function() {	  
/*
		if ( Modernizr.mq('(min-width: 768px)')) {
		}
*/
		
	}).trigger('resize');
});