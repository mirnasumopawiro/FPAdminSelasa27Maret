<?php

namespace App\Admin\Controllers;

use App\Order;
use App\OrderItem;
use App\ProductDetail;
use App\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class OrderItemController extends Controller
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

            $content->body($this->form()->edit($id));
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
        return Admin::grid(OrderItem::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('order_id');
            $grid->column('product_id');
            $grid->column('qty');
            $grid->column('price');
            $grid->column('additional_information');



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
        return Admin::form(OrderItem::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('order_id')->options(Order::all()->pluck('id', 'id'));
            $form->select('product_id')->options(ProductDetail::all()->pluck('id', 'id'));

            $form->number('qty','Quantity: ');
            $form->number('price','Price: ');

            $form->text('additional_information');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
