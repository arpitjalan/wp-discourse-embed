<?php
/**
 * WP-Discourse-Embed
 */
class DiscourseEmbed {

  // Version
  static $version ='0.1.1';

  // Options and defaults
  static $options = array(
    'url' => '',
    'embed_after_date' => ''
  );

  public function __construct() {
    add_action( 'init', array( $this, 'init' ) );
    add_action( 'wp_footer', array( $this, 'discourse_embed_js' ), 100 );
  }

  static function install() {
    update_option( 'discourse_embed_version', self::$version );
    add_option( 'discourse_embed', self::$options );
  }

  public function init() {
    // replace comments with discourse comments
    add_filter( 'comments_template', array( $this, 'comments_template' ) );
  }

  function discourse_embed_js() {
    global $post;
    $discourse_embed_options = self::get_plugin_options();
    $discourse_embed_url = $discourse_embed_options['url'] . "/";
  ?>
    <script>
      var discourseUrl = '<?php echo $discourse_embed_url; ?>',
          discourseEmbedUrl = '<?php echo get_permalink( $post->ID ); ?>';
      (function() {
        var d = document.createElement('script'); d.type = 'text/javascript'; d.async = true;
          d.src = discourseUrl + 'javascripts/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(d);
      })();
    </script>
  <?php
  }

  static function get_plugin_options() {
    return wp_parse_args( get_option( 'discourse_embed' ), DiscourseEmbed::$options );
  }

  function comments_template( $old ) {
    global $post;
    $discourse_embed_options = self::get_plugin_options();
    $discourse_embed_url = $discourse_embed_options['url'];
    $discourse_embed_after_date = $discourse_embed_options['embed_after_date'];
    $post_publish_date = get_the_date( 'm/d/Y', $post->ID );;

    if( isset($discourse_embed_url) ) {
      if ( isset($discourse_embed_after_date) && (strtotime($post_publish_date) > strtotime($discourse_embed_after_date)) ) {
        return WPDISCOURSEEMBED_PATH . '/templates/comments.php';
      } else if ( isset($discourse_embed_after_date) ) {
        return $old;
      } else {
        return WPDISCOURSEEMBED_PATH . '/templates/comments.php';
      }
    } else {
      return $old;
    }
  }

}
