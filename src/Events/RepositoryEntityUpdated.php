<?php

namespace Giangmv\Repository\Events;

/**
 * Class RepositoryEntityUpdated
 *
 * @package Giangmv\Repository\Events
 */
class RepositoryEntityUpdated extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "updated";
}
