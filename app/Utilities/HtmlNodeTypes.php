<?php
namespace app\Utilities;

use App\Models\Nodes\BootstrapNavbar;
use App\Models\Nodes\BootstrapNavLink;
use App\Models\Nodes\HtmlCheckbox;
use App\Models\Nodes\HtmlCol;
use App\Models\Nodes\HtmlDate;
use App\Models\Nodes\HtmlDateTime;
use App\Models\Nodes\HtmlFieldset;
use App\Models\Nodes\HtmlForm;
use App\Models\Nodes\HtmlInputFile;
use App\Models\Nodes\HtmlInputText;
use App\Models\Nodes\HtmlList;
use App\Models\Nodes\HtmlListBody;
use App\Models\Nodes\HtmlRow;
use App\Models\Nodes\HtmlSelect;
use App\Models\Nodes\HtmlSharingSelect;
use App\Models\Nodes\HtmlStaticSelect;
use App\Models\Nodes\HtmlTextarea;
use App\Models\Nodes\HtmlTime;
use App\Models\Nodes\SublistButton;

class HtmlNodeTypes
{

    private static $values = [
        "NAVBAR" => [
            "class" => BootstrapNavbar::class,
            "preview-component" => "preview.navbar",
            "start-component" => "start.navbar",
            "render-component" => "render.navbar",
            "label" => "Bootstrap Navbar",
            "form-component" => "nodes.navbar"
        ],
        "NAVLINK" => [
            "class" => BootstrapNavLink::class,
            "preview-component" => "preview.navlink",
            "start-component" => "start.navlink",
            "render-component" => "render.navlink",
            "label" => "Bootstrap NavLink",
            "form-component" => "nodes.navlink"
        ],
        "FORM" => [
            "class" => HtmlForm::class,
            "preview-component" => "preview.form",
            "start-component" => "start.form",
            "render-component" => "render.form",
            "label" => "Html Form",
            "form-component" => "nodes.html-form"
        ],
        /*
        "FIELDSET" => [
            "class" => HtmlFieldset::class,
            "preview-component" => "preview.fieldset",
            "start-component" => "start.fieldset",
            "render-component" => "render.navabar",
            "label" => "Fieldset",
            "form-component" => "nodes.fieldset"
        ],
        "ROW" => [
            "class" => HtmlRow::class,
            "preview-component" => "preview.row",
            "start-component" => "start.row",
            "render-component" => "render.navabar",
            "label" => "Row",
            "form-component" => "nodes.row"
        ],
        "COL" => [
            "class" => HtmlCol::class,
            "preview-component" => "preview.col",
            "start-component" => "start.col",
            "render-component" => "render.navabar",
            "label" => "Col",
            "form-component" => "nodes.col"
        ],
        */
        "INPUT_TEXT" => [
            "class" => HtmlInputText::class,
            "preview-component" => "preview.input-text",
            "start-component" => "start.input-text",
            "render-component" => "render.input-text",
            "label" => "Html InputText",
            "form-component" => "nodes.input-text",
            "is-input" => true
        ],
        "SELECT_SHARING" => [
            "class" => HtmlSharingSelect::class,
            "preview-component" => null,
            "start-component" => null,
            "render-component" => "render.sharing-select",
            "label" => "Html Sharing Select",
            "form-component" => "nodes.sharing-select",
            "is-input" => true
        ],
        "HTML_LIST" => [
            "class" => HtmlList::class,
            "preview-component" => null,
            "start-component" => null,
            "render-component" => "render.html-list",
            "label" => "Html List",
            "form-component" => "nodes.html_list"
        ],
        "HTML_SELECT" => [
            "class" => HtmlSelect::class,
            "preview-component" => null,
            "start-component" => null,
            "render-component" => "render.html-select",
            "label" => "Html Select",
            "form-component" => "nodes.select",
            "is-input" => true
        ],
        "HTML_STATIC_SELECT" => [
            "class" => HtmlStaticSelect::class,
            "preview-component" => null,
            "start-component" => null,
            "render-component" => "render.html-static-select",
            "label" => "Html Static Select",
            "form-component" => "nodes.html-static-select",
            "is-input" => true
        ],
        "SUBLIST_BUTTON" => [
            "class" => SublistButton::class,
            "preview-component" => null,
            "start-component" => null,
            "render-component" => "render.sublist-button",
            "label" => "Html Sublist Button",
            "form-component" => "nodes.sublist-button"
        ],
        "HTML_CHECKBOX" => [
            "class" => HtmlCheckbox::class,
            "preview-component" => null,
            "start-component" => null,
            "render-component" => "render.html-checkbox",
            "label" => "Html Checkbox",
            "form-component" => "nodes.html-checkbox",
            "is-input" => true
        ],
        "HTML_DATE" => [
            "class" => HtmlDate::class,
            "preview-component" => null,
            "start-component" => null,
            "render-component" => "render.html-date",
            "label" => "Html Date",
            "form-component" => "nodes.html-date",
            "is-input" => true
        ],
        "HTML_TIME" => [
            "class" => HtmlTime::class,
            "preview-component" => null,
            "start-component" => null,
            "render-component" => "render.html-time",
            "label" => "Html Time",
            "form-component" => "nodes.html-time",
            "is-input" => true
        ],
        "HTML_DATE_TIME" => [
            "class" => HtmlDateTime::class,
            "preview-component" => null,
            "start-component" => null,
            "render-component" => "render.html-date-time",
            "label" => "Html Date Time",
            "form-component" => "nodes.html-date-time",
            "is-input" => true
        ],
        "HTML_LIST_BODY" => [
            "class" => HtmlListBody::class,
            "preview-component" => null,
            "start-component" => null,
            "render-component" => "render.html-list-body",
            "label" => "Html List Body",
            "form-component" => null
        ],
        "HTML_TEXTAREA" => [
            "class" => HtmlTextarea::class,
            "preview-component" => null,
            "start-component" => null,
            "render-component" => "render.html-textarea",
            "label" => "Html Textarea",
            "form-component" => "nodes.html-textarea",
            "is-input" => true
        ],
        "HTML_INPUT_FILE" => [
            "class" => HtmlInputFile::class,
            "preview-component" => null,
            "start-component" => null,
            "render-component" => "render.html-input-file",
            "label" => "Html Input File",
            "form-component" => "nodes.html-input-file",
            "is-input" => true
        ]

    ];

    public static function getValues() {

        return self::$values;
    }


    public static function getSectedNodeType($selectedNode) {

        $foundedHtmlType = null;

        foreach (self::$values as $nodeType => $node) {

            if ($selectedNode->html_type === $node["class"]) {
                $foundedHtmlType = $nodeType;
            }

        }

        return $foundedHtmlType;

    }

}

