<?php

namespace App\Http\Controllers\Admin\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * 角色接口
 * Class RoleController
 * @package App\Http\Controllers\Admin\Api
 */
class RoleController extends ApiController
{
    /**
     * 角色列表数据
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        //重组数据
        $param = $request->all();
        
        return $this->response($this->role->dataTable(['id', 'name', 'display_name', 'description', 'updated_at'], $param, [
            'condition' => [
                [
                    'where',
                    ['where', 'display_name like %?%'],
                    ['orWhere', 'name like %?%']
                ]
            ]
        ]));
    }

    /**
     * 删除
     * @param int $id
     */
    public function destroy($id = 0)
    {
        $id = (int)$id;

        $role = $this->role->getById($id);
        if(!empty($role)){
            $res = $role -> delete();
            if($res){
                return $this->responseSuccess('删除成功!');
            }
        }

        return $this->setStatusCode(400)->responseError('删除失败!');
    }
}