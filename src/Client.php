<?php
    class Client
    {
        private $id;
        private $name;
        private $stylist_id;

        function __construct ($id = null, $name, $stylist_id)
        {
            $this->id = $id;
            $this->name = $name;
            $this->stylist_id = $stylist_id;
        }

        function getId()
        {
            return $this->id;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function setStylistId($new_stylist_id)
        {
            $this->stylist_id = $new_stylist_id;
        }

        function getStylistId()
        {
            return $this->stylist_id;
        }

        function save()
        {
            $name = $this->getName();
            $name = ucwords(strtolower($name));
            $stylist_id = $this->getStylistId();
            $GLOBALS['DB']->exec("INSERT INTO clients (name, stylist_id) VALUES ('{$name}', {$stylist_id});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
            $clients = array();
            foreach ($returned_clients as $client) {
                $id = $client['id'];
                $name = $client['name'];
                $stylist_id = $client['stylist_id'];
                $new_client = new Client($id, $name, $stylist_id);
                array_push($clients, $new_client);
            }
            return $clients;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients;");
        }

        static function find($search_id)
        {
            $found_client = null;
            $clients = Client::getAll();
            foreach ($clients as $client) {
                $client_id = $client->getId();
                if ($client_id == $search_id) {
                    $found_client = $client;
                }
            }
            return $found_client;
        }

        function updateClient($edit_name)
        {
            $edit_name = ucwords(strtolower($edit_name));
            $GLOBALS['DB']->exec("UPDATE clients SET name = '{$edit_name}' WHERE id = {$this->getId()};");
            $this->setName($edit_name);
        }

        function deleteClient()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients WHERE id = {$this->getId()};");
        }
    }
?>
