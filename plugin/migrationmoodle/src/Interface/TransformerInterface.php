<?php
/* For licensing terms, see /license.txt */

/**
 * Interface TransformerInterface.
 */
interface TransformerInterface
{
    /**
     * @return array
     */
    public function mapProperties(): array;

    /**
     * @param array $sourceData
     *
     * @throws Exception
     *
     * @return array
     */
    public function transform(array $sourceData): array;
}
