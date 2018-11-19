<?php

    namespace AppBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * Categorie
     *
     * @ORM\Table(name="categorie")
     * @ORM\Entity(repositoryClass="AppBundle\Repository\CategorieRepository")
     */
    class Categorie {
        /**
         * @var int
         *
         * @ORM\Column(name="id", type="integer")
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        private $id;

        /**
         * @var string
         *
         * @ORM\Column(name="name", type="string", length=255)
         */
        private $name;

        /**
         * @var string
         *
         * @ORM\Column(name="slug", type="string", length=255)
         */
        private $slug;


        /**
         * Get id
         *
         * @return int
         */
        public function getId() {
            return $this->id;
        }

        /**
         * Set name
         *
         * @param string $name
         *
         * @return Categorie
         */
        public function setName($name) {
            $this->name = $name;

            return $this;
        }

        /**
         * Get name
         *
         * @return string
         */
        public function getName() {
            return $this->name;
        }

        /**
         * Set slug
         *
         * @param string $slug
         *
         * @return Categorie
         */
        public function setSlug($slug) {
            $this->slug = $slug;

            return $this;
        }

        /**
         * Get slug
         *
         * @return string
         */
        public function getSlug() {
            return $this->slug;
        }

        public function __toString() {
            return $this->slug;
        }
    }
