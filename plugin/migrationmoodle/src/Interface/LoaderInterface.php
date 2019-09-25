<?php
/* For licensing terms, see /license.txt */

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
