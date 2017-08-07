<?php
/**
 * Exports Actions
 *
 * These are actions related to exporting data from MDJM Event Management.
 *
 * @package     MDJM
 * @subpackage  Admin/Export
 * @copyright   Copyright (c) 2016, Mike Howard
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * Process the download file generated by a batch export
 *
 * @since	1.4
 * @return	void
 */
function mdjm_process_batch_export_download() {

	if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'mdjm-batch-export' ) ) {
		wp_die( __( 'Nonce verification failed', 'mobile-dj-manager' ), __( 'Error', 'mobile-dj-manager' ), array( 'response' => 403 ) );
	}

	require_once( MDJM_PLUGIN_DIR . '/includes/admin/reporting/export/class-batch-export.php' );

	do_action( 'mdjm_batch_export_class_include', $_REQUEST['class'] );

	$export = new $_REQUEST['class'];
	$export->export();

}
add_action( 'mdjm_download_batch_export', 'mdjm_process_batch_export_download' );

/**
 * Export all the clients to a CSV file.
 *
 * Note: The WordPress Database API is being used directly for performance
 * reasons (workaround of calling all posts and fetch data respectively)
 *
 * @since	1.4
 * @return	void
 */
function mdjm_export_all_clients() {
	require_once MDJM_PLUGIN_DIR . '/includes/admin/reporting/class-mdjm-clients-export.php';

	$client_export = new MDJM_Clients_Export();

	$client_export->export();
} // mdjm_export_all_clients
add_action( 'mdjm_email_export', 'mdjm_export_all_clients' );

/**
 * Add a hook allowing extensions to register a hook on the batch export process
 *
 * @since	1.4
 * @return	void
 */
function mdjm_register_batch_exporters() {
	if ( is_admin() ) {
		do_action( 'mdjm_register_batch_exporter' );
	}
} // mdjm_register_batch_exporters
add_action( 'plugins_loaded', 'mdjm_register_batch_exporters' );

/**
 * Register the events batch exporter
 * @since	1.4
 */
function mdjm_register_events_batch_export() {
	add_action( 'mdjm_batch_export_class_include', 'mdjm_include_events_batch_processer', 10, 1 );
} // mdjm_register_txns_batch_export
add_action( 'mdjm_register_batch_exporter', 'mdjm_register_events_batch_export', 10 );

/**
 * Loads the events batch process if needed
 *
 * @since 	1.4
 * @param	str		$class	The class being requested to run for the batch export
 * @return	void
 */
function mdjm_include_events_batch_processer( $class ) {

	if ( 'MDJM_Batch_Export_Events' === $class ) {
		require_once( MDJM_PLUGIN_DIR . '/includes/admin/reporting/export/class-batch-export-events.php' );
	}

} // mdjm_include_txns_batch_processer

/**
 * Register the transactions batch exporter
 * @since	1.4
 */
function mdjm_register_txns_batch_export() {
	add_action( 'mdjm_batch_export_class_include', 'mdjm_include_txns_batch_processer', 10, 1 );
} // mdjm_register_txns_batch_export
add_action( 'mdjm_register_batch_exporter', 'mdjm_register_txns_batch_export', 10 );

/**
 * Loads the transactions batch process if needed
 *
 * @since 	1.4
 * @param	str		$class	The class being requested to run for the batch export
 * @return	void
 */
function mdjm_include_txns_batch_processer( $class ) {

	if ( 'MDJM_Batch_Export_Txns' === $class ) {
		require_once( MDJM_PLUGIN_DIR . '/includes/admin/reporting/export/class-batch-export-txns.php' );
	}

} // mdjm_include_txns_batch_processer

/**
 * Register the clients batch exporter
 * @since	1.4
 */
function mdjm_register_clients_batch_export() {
	add_action( 'mdjm_batch_export_class_include', 'mdjm_include_clients_batch_processer', 10, 1 );
} // mdjm_register_clients_batch_export
add_action( 'mdjm_register_batch_exporter', 'mdjm_register_clients_batch_export', 10 );

/**
 * Loads the clients batch process if needed
 *
 * @since 	1.4
 * @param	str		$class	The class being requested to run for the batch export
 * @return	void
 */
function mdjm_include_clients_batch_processer( $class ) {

	if ( 'MDJM_Batch_Export_Clients' === $class ) {
		require_once( MDJM_PLUGIN_DIR . '/includes/admin/reporting/export/class-batch-export-clients.php' );
	}

} // mdjm_include_clients_batch_processer

/**
 * Register the employees batch exporter
 * @since	1.4
 */
function mdjm_register_employees_batch_export() {
	add_action( 'mdjm_batch_export_class_include', 'mdjm_include_employees_batch_processer', 10, 1 );
} // mdjm_register_clients_batch_export
add_action( 'mdjm_register_batch_exporter', 'mdjm_register_employees_batch_export', 10 );

/**
 * Loads the employees batch process if needed
 *
 * @since 	1.4
 * @param	str		$class	The class being requested to run for the batch export
 * @return	void
 */
function mdjm_include_employees_batch_processer( $class ) {

	if ( 'MDJM_Batch_Export_Employees' === $class ) {
		require_once( MDJM_PLUGIN_DIR . '/includes/admin/reporting/export/class-batch-export-employees.php' );
	}

} // mdjm_include_employees_batch_processer
