<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Field;
use App\Models\Invite;
use App\Models\Node;
use App\Models\OwnerApp;
use App\Models\Row;
use App\Models\Value;
use App\Models\ValueTypes\FloatValue;
use App\Models\ValueTypes\IntegerValue;
use App\Models\ValueTypes\StringValue;
use App\Rules\MyUnique;
use App\Utilities\CommonService;
use App\Utilities\FieldTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utilities\Permission;
use App\Models\RegisteredUserApp;
use Illuminate\Support\Facades\Cookie;
use App\Models\Sharing;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Type\Integer;
use function Illuminate\Foundation\Console\redirectPath;

class RowController extends Controller
{


    private function validator() {

        $rules = [];

        foreach (request()->nodes as $nodeId => $fieldValue) {

            $node = Node::find($nodeId);
            $genericType = $node->html->binding;
            $type = $node->html->binding->withType;

            if ($genericType->required) {
                $rules["nodes.$nodeId"][] = "required";
            } else {
                $rules["nodes.$nodeId"][] = "nullable";
            }

            if ($genericType->unique) {
                $rules["nodes.$nodeId"][] = new MyUnique();
            }

            if (StringValue::class === $type->getValueClass()) {
                $rules["nodes.$nodeId"][] = "string";
                $rules["nodes.$nodeId"][] = "max:250";
            } elseif (IntegerValue::class === $type->getValueClass()) {
                $rules["nodes.$nodeId"][] = "integer";
                $rules["nodes.$nodeId"][] = "digits_between:0,999999999";
            } elseif (FloatValue::class === $type->getValueClass()) {
                $rules["nodes.$nodeId"][] = "decimal:2";
            }



        }

        $validator = Validator::make(request()->all(), $rules);

        return $validator;

    }

    public function store(Node $node, CommonService $commonService) {

        if (Auth::user()->canCreate($node)) {

            if ($this->validator()->fails()) {
                return redirect("/render/$node->id")
                    ->withErrors($this->validator())
                    ->withInput();
            }

            $row = new Row;

            $row->form_id = $node->html->id;

            $row->save();



            foreach (request()->nodes as $nodeId => $fieldValue) {

                $node0 = Node::find($nodeId);

                if (is_array($fieldValue)) {

                    if (Auth::user()->canCreate($node0)) {

                        foreach ($fieldValue as $fv) {

                            $value = new Value();
                            $value->row_id = $row->id;
                            $value->field_id = $node0->html->binding->id;
                            $value->save();

                            $valueWithValue = new ($node0->html->binding->withType->getValueClass());
                            if (method_exists($node0->html, "transformInput")) {
                                $valueWithValue->value = $node0->html->transformInput($fv);
                            } else {
                                $valueWithValue->value = $fv;
                            }
                            $valueWithValue->save();

                            $valueWithValue->value()->save($value);

                        }
                    }

                } else {
                    $node0 = Node::find($nodeId);

                    $value = new Value();
                    $value->row_id = $row->id;
                    $value->field_id = $node0->html->binding->id;
                    $value->save();

                    $valueWithValue = new ($node0->html->binding->withType->getValueClass());
                    if (method_exists($node0->html, "transformInput")) {
                        $valueWithValue->value = $node0->html->transformInput($fieldValue);
                    } else {

                        $valueWithValue->value = $fieldValue;
                    }
                    $valueWithValue->save();

                    $valueWithValue->value()->save($value);
                }
            }

            return redirect("/rows/$row->id");

        }

    }

    public function edit(Row $row) {

        $component = $row->form->node->getSelectedNodeRenderComponent();

        $node = $row->form->node;

        if (request()->ajax()) {

            return view("components.ajax-component", [
                "component" => $component,
                "selectedNode" => $node
            ]);

        }

    }


    public function update(Row $row) {

        if (Auth::user()->canUpdate($row->form->node)) {

            if ($this->validator()->fails()) {
                return redirect("/rows/$row->id")
                    ->withErrors($this->validator())
                    ->withInput();
            }

            foreach (request()->nodes as $nodeId => $fieldValue) {

                $node0 = Node::find($nodeId);

                if (is_array($fieldValue)) {

                    if (Auth::user()->canUpdate($node0)) {

                        $values = $node0->html->binding->values($row)->get();

                        foreach ($values as $value) {
                            if (!in_array($value->withValue->value, $fieldValue)) {
                                $value->delete();
                            }
                        }


                        $valuesWithValue = [];
                        foreach ($values as $v) {
                            $valuesWithValue[] = $v->withValue->value;
                        }


                        foreach ($fieldValue as $fv) {

                            if (!in_array($fv, $valuesWithValue)) {
                                $value = new Value();
                                $value->row_id = $row->id;
                                $value->field_id = $node0->html->binding->id;
                                $value->save();

                                $valueWithValue = new ($node0->html->binding->withType->getValueClass());
                                if (method_exists($node0->html, "transformInput")) {
                                    $valueWithValue->value = $node0->html->transformInput($fv);
                                } else {
                                    $valueWithValue->value = $fv;
                                }
                                $valueWithValue->save();

                                $valueWithValue->value()->save($value);
                            }

                        }

                    }

                } else {

                    $value = $node0->html->binding->values($row)->first();
                    if (Auth::user()->canUpdate($node0)) {
                        if (method_exists($node0->html, "transformInput")) {
                            $value->withValue->value = $node0->html->transformInput($fieldValue);
                        } else {
                            $value->withValue->value = $fieldValue;
                        }
                    }
                    $value->withValue->save();

                }

            }

            return redirect("/rows/$row->id");

        }

    }

    public function delete(Row $row) {

        if (Auth::user()->canDelete($row->form->node)) {
            $row->delete();
        }

        //return redirect("/nodes/$node->id");

    }
}
