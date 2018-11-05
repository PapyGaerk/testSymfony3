<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Projects
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="projects")
 */
class Projects
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    public $name;
    /**
     * @ORM\Column(type="string")
     */
    public $description;
    /**
     * @ORM\Column(type="string")
     */
    public $image;
}
