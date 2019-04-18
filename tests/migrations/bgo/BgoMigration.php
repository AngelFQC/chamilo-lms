<?php
/* For licensing terms, see /license.txt */

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class BgoMigration
 */
class BgoMigration
{
    /**
     * @var int
     */
    private $adminId;
    /**
     * @var string
     */
    private $oldPortalPath;

    /**
     * @var array
     */
    private $categories = [];

    /**
     * @var PDO
     */
    private $db;

    /**
     * BgoMigration constructor.
     *
     * @param int    $adminId
     * @param string $oldSiteUrl
     * @param string $oldPortalPath
     */
    public function __construct($adminId, $oldPortalPath)
    {
        $this->adminId = $adminId;
        $this->oldPortalPath = $oldPortalPath;
    }

    /**
     * @param string $host
     * @param string $name
     * @param string $user
     * @param string $password
     */
    public function connectDB($host, $name, $user, $password)
    {
        $this->db = new PDO(
            "mysql:host=$host;dbname=$name",
            $user,
            $password
        );
    }

    public function migrateCoursesCategories()
    {
        $classes = ['N' => 'Normal', 'E' => 'Especial'];

        foreach ($classes as $code => $name) {
            CourseCategory::addNode($code, $name, 'FALSE', null);
        }

        $sql = 'SELECT linea_id, linea_nombre, linea_clase FROM linea';

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (!array_key_exists($row['linea_clase'], $classes)) {
                continue;
            }

            $id = CourseCategory::addNode($row['linea_nombre'], $row['linea_nombre'], 'TRUE', $row['linea_clase']);

            if ($id) {
                $category = CourseCategory::getCategoryById($id);
                $this->categories[$row['linea_id']] = $category['code'];

                echo 'Course category created: '.$category['name'].PHP_EOL;
            }
        }
    }

    public function migrateCourses()
    {
        $stmt = $this->db->prepare('SELECT * FROM producto');
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categoryCode = $this->getCategoryFromProductLine($row['producto_id']);

            $courseInfo = CourseManager::create_course(
                [
                    'title' => $row['producto_titulo'],
                    'course_category' => $categoryCode,
                ],
                $this->adminId
            );

            if (false === $courseInfo) {
                continue;
            }

            $this->courses[$row['producto_id']] = $courseInfo['real_id'];

            echo 'Course created: '.$courseInfo['title'].PHP_EOL;

            $this->createDirectoryForImportedFiles($courseInfo);

            $this->migrateCourseDescriptions(
                [
                    1 => $row['producto_lqds'],
                    2 => $row['producto_manual'],
                    3 => $row['producto_tecvtas'],
                    4 => $row['producto_apoaca'],
                    5 => $row['producto_bencom'],
                    6 => $row['producto_precom'],
                    7 => $row['producto_infoad'],
                ],
                $courseInfo['real_id']
            );
        };
    }

    /**
     * @param int $productId
     *
     * @return array|null
     */
    private function getCategoryFromProductLine($productId)
    {
        $stmt = $this->db
            ->prepare(
                'SELECT l.linea_id FROM linea l
                INNER JOIN linea_has_producto lp ON l.linea_id = lp.linea_id
                WHERE lp.producto_id = ?'
            );
        $stmt->execute([$productId]);

        if ($stmt->rowCount() <= 0) {
            return null;
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $oldId = $row['linea_id'];

        if (!array_key_exists($oldId, $this->categories)) {
            return null;
        }

        return $this->categories[$oldId];
    }

    /**
     * @param array $courseInfo
     */
    private function createDirectoryForImportedFiles(array $courseInfo)
    {
        $sysCoursePath = api_get_path(SYS_COURSE_PATH);
        $courseDir = $courseInfo['path'].'/document';
        $baseWorkDir = $sysCoursePath.$courseDir;

        $importedDirectories = [
            '/imported' => get_lang('Imported'),
            '/imported/images' => get_lang('Images'),
            '/imported/documents' => get_lang('Documents'),
        ];

        foreach ($importedDirectories as $directory => $name) {
            create_unexisting_directory(
                $courseInfo,
                $this->adminId,
                0,
                0,
                0,
                $baseWorkDir,
                $directory,
                $name,
                0,
                false,
                false
            );
        }
    }

    /**
     * @param array $descriptions
     * @param int   $courseId
     */
    public function migrateCourseDescriptions(array $descriptions, $courseId)
    {
        $titles = [
            1 => 'Lo que debo saber',
            2 => 'Manual del Producto',
            3 => 'Técnica de Ventas',
            4 => 'Apoyo Académico',
            5 => 'Beneficios Comparativos',
            6 => 'Precios Comparativos',
            7 => 'Información Adicional',
        ];

        foreach ($descriptions as $type => $content) {
            $content = trim($content);

            if (empty($content)) {
                continue;
            }

            $content = $this->processFilesInHtml($content, $courseId);
            //$content = $this->processImagesHtml($content, $courseId);

            $description = new CourseDescription();
            $description->set_course_id($courseId);
            $description->set_session_id(0);
            $description->set_description_type($type);
            $description->set_title($titles[$type]);
            $description->set_content($content);
            $description->insert();

            echo "\tCourse description assigned: {$titles[$type]}".PHP_EOL;
        }
    }

    /**
     * @param string $html
     * @param int    $courseId
     *
     * @return mixed
     */
    private function processFilesInHtml($html, $courseId)
    {
        $courseInfo = api_get_course_info_by_id($courseId);

        $relCoursePath = api_get_path(REL_COURSE_PATH);
        $courseDir = $courseInfo['path'].'/document';

        $crawler = new Crawler($html);
        $links = $crawler->filterXPath('//a');
        $images = $crawler->filterXPath('//img');
        $elements = array_merge(iterator_to_array($links), iterator_to_array($images));

        $toReplace = [];

        /** @var DOMElement $element */
        foreach ($elements as $element) {
            $source = '';
            $uploadPath = '';

            if ('a' === strtolower($element->nodeName)) {
                $source = $element->getAttribute('href');
                $uploadPath = '/imported/documents';
            } elseif ('img' === strtolower($element->nodeName)) {
                $source = $element->getAttribute('src');
                $uploadPath = '/imported/images';
            }

            if (empty($source) || strpos($source, '/UserFilesBago/') !== 0) {
                continue;
            }

            $documentPath = $this->putFileOnCourse($source, $uploadPath, $courseInfo);

            if (false === $documentPath) {
                continue;
            }

            $toReplace[$source] = $relCoursePath.$courseDir.$documentPath;
        }

        foreach ($toReplace as $search => $replace) {
            echo "\t\tDocument created: ".$replace.PHP_EOL;

            $html = str_replace($search, $replace, $html);
        }

        return $html;
    }

    /**
     * @param string $source
     * @param string $destinationFolder
     * @param array  $courseInfo
     *
     * @return bool|string
     */
    private function putFileOnCourse($source, $destinationFolder, array $courseInfo)
    {
        $sysCachePath = api_get_path(SYS_ARCHIVE_PATH);
        $sysCoursePath = api_get_path(SYS_COURSE_PATH);
        $courseDir = $courseInfo['path'].'/document';
        $baseWorkDir = $sysCoursePath.$courseDir;

        $fileName = basename($source);
        $destination = $sysCachePath.$fileName;

        $isCopied = copy($this->oldPortalPath.$source, $destination);

        if (false === $isCopied) {
            return false;
        }

        $documentPath = handle_uploaded_document(
            $courseInfo,
            [
                'name' => $fileName,
                'tmp_name' => $destination,
                'size' => filesize($destination),
                'type' => null,
                'from_file' => true,
                'move_file' => true,
            ],
            $baseWorkDir,
            $destinationFolder,
            1,
            0,
            null,
            0,
            'overwrite',
            true
        );

        return $documentPath;
    }
}
