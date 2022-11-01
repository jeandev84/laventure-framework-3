<?php
namespace Laventure\Component\Database\ORM\Mapper\Manager\Event;

/**
 * Event names
*/
class Event
{
    const PrePersist = 'prePersist';
    const PreUpdate  = 'preUpdate';
    const PreRemove  = 'preRemove';
}