<?php
/* For licensing terms, see /license.txt */

/**
 * Class BaseTransformer.
 */
abstract class BaseTransformer implements TransformerInterface
{
    /**
     * @param array $sourceData
     *
     * @return array
     * @throws Exception
     */
    public function transform(array $sourceData): array
    {
        $incomingResult = [];

        $mapping = $this->mapProperties();

        foreach ($mapping as $incomingProperty => $sourceProperty) {
            if (is_array($sourceProperty)) {
                list($propertyName, $filterMethod) = $sourceProperty;

                if (!method_exists($this, $filterMethod)) {
                    throw new Exception('Filter method "'.$filterMethod.'" not found.');
                }

                $incomingResult[$incomingProperty] = $this->$filterMethod($sourceData[$propertyName]);

                continue;
            }

            $filterMethod = 'transform'.underScoreToCamelCase($sourceProperty);

            if (method_exists($this, $filterMethod)) {
                $incomingResult[$incomingProperty] = $this->$filterMethod($sourceData[$sourceProperty]);

                continue;
            }

            if (!array_key_exists($sourceProperty, $sourceData)) {
                throw new Exception("Source property \"$sourceProperty\" not found-");
            }

            $incomingResult[$incomingProperty] = $sourceData[$sourceProperty];
        }

        return $incomingResult;
    }

    /**
     * @return array
     */
    abstract public function mapProperties(): array;
}
