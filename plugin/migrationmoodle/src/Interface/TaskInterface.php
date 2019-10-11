<?php
/* For licensing terms, see /license.txt */

/**
 * Interface TaskInterface.
 */
interface TaskInterface
{
    /**
     * Allow execute the ETL task.
     */
    public function execute(): void;
}
