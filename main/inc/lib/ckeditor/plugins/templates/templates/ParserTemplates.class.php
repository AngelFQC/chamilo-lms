<?php
/* For licensing terms, see /license.txt */
/**
 * Class for get the CKEditor templates
 * @author Angel Fernando Quiroz Campos <angel.quiroz@beeznest.com>
 */
class ParserTemplates
{

    /**
     * CSS directory
     * @var string  
     */
    private $css;
    /**
     * Image directory
     * @var string
     */
    private $img_dir;
    /**
     * Default course directory
     * @var string
     */
    private $default_course_dir;
    /**
     * JS directory
     * @var string
     */
    private $js;
    /**
     * The templates
     * @var array
     */
    private $templates;

    /**
     * Class constructor
     * @global string $js JS directory
     */
    public function __construct()
    {
        global $js;

        $this->css = self::loadCSS(api_get_setting('stylesheets'));
        $this->img_dir = api_get_path(REL_CODE_PATH) . 'img/';
        $this->default_course_dir = api_get_path(REL_CODE_PATH) . 'default_course_document/';
        $this->js = $js;

        $this->templates = array();
    }

    /**
     * Get the templates for CKEditor
     * @return array The templates
     */
    public function getTemplates()
    {
        return $this->templates;
    }

    /**
     * Loads a given css style (default.css).
     *
     * @param string $cssName the folder name of the style
     * @return html code for adding a css style <style ...
     */
    public static function loadCSS($cssName)
    {
        $templateCSS = file_get_contents(api_get_path(SYS_PATH) . 'main/css/' . $cssName . '/default.css');
        $templateCSS = str_replace('../../img/', api_get_path(REL_CODE_PATH) . 'img/', $templateCSS);
        $templateCSS = str_replace('images/', api_get_path(REL_CODE_PATH) . 'css/' . $cssName . '/images/', $templateCSS);

        // Reseting the body's background color to be in white, see Task #1885 and http://www.chamilo.org/en/node/713
        $templateCSS .= "\n" . 'body { background: #fff; } /* Resetting the background. */' . "\n";

        // Removing system-specific styles and cleaning, see task #1282.
        $regex1 = array(
            '/\/\*(.+?)\*\//sm' => '', // Removing comments.
            '/\r\n/m' => "\n", // New lines in Unix style.
            '/\r/m' => "\n"                     // New lines in Unix style.
        );
        $templateCSS = preg_replace(array_keys($regex1), $regex1, $templateCSS);
        $templateCSS = preg_replace('/behavior[^;\{\}]*;/ism', '', $templateCSS);   // Removing behavior-definition, it is IE-specific.
        $templateCSSArray = explode('}', $templateCSS);

        if (!empty($templateCSSArray)) {
            $deleters = array(
                '/.*\#.*\{[^\}]*\}/sm', // Removing css definitions bound to system secific elements (identified by id).
                '/.*\..*\{[^\}]*\}/sm', // Removing css definitions bound to classes, we assume them as system secific.
                // Removing css definitions bound to intractive types of elements that teachers most probably don't need.
                '/.*input.*\{[^\}]*\}/ism',
                '/.*textarea.*\{[^\}]*\}/ism',
                '/.*select.*\{[^\}]*\}/ism',
                '/.*form.*\{[^\}]*\}/ism',
                '/.*button.*\{[^\}]*\}/ism'
            );
            foreach ($templateCSSArray as $key => & $CSSDefinition) {
                if (trim($CSSDefinition) == '') {
                    unset($templateCSSArray[$key]);
                    continue;
                }
                $CSSDefinition = trim($CSSDefinition . '}');
                foreach ($deleters as & $deleter) {
                    if (preg_match($deleter, $CSSDefinition)) {
                        unset($templateCSSArray[$key]);
                    }
                }
            }
            $templateCSS = implode("\n\n", $templateCSSArray);
        }
        $regex2 = array(
            '/[ \t]*\n/m' => "\n", // Removing trailing whitespace.
            '/\n{3,}/m' => "\n\n"               // Removing extra empty lines.
        );
        $templateCSS = preg_replace(array_keys($regex2), $regex2, $templateCSS);

        if (trim($templateCSS) == '') {
            return '';
        }

        return "\n" . '<style type="text/css">' . "\n" . $templateCSS . "\n" . '</style>' . "\n";
    }

    /**
     * Load a empty template
     */
    public function loadEmptyTemplate()
    {
        $this->templates[] = array(
            'title' => 'Empty',
            'image' => api_get_path(WEB_PATH) . 'home/default_platform_document/template_thumb/empty.gif',
            'description' => '',
            'html' => '<p><br/></p>'
        );
    }

    /**
     * Load the platform templates as defined by the platform administrator
     * @author Patrick Cool <patrick.cool@UGent.be>, Ghent University, Belgium
     * @author Angel Fernando Quiroz Campos <angel.quiroz@beeznest.com>
     */
    public function loadPlatformTemplates()
    {
        $systemTemplateTable = Database::get_main_table(TABLE_MAIN_SYSTEM_TEMPLATE);
        $sql = "SELECT title, image, comment, content FROM $systemTemplateTable";
        $result = Database::query($sql);

        $search = array('{CSS}', '{IMG_DIR}', '{REL_PATH}', '{COURSE_DIR}', '{WEB_PATH}');
        $replace = array(
            $this->css . $this->js,
            $this->img_dir,
            api_get_path(REL_PATH),
            $this->default_course_dir, api_get_path(WEB_PATH)
        );
        $templateThumb = api_get_path(WEB_PATH) . 'home/default_platform_document/template_thumb/';

        while ($row = Database::fetch_array($result)) {
            $image = empty($row['image']) ? $templateThumb . 'empty.gif' : $templateThumb . $row['image'];
            $row['content'] = str_replace($search, $replace, $row['content']);

            $this->templates[] = array(
                'title' => $row['title'],
                'image' => $image,
                'desription' => $row['comment'],
                'html' => $row['content']
            );
        }

        $certificateTemplateThumb = api_get_path(WEB_PATH);
        $certificateTemplateThumb .= 'main/gradebook/certificate_template/certificate_template.png';
        $certificateTemplateContent = file_get_contents(
            api_get_path(SYS_PATH) . 'main/gradebook/certificate_template/template.html'
        );
        $certificateTemplateHTML = str_replace($search, $replace, $certificateTemplateContent);

        $this->templates[] = array(
            'title' => 'TemplateCertificateTitle',
            'image' => $certificateTemplateThumb,
            'description' => 'TemplateCertificateDescription',
            'html' => $certificateTemplateHTML
        );
    }

    /**
     * Load the templates for students
     */
    public function loadStudentTemplates()
    {
        $fckeditor_template_path = api_get_path(LIBRARY_PATH) . '/main/inc/lib/fckeditor/editor/dialog/fck_template/images/';

        $this->templates[] = array(
            'title' => 'Image and Title',
            'image' => api_get_path(WEB_PATH) . $fckeditor_template_path . 'template1.gif',
            'description' => 'One main image with a title and text that surround the image.',
            'html' => '<img style="MARGIN-RIGHT: 10px" height="100" alt="" width="100" align="left"/><h3>Type the title here</h3>Type the text here'
        );
        $this->templates[] = array(
            'title' => 'Strange Template',
            'image' => api_get_path(WEB_PATH) . $fckeditor_template_path . 'template2.gif',
            'description' => 'A template that defines two colums, each one with a title, and some text.',
            'html' => ''
        );
        $this->templates[] = array(
            'title' => 'Text and Table',
            'image' => api_get_path(WEB_PATH) . $fckeditor_template_path . 'template3.gif',
            'description' => 'A title with some text and a table.',
            'html' => '<div style="width: 80%"><h3>Title goes here</h3><table style="width:150px;float: right" cellspacing="0" cellpadding="0" border="1"><caption style="border:solid 1px black"><strong>Table title</strong></caption></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table><p>Type the text here</p></div>'
        );
    }

    /**
     * Load all the personal templates of the user for a course
     * @global array $_course The current course data
     * @param int $userId The user id
     * @author Patrick Cool <patrick.cool@UGent.be>, Ghent University, Belgium
     * @author Angel Fernando Quiroz Campos <angel.quiroz@beeznest.com>
     * @return void
     */
    public function loadPersonalTemplates($userId)
    {
        global $_course;

        // the templates that the user has defined are only available inside the course itself
        if (empty($_course)) {
            return;
        }

        // For which user are we getting the templates?
        if ($userId == 0) {
            $userId = api_get_user_id();
        } else {
            $userId = intval($userId);
        }

        $templatesTable = Database::get_main_table(TABLE_MAIN_TEMPLATES);
        $documentTable = Database::get_course_table(TABLE_DOCUMENT);

        $courseId = api_get_course_int_id();

        // The sql statement for getting all the user defined templates
        $sql = "SELECT template.id, template.title, template.description, template.image, template.ref_doc, document.path
            FROM " . $templatesTable . " template, " . $documentTable . " document
            WHERE
                user_id='" . Database::escape_string($userId) . "' AND
                course_code='" . Database::escape_string(api_get_course_id()) . "' AND
                document.c_id = $courseId AND
                document.id = template.ref_doc";

        $resultTemplate = Database::query($sql);

        while ($row = Database::fetch_array($resultTemplate)) {
            $row['content'] = file_get_contents(api_get_path(SYS_COURSE_PATH) . $_course['path'] . '/document' . $row['path']);
            //$row['content'] = api_get_path(SYS_COURSE_PATH).$_course['path'].'/document'.$row['path'];

            if (!empty($row['image'])) {
                $image = api_get_path(WEB_PATH) . 'courses/' . $_course['path'] . '/upload/template_thumbnails/' . $row['image'];
            } else {
                $image = api_get_path(WEB_PATH) . 'home/default_platform_document/template_thumb/noimage.gif';
            }

            $this->templates[] = array(
                'title' => $row['title'],
                'image' => $image,
                'description' => $row['description'],
                'html' => $row['content']
            );
        }
    }

}
