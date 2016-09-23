<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    //TO RUN TESTS IN TERMINAL:
    //export PATH=$PATH:./vendor/bin
    //phpunit tests

    require_once "src/Stylist.php";
    require_once "src/Client.php";

    //ALTERNATIVE SERVER:
    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    // $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StylistTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $new_name = "Jennifer Jones";
            $id = 1;
            $test_stylist = new Stylist($id, $new_name);

            //Act
            $output = $test_stylist->getId();

            //Assert
            $this->assertEquals(1, $output);
        }

        function test_setAndGetName()
        {
            //Arrange
            $new_name = "Jennifer Jones";
            $id = 1;
            $test_stylist = new Stylist($id, $new_name);
            $edit_name = "Jennifer Williams";

            //Act
            $test_stylist->setName($edit_name);
            $output = $test_stylist->getName();

            //Assert
            $this->assertEquals("Jennifer Williams", $output);
        }

        function test_save_toDatabase()
        {
            //Arrange
            $new_name = "Jennifer Jones";
            $test_stylist = new Stylist($id = null, $new_name);

            //Act
            $test_stylist->save();
            $output = Stylist::getAll();

            //Assert
            $this->assertEquals([$test_stylist], $output);
        }

        function test_getAll()
        {
            //Arrange
            $new_name1 = "Jennifer Jones";
            $test_stylist1 = new Stylist($id = null, $new_name1);

            $new_name2 = "Amber Hill";
            $test_stylist2 = new Stylist($id = null, $new_name2);

            //Act
            $test_stylist1->save();
            $test_stylist2->save();
            $output = Stylist::getAll();

            //Assert
            $this->assertEquals([$test_stylist1, $test_stylist2], $output);
        }

        function test_deleteAll()
        {
            //Arrange
            $new_name1 = "Jennifer Jones";
            $test_stylist1 = new Stylist($id = null, $new_name1);
            $test_stylist1->save();

            $new_name2 = "Amber Hill";
            $test_stylist2 = new Stylist($id = null, $new_name2);
            $test_stylist2->save();

            //Act
            Stylist::deleteAll();
            $output = Stylist::getAll();

            //Assert
            $this->assertEquals([], $output);
        }

        function test_find()
        {
            //Arrange
            $new_name1 = "Jennifer Jones";
            $test_stylist1 = new Stylist($id = null, $new_name1);

            $new_name2 = "Amber Hill";
            $test_stylist2 = new Stylist($id = null, $new_name2);

            $test_stylist1->save();
            $test_stylist2->save();

            //Act
            $search_id = $test_stylist1->getId();
            $output = Stylist::find($search_id);

            //Assert
            $this->assertEquals($test_stylist1, $output);
        }

        function test_updateStylist()
        {
            //Arrange
            $new_name = "Jennifer Jones";
            $test_stylist = new Stylist($id = null, $new_name);
            $test_stylist->save();
            $edit_name = "Jennifer Williams";

            //Act
            $test_stylist->updateStylist($edit_name);
            $output = $test_stylist->getName();

            //Assert
            $this->assertEquals("Jennifer Williams", $output);
        }

        function test_deleteStylist()
        {
            //Arrange
            $new_name1 = "Jennifer Jones";
            $test_stylist1 = new Stylist($id = null, $new_name1);
            $test_stylist1->save();

            $new_name2 = "Amber Hill";
            $test_stylist2 = new Stylist($id = null, $new_name2);
            $test_stylist2->save();

            //Act
            $test_stylist1->deleteStylist();
            $output = Stylist::getAll();

            //Assert
            $this->assertEquals([$test_stylist2], $output);
        }

        function test_findClients()
        {
            //Arrange
            $new_name1 = "Jennifer Jones";
            $test_stylist1 = new Stylist($id = null, $new_name1);
            $test_stylist1->save();

            $new_name2 = "Amber Hill";
            $test_stylist2 = new Stylist($id = null, $new_name2);
            $test_stylist2->save();

            $new_name1 = "James Jones";
            $stylist_id1 = $test_stylist1->getId();
            $test_client1 = new Client($id = null, $new_name1, $stylist_id1);
            $test_client1->save();

            $new_name2 = "Amber Hill";
            $stylist_id2 = $test_stylist2->getId();
            $test_client2 = new Client($id = null, $new_name2, $stylist_id2);
            $test_client2->save();


            //Act
            $output = $test_stylist1->findClients();

            //Assert
            $this->assertEquals([$test_client1], $output);
        }
    }
?>
