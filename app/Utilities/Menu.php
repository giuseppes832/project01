<?php
namespace app\Utilities;

use App\Models\Node;
use Illuminate\Support\Facades\Request;

class Menu
{

    public static function getCurrentMenuItem() {

        if(Request::get('menu_item')) {

            return Node::find(Request::get('menu_item'))->html->ref;

        } else {

            return null;

        }

    }

    public static  function newItem() {
        if(Request::get('new_item')) {

            return true;

        } else {

            return false;

        }
    }

    public static function getRow() {

        return Request::route('row');


    }


}

