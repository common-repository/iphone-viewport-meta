<?php
// WordPress iPhone Viewport Meta Tag
// version 0.8.3, 2007-12-31
//
// Copyright (c) 2007 Bill Humphries
// http://whump.com/
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// *****************************************************************

/*
Plugin Name: iPhone Viewport Meta Tag
Plugin URI: http://www.whump.com/moreLikeThis/2007/07/11/iphone-viewport-meta-plugin-for-wordpress/
Description: Add a viewport tag and iPhone specific CSS rules to head if user agent is iPhone Safari.
Author: Bill Humphries and James Craig
Author URI: http://whump.com
Version: 0.8.3
*/ 

function weh_is_iPhone() {
  $agents = array(
    'iPhone',
    'iPod'
  );
  foreach ($agents as $agent) {
    if (strstr($_SERVER["HTTP_USER_AGENT"], $agent) ||
      $_GET["forceiphone"] == 'y') {
        return true;
    }
  }
  return false;
}

function weh_add_viewport_meta_tag() {
  if (weh_is_iPhone()) {
    echo <<< EOT
  <meta content="width=device-width, maximum-scale=0.6667" name="viewport"/>
  <style media="only screen and (max-device-width: 480px)" type="text/css">
  /* <![CDATA[ */
      div#content { margin: 0pt; }
  /* ]]> */
  </style>
EOT;
  }
}

function weh_add_scroll() {
  if (weh_is_iPhone()) {
    echo <<< EOT
    <script type="text/javascript">
    // only call window.scrollto if we aren't jumping to a named location on the page.
    if (window.location.hash == "") {
        setTimeout(function() {window.scrollTo(0,1);}, 0); 
    }
    </script>
EOT;
  }
}

add_action('wp_head', 'weh_add_viewport_meta_tag', 0);
add_action('wp_footer', 'weh_add_scroll',0);
?>