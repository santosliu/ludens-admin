<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UnpublishGameRequest; // 假設存在此 Request
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UnpublishGameCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UnpublishGameCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\UnpublishGame::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/unpublish-game');
        CRUD::setEntityNameStrings('unpublish game', 'unpublish games');

        // 禁用 ShowOperation，因為目前沒有特別設定其欄位
        $this->crud->denyAccess('show');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        $this->crud->setDefaultPageLength(100);
        
        CRUD::addColumn([
            'name'  => 'game_name',
            'label' => '遊戲名稱',
            'type'  => 'text',
        ]);

        CRUD::addColumn([
            'name'  => 'game_type',
            'label' => '遊戲類型',
            'type'  => 'text',
        ]);

        CRUD::addColumn([
            'name'  => 'game_company',
            'label' => '遊戲公司',
            'type'  => 'text',
        ]);

        CRUD::addColumn([
            'name'  => 'launch_date',
            'label' => '發行日期',
            'type'  => 'text',
        ]);

        CRUD::setOperationSetting('pageLength', 25);
        CRUD::setOperationSetting('lengthMenu', [[10, 25, 50], [10, 25, 50]]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(UnpublishGameRequest::class); // 假設存在此 Request

        CRUD::addField([
            'name'  => 'game_name',
            'label' => '遊戲名稱',
            'type'  => 'text',
        ]);

        CRUD::addField([
            'name'  => 'game_type',
            'label' => '遊戲類型',
            'type'  => 'text',
        ]);

        CRUD::addField([
            'name'  => 'game_company',
            'label' => '遊戲公司',
            'type'  => 'text',
        ]);

        CRUD::addField([
            'name'  => 'launch_date',
            'label' => '發行日期',
            'type'  => 'date', // 假設為日期類型
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
