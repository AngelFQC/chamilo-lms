<?php
/* For licensing terms, see /license.txt */

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\FetchMode;

/**
 * Class UsersExtractor.
 */
class UsersExtractor extends BaseExtractor
{
    /**
     * @param array $sourceData
     *
     * @return bool
     */
    public function filter(array $sourceData): bool
    {
        return in_array(
            $sourceData['username'],
            ['admin', 'guest']
        );
    }

    /**
     * @return iterable
     *
     * @throws Exception
     */
    public function extract(): iterable
    {
        $plugin = MigrationMoodlePlugin::create();

        try {
            $connection = $plugin->getConnection();
        } catch (DBALException $e) {
            throw new Exception('Unable to start connection.', 0, $e);
        }

        $query = 'SELECT * FROM mdl_user';

        try {
            $statement = $connection->executeQuery($query);
        } catch (DBALException $e) {
            throw new Exception("Unable to execute query \"$query\".", 0, $e);
        }

        while ($sourceRow = $statement->fetch(FetchMode::ASSOCIATIVE)) {
            yield $sourceRow;
        }

        $connection->close();
    }
}
