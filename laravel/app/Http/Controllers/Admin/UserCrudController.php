<?php
 
namespace App\Http\Controllers\Admin;
 
use Backpack\PermissionManager\app\Http\Controllers\UserCrudController 
as PM_UserCrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
 
class UserCrudController extends PM_UserCrudController
{
   public function setup()
   {
       parent::setup();
       // Add your code here
        if (!backpack_user()->hasRole('admin')) {
            CRUD::denyAccess(['list','create','read','edit','delete']);
        }



   }
}