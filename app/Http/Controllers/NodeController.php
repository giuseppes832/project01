<?php

namespace App\Http\Controllers;


use App\Models\Node;
use App\Models\Resource;
use App\Utilities\CommonService;
use App\Utilities\HtmlNodeTypes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;

class NodeController extends Controller
{


    public function index() {

        $resources = Resource::all();

        $nodes = Node::query()->whereNull("parent_id")->get();

        return view("components.nodes.nodes", [
            "nodes" => $nodes,
            "resources" => $resources
        ]);

    }

    public function store() {

        request()->validate([
            "name" => "required|string|max:250|unique:nodes,name"
        ]);

        $node = new Node;
        $node->name = request()->name;
        $node->save();

        return redirect("/nodes");

    }






    public  function edit(Node $node) {

        $resources = Resource::all();

        $nodes = Node::query()->whereNull("parent_id")->get();

        return view("components.nodes.nodes", [
            "nodes" => $nodes,
            "selectedNode" => $node,
            "resources" => $resources
        ]);

    }

    public  function update(Node $node) {

        request()->validate([
            "name" => "required|string|max:250|unique:nodes,name,$node->id",
            "label" => "nullable|string|max:250"
        ]);

        DB::transaction(function() use ($node) {

            $node->name = request()->name;
            $node->label = request()->label;
            $node->save();

            if (request()->has("html_type") && request()->html_type) {
                $node->changeHtmlType(HtmlNodeTypes::getValues()[request()->html_type]["class"]);
            }

        });

        return redirect("/nodes/$node->id");

    }

    public  function updateInputText(Node $node) {

        $node->html->binding_id = request()->binding;
        $node->html->save();

        return redirect("/nodes/$node->id");

    }


    public  function updateNavLink(Node $node) {

        $node->html->label = request()->label;
        $node->html->ref_id = request()->ref;
        $node->html->save();

        return redirect("/nodes/$node->id");

    }

    public  function updateHtmlList(Node $node) {

        $node->html->binding_id = request()->binding;
        $node->html->node_id1 = request()->node1;
        $node->html->node_id2 = request()->node2;
        $node->html->default_filter_binding_id = request()->default_filter_binding;
        $node->html->save();

        return redirect("/nodes/$node->id");

    }

    public  function updateSharingSelect(Node $node) {

        $node->html->binding_id = request()->binding;
        $node->html->save();

        return redirect("/nodes/$node->id");

    }

    public  function updateHtmlSelect(Node $node) {

        $node->html->auth_filtered = (request()->auth_filtered==="on")?true:false;
        $node->html->subselect = (request()->subselect==="on")?true:false;
        $node->html->multiple = (request()->multiple==="on")?true:false;
        $node->html->binding_id = request()->binding;
        $node->html->form_binding_id = request()->form_binding;
        $node->html->form_field_binding_id = request()->form_field_binding;
        $node->html->save();

        return redirect("/nodes/$node->id");

    }

    public  function updateHtmlStaticSelect(Node $node) {

        $node->html->multiple = (request()->multiple==="on")?true:false;
        $node->html->binding_id = request()->binding;
        $node->html->save();
        return redirect("/nodes/$node->id");

    }

    public  function updateSublistButton(Node $node) {

        $node->html->list_binding_id = request()->list_binding;
        $node->html->save();
        return redirect("/nodes/$node->id");

    }

    public  function updateHtmlCheckbox(Node $node) {

        $node->html->binding_id = request()->binding;
        $node->html->save();
        return redirect("/nodes/$node->id");

    }

    public  function updateHtmlDate(Node $node) {

        $node->html->binding_id = request()->binding;
        $node->html->save();
        return redirect("/nodes/$node->id");

    }

    public  function updateHtmlTime(Node $node) {

        $node->html->binding_id = request()->binding;
        $node->html->save();
        return redirect("/nodes/$node->id");

    }

    public  function updateHtmlDateTime(Node $node) {

        $node->html->binding_id = request()->binding;
        $node->html->save();
        return redirect("/nodes/$node->id");

    }

    public  function updateTextarea(Node $node) {

        $node->html->binding_id = request()->binding;
        $node->html->save();
        return redirect("/nodes/$node->id");

    }



    public  function storeChild(Node $node) {

        request()->validate([
            "name" => "required|string|max:250|unique:nodes,name"
        ]);

        $child = new Node;
        $child->name = request()->name;
        $child->parent_id = $node->id;
        $child->save();

        return redirect("/nodes/$node->id");

    }

    private function rec(Node $node) {

        foreach($node->children as $child) {
            $this->rec($child);
        }
        if ($node->html) {
            $node->html->delete();
        }

        $node->delete();

    }

    public function delete(Node $node) {

        DB::transaction(function () use ($node) {

            $this->rec($node);

        });



        return redirect("/nodes");

    }

    public function render(Node $node) {

        $component = $node->getSelectedNodeRenderComponent();

        if (request()->ajax()) {

            return view("components.ajax-component", [
                "component" => $component,
                "selectedNode" => $node
            ]);

        } else {

            return view("components.start", [
                "component" => $component,
                "selectedNode" => $node
            ]);

        }

    }


    public function renderHtmlListBody(Node $node, CommonService $commonService) {

        $rows = null;

        $filteringNode = $node->html->defaultFilterBinding;
        $defaultFilterValue = null;
        if ($filteringNode) {

            if ($filteringNode) {
                $defaultFilterValue = $commonService->getFilteringValue($filteringNode);
            }

        }

        $filteringString = Request::query("filter");
        $filters = [];
        if ($filteringString) {
            $filters[$node->html->node1->html->binding->withType->getValueClass()] = $filteringString;
            $filters[$node->html->node2->html->binding->withType->getValueClass()] = $filteringString;
        }

        $rows = $node->html->binding->filteredRows($defaultFilterValue, $filters);

        return view("components.render.html-list-body", [
            "selectedNode" => $node,
            "rows" => $rows
        ]);

    }




}
