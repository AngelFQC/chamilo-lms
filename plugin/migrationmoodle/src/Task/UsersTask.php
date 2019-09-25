<?php
/* For licensing terms, see /license.txt */

/**
 * Class UsersTask.
 */
class UsersTask extends BaseTask
{
    public function __construct()
    {
        $extractor = new UsersExtractor();
        $transformer = new UsersTransformer();
        $loader = new UsersLoader();

        parent::__construct($extractor, $transformer, $loader);
    }
}
