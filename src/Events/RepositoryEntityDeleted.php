<?php

namespace Giangmv\Repository\Events;

/**
 * Class RepositoryEntityDeleted
 *
 * @package Giangmv\Repository\Events
 */
class RepositoryEntityDeleted extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "deleted";
}
