<?php
/* For licensing terms, see /license.txt */

/**
 * Class BaseExtractor.
 */
abstract class BaseExtractor implements ExtractorInterface
{
    /**
     * @param array $sourceData
     *
     * @return bool
     */
    public function filter(array $sourceData): bool
    {
        return false;
    }

    /**
     * @return iterable
     *
     * @throws Exception
     */
    abstract public function extract(): iterable;
}
