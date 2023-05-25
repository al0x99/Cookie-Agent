<?php
class Cookie_Agent_Admin {
    public function __construct() {
        add_action('admin_menu', array($this, 'cookie_agent_menu'));
        add_action('admin_init', array($this, 'cookie_agent_settings'));
        add_shortcode('cookie_agent_input', array($this, 'cookie_agent_input_shortcode'));
    }

    public function cookie_agent_menu() {
        add_menu_page(
            'Cookie Agent',
            'Cookie Agent',
            'manage_options',
            'cookie-agent',
            array($this, 'cookie_agent_dashboard_page'),
            '', 
            2 // Cambiare questo valore per cambiare la posizione nel menu
        );
    }

    public function cookie_agent_settings() {
        
    }

    public function cookie_agent_dashboard_page() {
        // Controllo per la richiesta POST
        if (isset($_POST['fetch_data'], $_POST['url'])) {
            $result = $this->cookie_agent_fetch_data($_POST['url']);
            if (!empty($result)) {
                echo '<div class="notice notice-error is-dismissible"><p>' . $result . '</p></div>';
            } else {
                echo '<div class="notice notice-success is-dismissible"><p>' . __('Dati salvati correttamente nel database.', 'cookie-agent') . '</p></div>';
            }
        }
    
        // Contenuto della pagina di amministrazione
        echo '<div class="wrap">';
        echo '<h1>' . __('Cookie Agent', 'cookie-agent') . '</h1>';
        echo '<form action="" method="post">';
        echo '<input type="hidden" name="fetch_data" value="1">';
        echo '<label for="url">' . __('Inserisci l\'URL del sito:', 'cookie-agent') . '</label><br>';
        echo '<input type="text" name="url" id="url" value="" size="50" required autofocus><br><br>';
        echo '<input type="submit" name="fetch" class="button button-primary" value="' . __('Recupera dati', 'cookie-agent') . '">';
        echo '</form>';
        echo '</div>';
        
        echo '<h2>' . __('Shortcode per il frontend', 'cookie-agent') . '</h2>';
        echo '<p><strong>[cookie_agent_input]</strong></p>';
    
        // Qui si possono aggiungere le funzioni per visualizzare i risultati delle ricerche precedenti
    }

    public function cookie_agent_fetch_data($url) {
        $username = 'alinsfirschi';
        $password = 'imcAeh23a@';
    
        $response = wp_remote_post('http://195.32.71.172:3000/scan', array(
            'body' => json_encode(array(
                'url' => $url
            )),
            'headers' => array(
                'Content-Type' => 'application/json; charset=utf-8',
                'Authorization' => 'Basic ' . base64_encode( $username . ':' . $password ),
            ),
        ));
    
        if (is_wp_error($response)) {
            return $response->get_error_message();
        }
    
        $response_data = json_decode(wp_remote_retrieve_body($response), true);
        
        $this->cookie_agent_save_data_to_database($response_data);

        return '';
    }

    public function cookie_agent_save_data_to_database($data) {
        global $wpdb;
        $table_name_cookies = $wpdb->prefix . 'cookies';
        $table_name_scripts = $wpdb->prefix . 'scripts';
    
        // Salva i cookies nel db
        foreach ($data['cookies'] as $cookie) {
            $wpdb->insert($table_name_cookies, array(
                'name' => $cookie['name'],
                'value' => $cookie['value'],
                'domain' => $cookie['domain'],
                'path' => $cookie['path'],
                'expires' => $cookie['expires'],
                'size' => $cookie['size'],
                'httpOnly' => $cookie['httpOnly'],
                'secure' => $cookie['secure'],
                'session' => $cookie['session'],
                'sameParty' => $cookie['sameParty'],
                'sourceScheme' => $cookie['sourceScheme'],
                'sourcePort' => $cookie['sourcePort']
            ));
        }
    
        // Salva gli scripts nel db
        foreach ($data['scripts'] as $script) {
            $wpdb->insert($table_name_scripts, array(
                'script_src' => $script
            ));
        }
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

    public function run() {
        $this->__construct();
    }
}