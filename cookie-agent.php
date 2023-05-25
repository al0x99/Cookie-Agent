<?php
/**
 * Plugin Name: Cookie Agent
 * Description: Un plugin che richiama un endpoint per avere informazioni su cookies e script usati in una pagina web
 * Version: 0.0.1
 * Author: Alin Sfirschi
 * Text Domain: cookie-agent
 */

// Exit se il file viene richiamato direttamente
if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/cookie-agent-activator.php';
require_once plugin_dir_path(__FILE__) . 'includes/cookie-agent-deactivator.php';
require_once plugin_dir_path(__FILE__) . 'admin/cookie-agent-admin.php';
require plugin_dir_path( __FILE__ ) . 'includes/cookie-agent-public.php';


// Usa queste righe per registrare correttamente le classi di attivazione e disattivazione
$activator = new Cookie_Agent_Activator();
register_activation_hook(__FILE__, array($activator, 'activate'));

$deactivator = new Cookie_Agent_Deactivator();
register_deactivation_hook(__FILE__, array($deactivator, 'deactivate'));

/**
 * Inizia il plugin
 */
function cookie_agent() {
    $plugin_admin = new Cookie_Agent_Admin();
    $plugin_admin->run();
}

function run_cookie_agent() {
    $plugin_admin = new Cookie_Agent_Admin();

    $plugin_public = new Cookie_Agent_Public();
}

run_cookie_agent();


cookie_agent();