<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BidratingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BidratingsTable Test Case
 */
class BidratingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BidratingsTable
     */
    public $Bidratings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Bidratings',
        'app.Bidinfo',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Bidratings') ? [] : ['className' => BidratingsTable::class];
        $this->Bidratings = TableRegistry::getTableLocator()->get('Bidratings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Bidratings);

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
