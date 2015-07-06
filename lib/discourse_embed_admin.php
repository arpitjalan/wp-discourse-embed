<?php
/**
 * WP-Discourse-Embed admin settings
 */
require_once('discourse_embed.php');

class DiscourseEmbedAdmin {
  protected $options;

  public function __construct() {
    $this->options = get_option( 'discourse_embed' );

    add_action( 'admin_init', array( $this, 'admin_init' ) );
    add_action( 'admin_menu', array( $this, 'discourse_embed_admin_menu' ) );
  }

  /**
   * Settings
   */
  public function admin_init() {
    register_setting( 'discourse_embed', 'discourse_embed', array( $this, 'discourse_validate_options' ) );
    add_settings_section( 'discourse_embed_api', 'Common Settings', array( $this, 'init_default_settings' ), 'discourse_embed' );

    add_settings_field( 'discourse_url', 'Discourse URL', array( $this, 'url_input' ), 'discourse_embed', 'discourse_embed_api' );
    add_settings_field( 'embed_after_date_input', 'Embed blog posts created after date (optional)', array( $this, 'embed_after_date_input' ), 'discourse_embed', 'discourse_embed_api' );
  }

  function url_input() {
    self::text_input( 'url', '' );
  }

  function embed_after_date_input() {
    self::text_input( 'embed_after_date', 'Date format should be mm/dd/yyyy' );
  }

  function text_input( $option, $description ) {
    $options = $this->options;

    if ( array_key_exists( $option, $options ) ) {
      $value = $options[$option];
    } else {
      $value = '';
    }

    ?>
    <input id='discourse_<?php echo $option?>' name='discourse_embed[<?php echo $option?>]' type='text' value='<?php echo esc_attr( $value ); ?>' class="regular-text ltr" />
    <p class="description"><?php echo $description ?></p>
    <?php
  }

  function discourse_validate_options( $inputs ) {
    foreach ( $inputs as $key => $input ) {
      $inputs[ $key ] = is_string( $input ) ? trim( $input ) : $input;
    }

    $inputs['url'] = untrailingslashit( $inputs['url'] );
    return $inputs;
  }

  function discourse_embed_admin_menu(){
    add_options_page( 'Discourse Embed', 'Discourse Embed', 'manage_options', 'discourse_embed', array ( $this, 'discourse_embed_options_page' ) );
  }

  function discourse_embed_options_page() {
    if ( !current_user_can( 'manage_options' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    ?>
    <div class="wrap">
        <h2>Discourse Embed Options</h2>
        <form action="options.php" method="POST">
            <?php settings_fields( 'discourse_embed' ); ?>
            <?php do_settings_sections( 'discourse_embed' ); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
  }

}
