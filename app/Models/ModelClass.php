<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelClass extends Model
{
    use HasFactory;
    public static function totalItem($array = ['authors' => array(), 'categories' => array(), 'companies' => array()])
    {
        $join = '';
        $where = array();
        if (isset($array['authors']) && count($array['authors']) > 0) {
            $join .= 'LEFT OUTER JOIN authors  as a
                ON a.id=b.author_id ';
            $where[] = 'b.author_id IN (' . implode(',', $array['authors']) . ') ';
        }
        if (isset($array['companies']) && count($array['companies']) > 0) {
            $join .= 'LEFT OUTER JOIN companies  as co
                ON co.id=b.company_id ';
            $where[] = 'b.company_id IN (' . implode(',', $array['companies']) . ') ';
        }
        if (isset($array['categories']) && count($array['categories']) > 0) {
            $join .= 'LEFT OUTER JOIN categories  as ca
                ON ca.id=b.category_id ';
            $where[] = 'b.category_id IN (' . implode(',', $array['categories']) . ') ';
        }
        $query = 'SELECT * FROM books as b ' . $join . 'WHERE ' . implode('AND ', $where);
        return  count(DB::select($query));
    }
}
