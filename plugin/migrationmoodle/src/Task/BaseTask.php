<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\PluginBundle\MigrationMoodle\Task;

use Chamilo\PluginBundle\MigrationMoodle\Interfaces\ExtractorInterface;
use Chamilo\PluginBundle\MigrationMoodle\Interfaces\LoaderInterface;
use Chamilo\PluginBundle\MigrationMoodle\Interfaces\TransformerInterface;
use Symfony\Component\Filesystem\Filesystem;

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

        $this->initMapLog();
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

    public function execute(): void
    {
        foreach ($this->extractor->extract() as $extractedData) {
            if ($this->extractor->filter($extractedData)) {
                continue;
            }

            try {
                $incomingData = $this->transformer->transform($extractedData);

                $loadedId = $this->loader->load($incomingData);

                $this->saveMapLog($extractedData['id'], $loadedId);
            } catch (\Exception $exception) {
                echo 'Error while executing transform or load for: ';
                print_r($extractedData);
                echo PHP_EOL;
                echo 'Message: '.$exception->getMessage().PHP_EOL;
            }
        }
    }

    /**
     * @throws \Exception
     */
    private function initMapLog()
    {
        $filePath = $this->getMapFilePath();
        $dirPath = dirname($filePath);

        $fileSystem = new Filesystem();
        $fileSystem->mkdir($dirPath);
        $fileSystem->touch($filePath);
    }

    /**
     * @return string
     */
    private function getMapFileName()
    {
        $name = str_replace(__NAMESPACE__.'\\', '', get_called_class());

        return  api_camel_case_to_underscore($name);
    }

    /**
     * @return string
     */
    private function getMapFilePath()
    {
        $name = $this->getMapFileName();

        $dirPath = __DIR__.'/../../map';

        return "$dirPath/$name.json";
    }

    /**
     * @param int $extractedId
     * @param int $loadedId
     */
    private function saveMapLog(int $extractedId, int $loadedId)
    {
        $filePath = $this->getMapFilePath();

        $contents = file_get_contents($filePath);
        /** @var array $mapLog */
        $mapLog = json_decode($contents, true);
        $mapLog[] = [
            'hash' => md5("$extractedId@@$loadedId"),
            'extracted' => $extractedId,
            'loaded' => $loadedId,
        ];

        $fileSystem = new Filesystem();
        $fileSystem->dumpFile($filePath, json_encode($mapLog));
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
