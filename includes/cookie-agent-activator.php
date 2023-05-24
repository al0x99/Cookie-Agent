<?php
class Cookie_Agent_Activator {
    public function activate() {
        global $wpdb;

        $table_name_cookies = $wpdb->prefix . "cookies";
        $table_name_scripts = $wpdb->prefix . "scripts";
        
        // Creazione tabelle nel database
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name_cookies (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name tinytext NOT NULL,
            value text NOT NULL,
            domain tinytext NOT NULL,
            path tinytext NOT NULL,
            expires bigint(20) NOT NULL,
            size mediumint(9) NOT NULL,
            httpOnly tinyint(1) NOT NULL,
            secure tinyint(1) NOT NULL,
            session tinyint(1) NOT NULL,
            sameParty tinyint(1) NOT NULL,
            sourceScheme tinytext NOT NULL,
            sourcePort int(11) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        $sql .= "CREATE TABLE $table_name_scripts (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            script_src text NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}