<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BidsendingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BidsendingsTable Test Case
 */
class BidsendingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BidsendingsTable
     */
    public $Bidsendings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Bidsendings',
        'app.Bidinfos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Bidsendings') ? [] : ['className' => BidsendingsTable::class];
        $this->Bidsendings = TableRegistry::getTableLocator()->get('Bidsendings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Bidsendings);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
