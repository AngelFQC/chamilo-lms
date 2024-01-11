<?php

/* For licensing terms, see /license.txt */

declare(strict_types=1);

namespace Chamilo\CoreBundle\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Chamilo\CoreBundle\ApiResource\CourseTool;
use Chamilo\CoreBundle\Tool\ToolChain;
use Chamilo\CourseBundle\Entity\CTool;

class CourseToolDataTranformer implements DataTransformerInterface
{

    public function __construct(
        protected readonly ToolChain $toolChain
    ) {
    }

    /**
     * @inheritDoc
     */
    public function transform($object, string $to, array $context = [])
    {
        assert($object instanceof CTool);

        $courseTool = new CourseTool();
        $courseTool->iid = $object->getIid();
        $courseTool->name = $object->getName();
        $courseTool->visibility = $object->getVisibility();
        $courseTool->tool = $this->toolChain->getToolFromName(
            $object->getTool()->getName()
        );
        $courseTool->resourceNode = $object->resourceNode;

        return $courseTool;
    }

    /**
     * @inheritDoc
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return $data instanceof CTool && $to === CourseTool::class;
    }
}
