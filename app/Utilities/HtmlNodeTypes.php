<?php
namespace app\Utilities;

use App\Models\BootstrapNavLink;
use App\Models\BootstrapNavbar;
use App\Models\HtmlCol;
use App\Models\HtmlFieldset;
use App\Models\HtmlForm;
use App\Models\HtmlInputText;
use App\Models\HtmlList;
use App\Models\HtmlRow;
use App\Models\HtmlSelect;
use App\Models\Nodes\HtmlCheckbox;
use App\Models\Nodes\HtmlDate;
use App\Models\Nodes\HtmlDateTime;
use App\Models\Nodes\HtmlStaticSelect;
use App\Models\Nodes\HtmlTime;
use App\Models\Nodes\SublistButton;
use App\Models\Sharing;
use App\Models\HtmlSharingSelect;

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
            "label" => "Form",
            "form-component" => "nodes.form"
        ],
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
        "INPUT_TEXT" => [
            "class" => HtmlInputText::class,
            "preview-component" => "preview.input-text",
            "start-component" => "start.input-text",
            "render-component" => "render.input-text",
            "label" => "InputText",
            "form-component" => "nodes.input-text"
        ],
        "SELECT_SHARING" => [
            "class" => HtmlSharingSelect::class,
            "preview-component" => null,
            "start-component" => null,
            "render-component" => "render.sharing-select",
            "label" => "Sharing Select",
            "form-component" => "nodes.sharing-select"
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
            "form-component" => "nodes.select"
        ],
        "HTML_STATIC_SELECT" => [
            "class" => HtmlStaticSelect::class,
            "preview-component" => null,
            "start-component" => null,
            "render-component" => "render.html-static-select",
            "label" => "Html Static Select",
            "form-component" => "nodes.html-static-select"
        ],
        "SUBLIST_BUTTON" => [
            "class" => SublistButton::class,
            "preview-component" => null,
            "start-component" => null,
            "render-component" => "render.sublist-button",
            "label" => "Sublist Button",
            "form-component" => "nodes.sublist-button"
        ],
        "HTML_CHECKBOX" => [
            "class" => HtmlCheckbox::class,
            "preview-component" => null,
            "start-component" => null,
            "render-component" => "render.html-checkbox",
            "label" => "Html Checkbox",
            "form-component" => "nodes.html-checkbox"
        ],
        "HTML_DATE" => [
            "class" => HtmlDate::class,
            "preview-component" => null,
            "start-component" => null,
            "render-component" => "render.html-date",
            "label" => "Html Date",
            "form-component" => "nodes.html-date"
        ],
        "HTML_TIME" => [
            "class" => HtmlTime::class,
            "preview-component" => null,
            "start-component" => null,
            "render-component" => "render.html-time",
            "label" => "Html Time",
            "form-component" => "nodes.html-time"
        ],
        "HTML_DATE_TIME" => [
            "class" => HtmlDateTime::class,
            "preview-component" => null,
            "start-component" => null,
            "render-component" => "render.html-date-time",
            "label" => "Html Date Time",
            "form-component" => "nodes.html-date-time"
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

