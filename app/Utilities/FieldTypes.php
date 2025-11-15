<?php
namespace App\Utilities;

use App\Models\FieldTypes\BooleanField;
use App\Models\FieldTypes\DateField;
use App\Models\FieldTypes\DateTimeField;
use App\Models\FieldTypes\EnumField;
use App\Models\FieldTypes\FKField;
use App\Models\FieldTypes\FloatField;
use App\Models\FieldTypes\IntegerField;
use App\Models\FieldTypes\StringField;
use App\Models\FieldTypes\TextField;
use App\Models\FieldTypes\TimeField;

class FieldTypes
{

    private static $values = [
        "STRING" => [
            "class" => StringField::class,
            "form-component" => null,
            "label" => "String"
        ],
        "INTEGER" => [
            "class" => IntegerField::class,
            "form-component" => null,
            "label" => "Integer"
        ],
        "FLOAT" => [
            "class" => FloatField::class,
            "form-component" => null,
            "label" => "Float"
        ],
        "BOOLEAN" => [
            "class" => BooleanField::class,
            "form-component" => null,
            "label" => "Boolean"
        ],
        "FK" => [
            "class" => FKField::class,
            "form-component" => "resources.fk-field",
            "label" => "Foreign Key"
        ],
        "ENUM" => [
            "class" => EnumField::class,
            "form-component" => "resources.enum-field",
            "label" => "Enum"
        ],
        "DATE" => [
            "class" => DateField::class,
            "form-component" => null,
            "label" => "Date"
        ],
        "TIME" => [
            "class" => TimeField::class,
            "form-component" => null,
            "label" => "Time"
        ],
        "DATE_TIME" => [
            "class" => DateTimeField::class,
            "form-component" => null,
            "label" => "Date Time"
        ],
        "TEXT" => [
            "class" => TextField::class,
            "form-component" => null,
            "label" => "Text"
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

