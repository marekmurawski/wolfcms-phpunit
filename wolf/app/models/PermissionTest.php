<?php

/**
 * Test class for Permission.
 * Generated by PHPUnit on 2010-10-17 at 13:20:10.
 */
class PermissionTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Permission
     */
    protected $object;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Permission;

        // Setup DB connection
        try {
            $PDO = new PDO(DB_DSN, DB_USER, DB_PASS);
        } catch (PDOException $error) {
            die('DB Connection failed: '.$error->getMessage());
        }

        $driver = $PDO->getAttribute(PDO::ATTR_DRIVER_NAME);
        $PDO->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

        Record::connection($PDO);
        Record::getConnection()->exec("set names 'utf8'");
        $this->PDO = $PDO;

        // Setup test table(s)
        $PDO->exec("CREATE TABLE ".TABLE_PREFIX."permission (
                id int(11) NOT NULL auto_increment,
                name varchar(25) NOT NULL,
                PRIMARY KEY  (id),
                UNIQUE KEY name (name)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8");

        // Insert test data
        $this->PDO->exec("INSERT INTO permission (id, name) VALUES (1, 'administrator')");
        $this->PDO->exec("INSERT INTO permission (id, name) VALUES (2, 'developer')");
        $this->PDO->exec("INSERT INTO permission (id, name) VALUES (3, 'editor')");
    }


    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        $this->object = null;
        $this->PDO->exec('DROP TABLE permission');
    }


    /**
     * @todo Implement testId().
     */
    public function testId() {
        // Setup
        $this->object->id = 1;
        $expected = 1;

        $actual = $this->object->id();
        $this->assertType('integer', $actual);
        $this->assertEquals($expected, $actual);
    }


    /**
     * @todo Implement testName().
     */
    public function testName() {
        // Setup
        $expected = 'Just a test';
        $this->object->name = $expected;

        $actual = $this->object->name();
        $this->assertType('string', $actual);
        $this->assertEquals($expected, $actual);
    }


    /**
     * @todo Implement test__toString().
     */
    public function test__toString() {
        // Setup
        $expected = 'Just a test';
        $this->object->name = $expected;

        $actual = $this->object->__toString();
        $this->assertType('string', $actual);
        $this->assertEquals($expected, $actual);
    }


    /**
     * @todo Implement testGetPermissions().
     */
    public function testGetPermissions() {
        $expected = array(new Permission(array('id' => 1, 'name' => 'administrator')),
                          new Permission(array('id' => 2, 'name' => 'developer')),
                          new Permission(array('id' => 3, 'name' => 'editor')),
                    );

        $actual = $this->object->findAllFrom('Permission');
        $this->assertType('array', $actual);
        $this->assertEquals($expected, $actual);

        $actual = $this->object->getPermissions();
        $this->assertType('array', $actual);
        $this->assertEquals($expected, $actual);
    }


    /**
     * @todo Implement testBeforeSave().
     */
    public function testBeforeSave() {
        $this->assertTrue($this->object->beforeSave());
    }


    /**
     * @todo Implement testFindById().
     */
    public function testFindById() {
        $expected = new Permission(array('id' => 1, 'name' => 'administrator'));

        // Normal
        $actual = $this->object->findById(1);
        $this->assertType('Permission', $actual);
        $this->assertEquals($expected, $actual);

        // Normal but string
        $actual = $this->object->findById('1');
        $this->assertType('Permission', $actual);
        $this->assertEquals($expected, $actual);

        // Non existent perm
        $actual = $this->object->findById(2300);
        $this->assertType('boolean', $actual);
        $this->assertFalse($actual);

        // Garbage string
        $actual = $this->object->findById('just garbadge');
        $this->assertType('boolean', $actual);
        $this->assertFalse($actual);

        // No params
        $actual = $this->object->findById();
        $this->assertType('boolean', $actual);
        $this->assertFalse($actual);
    }


    /**
     * @todo Implement testFindByName().
     */
    public function testFindByName() {
        $expected = new Permission(array('id' => 1, 'name' => 'administrator'));

        // Normal
        $actual = $this->object->findByName('administrator');
        $this->assertType('Permission', $actual);
        $this->assertEquals($expected, $actual);

        // Empty string
        $actual = $this->object->findByName('');
        $this->assertType('boolean', $actual);
        $this->assertFalse($actual);

        // Non existent perm
        $actual = $this->object->findByName('nonexistant');
        $this->assertType('boolean', $actual);
        $this->assertFalse($actual);

        // Another type
        $actual = $this->object->findByName(2300);
        $this->assertType('boolean', $actual);
        $this->assertFalse($actual);

        // Null param
        $actual = $this->object->findByName(null);
        $this->assertType('boolean', $actual);
        $this->assertFalse($actual);

        // No params
        $actual = $this->object->findByName();
        $this->assertType('boolean', $actual);
        $this->assertFalse($actual);
    }


    /**
     * @todo Implement testGetColumns().
     */
    public function testGetColumns() {
        $expected = array('id', 'name');
        $actual = $this->object->getColumns();

        $this->assertType('array', $actual);
        $this->assertTrue(count($actual) == count($expected));
        $this->assertEquals($expected, $actual);
    }

}

?>
