<?php

/**
 * @file
 * Drupal settings for the Knecht test-drupal10 e2e fixture.
 *
 * This file is intentionally small and generic. DDEV provides the database
 * credentials via settings.ddev.php (generated on `ddev start`, not tracked in
 * git). Everything the fixture needs to be reproducible from a bare clone plus
 * seed/db.sql.gz is pinned at the bottom of this file.
 */

$databases = [];

$settings['config_sync_directory'] = '../config/sync';
$settings['file_public_path'] = 'sites/default/files';
$settings['file_temp_path'] = '/tmp';
$settings['update_free_access'] = FALSE;
$settings['file_scan_ignore_directories'] = [
  'node_modules',
  'bower_components',
];
$settings['entity_update_batch_size'] = 50;
$settings['entity_update_backup'] = TRUE;
$settings['migrate_node_migrate_type_classic'] = FALSE;

// Automatically generated include for settings managed by ddev.
$ddev_settings = dirname(__FILE__) . '/settings.ddev.php';
if (getenv('IS_DDEV_PROJECT') == 'true' && is_readable($ddev_settings)) {
  include $ddev_settings;
}

/**
 * Local development override configuration, if available.
 */
if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
  include $app_root . '/' . $site_path . '/settings.local.php';
}

/**
 * Fixture-specific settings.
 *
 * These come last on purpose so they win over whatever DDEV generated: the
 * hash salt must be stable across fresh clones (it is baked into the seed
 * dump), and the fixture is served through Knecht's proxy on arbitrary
 * hostnames, so trusted hosts are left fully open.
 */
$settings['hash_salt'] = 'knecht-test-drupal10-e2e-fixture-hash-salt-3f9c1a7e';
$settings['trusted_host_patterns'] = ['.*'];
$settings['skip_permissions_hardening'] = TRUE;
$settings['state_cache'] = TRUE;

// Vite HMR under Knecht: the dev server runs next to the site on its own
// origin, handed in as KNECHT_DEV_SERVER_URL. Switch explicitly instead of
// letting drupal/vite probe, because the probe result is baked into the
// library cache at `drush cr`, which runs before the dev server is up, and
// the public dev origin is not reachable from inside the container anyway.
if ($knecht_dev_server = getenv('KNECHT_DEV_SERVER_URL')) {
  $settings['vite'] = [
    'useDevServer' => TRUE,
    'devServerUrl' => rtrim($knecht_dev_server, '/'),
  ];
}
