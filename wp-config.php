<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa user o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações
// com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'estudoacf');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'root');

/** Nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Charset do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '^o(Q^5<l:11?rJF$|o}k28LGg$pLu[H0Ht7bwn>`0@??-3Cl9Qo!*n UKfEh( %q');
define('SECURE_AUTH_KEY',  'lL#m11O/@_set<Abd#mRI|7Kli<M 3k]hQ5Dy{w:V$2Tt.)2muI8wzye CzSs}F/');
define('LOGGED_IN_KEY',    '`CT42hJr-?4UaO!<b5%)N^~?nSxt#/-,E&OzApYUjC3Hgve+AxC;:5ClgZBla|JS');
define('NONCE_KEY',        'U`TaIoia2Lu=|(,Zt*/tviy3!R%;OukszB5Ty,,5;uN@F4[->JJjy48%q,*h$Qj,');
define('AUTH_SALT',        'Sz?zt#Cux&CS1&WXOj^OP~5gCG*p]@j.@kZDs`0#ZHy.x+]@<>)o3ly%lK>Iuglm');
define('SECURE_AUTH_SALT', '1/ZN(gWh4q}>QgO}VD-8e9x(y,D~V^U<:=a P|Z[0[a|y6,#1UFq^ZQ@}5.hNM1B');
define('LOGGED_IN_SALT',   'p`|:2pBp 5DZ;T2Z<+E:tZxEE*h|~f,@{!pz=s,OnWRhA<+2DEv*zl/H$:87>]au');
define('NONCE_SALT',       'OTxaiYh%H} 09gis<(S:<KOkFb&QadlP^s3V^BtVFO[[(G{JY/EX[6i{xdGN5;$Z');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * para cada um um único prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'eacf_';

/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
