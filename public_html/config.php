<?php
/**
 @ In the name Of Allah
 * The base configurations of the Samac.
 * This file has the configurations of MySQL settings and useful core settings
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database */
define('db_name', 'quran_hadith');

/** MySQL database username */
define('db_user', 'root');

/** MySQL database password */
define('db_password', 'root');

/** MySQL hostname  */
define('db_host', 'localhost');

/** Database Charset to use in creating database tables. */
define('db_charset', 'utf8');

/**
 * Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to content/languages. For example, install
 * fa_IR.mo to content/languages and set WPLANG to 'fa_IR' to enable Persian
 * language support.
 */
define('WPLANG', 'en_US');
/**
 * For developers: debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use DEBUG
 * in their development environments.a
 */
define('DEBUG', true);
define('FACHR', 'ابپتثجچحخدذرزژسشصضطظعغفقکگلمنوهیآيئؤكآأإة');
define("core", DIR."/../core/");
define("root_dir", DIR."/../");
define("lib", core."lib/");
define("cls", root_dir."cls/");
define("sql", root_dir."sql/");
define("content", root_dir."content/");
?>