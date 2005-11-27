<?php

/*
 del.icio.us - Bookmark this!
 ==============================================================================
 
 This plugin will allow you to add an "Bookmark this page on del.icio.us"
 link on you sidebar / posts / wherever
 
 Feel free to visit my website under www.arnebrachhold.de or contact me at
 himself [at] arnebrachhold [dot] de
 
 
 Info for WordPress:
 ==============================================================================
 Plugin Name: del.icio.us - Bookmark this!
 Plugin URI: http://www.arnebrachhold.de/2005/06/05/delicious-bookmark-this-wordpress-plugin
 Description: This plugin will allow you to add an "Bookmark this page on del.icio.us" link on you sidebar / posts / wherever. Don't forget to add the &lt;?php dbt_getLinkTag("Bookmark on del.icio.us"); ?&gt; code in your templates OR use &lt;?php dbt_the_LinkTag("Bookmark on del.icio.us"); ?&gt; inside &quot;The Loop&quot;.
 Version: 1.1
 Author: Arne Brachhold
 Author URI: http://www.arnebrachhold.de
 
 
 Contributors:
 ==============================================================================
 Idea, Code, Docu			Arne Brachhold		http://www.arnebrachhold.de	
 
 
 Release History:
 ==============================================================================
 2005-06-15		1.0		First release
 2005-11-27		1.1		Added dbt_the_LinkTag which works inside "The Loop"
 
 
 Maybe Todo:
 ==============================================================================
 - Your wishes :)
 
 
 License:
 ==============================================================================
 Copyright 2005  ARNE BRACHHOLD  (email : himself [a|t] arnebrachhold d0t de)

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.
 
 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 
 */

//Enable for dev
//error_reporting(E_ALL);

//Default configuration values
$dbt_options=array();
$dbt_options["useHead"]=true;				//Insert JavaScript function in head. Set false to place it inline

//Global Storage for runtime variables
$dbt_globals["functionDone"]=false;			//Was our dbt_bookmark() written on the page?

if(!function_exists("dbt_addJavaScript")) {
	/**
	 * Echos the JavaScript function which is needed to bookmark the page
	 * @global $dbt_globals
	 */
	function dbt_addJavaScript() {
		global $dbt_globals;
		if($dbt_globals["functionDone"]===false) {
			echo "
			<!-- Added by \"del.icio.us - Bookmark this!\", a WordPress Plugin of Arne Brachhold, v1.1 -->
			<script type=\"text/javascript\" language=\"JavaScript\">
				//Bookmark on del.icio.us
				function dbt_bookmark(targetURL) {
					//URL of this document
					var loc=location.href;
					if(targetURL && targetURL.length>0) loc = targetURL;
					//Strip out any anchors
					var apos=loc.indexOf('#');
					loc=(apos>0?loc.substring(0,apos):loc);
					//Redirect to del.icio.us
					location.href='http://del.icio.us/post?v=2&amp;url='
					+ encodeURIComponent(loc)
					+'&amp;title='
					+encodeURIComponent(document.title);
					//Return false so the link won't be activated. 
					return false;
				}
			</script>
			";	
			$dbt_globals["functionDone"]=true;
		}
	}	
}

if(!function_exists("dbt_getLinkTag")) {
	/**
	 * Echos a link tag to bookmark the page
	 *
	 * @param string $text The text of the link and/or HTML
	 * @param string $attr Additional attributes for the tag.
	 *
	 * @example dbt_getLinkTag("<img src='bm.gif' border='0' />"); //Will create a link with an image
	 * @example dbt_getLinkTag("Bookmark this",'style="color:blue;"'); //Will create a textlink in blue color
	 */
	function dbt_getLinkTag($text="Bookmark on del.icio.us",$attr="") {
		dbt_addJavaScript();
		echo "<a href=\"#\" onclick=\"return dbt_bookmark();\" $attr>$text</a>";
	}	
}

if(!function_exists("dbt_the_LinkTag")) {
	/**
	 * Echos a link tag to bookmark the current post. Works only inside the loop
	 *
	 * @param string $text The text of the link and/or HTML
	 * @param string $attr Additional attributes for the tag.
	 *
	 * @example dbt_the_LinkTag("<img src='bm.gif' border='0' />"); //Will create a link with an image
	 * @example dbt_the_LinkTag("Bookmark this",'style="color:blue;"'); //Will create a textlink in blue color
	 */
	function dbt_the_LinkTag($text="Bookmark on del.icio.us",$attr="") {
		global $post;
		if($post && is_object($post) && $post->ID>0) {
			dbt_addJavaScript();
			echo "<a href=\"#\" onclick=\"return dbt_bookmark('" . get_permalink($post->ID) . "');\" $attr>$text</a>";
		}
	}
}

//If enabled, write the JavaScript function into the head method.
if($dbt_options["useHead"]===true && function_exists("add_action")) {
	add_action('wp_head', "dbt_addJavaScript");
}
?>