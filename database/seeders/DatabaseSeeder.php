<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\App;
use App\Models\Field;
use App\Models\FieldTypes\FKField;
use App\Models\FieldTypes\StringField;
use App\Models\FieldTypes\SvStringField;
use App\Models\FieldTypes\TextField;
use App\Models\InvitedUser;
use App\Models\Node;
use App\Models\Nodes\BootstrapNavbar;
use App\Models\Nodes\BootstrapNavLink;
use App\Models\Nodes\HtmlForm;
use App\Models\Nodes\HtmlInputText;
use App\Models\Nodes\HtmlList;
use App\Models\Nodes\HtmlSelect;
use App\Models\Nodes\HtmlTextarea;
use App\Models\Nodes\SublistButton;
use App\Models\Owner;
use App\Models\Resource;
use App\Models\SvFloatField;
use App\Models\SvIntegerField;
use App\Models\User;
use App\View\Components\Nodes\Navbar;
use App\View\Components\Nodes\NavLink;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        */

        $user = new User();
        $user->name = "Admin";
        $user->email = "admin@example.com";
        $user->password = Hash::make("123");
        $user->save();

        $admin = new Admin();
        $admin->save();
        $admin->user()->save($user);


        $user2 = new User();
        $user2->name = "Owner";
        $user2->email = "owner@example.com";
        $user2->password = Hash::make("123");
        $user2->save();

        $owner = new Owner();
        $owner->save();
        $owner->user()->save($user2);


        $user3 = new User();
        $user3->name = "User1";
        $user3->email = "user1@example.com";
        $user3->password = Hash::make("123");
        $user3->save();

        $invitedUser = new InvitedUser();
        $invitedUser->save();
        $invitedUser->user()->save($user3);



        $user4 = new User();
        $user4->name = "User2";
        $user4->email = "user2@example.com";
        $user4->password = Hash::make("123");
        $user4->save();

        $invitedUser2 = new InvitedUser();
        $invitedUser2->save();
        $invitedUser2->user()->save($user4);

        /*

        $nodeMenu = new Node();
        $nodeMenu->name = "Menu";
        $nodeMenu->label = "Menu";
        $nodeMenu->save();
        $navbarMenu = new BootstrapNavbar();
        $navbarMenu->save();
        $navbarMenu->node()->save($nodeMenu);



        $resourcePropertyName = new Resource();
        $resourcePropertyName->name = "ResourcePropertyName";
        $resourcePropertyName->save();

        $fieldProprietyNameName = new Field();
        $fieldProprietyNameName->resource_id = $resourcePropertyName->id;
        $fieldProprietyNameName->name = "FieldPropertyNameName";
        $fieldProprietyNameName->required = true;
        $fieldProprietyNameName->unique = true;
        $fieldProprietyNameName->save();
        $stringFieldPropertyNameName = new StringField();
        $stringFieldPropertyNameName->save();
        $stringFieldPropertyNameName->field()->save($fieldProprietyNameName);

        $fieldProprietyNameDesc = new Field();
        $fieldProprietyNameDesc->resource_id = $resourcePropertyName->id;
        $fieldProprietyNameDesc->name = "FieldPropertyNameDesc";
        $fieldProprietyNameDesc->save();
        $textPropertyNameDesc = new TextField();
        $textPropertyNameDesc->save();
        $textPropertyNameDesc->field()->save($fieldProprietyNameDesc);

        $nodePropertyName = new Node();
        $nodePropertyName->name = "NodePropertyName";
        $nodePropertyName->label = "Property name form";
        $nodePropertyName->save();
        $formPropertyName = new HtmlForm();
        $formPropertyName->save();
        $formPropertyName->node()->save($nodePropertyName);

        $nodePropertyNameName = new Node();
        $nodePropertyNameName->name = "NodePropertyNameName";
        $nodePropertyNameName->label = "Property name";
        $nodePropertyNameName->parent_id = $nodePropertyName->id;
        $nodePropertyNameName->save();
        $inputPropertyNameName = new HtmlInputText();
        $inputPropertyNameName->binding_id = $fieldProprietyNameName->id;
        $inputPropertyNameName->save();
        $inputPropertyNameName->node()->save($nodePropertyNameName);

        $nodePropertyNameDesc = new Node();
        $nodePropertyNameDesc->name = "NodePropertyNameDesc";
        $nodePropertyNameDesc->label = "Property name description";
        $nodePropertyNameDesc->parent_id = $nodePropertyName->id;
        $nodePropertyNameDesc->save();
        $textareaPropertyNameDesc = new HtmlTextarea();
        $textareaPropertyNameDesc->binding_id = $fieldProprietyNameDesc->id;
        $textareaPropertyNameDesc->save();
        $textareaPropertyNameDesc->node()->save($nodePropertyNameDesc);

        $nodeListPropertyName = new Node();
        $nodeListPropertyName->name = "NodeListPropertyName";
        $nodeListPropertyName->label = "List of property name";
        $nodeListPropertyName->save();
        $listPropertyName = new HtmlList();
        $listPropertyName->binding_id = $formPropertyName->id;
        $listPropertyName->node_id1 = $nodePropertyNameName->id;
        $listPropertyName->node_id2 = $nodePropertyNameDesc->id;
        $listPropertyName->save();
        $listPropertyName->node()->save($nodeListPropertyName);

        $nodeMenuItemPropertyName = new Node();
        $nodeMenuItemPropertyName->name = "NodeMenuItemPropertyName";
        $nodeMenuItemPropertyName->label = "List of property name";
        $nodeMenuItemPropertyName->parent_id = $nodeMenu->id;
        $nodeMenuItemPropertyName->save();
        $menuItemPropertyName = new BootstrapNavLink();
        $menuItemPropertyName->label = "List of property name";
        $menuItemPropertyName->ref_id = $nodeListPropertyName->id;
        $menuItemPropertyName->save();
        $menuItemPropertyName->node()->save($nodeMenuItemPropertyName);






        $resourcePropriety = new Resource();
        $resourcePropriety->name = "ResourceProperty";
        $resourcePropriety->save();

        $fieldProperty = new Field();
        $fieldProperty->resource_id = $resourcePropriety->id;
        $fieldProperty->name = "FieldProperty";
        $fieldProperty->required = true;
        $fieldProperty->unique = true;
        $fieldProperty->save();
        $stringFieldProperty = new StringField();
        $stringFieldProperty->save();
        $stringFieldProperty->field()->save($fieldProperty);

        $fieldPropertyDesc = new Field();
        $fieldPropertyDesc->resource_id = $resourcePropriety->id;
        $fieldPropertyDesc->name = "FieldPropertyDesc";
        $fieldPropertyDesc->save();
        $textPropertyDesc = new TextField();
        $textPropertyDesc->save();
        $textPropertyDesc->field()->save($fieldPropertyDesc);

        $fieldPropertyName = new Field();
        $fieldPropertyName->resource_id = $resourcePropriety->id;
        $fieldPropertyName->name = "FieldPropertyName";
        $fieldPropertyName->required = true;
        $fieldPropertyName->save();
        $fkFieldPropertyName = new FKField();
        $fkFieldPropertyName->save();
        $fkFieldPropertyName->field()->save($fieldPropertyName);

        $nodeProperty = new Node();
        $nodeProperty->name = "NodeProperty";
        $nodeProperty->label = "Property form";
        $nodeProperty->save();
        $formProperty = new HtmlForm();
        $formProperty->save();
        $formProperty->node()->save($nodeProperty);

        $nodeProperty1 = new Node();
        $nodeProperty1->name = "NodeProperty1";
        $nodeProperty1->label = "Property";
        $nodeProperty1->parent_id = $nodeProperty->id;
        $nodeProperty1->save();
        $inputProperty1 = new HtmlInputText();
        $inputProperty1->binding_id = $fieldProperty->id;
        $inputProperty1->save();
        $inputProperty1->node()->save($nodeProperty1);

        $nodePropertyDesc = new Node();
        $nodePropertyDesc->name = "NodePropertyDesc";
        $nodePropertyDesc->label = "Property description";
        $nodePropertyDesc->parent_id = $nodeProperty->id;
        $nodePropertyDesc->save();
        $textareaPropertyDesc = new HtmlTextarea();
        $textareaPropertyDesc->binding_id = $fieldPropertyDesc->id;
        $textareaPropertyDesc->save();
        $textareaPropertyDesc->node()->save($nodePropertyDesc);

        $nodePropertyNameS = new Node();
        $nodePropertyNameS->name = "NodePropertyNameS";
        $nodePropertyNameS->label = "Property name";
        $nodePropertyNameS->parent_id = $nodeProperty->id;
        $nodePropertyNameS->save();
        $selectPropertyName = new HtmlSelect();
        $selectPropertyName->binding_id = $fieldPropertyName->id;
        $selectPropertyName->form_binding_id = $formPropertyName->id;
        $selectPropertyName->form_field_binding_id = $nodePropertyNameName->id;
        $selectPropertyName->save();
        $selectPropertyName->node()->save($nodePropertyNameS);

        $nodeListProperty = new Node();
        $nodeListProperty->name = "NodeListProperty";
        $nodeListProperty->label = "List of property";
        $nodeListProperty->save();
        $listProperty = new HtmlList();
        $listProperty->binding_id = $formProperty->id;
        $listProperty->node_id1 = $nodeProperty1->id;
        $listProperty->node_id2 = $nodePropertyDesc->id;
        $listProperty->save();
        $listProperty->node()->save($nodeListProperty);

        $nodeMenuItemProperty = new Node();
        $nodeMenuItemProperty->name = "NodeMenuItemProperty";
        $nodeMenuItemProperty->label = "List of property";
        $nodeMenuItemProperty->parent_id = $nodeMenu->id;
        $nodeMenuItemProperty->save();
        $menuItemProperty = new BootstrapNavLink();
        $menuItemProperty->label = "List of property";
        $menuItemProperty->ref_id = $nodeListProperty->id;
        $menuItemProperty->save();
        $menuItemProperty->node()->save($nodeMenuItemProperty);




        $resourceItem = new Resource();
        $resourceItem->name = "ResourceItem";
        $resourceItem->save();

        $fieldItemName = new Field();
        $fieldItemName->resource_id = $resourceItem->id;
        $fieldItemName->name = "FieldItemName";
        $fieldItemName->required = true;
        $fieldItemName->unique = true;
        $fieldItemName->save();
        $stringFieldItemName = new StringField();
        $stringFieldItemName->save();
        $stringFieldItemName->field()->save($fieldItemName);

        $fieldItemDesc = new Field();
        $fieldItemDesc->resource_id = $resourceItem->id;
        $fieldItemDesc->name = "FieldItemDesc";
        $fieldItemDesc->save();
        $textItemDesc = new TextField();
        $textItemDesc->save();
        $textItemDesc->field()->save($fieldItemDesc);

        $nodeItem = new Node();
        $nodeItem->name = "NodeItem";
        $nodeItem->label = "Item form";
        $nodeItem->save();
        $formItem = new HtmlForm();
        $formItem->save();
        $formItem->node()->save($nodeItem);

        $nodeItemName = new Node();
        $nodeItemName->name = "NodeItemName";
        $nodeItemName->label = "Item name";
        $nodeItemName->parent_id = $nodeItem->id;
        $nodeItemName->save();
        $inputItemName = new HtmlInputText();
        $inputItemName->binding_id = $fieldItemName->id;
        $inputItemName->save();
        $inputItemName->node()->save($nodeItemName);

        $nodeItemDesc = new Node();
        $nodeItemDesc->name = "NodeItemDesc";
        $nodeItemDesc->label = "Item description";
        $nodeItemDesc->parent_id = $nodeItem->id;
        $nodeItemDesc->save();
        $textareaItemDesc = new HtmlTextarea();
        $textareaItemDesc->binding_id = $fieldItemDesc->id;
        $textareaItemDesc->save();
        $textareaItemDesc->node()->save($nodeItemDesc);

        $nodeListItem = new Node();
        $nodeListItem->name = "NodeListItem";
        $nodeListItem->label = "List of item";
        $nodeListItem->save();
        $listItem = new HtmlList();
        $listItem->binding_id = $formItem->id;
        $listItem->node_id1 = $nodeItemName->id;
        $listItem->node_id2 = $nodeItemDesc->id;
        $listItem->save();
        $listItem->node()->save($nodeListItem);

        $nodeMenuItemItem = new Node();
        $nodeMenuItemItem->name = "NodeMenuItemItem";
        $nodeMenuItemItem->label = "List of item";
        $nodeMenuItemItem->parent_id = $nodeMenu->id;
        $nodeMenuItemItem->save();
        $menuItemItem = new BootstrapNavLink();
        $menuItemItem->label = "List of item";
        $menuItemItem->ref_id = $nodeListItem->id;
        $menuItemItem->save();
        $menuItemItem->node()->save($nodeMenuItemItem);




        $resourceItemPropriety = new Resource();
        $resourceItemPropriety->name = "ResourceItemProperty";
        $resourceItemPropriety->save();

        $fieldItem = new Field();
        $fieldItem->resource_id = $resourceItemPropriety->id;
        $fieldItem->name = "FieldItem";
        $fieldItem->required = true;
        $fieldItem->save();
        $fkFieldItem = new FKField();
        $fkFieldItem->save();
        $fkFieldItem->field()->save($fieldItem);

        $fieldProperty = new Field();
        $fieldProperty->resource_id = $resourceItemPropriety->id;
        $fieldProperty->name = "FieldProperty";
        $fieldProperty->required = true;
        $fieldProperty->save();
        $fkFieldProperty = new FKField();
        $fkFieldProperty->save();
        $fkFieldProperty->field()->save($fieldProperty);

        $nodeItemProperty = new Node();
        $nodeItemProperty->name = "NodeItemProperty";
        $nodeItemProperty->label = "Item Property form";
        $nodeItemProperty->save();
        $formItemProperty = new HtmlForm();
        $formItemProperty->save();
        $formItemProperty->node()->save($nodeItemProperty);

        $nodeItemS = new Node();
        $nodeItemS->name = "NodeItemS";
        $nodeItemS->label = "Item";
        $nodeItemS->parent_id = $nodeItemProperty->id;
        $nodeItemS->save();
        $selectItem = new HtmlSelect();
        $selectItem->binding_id = $fieldItem->id;
        $selectItem->form_binding_id = $formItem->id;
        $selectItem->form_field_binding_id = $nodeItemName->id;
        $selectItem->save();
        $selectItem->node()->save($nodeItemS);

        $nodePropertyS = new Node();
        $nodePropertyS->name = "NodePropertyS";
        $nodePropertyS->label = "Property";
        $nodePropertyS->parent_id = $nodeItemProperty->id;
        $nodePropertyS->save();
        $selectProperty = new HtmlSelect();
        $selectProperty->binding_id = $fieldProperty->id;
        $selectProperty->form_binding_id = $formProperty->id;
        $selectProperty->form_field_binding_id = $nodeProperty1->id;
        $selectProperty->save();
        $selectProperty->node()->save($nodePropertyS);

        $nodeListItemProperty = new Node();
        $nodeListItemProperty->name = "NodeListItemProperty";
        $nodeListItemProperty->label = "List of item property";
        $nodeListItemProperty->save();
        $listItemProperty = new HtmlList();
        $listItemProperty->binding_id = $formItemProperty->id;
        $listItemProperty->node_id1 = $nodeItemS->id;
        $listItemProperty->node_id2 = $nodePropertyS->id;
        $listItemProperty->save();
        $listItemProperty->node()->save($nodeListItemProperty);

        $nodeMenuItemItemProperty = new Node();
        $nodeMenuItemItemProperty->name = "NodeMenuItemItemProperty";
        $nodeMenuItemItemProperty->label = "List of item property";
        $nodeMenuItemItemProperty->parent_id = $nodeMenu->id;
        $nodeMenuItemItemProperty->save();
        $menuItemItemProperty = new BootstrapNavLink();
        $menuItemItemProperty->label = "List of item property";
        $menuItemItemProperty->ref_id = $nodeListItemProperty->id;
        $menuItemItemProperty->save();
        $menuItemItemProperty->node()->save($nodeMenuItemItemProperty);










        $nodeSublistProperty = new Node();
        $nodeSublistProperty->name = "NodeSublistProperty";
        $nodeSublistProperty->label = "List of property";
        $nodeSublistProperty->parent_id = $nodeListPropertyName->id;
        $nodeSublistProperty->save();
        $sublistProperty = new SublistButton();
        $sublistProperty->list_binding_id = $listProperty->id;
        $sublistProperty->save();
        $sublistProperty->node()->save($nodeSublistProperty);

        $listProperty->default_filter_binding_id = $nodePropertyNameS->id;
        $listProperty->save();


        $nodeSublistItemProperty = new Node();
        $nodeSublistItemProperty->name = "NodeSublistItemProperty";
        $nodeSublistItemProperty->label = "List of item property";
        $nodeSublistItemProperty->parent_id = $nodeListItem->id;
        $nodeSublistItemProperty->save();
        $sublistItemProperty = new SublistButton();
        $sublistItemProperty->list_binding_id = $listItemProperty->id;
        $sublistItemProperty->save();
        $sublistItemProperty->node()->save($nodeSublistItemProperty);

        $listItemProperty->default_filter_binding_id = $nodeItemS->id;
        $listItemProperty->save();


        */



    }
}
