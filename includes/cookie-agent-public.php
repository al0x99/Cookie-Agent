<?php
class Cookie_Agent_Public {

    public function __construct() {
        add_action('init', array($this, 'handle_post_request'));
    }

    public function handle_post_request() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        if (!isset($_POST['fetch_data'], $_POST['url'])) {
            return;
        }
        require_once plugin_dir_path( __FILE__ ) . 'cookie-agent-admin.php';
        $admin = new Cookie_Agent_Admin();

        $result = $admin->cookie_agent_fetch_data($_POST['url']);
        if (!empty($result)) {
            $_SESSION['cookie_agent_error'] = $result;
        } else {
            $_SESSION['cookie_agent_success'] = __('Dati salvati correttamente nel database.', 'cookie-agent');
        }
    
        wp_redirect(wp_get_referer());
        exit;
    }


    public function cookie_agent_input_shortcode($atts) {
        ob_start();
        ?>
        <form action="" method="post">
            <input type="hidden" name="fetch_data" value="1">
            <label for="url"><?php _e('Inserisci l\'URL del sito:', 'cookie-agent'); ?></label><br>
            <input type="text" name="url" id="url" value="" size="50" required autofocus><br><br>
            <input type="submit" name="fetch" class="button button-primary" value="<?php _e('Recupera dati', 'cookie-agent'); ?>">
        </form>
        <?php
        return ob_get_clean();
    }

    function run_cookie_agent() {
        $plugin_admin = new Cookie_Agent_Admin();
    
        $plugin_public = new Cookie_Agent_Public();
    }
}
