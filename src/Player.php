<?php
    class Player
    {
      private $id;
      private $first_name;
      private $last_name;
      private $position;


      function __construct($first_name, $last_name, $position, $id = null)
      {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->position = $position;
      }

      function getId()
      {
        return $this->id;
      }

      function getFirstName()
      {
        return $this->first_name;
      }

      function setFirstName($name)
      {
        $this->first_name = $name;
      }

      function getLastName()
      {
        return $this->last_name;
      }

      function setLastName($name)
      {
        $this->last_name = $name;
      }

      function getPosition()
      {
        return $this->position;
      }

      function setPosition($position)
      {
        $this->position = $position;
      }
    }
?>
