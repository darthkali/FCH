<?php
namespace FCH;

class Function_FCH extends BaseModel{
    const TABLENAME = '`FUNCTION_FCH`';

    protected $schema = [
        'ID'               => [ 'type' => BaseModel::TYPE_INT    ],
        'CREATED_AT'       => [ 'type' => BaseModel::TYPE_STRING ],
        'UPDATED_AT'       => [ 'type' => BaseModel::TYPE_STRING ],
        'NAME'             => [ 'type' => BaseModel::TYPE_STRING,'min' => 6, 'max' => 30 ]
    ];

    public static function generateFunctionFCHNameByFunctionID($functionID){
        if($functionID != ''){
            $function = self::findOne('ID = '. $functionID);
            return $function['NAME'];
        }
        return '';
    }

    public  static function generateFunctionFCHNameByUserID($userID){
        $memberHistory = MemberHistory::generateActualMemberHistory($userID);
        return Function_FCH::generateFunctionFCHNameByFunctionID($memberHistory['FUNCTION_FCH_ID']);
    }

    public static function changeUserFunction($userID, $newFunction){
        $memberHistory = MemberHistory::generateActualMemberHistory($userID);
        $actualFunction = $memberHistory['Function_FCH_ID'];
        if($actualFunction === $newFunction) {
            return true;
        }
        MemberHistory::closeActualMemberHistory($userID);
        MemberHistory::createNewMemberHistory($userID, $newFunction);
        return true;
    }
}