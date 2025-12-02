<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Node;
use App\Models\Nodes\HtmlSelect;
use App\Models\Nodes\HtmlSharingSelect;
use App\Models\OwnerApp;
use App\Models\RegisteredUserApp;
use App\Models\Row;
use App\Models\Value;
use App\Models\ValueTypes\FKValue;
use App\Models\ValueTypes\FloatValue;
use App\Models\ValueTypes\IntegerValue;
use App\Models\ValueTypes\StringValue;
use App\Rules\MyExists;
use App\Rules\MyExists2;
use App\Rules\MyUnique;
use App\Utilities\CommonService;
use App\Utilities\Permission;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use function Illuminate\Foundation\Console\redirectPath;

class RowController extends Controller
{


    private function validator() {

        $rules = [];

        foreach (request()->nodes as $nodeId => $fieldValue) {

            $node = Node::find($nodeId);

            if ($node->html && $node->html->binding && $node->html->binding->withType) {

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


                if (Auth::user()->isInvitedUser()) {
                    if (
                        (HtmlSelect::class === $node->html_type && $node->html->subselect) ||
                        (HtmlSharingSelect::class === $node->html_type)
                    ) {
                        // Integrity Constraint
                        $rules["nodes.$nodeId"][] = "required";

                        $rules["nodes.$nodeId"][] = new MyExists();
                    }
                }


                if (Auth::user()->isInvitedUser()) {
                    if (HtmlSelect::class === $node->html_type && $node->html->auth_filtered) {
                        $rules["nodes.$nodeId"][] = new MyExists2();
                    }
                }

            }



        }

        $validator = Validator::make(request()->all(), $rules);

        return $validator;

    }

    private function storeMultipleValue(bool $auth, array $fieldValue, Row $row, Node $node0) {

        if ($auth && $node0->html && $node0->html->binding && $node0->html->binding->withType) {

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

    }

    private function storeSingleValue(bool $auth, mixed $fieldValue, Row $row , Node $node0) {

        if ($node0->html && $node0->html->binding && $node0->html->binding->withType) {

            $value = new Value();
            $value->row_id = $row->id;
            $value->field_id = $node0->html->binding->id;
            $value->save();

            $valueWithValue = new ($node0->html->binding->withType->getValueClass());
            if ($auth) {
                if (method_exists($node0->html, "transformInput")) {
                    $valueWithValue->value = $node0->html->transformInput($fieldValue);
                } else {

                    $valueWithValue->value = $fieldValue;
                }
                if (request()->hasFile("nodes.$node0->id")) {
                    $fieldValue->storeAs($valueWithValue->value, $fieldValue->getClientOriginalName());
                }
            }
            $valueWithValue->save();

            $valueWithValue->value()->save($value);

        }

    }


    private function updateMultipleValue(bool $auth, array $fieldValue, Row $row , Node $node0) {

        if ($auth && $node0->html && $node0->html->binding && $node0->html->binding->withType) {

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

    }


    private function updateSingleValue(bool $authUpdate, bool $authStore, mixed $fieldValue, Row $row , Node $node0) {

        if ($node0->html && $node0->html->binding && $node0->html->binding->withType) {

            $value = $node0->html->binding->values($row)->first();

            if ($value) {

                if ($authUpdate) {
                    if (request()->hasFile("nodes.$node0->id")) {
                        Storage::deleteDirectory($value->withValue->value);
                    }
                    if (method_exists($node0->html, "transformInput")) {
                        $value->withValue->value = $node0->html->transformInput($fieldValue);
                    } else {
                        $value->withValue->value = $fieldValue;
                    }
                    if (request()->hasFile("nodes.$node0->id")) {
                        $fieldValue->storeAs($value->withValue->value, $fieldValue->getClientOriginalName());
                    }
                }
                $value->withValue->save();
            } else {

                $value = new Value();
                $value->row_id = $row->id;
                $value->field_id = $node0->html->binding->id;
                $value->save();

                $valueWithValue = new ($node0->html->binding->withType->getValueClass());
                if ($authStore) {
                    if (method_exists($node0->html, "transformInput")) {
                        $valueWithValue->value = $node0->html->transformInput($fieldValue);
                    } else {

                        $valueWithValue->value = $fieldValue;
                    }
                    if (request()->hasFile("nodes.$node0->id")) {
                        $fieldValue->storeAs($valueWithValue->value, $fieldValue->getClientOriginalName());
                    }
                }
                $valueWithValue->save();

                $valueWithValue->value()->save($value);
            }

        }

    }



    public function store(Node $node) {

        if (Auth::user()->canCreate($node)) {

            if ($this->validator()->fails()) {

                $qs = \request()->getQueryString();
                $append = $qs?"?$qs":"";

                return redirect("/render/$node->id$append")
                    ->withErrors($this->validator())
                    ->withInput();

            }

            $row = DB::transaction(function() use ($node) {

                $row = new Row;

                $row->form_id = $node->html->id;

                $row->save();

                foreach (request()->nodes as $nodeId => $fieldValue) {

                    $node0 = Node::find($nodeId);
                    $auth = Auth::user()->canCreate($node0);

                    if (is_array($fieldValue)) {
                        $this->storeMultipleValue($auth, $fieldValue, $row, $node0);
                    } else {
                        $this->storeSingleValue($auth, $fieldValue, $row, $node0);
                    }

                }

                return $row;

            });

            $qs = \request()->getQueryString();
            $append = $qs?"?$qs":"";

            return redirect("/rows/$row->id$append");

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

                $qs = \request()->getQueryString();
                $append = $qs?"?$qs":"";

                return redirect("/rows/$row->id$append")
                    ->withErrors($this->validator())
                    ->withInput();
            }

            DB::transaction(function () use ($row) {

                foreach (request()->nodes as $nodeId => $fieldValue) {

                    $node0 = Node::find($nodeId);
                    $auth = Auth::user()->canUpdate($node0);
                    $authStore = Auth::user()->canCreate($node0);

                    if (is_array($fieldValue)) {

                        $this->updateMultipleValue($auth, $fieldValue, $row, $node0);

                    } else {

                        // Authorization Check
                        if (Auth::user()->isInvitedUser()) {
                            if (
                                (HtmlSelect::class === $node0->html_type && $node0->html->subselect) ||
                                (HtmlSharingSelect::class === $node0->html_type)
                            ) {

                                $rows = $row->form->filteredRows($fieldValue, null);
                                if (!in_array($fieldValue, $rows->pluck("id")->toArray())) {
                                    abort(403);
                                }
                            }
                        }

                        $this->updateSingleValue($auth, $authStore, $fieldValue, $row, $node0);

                    }

                }

            });

            $qs = \request()->getQueryString();
            $append = $qs?"?$qs":"";

            return redirect("/rows/$row->id$append");

        }

    }

    public function delete(Row $row) {

        if (Auth::user()->canDelete($row->form->node)) {

            $subselectsCount = HtmlSelect::query()
                ->where("subselect", true)
                ->whereHas("binding", function($query) use ($row) {
                    $query->whereHas("allValues", function ($query) use ($row) {
                        $query->whereHasMorph("withValue", [FKValue::class], function ($query) use ($row) {
                            $query->where("value", $row->id);
                        });
                    });
                })->count();

            if ($subselectsCount === 0) {

                DB::transaction(function () use($row) {
                    foreach ($row->values as $value) {
                        if (Storage::directoryExists($value->withValue->value)) {
                            Storage::deleteDirectory($value->withValue->value);
                        }
                        $value->withValue->delete();
                        $value->delete();
                    }
                    $row->delete();
                });


            } else {
                abort(403, "Non puoi effettuare la cancellazione");
            }


        }

        //return redirect("/nodes/$node->id");

    }
}
