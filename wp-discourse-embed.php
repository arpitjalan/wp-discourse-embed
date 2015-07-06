<?php
/*
Plugin Name: WP-Discourse-Embed
Description: Use Discourse as a community engine for your WordPress blog
Version: 0.1.1
Author: Arpit Jalan
Author URI: https://github.com/techAPJ/wp-discourse-embed
Plugin URI: https://github.com/techAPJ/wp-discourse-embed
GitHub Plugin URI: https://github.com/techAPJ/wp-discourse-embed
*/
/*  Copyright 2015 Civilized Discourse Construction Kit, Inc (team@discourse.org)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

define( 'WPDISCOURSEEMBED_PATH', plugin_dir_path( __FILE__ ) );

require_once( __DIR__ . '/lib/discourse_embed.php' );
require_once( __DIR__ . '/lib/discourse_embed_admin.php' );

$discourse_embed = new DiscourseEmbed();
$discourse_embed_admin = new DiscourseEmbedAdmin();

register_activation_hook( __FILE__, array( $discourse_embed, 'install' ) );
