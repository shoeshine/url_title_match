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
	var $version	 	= '1.0';
	var $description	= 'Forces match of Structure URL and URL Title when first character for Structure URL is digit or letter.';
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
					function match_url_titles() {
						var structure_url = $("#structure__uri").val();
						var structure_first_char = structure_url.charAt(0);
						var url_title = $("#url_title").val();

						$(".publish_text input#url_title").each(function() {
							// Only match if first character is alphanumeric
							if ( /^[0-9A-Za-z]+$/.test(structure_first_char) ) {
								$(this).val(structure_url);
							}
						});
					}

					// Check URL queries to see if we are on an edit entry page view, if so, fire away
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
					var entry_id = qs["entry_id"];
					
					if (entry_id) {
						match_url_titles();
						$(document).on("focus", "#structure__uri", match_url_titles);
						$(document).on("change, keyup", "#structure__uri", match_url_titles);
					}
				});
			</script>
		');
		
	}
	
}
// END CLASS

/* End of file acc.url_title_match.php */
/* Location: ./system/expressionengine/third_party/developer/acc.url_title_match.php */