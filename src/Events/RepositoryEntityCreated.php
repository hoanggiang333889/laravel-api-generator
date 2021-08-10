<?php

namespace Giangmv\Repository\Events;

/**
 * Class RepositoryEntityCreated
 *
 * @package Giangmv\Repository\Events
 */
class RepositoryEntityCreated extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "created";
}
