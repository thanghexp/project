<?php
/**
 * Created by PhpStorm.
 * User: thanghepxp
 * Date: 24/06/2016
 * Time: 16:23
 */

namespace App\Test\TestCase\Controller\Admin;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

class CategorysControllerTest extends IntegrationTestCase
{
   //public $fixtures = ['app.articles'];

   public function setUp() {
      parent::setUp();
   }


   public function testAdd() {
      $this->get('/categorys/addCategory');
      $this->assertResponseOk();

      $data = ['name_category' => 'abc'];
      $this->post('users/add', $data);
      $this->assertResponseSuccess();

      $categorys = TableRegistry::get('categorys');
      $query = $users->find()->where(['username' => $data['name_category']]);
      $this->assertEquals(1, $query->count());
   }
}
