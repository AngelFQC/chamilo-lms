<?php
/* For licensing terms, see /license.txt */

/**
 * Class BaseTask.
 */
abstract class BaseTask implements TaskInterface
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
     *
     * @param ExtractorInterface   $extractor
     * @param TransformerInterface $transformer
     * @param LoaderInterface      $loader
     */
    public function __construct(
        ExtractorInterface $extractor,
        TransformerInterface $transformer,
        LoaderInterface $loader
    ) {
        $this->extractor = $extractor;
        $this->transformer = $transformer;
        $this->loader = $loader;
    }

    /**
     * @throws Exception
     */
    public function execute(): void
    {
        foreach ($this->extractFiltered() as $sourceRow) {
            $incomingRow = $this->transform($sourceRow);

            $this->load($incomingRow);
        }
    }

    /**
     * @throws Exception
     *
     * @return iterable
     */
    protected function extractFiltered(): iterable
    {
        foreach ($this->extractor->extract() as $extracted) {
            if ($this->extractor->filter($extracted)) {
                continue;
            }

            yield $extracted;
        }
    }

    /**
     * @param array $sourceRow
     *
     * @return mixed
     */
    /**
     * @param array $sourceRow
     *
     * @return mixed
     */
    protected function transform(array $sourceRow)
    {
        return $this->transformer->transform($sourceRow);
    }

    /**
     * @param array $incomingRow
     */
    protected function load(array $incomingRow)
    {
        return $this->loader->load($incomingRow);
    }
}
