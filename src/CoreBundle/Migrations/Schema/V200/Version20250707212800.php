<?php

/* For licensing terms, see /license.txt */

declare(strict_types=1);

namespace Chamilo\CoreBundle\Migrations\Schema\V200;

use Chamilo\CoreBundle\Migrations\AbstractMigrationChamilo;
use Doctrine\DBAL\Schema\Schema;

final class Version20250707212800 extends AbstractMigrationChamilo
{
    public function getDescription(): string
    {
        return 'Migrate settings from mail.conf.php to settings';
    }

    public function up(Schema $schema): void
    {
        $updateRootPath = $this->getUpdateRootPath();
        $oldMailConfPath = $updateRootPath.'/app/config/mail.conf.php';

        $envSettings = $this->migrateMailConf($oldMailConfPath);

        if (!empty($envSettings)) {
            $this->updateEnvFiles($envSettings);
        }
    }

    private function migrateMailConf(string $oldMailConfPath): array
    {
        if (!file_exists($oldMailConfPath)) {
            return [];
        }

        /** @var array{
         *   SMTP_USER?: string,
         *   SMTP_PASS?: string,
         *   SMTP_HOST?: string,
         *   SMTP_PORT?: string,
         *   SMTP_SECURE?: string,
         *   SMTP_AUTH?: bool,
         *   SMTP_FROM_EMAIL?: string,
         *   SMTP_FROM_NAME?: string,
         *   SMTP_CHARSET?: string,
         *   SMTP_DEBUG?: bool,
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

        $mailerScheme = 'null';
        $smtpSecure = $platform_email['SMTP_SECURE'] ?? '';
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
            !empty($platform_email['SMTP_AUTH']) ? ($platform_email['SMTP_USER'] ?? '') : '',
            !empty($platform_email['SMTP_AUTH']) ? ':'.($platform_email['SMTP_PASS'] ?? '') : '',
            $platform_email['SMTP_HOST'] ?? '',
            $platform_email['SMTP_PORT'] ?? '',
            $query
        );

        $dkim = [
            'enable' => $platform_email['DKIM'] ?? false,
            'selector' => $platform_email['DKIM_SELECTOR'] ?? '',
            'domain' => $platform_email['DKIM_DOMAIN'] ?? '',
            'private_key_string' => $platform_email['DKIM_PRIVATE_KEY_STRING'] ?? '',
            'private_key' => $platform_email['DKIM_PRIVATE_KEY'] ?? '',
            'passphrase' => $platform_email['DKIM_PASSPHRASE'] ?? '',
        ];

        // SMTP_UNIQUE_SENDER intentionally ignored as requested.

        return [
            'mailer_from_email' => $platform_email['SMTP_FROM_EMAIL'] ?? '',
            'mailer_from_name' => $platform_email['SMTP_FROM_NAME'] ?? '',
            'mailer_dsn' => $dsn,
            'mailer_mails_charset' => $platform_email['SMTP_CHARSET'] ?? 'UTF-8',
            'mailer_debug_enable' => !empty($platform_email['SMTP_DEBUG']) ? 'true' : 'false',
            'mailer_exclude_json' => $platform_email['EXCLUDE_JSON'] ?? false,
            'mailer_dkim' => json_encode($dkim),
        ];
    }

    private function updateEnvFiles(array $envSettings): void
    {
        foreach ($envSettings as $variable => $value) {
            $this->addSql(
                \sprintf(
                    "UPDATE settings SET selected_value = '%s' WHERE variable = '%s' AND category = 'mail'",
                    $value,
                    $variable
                )
            );
        }
    }
}
