<div align="center">

  <img src="https://knecht.works/styleguide/favicon/favicon.svg" alt="Knecht" width="112" height="112">

# test-drupal10

<p>
  <img src="https://img.shields.io/badge/Drupal-10.x-0678BE?logo=drupal&logoColor=white" alt="Drupal 10.x">
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?logo=php&logoColor=white" alt="PHP 8.3">
  <img src="https://img.shields.io/badge/DDEV-nginx--fpm-02A8E2?logo=docker&logoColor=white" alt="DDEV · nginx-fpm">
  <img src="https://img.shields.io/badge/Knecht-e2e%20fixture-b7f8a2?labelColor=09090b" alt="Knecht e2e fixture">
  <img src="https://img.shields.io/badge/license-MIT-blue" alt="MIT License">
</p>

</div>

A [DDEV](https://ddev.com)-based Drupal 10 project used as an end-to-end test fixture for [Knecht](https://knecht.works). It's a stock `standard` profile install with a tiny custom theme (`web/themes/custom/knecht`) that renders a demo front page built with the Knecht Styleguide Kit, so Knecht can boot the environment, hit the site, and assert against real CMS behavior (rendered Twig templates, database queries, the admin login). The database ships as a seed dump in `seed/db.sql.gz`, so no interactive installer is needed.

## Setup

Requires [DDEV](https://ddev.readthedocs.io/en/stable/users/install/ddev-installation/) and a Docker provider (Docker, OrbStack, or Colima).

```bash
ddev start                                # boot the containers
ddev composer install                     # install Drupal core, contrib and Drush
ddev import-db --file=seed/db.sql.gz      # load the pre-installed site
ddev drush cr                             # rebuild caches (optional)
```

The seed already contains the installed site (site name `test-drupal10`, default theme `knecht`) with one administrator account:

| Username | Password           |
| -------- | ------------------ |
| `admin`  | `admin123` |

To recreate the seed after changing the site, run `ddev export-db --file=seed/db.sql.gz`. The dump does not reference any uploaded files, so nothing under `web/sites/default/files` needs to be tracked.

## URLs

`ddev launch` opens the site in your browser.

| Role        | URL                                            |
| ----------- | ---------------------------------------------- |
| Site        | `https://test-drupal10.ddev.site`              |
| Admin login | `https://test-drupal10.ddev.site/user/login`   |
| Status page | `https://test-drupal10.ddev.site/admin/reports/status` |
