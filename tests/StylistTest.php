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

    class ClassTest extends PHPUnit_Framework_TestCase
    {
        // protected function tearDown()
        // {
        //     Stylist::deleteAll();
        //
        // }

        function test_save()
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

    }
        // export PATH=$PATH:./vendor/bin first and then you will only have to run  $ phpunit tests
?>
