<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    //TO RUN TESTS IN TERMINAL:
    //export PATH=$PATH:./vendor/bin
    //phpunit tests

    require_once "src/Client.php";

    //ALTERNATIVE SERVER:
    //$server = 'mysql:host=localhost;dbname=hair_salon_test';
    $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ClientTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Client::deleteAll();
        }

        function test_save_toDatabase()
        {
            //Arrange
            $new_name = "Joe Dirt";
            $stylist_id = 3;
            $test_Client = new Client($id = null, $new_name, $stylist_id);

            //Act
            $test_Client->save();
            $output = Client::getAll();

            //Assert
            $this->assertEquals([$test_Client], $output);
        }

        function test_getAll()
        {
            //Arrange
            $new_name1 = "Joe Dirt";
            $stylist_id1 = 3;
            $test_Client1 = new Client($id = null, $new_name1, $stylist_id1);
            $test_Client1->save();

            $new_name2 = "Bill Smith";
            $stylist_id2 = 1;
            $test_Client2 = new Client($id = null, $new_name2, $stylist_id2);
            $test_Client2->save();

            //Act
            $output = Client::getAll();

            //Assert
            $this->assertEquals([$test_Client1, $test_Client2], $output);
        }

        function test_deleteAll()
        {
            //Arrange
            $new_name1 = "Joe Dirt";
            $stylist_id1 = 3;
            $test_Client1 = new Client($id = null, $new_name1, $stylist_id1);
            $test_Client1->save();

            $new_name2 = "Bill Smith";
            $stylist_id2 = 1;
            $test_Client2 = new Client($id = null, $new_name2, $stylist_id2);
            $test_Client2->save();

            //Act
            Client::deleteAll();
            $output = Client::getAll();

            //Assert
            $this->assertEquals([], $output);
        }

        function test_find()
        {
            //Arrange
            $new_name1 = "Joe Dirt";
            $stylist_id1 = 3;
            $test_Client1 = new Client($id = null, $new_name1, $stylist_id1);
            $test_Client1->save();

            $new_name2 = "Bill Smith";
            $stylist_id2 = 1;
            $test_Client2 = new Client($id = null, $new_name2, $stylist_id2);
            $test_Client2->save();

            //Act
            $search_id = $test_Client1->getId();
            $output = Stylist::find($search_id);

            //Assert
            $this->assertEquals($test_Stylist1, $output);
        }

        function test_updateClient()
        {
            //Arrange
            $new_name = "Jennifer Lopez";
            $stylist_id = 3;
            $test_Client = new Client($id = null, $new_name, $stylist_id);
            $test_Client->save();
            $edit_name = "Jennifer Dirt";

            //Act
            $test_Client->updateClient($edit_name);
            $output = $test_Client->getName();

            //Assert
            $this->assertEquals("Jennifer Dirt", $output);
        }

        function test_deleteClient()
        {
            //Arrange
            $new_name1 = "James Jones";
            $stylist_id1 = 3;
            $test_Client1 = new Client($id = null, $new_name1, $stylist_id1);
            $test_Client1->save();

            $new_name2 = "Amber Hill";
            $stylist_id2 = 3;
            $test_Client2 = new Client($id = null, $new_name2, $stylist_id2);
            $test_Client2->save();

            //Act
            $test_Client1->deleteClient();
            $output = Client::getAll();

            //Assert
            $this->assertEquals([$test_Client2], $output);
        }

    }
?>
