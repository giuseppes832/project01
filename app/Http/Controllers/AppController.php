<?php

namespace App\Http\Controllers;


use App\Mail\OwnerInvite;
use App\Models\Field;
use App\Models\FieldTypes\StringField;
use App\Models\Node;
use App\Models\Nodes\BootstrapNavbar;
use App\Models\Nodes\BootstrapNavLink;
use App\Models\Nodes\HtmlForm;
use App\Models\Nodes\HtmlInputText;
use App\Models\Nodes\HtmlList;
use App\Models\Owner;
use App\Models\Resource;
use App\Models\Row;
use App\Models\Sharing;
use App\Models\User;
use App\Utilities\FieldTypes;
use Brick\Math\Exception\MathException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AppController extends Controller
{
    public function adminApp() {

        $owner = User::query()->whereHasMorph("loggable", [Owner::class])->first();

        return view("components.apps.apps", [
            "owner" => $owner
        ]);
    }

    public function ownerApp() {

        $bootstrapNavbar = BootstrapNavbar::query()->first();

        $node = null;
        if ($bootstrapNavbar) {
           $node =  $bootstrapNavbar->node;
        }

        return view("components.apps.invites", [
            "node" => $node
        ]);
    }

    public function sendOwnerInvite() {

        request()->validate([
            "email" => "required|string|max:250"
        ]);

        DB::transaction(function() {

            $user = User::query()->whereHasMorph("loggable", [Owner::class])->first();

            $passsword = "temporanea" . 1000000 - random_int(1, 100000);
            if (!$user) {
                $user = new User();
                $user->name = request()->email;
                $user->email = request()->email;

                $user->password = Hash::make($passsword);
                $user->save();

                $owner = new Owner();
                $owner->save();
                $owner->user()->save($user);
            } else {

                $user->name = request()->email;
                $user->email = request()->email;

                $user->password = Hash::make($passsword);
                $user->save();

            }

            Mail::to(request()->email)->send(new OwnerInvite($passsword));

            Log::info('Admin send invite to Owner with a temporary password.', ['email' => request()->email]);

        });

        return redirect("/apps/app");
    }

    public function exportData() {

        $allRows = HtmlForm::query()->with(["node", "resource.rows", "resource.rows.values", "resource.rows.values.field", "resource.rows.values.field.withType", "resource.rows.values.withValue"])->orderBy("id")->get();

        $allUsers = User::all();

        $allSharings = Sharing::query()->with(["sharingType"])->get();

        echo "<pre>" . $allRows->toJson(JSON_PRETTY_PRINT) . "</pre>";

        echo "<pre>" . $allUsers->toJson(JSON_PRETTY_PRINT) . "</pre>";

        echo "<pre>" . $allSharings->toJson(JSON_PRETTY_PRINT) . "</pre>";

    }

    public function storeApp() {


        DB::transaction(function () {

            $menuName = request()->menu_name . "-" . uniqid();

            $nodeMenu = new Node();
            $nodeMenu->name = "Menu$menuName";
            $nodeMenu->label = "$menuName";
            $nodeMenu->save();
            $navbarMenu = new BootstrapNavbar();
            $navbarMenu->save();
            $navbarMenu->node()->save($nodeMenu);

            $resources = [];
            $forms = [];
            $lists = [];
            $nodes = [];

            foreach (request()->except(["_token"]) as $inputName => $input) {

                $inputNameTags = explode("-", $inputName);

                if (count($inputNameTags) === 3) {

                    $resource = new Resource();
                    $resource->name = "Resource$menuName$input";
                    $resource->save();
                    $resources[$inputName] = $resource;

                    $nodeForm = new Node();
                    $nodeForm->name = "Form$menuName$input";
                    $nodeForm->label = "$input form";
                    $nodeForm->save();
                    $form = new HtmlForm();
                    $form->resource_id = $resource->id;
                    $form->save();
                    $form->node()->save($nodeForm);
                    $forms[$inputName] = $nodeForm;

                    $nodeList = new Node();
                    $nodeList->name = "List$menuName$input";
                    $nodeList->label = "List of $input";
                    $nodeList->save();
                    $list = new HtmlList();
                    $list->binding_id = $form->id;
                    $list->save();
                    $list->node()->save($nodeList);
                    $lists[$inputName] = $list;

                    $nodeMenuItem = new Node();
                    $nodeMenuItem->name = "MenuItem$menuName$input";
                    $nodeMenuItem->label = "List of $input";
                    $nodeMenuItem->parent_id = $nodeMenu->id;
                    $nodeMenuItem->save();
                    $menuItem = new BootstrapNavLink();
                    $menuItem->label = "List of $input";
                    $menuItem->ref_id = $nodeList->id;
                    $menuItem->save();
                    $menuItem->node()->save($nodeMenuItem);

                } else if (count($inputNameTags) === 4) {

                    $resourceName = $inputNameTags[0] . "-" . $inputNameTags[1] . "-" . $inputNameTags[2];
                    $fieldName = $inputNameTags[0] . "-" . $inputNameTags[1] . "-" . $inputNameTags[2] . "-" . $inputNameTags[3];

                    $field = new Field();
                    $field->resource_id = $resources[$resourceName]->id;
                    $field->name = "Field$input";
                    $field->required = (request()->get($fieldName . "-required") === "on")?true:false;
                    $field->unique = (request()->get($fieldName . "-unique") === "on")?true:false;
                    $field->save();

                    $fieldClass = null;
                    $type = request()->get($fieldName . "-type");
                    if ($type) {
                        if (isset(FieldTypes::getValues()[$type]["class"])) {
                            $fieldClass = FieldTypes::getValues()[$type]["class"];
                        }
                    }

                    if ($fieldClass) {
                        $newFieldOfType = new $fieldClass;
                        $newFieldOfType->save();
                        $newFieldOfType->field()->save($field);
                    }

                    $node = new Node();
                    $node->name = "Node$input";
                    $node->label = $input;
                    $node->parent_id = $forms[$resourceName]->id;
                    $node->save();
                    $nodes[$resourceName][] = $node;

                    $defaultHtmlComponent = null;
                    $type = request()->get($fieldName . "-type");
                    if ($type) {
                        if (isset(FieldTypes::getValues()[$type]["default-html-component"])) {
                            $defaultHtmlComponent = FieldTypes::getValues()[$type]["default-html-component"];
                        }
                    }

                    if ($defaultHtmlComponent) {

                        $newDefaultHtmlComponent = new $defaultHtmlComponent;
                        $newDefaultHtmlComponent->binding_id = $field->id;
                        $newDefaultHtmlComponent->save();
                        $newDefaultHtmlComponent->node()->save($node);
                    }

                    $ref = $type = request()->get($fieldName . "-ref");
                    if ($ref) {
                        $newDefaultHtmlComponent->form_binding_id = $forms[$ref]->html->id;
                        $newDefaultHtmlComponent->form_field_binding_id = $nodes[$ref][0]->id;
                        $newDefaultHtmlComponent->save();
                    }


                }

            }


            foreach ($lists as $listName => $list) {

                if (isset($nodes[$listName][0])) {
                    $list->node_id1 = $nodes[$listName][0]->id;
                }

                if (isset($nodes[$listName][1])) {
                    $list->node_id2 = $nodes[$listName][1]->id;
                }

                $list->save();

            }

        });

        return redirect("/apps/app");



    }

}
