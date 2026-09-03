<?php

/* For licensing terms, see /license.txt */

declare(strict_types=1);

namespace Chamilo\CoreBundle\Migrations\Schema\V200;

use Chamilo\CoreBundle\Migrations\AbstractMigrationChamilo;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\Dotenv\Dotenv;

class Version20250721200725 extends AbstractMigrationChamilo
{
    public function up(Schema $schema): void
    {
        $projectDir = $this->container->getParameter('kernel.project_dir');
        $updateRootPath = $this->getUpdateRootPath();
        $oldMailConfPath = $updateRootPath.'/app/config/mail.conf.php';

        $envFile = $projectDir.'/.env';

        $dotenv = new Dotenv();
        $dotenv->loadEnv($envFile);

        $settings = [];
        $settings['mailer_dkim'] = '';

        if (isset($_ENV['MAILER'])) {
            $mailerScheme = 'null';
            $smtpSecure = $_ENV['SMTP_SECURE'] ?? '';
            $query = '';

            if (!empty($smtpSecure)) {
                $mailerScheme = 'smtp';

                if ('ssl' === $smtpSecure) {
                    $mailerScheme = 'smtps';
                } elseif ('tls' === $smtpSecure) {
                    $query = '?require_tls=true';
                }
            }

            $dsn = \sprintf(
                '%s://%s%s@%s:%s%s',
                $mailerScheme,
                !empty($_ENV['SMTP_AUTH']) ? ($_ENV['SMTP_USER'] ?? '') : '',
                !empty($_ENV['SMTP_AUTH']) ? ':'.($_ENV['SMTP_PASS'] ?? '') : '',
                $_ENV['SMTP_HOST'] ?? '',
                $_ENV['SMTP_PORT'] ?? '',
                $query
            );

            $settings['mailer_from_email'] = $_ENV['SMTP_FROM_EMAIL'] ?? '';
            $settings['mailer_from_name'] = $_ENV['SMTP_FROM_NAME'] ?? '';
            $settings['mailer_dsn'] = $dsn;
            $settings['mailer_mails_charset'] = $_ENV['SMTP_CHARSET'] ?? 'UTF-8';
            $settings['mailer_debug_enable'] = !empty($_ENV['SMTP_DEBUG']) ? 'true' : 'false';
        }

        if (file_exists($oldMailConfPath)) {
            /** @var array{
             *   EXCLUDE_JSON?: bool,
             *   DKIM?: bool,
             *   DKIM_SELECTOR?: string,
             *   DKIM_DOMAIN?: string,
             *   DKIM_PRIVATE_KEY_STRING?: string,
             *   DKIM_PRIVATE_KEY?: string,
             *   DKIM_PASSPHRASE?: string,
             * } $platform_email
             */
            $platform_email = [];

            include $oldMailConfPath;

            $settings['mailer_exclude_json'] = $platform_email['EXCLUDE_JSON'] ?? false;

            $dkim = [
                'enable' => $platform_email['DKIM'] ?? false,
                'selector' => $platform_email['DKIM_SELECTOR'] ?? '',
                'domain' => $platform_email['DKIM_DOMAIN'] ?? '',
                'private_key_string' => $platform_email['DKIM_PRIVATE_KEY_STRING'] ?? '',
                'private_key' => $platform_email['DKIM_PRIVATE_KEY'] ?? '',
                'passphrase' => $platform_email['DKIM_PASSPHRASE'] ?? '',
            ];

            $settings['mailer_dkim'] = json_encode($dkim);
        }

        foreach ($settings as $variable => $value) {
            $this->addSql(
                \sprintf(
                    "INSERT IGNORE INTO settings (variable, subkey, type, category, selected_value, title, comment, scope, subkeytext, access_url, access_url_changeable, access_url_locked) VALUES ('%s', null, null, 'mail', '%s', '%s', null, '', null, 1, 1, 1)",
                    $variable,
                    $value,
                    $variable
                ),
            );
        }
    }
}
