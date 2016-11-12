<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'rootsmagqyroots1');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'rootsmagqyroots1');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'Cameroun237');

/** Adresse de l’hébergement MySQL. */
define('DB_HOST', 'rootsmagqyroots1.mysql.db');
//define('DB_HOST', 'localhost:3306');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8');

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'z?:on0:QRafiH_:iAO`m?rF3nbp/u32%Yy{&$#$-lZAd-W,1yQjQ!3)UL2]7diB]');
define('SECURE_AUTH_KEY',  'W.bUG+ &C7K-|Z3I4{=3Blyv;V+#p?nuZ:&6N-7@3l(fZi*F}u,bU{BsK92]z>zp');
define('LOGGED_IN_KEY',    'GFPaf3F<mCGuRO78JLZywDx?WKGN58d6Z^W+Oqy[eQRqPMish)ctf]|+.|FH-ad@');
define('NONCE_KEY',        'Lov>lT}bjge%afD*vg@5tSV4+4OCY[4x?o,?P$3<v#,lwOQmO{l=jOu6[jq#4x0L');
define('AUTH_SALT',        'HyL+@5=F6(b;;l0+||TON(T7hWIU`1czl^:p7u<7q:cZoK =JU.p|#G4v<*t(N*g');
define('SECURE_AUTH_SALT', '_0G&SlygJW@M*&5ldLRE71i21W(b5m+-:{!?Td@.PsRXJul8?$o+jRUL!^rKWB6C');
define('LOGGED_IN_SALT',   '0jGwT6Vrd*0Y0(ROg.5i#;~*w93D_McXv;S.WF*m99*{o#N5ZYDLVwX%*2MAM=@s');
define('NONCE_SALT',       '<UFwqB13SOGo$HG?gAVG],)Ob60#,tpg^eh,2+-h@p38-HXxD)g^q5$^T5CfooSv');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix  = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d'information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');