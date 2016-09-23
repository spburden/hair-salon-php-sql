<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    //TO RUN TESTS IN TERMINAL:
    //export PATH=$PATH:./vendor/bin
    //phpunit tests

    require_once "src/Stylist.php";

    //ALTERNATIVE SERVER:
    //$server = 'mysql:host=localhost;dbname=hair_salon_test';
    $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
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
            $test_Stylist = new Stylist($id, $new_name);

            //Act
            $output = $test_Stylist->getId();

            //Assert
            $this->assertEquals(1, $output);
        }

        function test_setAndGetName()
        {
            //Arrange
            $new_name = "Jennifer Jones";
            $id = 1;
            $test_Stylist = new Stylist($id, $new_name);
            $edit_name = "Jennifer Williams";

            //Act
            $test_Stylist->setName($edit_name);
            $output = $test_Stylist->getName();

            //Assert
            $this->assertEquals("Jennifer Williams", $output);
        }


        function test_save_toDatabase()
        {
            //Arrange
            $new_name = "Jennifer Jones";
            $test_Stylist = new Stylist($id = null, $new_name);

            //Act
            $test_Stylist->save();
            $output = Stylist::getAll();

            //Assert
            $this->assertEquals([$test_Stylist], $output);
        }

        function test_getAll()
        {
            //Arrange
            $new_name1 = "Jennifer Jones";
            $test_Stylist1 = new Stylist($id = null, $new_name1);

            $new_name2 = "Amber Hill";
            $test_Stylist2 = new Stylist($id = null, $new_name2);

            //Act
            $test_Stylist1->save();
            $test_Stylist2->save();
            $output = Stylist::getAll();

            //Assert
            $this->assertEquals([$test_Stylist1, $test_Stylist2], $output);
        }

        function test_deleteAll()
        {
            //Arrange
            $new_name1 = "Jennifer Jones";
            $test_Stylist1 = new Stylist($id = null, $new_name1);
            $test_Stylist1->save();

            $new_name2 = "Amber Hill";
            $test_Stylist2 = new Stylist($id = null, $new_name2);
            $test_Stylist2->save();

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
            $test_Stylist1 = new Stylist($id = null, $new_name1);

            $new_name2 = "Amber Hill";
            $test_Stylist2 = new Stylist($id = null, $new_name2);

            $test_Stylist1->save();
            $test_Stylist2->save();

            //Act
            $search_id = $test_Stylist1->getId();
            $output = Stylist::find($search_id);

            //Assert
            $this->assertEquals($test_Stylist1, $output);
        }

        function test_updateStylist()
        {
            //Arrange
            $new_name = "Jennifer Jones";
            $test_Stylist = new Stylist($id = null, $new_name);
            $test_Stylist->save();
            $edit_name = "Jennifer Williams";

            //Act
            $test_Stylist->updateStylist($edit_name);
            $output = $test_Stylist->getName();

            //Assert
            $this->assertEquals("Jennifer Williams", $output);
        }

        function test_deleteStylist()
        {
            //Arrange
            $new_name1 = "Jennifer Jones";
            $test_Stylist1 = new Stylist($id = null, $new_name1);
            $test_Stylist1->save();

            $new_name2 = "Amber Hill";
            $test_Stylist2 = new Stylist($id = null, $new_name2);
            $test_Stylist2->save();

            //Act
            $test_Stylist1->deleteStylist();
            $output = Stylist::getAll();

            //Assert
            $this->assertEquals([$test_Stylist2], $output);
        }

    }
?>
