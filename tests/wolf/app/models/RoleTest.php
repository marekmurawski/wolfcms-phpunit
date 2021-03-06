<?php

// Make sure dependencies for the tests are loaded
require_once 'Permission.php';
require_once 'RolePermission.php';
require_once 'UserRole.php';
require_once 'Role.php';

/**
 * Test class for Role.
 * Generated by PHPUnit on 2010-10-17 at 00:00:55.
 */
class RoleTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Role
     */
    protected $object;
    protected $PDO;
    protected $driver;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Role();

        // Setup DB connection
        try {
            $PDO = new PDO(DB_DSN, DB_USER, DB_PASS);
        } catch (PDOException $error) {
            die('DB Connection failed: '.$error->getMessage());
        }
        
        $this->assertInstanceOf('PDO', $PDO);

        $this->driver = $PDO->getAttribute(PDO::ATTR_DRIVER_NAME);
        $PDO->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

        Record::connection($PDO);
        Record::getConnection()->exec("set names 'utf8'");
        $this->PDO = $PDO;

        // Setup test table(s)
        if ($this->driver === 'pgsql') {
            $this->markTestIncomplete('This test is not yet complete!');
        }
        
        if ($this->driver === 'sqlite') {
            $this->PDO->exec("CREATE TABLE permission ( 
                id INTEGER NOT NULL PRIMARY KEY, 
                name varchar(25) NOT NULL 
            )");
            $this->PDO->exec("CREATE UNIQUE INDEX permission_name ON permission (name)");

            $this->PDO->exec("CREATE TABLE role (
                id INTEGER NOT NULL PRIMARY KEY,
                name varchar(25) NOT NULL
            )");
            $this->PDO->exec("CREATE UNIQUE INDEX role_name ON role (name)");
            
            $this->PDO->exec("CREATE TABLE role_permission (
                role_id int(11) NOT NULL ,
                permission_id int(11) NOT NULL
            )");
            $this->PDO->exec("CREATE UNIQUE INDEX role_permission_role_id ON role_permission (role_id,permission_id)");
            
            $this->PDO->exec("CREATE TABLE user_role (
                user_id int(11) NOT NULL ,
                role_id int(11) NOT NULL
            )");
            $this->PDO->exec("CREATE UNIQUE INDEX user_role_user_id ON user_role (user_id,role_id)");
        }
        
        if ($this->driver === 'mysql') {
            
        $this->PDO->exec("CREATE TABLE role (
                id int(11) NOT NULL auto_increment,
                name varchar(25) NOT NULL,
                PRIMARY KEY  (id),
                UNIQUE KEY name (name)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8");

        $this->PDO->exec("CREATE TABLE ".TABLE_PREFIX."role_permission (
                role_id int(11) NOT NULL,
                permission_id int(11) NOT NULL,
                UNIQUE KEY user_id (role_id,permission_id)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8");

        $PDO->exec("CREATE TABLE ".TABLE_PREFIX."permission (
                id int(11) NOT NULL auto_increment,
                name varchar(25) NOT NULL,
                PRIMARY KEY  (id),
                UNIQUE KEY name (name)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8");

        $PDO->exec("CREATE TABLE ".TABLE_PREFIX."user_role (
                user_id int(11) NOT NULL,
                role_id int(11) NOT NULL,
                UNIQUE KEY user_id (user_id,role_id)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8");
        
        }

        // Insert test data
        $this->PDO->exec("INSERT INTO role (id, name) VALUES (1, 'administrator')");
        $this->PDO->exec("INSERT INTO role (id, name) VALUES (2, 'developer')");
        $this->PDO->exec("INSERT INTO role (id, name) VALUES (3, 'editor')");
        $this->PDO->exec("INSERT INTO role_permission (role_id, permission_id) VALUES (1, 1)");
        $this->PDO->exec("INSERT INTO permission (id, name) VALUES (1, 'administrator')");
        $this->PDO->exec("INSERT INTO permission (id, name) VALUES (2, 'developer')");
        $this->PDO->exec("INSERT INTO permission (id, name) VALUES (3, 'editor')");
        $this->PDO->exec("INSERT INTO user_role (user_id, role_id) VALUES (1, 1)");
        $this->PDO->exec("INSERT INTO user_role (user_id, role_id) VALUES (1, 2)");
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        $this->PDO->exec('DROP TABLE role');
        $this->PDO->exec('DROP TABLE role_permission');
        $this->PDO->exec('DROP TABLE permission');
        $this->PDO->exec('DROP TABLE user_role');
    }


    /**
     * @todo Implement test__toString().
     */
    public function test__toString() {
        $expected = 'a role';
        $actual = new Role();
        $actual->name = 'a role';
        $actual = $actual->__toString();
        $this->assertEquals($expected, $actual);
    }


    /**
     * @todo Implement testPermissions().
     */
    public function testPermissions() {
        // Make sure the method exists
        $this->assertTrue(method_exists('Role', 'findById'));
        $this->assertTrue(method_exists($this->object, 'permissions'));

        // Setup
        $this->object = Role::findById(1);
        $this->assertInstanceOf('Role', $this->object);
        $this->assertNotNull($this->object);

        $expected = array('administrator' => new Permission(array('id' => '1', 'name' => 'administrator')));

        // Found perms for role
        $actual = $this->object->permissions();
        $this->assertInternalType('array', $actual);
        $this->assertEquals($expected, $actual);
    }


    /**
     * 
     */
    public function testHasPermission() {
        // Make sure the method exists
        $this->assertTrue(method_exists('Role', 'findById'));
        $this->assertTrue(method_exists($this->object, 'hasPermission'));
        
        // Setup
        $this->object = Role::findById(1);
        $this->assertInstanceOf('Role', $this->object);
        $this->assertNotNull($this->object);

        $actual = $this->object->hasPermission('administrator');
        $this->assertInternalType('boolean', $actual);
        $this->assertTrue($actual);

        $actual = $this->object->hasPermission('administrator, developer');
        $this->assertInternalType('boolean', $actual);
        $this->assertTrue($actual);

        $actual = $this->object->hasPermission('administrator,developer');
        $this->assertInternalType('boolean', $actual);
        $this->assertTrue($actual);

        $actual = $this->object->hasPermission('');
        $this->assertInternalType('boolean', $actual);
        $this->assertFalse($actual);

        $actual = $this->object->hasPermission();
        $this->assertInternalType('boolean', $actual);
        $this->assertFalse($actual);
    }


    /**
     * 
     */
    public function testFindById() {
        // Make sure the method exists
        $this->assertTrue(method_exists($this->object, 'findById'));
        
        // Setup
        $expected = new Role(array('id' => 2, 'name' => 'developer'));

        // Normal use
        $actual = Role::findById(2);
        $this->assertInstanceOf('Role', $actual);
        $this->assertEquals($expected, $actual);

        // Param as string
        $actual = Role::findById('2');
        $this->assertInstanceOf('Role', $actual);
        $this->assertEquals($expected, $actual);

        // Invalid string
        $actual = Role::findById('abc');
        $this->assertInternalType('boolean', $actual);
        $this->assertNotEquals($expected, $actual);
        $this->assertFalse($actual);

        // No param
        $actual = Role::findById();
        $this->assertInternalType('boolean', $actual);
        $this->assertNotEquals($expected, $actual);
        $this->assertFalse($actual);
    }


    /**
     * @todo Implement testFindByName().
     */
    public function testFindByName() {
        // Make sure the method exists
        $this->assertTrue(method_exists($this->object, 'findByName'));
        
        // Setup
        $expected = new Role(array('id' => 2, 'name' => 'developer'));

        // Normal use
        $actual = Role::findByName('developer');
        $this->assertInstanceOf('Role', $actual);
        $this->assertEquals($expected, $actual);

        // Case test
        $actual = Role::findByName('Developer');
        
        // Note - sqlite uses case sensitive utf-8
        if ($this->driver === 'sqlite') {
            $this->assertFalse($actual);
        }
        // Note - mysql does not have case sensitive utf-8 (yet)
        else {
            $this->assertInstanceOf('Role', $actual);
            $this->assertEquals($expected, $actual);
        }

        // Empty string
        $actual = Role::findByName('');
        $this->assertInternalType('boolean', $actual);
        $this->assertFalse($actual);

        // Invalid string
        $actual = Role::findByName('doesNotExist');
        $this->assertInternalType('boolean', $actual);
        $this->assertFalse($actual);

        // No string
        $actual = Role::findByName(null);
        $this->assertInternalType('boolean', $actual);
        $this->assertFalse($actual);

        // No param
        $actual = Role::findByName();
        $this->assertInternalType('boolean', $actual);
        $this->assertFalse($actual);
    }


    /**
     * @todo Implement testFindByUserId().
     */
    public function testFindByUserId() {
        // Make sure the method exists
        $this->assertTrue(method_exists('Role', 'findByUserId'));
        
        // Setup
        $expected = array(
            new Role(array('id' => 1, 'name' => 'administrator')),
            new Role(array('id' => 2, 'name' => 'developer'))
        );
        
        $actual = Role::findByUserId(1);
        $this->assertInternalType('array', $actual);
        $this->assertEquals($expected, $actual);

        $actual = Role::findByUserId('1');
        $this->assertInternalType('array', $actual);
        $this->assertEquals($expected, $actual);

        $actual = Role::findByUserId(2300);
        $this->assertInternalType('boolean', $actual);
        $this->assertFalse($actual);

        $actual = Role::findByUserId('notValid');
        $this->assertInternalType('boolean', $actual);
        $this->assertFalse($actual);

        $actual = Role::findByUserId();
        $this->assertInternalType('boolean', $actual);
        $this->assertFalse($actual);

        $actual = Role::findByUserId(null);
        $this->assertInternalType('boolean', $actual);
        $this->assertFalse($actual);
    }


    /**
     * 
     */
    public function testGetColumns() {
        // Make sure the method exists
        $this->assertTrue(method_exists($this->object, 'getColumns'));
        
        $expected = array('id', 'name');
        $actual = $this->object->getColumns();

        $this->assertInternalType('array', $actual);
        $this->assertEquals($expected, $actual);
    }

}

?>