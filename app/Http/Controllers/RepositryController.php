<?php

namespace App\Http\Controllers;

use App\Http\Models\Repositories;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RepositryController extends Controller
{
    public function __construct()
    {
    }

    public function getData(Request $request)
    {
        Log::log("warning", "we will get the data now" . $request->page);
        request()->page ?? $request->page;
        try {
            $data = Repositories::paginate(50);
        } catch (Exception $ex) {
            Log::log("error", "error while get repositories " . $ex->getMessage());
            return response()->json(null, 500);
        }
        return response()->json($data, 200);
    }

    public function buildSql(Request $request)
    {
        $selectSql = $this->createSelectSql($request);
        $fromSql = " FROM ATHLETES ";
        $whereSql = $this->whereSql($request);
        $groupBySql = $this->groupBySql($request);
        $orderBySql = $this->orderBySql($request);
        $limitSql = $this->createLimitSql($request);

        $SQL = $selectSql . $fromSql . $whereSql . $groupBySql . $orderBySql . $limitSql;
        return $SQL;
    }
}
