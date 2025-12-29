<?php
namespace App\Utilities;

use App\Models\FieldTypes\BooleanField;
use App\Models\FieldTypes\DateField;
use App\Models\FieldTypes\DateTimeField;
use App\Models\FieldTypes\EnumField;
use App\Models\FieldTypes\FK2Field;
use App\Models\FieldTypes\FKField;
use App\Models\FieldTypes\FloatField;
use App\Models\FieldTypes\IntegerField;
use App\Models\FieldTypes\StringField;
use App\Models\FieldTypes\TextField;
use App\Models\FieldTypes\TimeField;
use App\Models\FieldTypes\TimestampField;
use App\Models\Nodes\HtmlCheckbox;
use App\Models\Nodes\HtmlDate;
use App\Models\Nodes\HtmlDateTime;
use App\Models\Nodes\HtmlInputFile;
use App\Models\Nodes\HtmlInputText;
use App\Models\Nodes\HtmlSelect;
use App\Models\Nodes\HtmlSharingSelect;
use App\Models\Nodes\HtmlStaticSelect;
use App\Models\Nodes\HtmlTextarea;
use App\Models\Nodes\HtmlTime;

class FieldTypes
{

    private static $values = [
        "STRING" => [
            "class" => StringField::class,
            "form-component" => null,
            "label" => "String",
            "default-html-component" => HtmlInputText::class
        ],
        "INTEGER" => [
            "class" => IntegerField::class,
            "form-component" => null,
            "label" => "Integer",
            "default-html-component" => HtmlInputText::class
        ],
        "FLOAT" => [
            "class" => FloatField::class,
            "form-component" => null,
            "label" => "Float",
            "default-html-component" => HtmlInputText::class
        ],
        "BOOLEAN" => [
            "class" => BooleanField::class,
            "form-component" => null,
            "label" => "Boolean",
            "default-html-component" => HtmlCheckbox::class
        ],
        "FK" => [
            "class" => FKField::class,
            "form-component" => null,
            "label" => "Foreign Key",
            "default-html-component" => HtmlSelect::class
        ],
        "ENUM" => [
            "class" => EnumField::class,
            "form-component" => "resources.enum-field",
            "label" => "Enum",
            "default-html-component" => HtmlStaticSelect::class
        ],
        "DATE" => [
            "class" => DateField::class,
            "form-component" => null,
            "label" => "Date",
            "default-html-component" => HtmlDate::class
        ],
        "TIME" => [
            "class" => TimeField::class,
            "form-component" => null,
            "label" => "Time",
            "default-html-component" => HtmlTime::class
        ],
        "DATE_TIME" => [
            "class" => DateTimeField::class,
            "form-component" => null,
            "label" => "Date Time",
            "default-html-component" => HtmlDateTime::class
        ],
        "TEXT" => [
            "class" => TextField::class,
            "form-component" => null,
            "label" => "Text",
            "default-html-component" => HtmlTextarea::class
        ],
        "TIMESTAMP" => [
            "class" => TimestampField::class,
            "form-component" => null,
            "label" => "Timestamp",
            "default-html-component" => HtmlInputFile::class
        ],
        "FK2" => [
            "class" => FK2Field::class,
            "form-component" => null,
            "label" => "Foreign Key 2",
            "default-html-component" => HtmlSharingSelect::class
        ]
    ];

    public static function getValues() {

        return self::$values;
    }


    public static function getSectedFieldType($selectedField) {

        $foundedFieldType = null;

        foreach (self::$values as $nodeType => $node) {

            if ($selectedField->with_type_type === $node["class"]) {
                $foundedFieldType = $nodeType;
            }

        }

        return $foundedFieldType;

    }

}

