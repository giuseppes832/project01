<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\App;
use App\Models\FieldTypes\SvStringField;
use App\Models\InvitedUser;
use App\Models\Owner;
use App\Models\SvFloatField;
use App\Models\SvIntegerField;
use App\Models\User;
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
        $user->email = "test@example.com";
        $user->password = Hash::make("123");
        $user->save();

        $admin = new Admin();
        $admin->save();
        $admin->user()->save($user);


        $user2 = new User();
        $user2->name = "Giuseppe";
        $user2->email = "giuseppesaponaro41@gmail.com";
        $user2->password = Hash::make("123");
        $user2->save();

        $owner = new Owner();
        $owner->save();
        $owner->user()->save($user2);


        $user3 = new User();
        $user3->name = "Invited";
        $user3->email = "invited@example.com";
        $user3->password = Hash::make("123");
        $user3->save();

        $invitedUser = new InvitedUser();
        $invitedUser->save();
        $invitedUser->user()->save($user3);



        /*
        $resource1 = new Resource();
        $resource1->name = "Tabella1";
        $resource1->save();


        $field1 = new Field();
        $field1->name = "Campo1";
        $field1->resource_id = $resource1->id;
        $field1->save();

        $strinField1 = new StringField();
        $strinField1->save();

        $strinField1->field()->save($field1);



        $field2 = new Field();
        $field2->name = "Campo2";
        $field2->resource_id = $resource1->id;
        $field2->save();

        $integerField1 = new IntegerField();
        $integerField1->save();

        $integerField1->field()->save($field2);




        $field3 = new Field();
        $field3->name = "Campo3";
        $field3->resource_id = $resource1->id;
        $field3->save();

        $floatField1 = new FloatField();
        $floatField1->save();

        $floatField1->field()->save($field3);



        $field4 = new Field();
        $field4->name = "Campo4";
        $field4->resource_id = $resource1->id;
        $field4->save();

        $fkField = new FKField();
        $fkField->save();

        $fkField->field()->save($field4);



        $node1 = new Node();
        $node1->name = "Form1";
        $node1->save();

        $htmlForm1 = new HtmlForm();
        $htmlForm1->save();

        $htmlForm1->node()->save($node1);


        $node2 = new Node();
        $node2->name = "Input1";
        $node2->parent_id = $node1->id;
        $node2->save();

        $htmlInputText1 = new HtmlInputText();
        $htmlInputText1->binding_id = $field1->id;
        $htmlInputText1->save();

        $htmlInputText1->node()->save($node2);


        $node3 = new Node();
        $node3->name = "Input2";
        $node3->parent_id = $node1->id;
        $node3->save();

        $htmlInputText2 = new HtmlInputText();
        $htmlInputText2->binding_id = $field2->id;
        $htmlInputText2->save();

        $htmlInputText2->node()->save($node3);



        $node4 = new Node();
        $node4->name = "Input3";
        $node4->parent_id = $node1->id;
        $node4->save();

        $htmlInputText3 = new HtmlInputText();
        $htmlInputText3->binding_id = $field3->id;
        $htmlInputText3->save();

        $htmlInputText3->node()->save($node4);


        $node8 = new Node();
        $node8->name = "Sharing field";
        $node8->parent_id = $node1->id;
        $node8->save();

        $htmlSharingSelect1 = new HtmlSharingSelect();
        $htmlSharingSelect1->binding_id = $field4->id;
        $htmlSharingSelect1->save();

        $htmlSharingSelect1->node()->save($node8);


        $node7 = new Node();
        $node7->name = "List1";
        $node7->save();

        $htmlList1 = new HtmlList();
        $htmlList1->binding_id = $node1->id;
        $htmlList1->node_id1 = $node2->id;
        $htmlList1->node_id2 = $node3->id;
        $htmlList1->save();

        $htmlList1->node()->save($node7);



        $node5 = new Node();
        $node5->name = "Menu1";
        $node5->save();

        $bootstrapNavbar1 = new BootstrapNavbar();
        $bootstrapNavbar1->save();

        $bootstrapNavbar1->node()->save($node5);


        $node6 = new Node();
        $node6->name = "VoceMenu1";
        $node6->parent_id = $node5->id;
        $node6->save();

        $bootstrapNavLink1 = new BootstrapNavLink();
        $bootstrapNavLink1->label = "Form1";
        $bootstrapNavLink1->ref_id = $node7->id;
        $bootstrapNavLink1->save();

        $bootstrapNavLink1->node()->save($node6);


        $role1 = new Role();
        $role1->name = "Ruolo1";
        $role1->save();







        $resource10 = new Resource();
        $resource10->name = "Tabella2";
        $resource10->save();


        $field10 = new Field();
        $field10->name = "Campo1";
        $field10->resource_id = $resource10->id;
        $field10->save();

        $strinField10 = new StringField();
        $strinField10->save();

        $strinField10->field()->save($field10);






        $field11 = new Field();
        $field11->name = "Campo5";
        $field11->resource_id = $resource1->id;
        $field11->save();

        $strinField11 = new FKField();
        $strinField11->save();

        $strinField11->field()->save($field11);





        $node30 = new Node();
        $node30->name = "Form2";
        $node30->save();

        $htmlForm30 = new HtmlForm();
        $htmlForm30->save();

        $htmlForm30->node()->save($node30);

        $node31 = new Node();
        $node31->name = "Option field";;
        $node31->parent_id = $node30->id;
        $node31->save();

        $html30 = new HtmlInputText();
        $html30->binding_id = $field10->id;
        $html30->save();

        $html30->node()->save($node31);





        $node20 = new Node();
        $node20->name = "Select field";
        $node20->parent_id = $node1->id;
        $node20->save();

        $htmlSelect20 = new HtmlSelect();
        $htmlSelect20->binding_id = $field11->id;
        $htmlSelect20->form_binding_id = $htmlForm30->id;
        $htmlSelect20->form_field_binding_id = $node31->id;
        $htmlSelect20->save();

        $htmlSelect20->node()->save($node20);














        $node40 = new Node();
        $node40->name = "List2";
        $node40->save();

        $htmlList40 = new HtmlList();
        $htmlList40->binding_id = $htmlForm30->id;
        $htmlList40->node_id1 = $node31->id;
        $htmlList40->node_id2 = $node31->id;
        $htmlList40->save();

        $htmlList40->node()->save($node40);











        $node60 = new Node();
        $node60->name = "VoceMenu2";
        $node60->parent_id = $node5->id;
        $node60->save();

        $bootstrapNavLink60 = new BootstrapNavLink();
        $bootstrapNavLink60->label = "Form2";
        $bootstrapNavLink60->ref_id = $node40->id;
        $bootstrapNavLink60->save();

        $bootstrapNavLink60->node()->save($node60);

        */

    }
}
