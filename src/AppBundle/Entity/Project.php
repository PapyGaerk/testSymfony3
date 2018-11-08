<?php

    namespace AppBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * Project
     *
     * @ORM\Table(name="projects")
     * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjectRepository")
     */
    class Project {
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
         * @ORM\Column(name="description", type="string", length=2550)
         */
        private $description;

        /**
         * @var string
         *
         * @ORM\Column(name="image", type="text")
         */
        private $image;

        /**
         * @var string
         *
         * @ORM\Column(name="categorie", type="string", length=255)
         */
        private $categorie;


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
         * @return Project
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
         * Set description
         *
         * @param string $description
         *
         * @return Project
         */
        public function setDescription($description) {
            $this->description = $description;

            return $this;
        }

        /**
         * Get description
         *
         * @return string
         */
        public function getDescription() {
            return $this->description;
        }

        /**
         * Set image
         *
         * @param string $image
         *
         * @return Project
         */
        public function setImage($image) {
            $this->image = $image;

            return $this;
        }

        /**
         * Get image
         *
         * @return string
         */
        public function getImage() {
            return $this->image;
        }

        /**
         * Set categorie
         *
         * @param string $categorie
         *
         * @return Project
         */
        public function setCategorie($categorie) {
            $this->categorie = $categorie;

            return $this;
        }

        /**
         * Get categorie
         *
         * @return string
         */
        public function getCategorie() {
            return $this->categorie;
        }
    }

