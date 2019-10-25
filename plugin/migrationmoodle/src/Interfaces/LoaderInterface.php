<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\PluginBundle\MigrationMoodle\Interfaces;

/**
 * Interface LoaderInterface.
 */
interface LoaderInterface
{
    /**
     * @param array $incomingData
     */
    public function load(array $incomingData): void;
}
