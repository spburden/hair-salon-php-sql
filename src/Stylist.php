<?php
    class Stylist
    {
        private $id;
        private $name;

        function __construct ($id = null, $name)
        {
            $this->id = $id;
            $this->name = $name;
        }
        function getId()
        {
            return $this->id;
        }
        function getName()
        {
            return $this->name;
        }
    }
?>
