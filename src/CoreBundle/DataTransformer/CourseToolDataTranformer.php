<?php

/* For licensing terms, see /license.txt */

declare(strict_types=1);

namespace Chamilo\CoreBundle\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Chamilo\CoreBundle\ApiResource\CourseTool;
use Chamilo\CoreBundle\Entity\Course;
use Chamilo\CoreBundle\Entity\Session;
use Chamilo\CoreBundle\Entity\Tool;
use Chamilo\CoreBundle\Tool\AbstractTool;
use Chamilo\CoreBundle\Tool\ToolChain;
use Chamilo\CoreBundle\Traits\ControllerTrait;
use Chamilo\CoreBundle\Traits\CourseControllerTrait;
use Chamilo\CourseBundle\Entity\CGroup;
use Chamilo\CourseBundle\Entity\CTool;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CourseToolDataTranformer implements DataTransformerInterface
{
    use ControllerTrait;
    use CourseControllerTrait;

    public function __construct(
        protected readonly ToolChain $toolChain,
        protected readonly ContainerInterface $appContainer,
    ) {
        $this->container = $this->appContainer;
    }

    /**
     * @inheritDoc
     */
    public function transform($object, string $to, array $context = [])
    {
        assert($object instanceof CTool);

        $tool = $object->getTool();

        $toolModel = $this->toolChain->getToolFromName(
            $tool->getName()
        );

        $course = $this->setCourseFromSessionHandler();

        $cTool = new CourseTool();
        $cTool->iid = $object->getIid();
        $cTool->name = $object->getName();
        $cTool->visibility = $object->getVisibility();
        $cTool->tool = $toolModel;
        $cTool->resourceNode = $object->resourceNode;
        $cTool->illustrationUrl = $object->illustrationUrl;
        $cTool->url = $this->generateToolUrl($toolModel, $course);
        $cTool->category = $toolModel->getCategory();

        return $cTool;
    }

    private function generateToolUrl(AbstractTool $tool, Course $course): string
    {
        $link = $tool->getLink();

        if (strpos($link, 'nodeId')) {
            $nodeId = (string) $course->getResourceNode()->getId();
            $link = str_replace(':nodeId', $nodeId, $link);
        }

        return $link.'?'.$this->getCourseUrlQuery();
    }

    /**
     * @inheritDoc
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return $data instanceof CTool && $to === CourseTool::class;
    }
}
