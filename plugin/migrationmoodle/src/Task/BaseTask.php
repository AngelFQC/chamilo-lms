<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\PluginBundle\MigrationMoodle\Task;

use Chamilo\PluginBundle\MigrationMoodle\Interfaces\ExtractorInterface;
use Chamilo\PluginBundle\MigrationMoodle\Interfaces\LoaderInterface;
use Chamilo\PluginBundle\MigrationMoodle\Interfaces\TransformerInterface;

/**
 * Class BaseTask.
 */
abstract class BaseTask
{
    /**
     * @var ExtractorInterface
     */
    protected $extractor;
    /**
     * @var TransformerInterface
     */
    protected $transformer;
    /**
     * @var LoaderInterface
     */
    protected $loader;

    /**
     * BaseTask constructor.
     */
    public function __construct()
    {
        $this->extractor = $this->getExtractor();

        $this->transformer = $this->getTransformer();

        $this->loader = $this->getLoader();
    }

    /**
     * @return array
     */
    abstract public function getExtractConfiguration(): array;

    /**
     * @return array
     */
    abstract public function getTransformConfiguration(): array;

    /**
     * @return array
     */
    abstract public function getLoadConfiguration(): array;

    /**
     *
     */
    public function execute(): void
    {
        foreach ($this->extractor->extract() as $extractedData) {
            if ($this->extractor->filter($extractedData)) {
                continue;
            }

            $incomingData = $this->transformer->transform($extractedData);

            $this->loader->load($incomingData);
        }
    }

    /**
     * @return ExtractorInterface
     */
    private function getExtractor()
    {
        $configuration = $this->getExtractConfiguration();

        $extractorClass = $configuration['class'];
        /** @var ExtractorInterface $extractor */
        $extractor = new $extractorClass($configuration);

        return $extractor;
    }

    /**
     * @return TransformerInterface
     */
    private function getTransformer()
    {
        $configuration = $this->getTransformConfiguration();

        $transformerClass = $configuration['class'];
        /** @var TransformerInterface $extractor */
        $extractor = new $transformerClass($configuration);

        return $extractor;
    }

    /**
     * @return LoaderInterface
     */
    private function getLoader()
    {
        $configuration = $this->getLoadConfiguration();

        $loaderClass = $configuration['class'];
        /** @var LoaderInterface $extractor */
        $extractor = new $loaderClass($configuration);

        return $extractor;
    }
}
