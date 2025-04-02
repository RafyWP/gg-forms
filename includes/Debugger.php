<?php

namespace RafyCo\GGForms;

defined( 'ABSPATH' ) || exit;

/**
 * Utility class for logging and admin notices.
 */
class Debugger {

    /**
     * Log message to custom file.
     *
     * @param string $message Message to log.
     */
    public static function log( $message ) {
        $log_path = WP_CONTENT_DIR . '/debug-log-gg-forms.log';
        $date     = date_i18n( 'Y-m-d H:i:s' );
        $entry    = "[{$date}] {$message}" . PHP_EOL;
        file_put_contents( $log_path, $entry, FILE_APPEND );
    }

    /**
     * Display an admin notice.
     *
     * @param string $message Notice message.
     * @param string $type    Notice type: error, warning, success, info.
     */
    public static function display_admin_notice( $message, $type = 'error' ) {
        add_action( 'admin_notices', function () use ( $message, $type ) {
            printf(
                '<div class="notice notice-%s"><p>%s</p></div>',
                esc_attr( $type ),
                esc_html( $message )
            );
        } );
    }
}
