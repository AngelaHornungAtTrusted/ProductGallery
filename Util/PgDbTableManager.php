<?php

namespace Util;
class PgDbTableManager
{
    public $pgdb;

    public function __construct($wpdb) {
        $this->pgdb = $wpdb;
    }

    public function initTables() : void {
        $charset_collate = $this->pgdb->get_charset_collate();

        $itemTables = "CREATE TABLE " . PG_TABLE_IMAGES . " (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title varchar(255) DEFAULT '' NOT NULL,
        path varchar(255) DEFAULT '' NOT NULL,
        thumbnail varchar(255) DEFAULT '' NOT NULL,
        description varchar(255) DEFAULT '' NOT NULL,
        create_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        update_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        PRIMARY KEY (id)) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($itemTables);
    }
}