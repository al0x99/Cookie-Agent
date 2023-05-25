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

        // Qui dovrai creare un'istanza di Cookie_Agent_Admin per chiamare la funzione cookie_agent_fetch_data().
        // Assicurati di includere il file cookie-agent-admin.php per poterlo fare.
        require_once plugin_dir_path( __FILE__ ) . 'cookie-agent-admin.php';
        $admin = new Cookie_Agent_Admin();

        $result = $admin->cookie_agent_fetch_data($_POST['url']);
        if (!empty($result)) {
            // Gestisci l'errore.
        } else {
            // Gestisci il successo.
        }
    }

    public function run() {
        $this->__construct();
    }
}
