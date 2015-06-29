<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine Developer Accessory
 *
 * @package		URL Title Match
 * @category	Accessory
 * @description	Forces match of Structure URL and URL Title when first character for Structure URL is digit or letter.
 * @author		Shoe Shine Design & Developer
 * @link		http://www.shoeshinedesign.com
 */


class Url_title_match_acc
{
	var $name	 		= 'URL Title Match';
	var $id	 			= 'url_title_match';
	var $version	 	= '1.1';
	var $description	= 'Forces match of Structure URL and URL Title when first character is a digit or letter.';
	var $sections	 	= array();
	
	// --------------------------------------------------------------------
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		$this->EE =& get_instance();
	} 

	// --------------------------------------------------------------------
	
	/**
	* Set Sections
	*/
	function set_sections()
	{
		// hide accessory
		$this->sections[] = '<script type="text/javascript" charset="utf-8">$("#accessoryTabs a.url_title_match").parent().remove();</script>';

		//add css, js and html
		$this->EE->cp->add_to_foot('
			<script>
				$(document).ready(function() {
					
					//	find our pair of url inputs, and setup some throttle timer variables
					var $url_title		= $(\'input[name="url_title"]\'),
						$structure_url	= $(\'input[name="structure__uri"]\'),
						throttle_delay	= 250,
						timer			= 0;
					
					
					//	real basic throttling to keep our matching from running wild
					function throttle_url_matching() {
						clearTimeout(timer);
						timer = setTimeout( $.proxy(match_url_titles,this), throttle_delay );
					}
					
					
					//	url matching magic			
					function match_url_titles() {
						var	$edited	= $(this);
						
						// Only match if first character is alphanumeric
						if ( /^[0-9A-Za-z]+$/.test( $edited.val().charAt(0) )) {
							//	loop both urls to see which is the other (ie not currently being edited)
							$.each([$url_title, $structure_url], function(){
								if( $edited.get(0) != this.get(0) )
								{
									this.val($edited.val());
								}
							});
						}
					}


					// Check URL queries for given keys
					var qs = (function(a) {
					    if (a == "") return {};
					    var b = {};
					    for (var i = 0; i < a.length; ++i)
					    {
					        var p=a[i].split("=");
					        if (p.length != 2) continue;
					        b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
					    }
					    return b;
					})(window.location.search.substr(1).split("&"));
					
					
					//	if we are on an edit entry page view, and our url pair inputs are present, fire away
					if ( qs["entry_id"] && $url_title.length && $structure_url.length ) {
						$("body").on("change keyup blur focus", "input[name=\'url_title\'], input[name=\'structure__uri\']", throttle_url_matching);
					}
					
				});
			</script>
		');
		
	}
	
}
// END CLASS

/* End of file acc.url_title_match.php */
/* Location: ./system/expressionengine/third_party/developer/acc.url_title_match.php */