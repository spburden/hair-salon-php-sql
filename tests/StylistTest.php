<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ClassTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();

        }

        function test_getName()
        {
            //Arrange
            $test_Stylist = new Stylist($id = null, $name);
            $name = "Jennifer";

            //Act
            $output = $test_Stylist->getName();

            //Assert
            $this->assertEquals("Jennifer", $output);
        }

    }
        // export PATH=$PATH:./vendor/bin first and then you will only have to run  $ phpunit tests
?>
