<?php
class Cookie_Agent_Admin {
    public function __construct() {
        add_action('admin_menu', array($this, 'cookie_agent_menu'));
        add_action('admin_init', array($this, 'cookie_agent_settings'));
    }

    public function cookie_agent_menu() {
        add_submenu_page('tools.php', 'Cookie Agent', 'Cookie Agent', 'manage_options', 'cookie-agent', array($this, 'cookie_agent_dashboard_page'));
    }

    public function cookie_agent_settings() {
        // Qui puoi aggiungere eventuali settaggi
    }

    public function cookie_agent_dashboard_page() {
        // Qui puoi creare il contenuto della pagina di amministrazione del plugin
    }

    public function run() {
        $this->__construct();
    }
}