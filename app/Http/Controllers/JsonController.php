<?php
/**
* Class and Function List:
* Function list:
* - search()
* - extractFields()
* Classes list:
* - JsonController extends Controller
*/
namespace App\Http\Controllers;

use DB;
use Log;
use Illuminate\Http\Request;

class JsonController extends Controller
{
    /* search
     *
     * Searches a given value, for a given key, in a given table, for a given field
     *
     *  @param $searchWord(string), $searchKey(string), $tableName(string), $fieldName(string)
     *  @return $data(array of objects)
    */
    public function search($searchWord, $searchKey, $tableName, $fieldName)
    {
        try
        {
            $data       = null;

            $searchWord = strip_tags($searchWord);
            $searchKey  = strip_tags($searchKey);
            // Log::info('Search word : '.print_r($searchWord,true));
            // Log::info('Search key : '.print_r($searchKey,true));
            if ($searchWord && $searchKey)
            {

                // sub query, searching json for the key & the value
                $Q1         = "(SELECT *,
                        JSON_SEARCH(" . $fieldName . ", 'all', '" . $searchWord . "') AS value_present,
                        JSON_SEARCH(" . $fieldName . ", 'all', '" . $searchKey . "') AS key_present
                        FROM " . $tableName . ") as Q1";

                // sub query, extracting index from json search result
                $Q2         = "(SELECT Q1.*,
                            REGEXP_SUBSTR(Q1.key_present,'[0-9]+') AS key_index,
                            REGEXP_SUBSTR(Q1.value_present,'[0-9]+') AS value_index
                        FROM
                            " . $Q1 . "
                        ) AS Q2";

                // main query extracting rows where both, key index & the value index are same
                $data       = DB::table(DB::raw($Q2))->whereRaw('key_index = value_index')
                    ->get();
            }

            Log::info('Data : '.print_r($data,true));
            return $data;
        }
        catch(Exception $e)
        {
            report($e);
        }
    }

    /* extractFields
     *
     * Extracts a given field, from a given json string
     *
     *  @param $field(string), $jsonString(string)
     *  @return $list(comma seperated string)
    */
    public function extractFields($field, $jsonString)
    {
        try
        {
            $arr  = [];
            $list = '';
            // dd($jsonString);
            if ($field && $jsonString)
            {

                // decoding the json string to a json object/array
                $json = json_decode($jsonString);
                // $unique_array = DB::table('drop')->first();
                // pushing given field to an array
                // if(!empty($unique_array)){
                //     $my_array = explode(',',$unique_array->array);
                //     // dd($my_array,$unique_array->array);
                //     // dd('my_array',$my_array);
                //     for($i=0;$i<count($json);$i++){
                //         array_push($arr, strip_tags($json[$i]->$field));
                //         if(!(in_array(strip_tags($json[$i]->$field),$my_array))){
                //             array_push($my_array,strip_tags($json[$i]->$field));
                //         }
                //     }
                //     // converting the array to comma seperated string
                //     $list = implode(',', $arr);
                //     // $my = implode(',', $my_array);
                //     // dd('my',$my);
                //     // DB::table('drop')->where('id',1)->update(['array' => implode(',',$my_array)]);
                // }
                // else{
                for ($i    = 0;$i < count($json);$i++)
                {
                    array_push($arr, strip_tags($json[$i]->$field));
                }
                // converting the array to comma seperated string
                $list = implode(',', $arr);
                // dd('list',$list);
                //     DB::table('drop')->insert(['array' => $list]);
                // }



            }
            // dd($list);
            return $list;
        }
        catch(Exception $e)
        {
            report($e);
        }
    }
}

