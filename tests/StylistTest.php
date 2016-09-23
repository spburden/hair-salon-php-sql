<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Stylist.php";

    // ALTERNATIVE SERVER:
    //$server = 'mysql:host=localhost;dbname=hair_salon_test';
    //
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

        function test_save()
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

        

    }
        // export PATH=$PATH:./vendor/bin first and then you will only have to run  $ phpunit tests
?>
