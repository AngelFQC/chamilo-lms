<?php
/* For licensing terms, see /license.txt */

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\FetchMode;

/**
 * Class ETLTask.
 */
abstract class ETLTask
{
    /**
     * @var MigrationMoodlePlugin|null
     */
    protected $plugin;
    /**
     * @var array
     */
    protected $extract;
    /**
     * @var array
     */
    protected $transform;

    /**
     * ETLTask constructor.
     */
    public function __construct()
    {
        $this->plugin = MigrationMoodlePlugin::create();
    }

    /**
     * Execute the migration task.
     *
     * @throws DBALException
     */
    public function execute()
    {
        foreach ($this->extract() as $sourceRow) {
            if ($this->filter($sourceRow)) {
                continue;
            }

            $incomingRow = $this->transform($sourceRow);

            $this->load($incomingRow);
        }
    }

    /**
     * @throws DBALException
     */
    private function extract(): iterable
    {
        $connection = $this->plugin->getConnection();
        $statement = $connection->executeQuery(
            $this->extract['query']
        );

        while ($row = $statement->fetch(FetchMode::ASSOCIATIVE)) {
            yield $row;
        }

        $connection->close();
    }

    /**
     * @param array $source
     *
     * @return array
     *
     * @throws Exception
     */
    private function transform(array $source): array
    {
        $incoming = [];

        foreach ($this->transform as $incomingKey => $sourceProperty) {
            if (is_array($sourceProperty)) {
                list($propertyName, $filterMethod) = $sourceProperty;

                if (!method_exists($this, $filterMethod)) {
                    throw new Exception('Filter method "'.$filterMethod.'" not found.');
                }

                $incoming[$incomingKey] = $this->$filterMethod($source[$propertyName]);

                continue;
            }

            $filterMethod = 'transform'.underScoreToCamelCase($sourceProperty);

            if (method_exists($this, $filterMethod)) {
                $incoming[$incomingKey] = $this->$filterMethod($source[$sourceProperty]);

                continue;
            }

            if (!array_key_exists($sourceProperty, $source)) {
                throw new Exception('Source property "'.$sourceProperty.'" not found.');
            }

            $incoming[$incomingKey] = $source[$sourceProperty];
        }

        return $incoming;
    }

    /**
     * @param array $incoming
     */
    abstract protected function load(array $incoming): void;

    /**
     * Allow filter the extracted data.
     *
     * @param array $sourceData
     *
     * @return bool
     */
    protected function filter(array $sourceData): bool
    {
        return false;
    }
}
