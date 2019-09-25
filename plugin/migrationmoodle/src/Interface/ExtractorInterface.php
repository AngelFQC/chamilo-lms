<?php
/* For licensing terms, see /license.txt */

/**
 * Interface ExtractorInterface.
 */
interface ExtractorInterface
{
    /**
     * @param array $sourceData
     *
     * @return bool
     */
    public function filter(array $sourceData): bool;

    /**
     * @return iterable
     *
     * @throws Exception
     */
    public function extract(): iterable;
}
