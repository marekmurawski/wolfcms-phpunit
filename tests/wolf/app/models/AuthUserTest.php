<?php

require_once 'AuthUser.php';

/**
 * Test class for AuthUser.
 * Generated by PHPUnit on 2013-09-29 at 22:46:17.
 */
class AuthUserTest extends PHPUnit_Framework_TestCase {

    /**
     * @var AuthUser
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        //$this->object = new AuthUser();
        
        //$this->assertInstanceOf('AuthUser', $this->object);

        // Setup DB connection
        try {
            $PDO = new PDO(DB_DSN, DB_USER, DB_PASS);
            
            
        } catch (PDOException $error) {
            die('DB Connection failed: '.$error->getMessage());
        }

        $this->assertInstanceOf('PDO', $PDO);

        $PDO->getAttribute(PDO::ATTR_DRIVER_NAME);
        $PDO->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

        Record::connection($PDO);
        Record::getConnection()->exec("set names 'utf8'");
        $this->PDO = $PDO;

        // Setup test table(s)
        $this->PDO->exec("CREATE TABLE role (
                id int(11) NOT NULL auto_increment,
                name varchar(25) NOT NULL,
                PRIMARY KEY  (id),
                UNIQUE KEY name (name)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8");

        $this->PDO->exec("CREATE TABLE role_permission (
                role_id int(11) NOT NULL,
                permission_id int(11) NOT NULL,
                UNIQUE KEY user_id (role_id,permission_id)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8");

        $this->PDO->exec("CREATE TABLE permission (
                id int(11) NOT NULL auto_increment,
                name varchar(25) NOT NULL,
                PRIMARY KEY  (id),
                UNIQUE KEY name (name)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8");

        $this->PDO->exec("CREATE TABLE user_role (
                user_id int(11) NOT NULL,
                role_id int(11) NOT NULL,
                UNIQUE KEY user_id (user_id,role_id)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8");

        // Insert test data
        $this->PDO->exec("INSERT INTO role (id, name) VALUES (1, 'administrator')");
        $this->PDO->exec("INSERT INTO role (id, name) VALUES (2, 'developer')");
        $this->PDO->exec("INSERT INTO role (id, name) VALUES (3, 'editor')");
        $this->PDO->exec("INSERT INTO role_permission (role_id, permission_id) VALUES (1, 1)");
        $this->PDO->exec("INSERT INTO permission (id, name) VALUES (1, 'administrator')");
        $this->PDO->exec("INSERT INTO permission (id, name) VALUES (2, 'developer')");
        $this->PDO->exec("INSERT INTO permission (id, name) VALUES (3, 'editor')");
        $this->PDO->exec("INSERT INTO user_role (user_id, role_id) VALUES (1, 1)");
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
     * @covers AuthUser::load
     * @todo Implement testLoad().
     */
    public function testLoad() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers AuthUser::isLoggedIn
     * @todo Implement testIsLoggedIn().
     */
    public function testIsLoggedIn() {
        // Make sure the method exists
        $this->assertTrue(method_exists('AuthUser', 'isLoggedIn'));
        
        $this->assertFalse(AuthUser::isLoggedIn());
    }

    /**
     * @covers AuthUser::getRecord
     * @todo Implement testGetRecord().
     */
    public function testGetRecord() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers AuthUser::getId
     * @todo Implement testGetId().
     */
    public function testGetId() {
        // Make sure the method exists
        $this->assertTrue(method_exists('AuthUser', 'getId'));
        
        $this->assertFalse(AuthUser::getId());
    }

    /**
     * @covers AuthUser::getUserName
     * @todo Implement testGetUserName().
     */
    public function testGetUserName() {
        // Make sure the method exists
        $this->assertTrue(method_exists('AuthUser', 'getUserName'));
        
        $this->assertFalse(AuthUser::getUserName());
    }

    /**
     * @covers AuthUser::getPermissions
     */
    public function testGetPermissions() {
        // Make sure the method exists
        $this->assertTrue(method_exists('AuthUser', 'getPermissions'));
        
        $expected = array();
        $actual = AuthUser::getPermissions();

        $this->assertInternalType('array', $actual);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers AuthUser::hasPermission
     * @todo Implement testHasPermission().
     */
    public function testHasPermission() {
        // Make sure the method exists
        $this->assertTrue(method_exists('AuthUser', 'hasPermission'));
        
        $actual = AuthUser::hasPermission('view_admin');
        $this->assertInternalType('boolean', $actual);
        $this->assertFalse($actual);

        $actual = AuthUser::hasPermission('');
        $this->assertInternalType('boolean', $actual);
        $this->assertFalse($actual);

        $actual = AuthUser::hasPermission();
        $this->assertInternalType('boolean', $actual);
        $this->assertFalse($actual);

        $actual = AuthUser::hasPermission(null);
        $this->assertInternalType('boolean', $actual);
        $this->assertFalse($actual);
    }

    /**
     * @covers AuthUser::hasRole
     * @todo Implement testHasRole().
     */
    public function testHasRole() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers AuthUser::forceLogin
     * @todo Implement testForceLogin().
     */
    public function testForceLogin() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers AuthUser::login
     * @todo Implement testLogin().
     */
    public function testLogin() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers AuthUser::logout
     * @todo Implement testLogout().
     */
    public function testLogout() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers AuthUser::generateSalt
     * @todo Implement testGenerateSalt().
     */
    public function testGenerateSalt() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers AuthUser::generateHashedPassword
     * @todo Implement testGenerateHashedPassword().
     */
    public function testGenerateHashedPassword() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers AuthUser::validatePassword
     * @todo Implement testValidatePassword().
     */
    public function testValidatePassword() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}

?>
