<?php

namespace App\Admin\Controllers;

use App\Categories;
use App\Category_detail;
use App\Product;

use App\ProductDetail;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class AdminProductDetailController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->updateForm($id)->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(ProductDetail::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('product_id');
            $grid->column('key');
            $grid->column('value');
            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ProductDetail::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('value','Value: ');
            $form->select('product_id')->options(Product::all()->pluck('product_name', 'id'));
            $form->select('key')->options(Category_detail::all()->pluck('key', 'id'));

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    public function updateForm($id){
        return Admin::form(ProductDetail::class, function (Form $form) use ($id) {

            $form->display('id', 'ID');
            $form->select('product_id')->options(Product::all()->pluck('product_name', 'id'));
            $form->select('key')->options($this->getKeys($id));
            $form->text('value','Value: ');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    public function getKeys($id){
        $pd = ProductDetail::find($id);
        $p = Product::find($pd['product_id']);
        $c = Categories::find($p['category_id']);
        $pc = Categories::find($c['parent_category_id']);
        $ck = Category_detail::where('category_id', $c['id'])->get();
        $ck2 = Category_detail::where('category_id', $pc['id'])->get();
        $ck3 = Category_detail::where('category_id', $pc['id'])->get();

        $arr = array();


        if(count($ck) > 0) {
            //array_push($arr, $ck);
            foreach($ck as $i){
                $arr[$i['id']] = $i['key'];
            }
        }

        if(count($ck2) > 0) {
            //array_push($arr, $ck2);
            foreach($ck2 as $i){
                $arr[$i['id']] = $i['key'];
            }
        }

        if(count($ck3) > 0) {
            //array_push($arr, $ck2);
            foreach($ck3 as $i){
                $arr[$i['id']] = $i['key'];
            }
        }

        return $arr;
    }
}
