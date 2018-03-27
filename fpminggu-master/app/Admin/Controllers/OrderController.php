<?php

namespace App\Admin\Controllers;

use App\Order;
use App\User;

use App\UserAddress;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class OrderController extends Controller
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
        return Admin::grid(Order::class, function (Grid $grid)

        {
            $grid->id('ID')->sortable();
            $grid->column('user_id');

            $grid->column('order_status');
            $grid->column('order_date');

            $grid->column('total_price');

            $grid->column('payment_date');
            $grid->column('payment_amount');
            $grid->column('max_payment_date');
            $grid->column('payment_status');

            $grid->column('shipment_address_id');
            $grid->column('shipment_date');
            $grid->column('shipment_status');
            $grid->column('shipment_tracking_number');

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
        return Admin::form(Order::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('user_id')->options(User::all()->pluck('name', 'id'));

            $form->select('order_status','Order Status: ')->options(['Waiting For Payment' => 'Waiting For Payment', 'On Process' => 'On Process','Complete' => 'Complete']);
            $form->date('order_date','Order Date: ');

            $form->number('total_price','Total Price: ');

            $form->date('payment_date','Payment Date: ');
            $form->number('payment_amount','Total Payment: ');
            $form->date('max_payment_date','Maximum Payment Date: ');
            $form->select('payment_status','Payment Status: ')->options(['Waiting Confirmation' => 'Waiting Confirmation', 'Verified' => 'Verified']);

            $form->select('shipment_address_id')->options(UserAddress::all()->pluck('address', 'id'));
            $form->date('shipment_date','Shipment Date: ');
            $form->select('shipment_status','Shipment Status: ')->options(['Packing' => 'Packing','On Process' => 'On Process', 'Receive' => 'Receive']);
            $form->number('shipment_tracking_number','Shipment Number: ');







            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
