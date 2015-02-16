<?php

namespace ChrKo\Bundles\SepaBundle\Traits;

use Doctrine\ORM\Mapping as ORM;

trait EntityId
{
    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }
}