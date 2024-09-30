<?php

namespace App\Http\Controllers;
date_default_timezone_set('Asia/Kolkata');
use App\Http\Requests\ProductRequest;
use App\Models\Group;
use App\Models\Product;
use App\Models\SubGroup;
use Exception;

interface ProductInterface
{
    public function index();
    public function store(ProductRequest $request);
    public function show(string $id);
    public function update(ProductRequest $request, string $id);
    public function destroy(string $id);
}
class ProductController extends Controller implements ProductInterface
{
    /**
     * This method return the view of the product page for the product CRUD.
     */
    public function index()
    {
        $products = Product::all();
        $groups = Group::all();
        $sub_groups = SubGroup::all();
        $last = Product::select('product_id')->orderBy('id', 'DESC')->limit(1)->get();
        //This creates the unique id to each product.
        if ($last->count() >= 1) {
            $lastProductId = substr($last[0]->product_id, 2);
            $productId = "MR" . (intval($lastProductId) + 1);
        } else {
            $productId = "MR1";
        }
        return view('addNewProduct', compact('products', 'groups', 'sub_groups', 'productId'));
    }
    /**
     * This method validate (using self define request 'ProductRequest') and  stores the product info
     */
    public function store(ProductRequest $request)
    {
        $product = new Product();
        $product->product_id = $request->p_id;
        $product->product_name = $request->p_name;
        $product->group_no = $request->group;
        $product->sub_group_no = $request->sub_group;
        $product->quantity = $request->qty;
        $product->rate = $request->p_rate;
        $product->MRP = $request->p_mrp;
        $product->discount = $request->discount;
        $product->GST = $request->gst;
        $product->weight = $request->weight;
        $product->GSTOn = $request->gstOn;

        $res = $product->save();
        $msg = $res ? '<b>Success! </b>Product Added Successfully..!' : '<b>Failed! </b>Product cannot Added..!';
        return redirect()->route('product.index')->with('success', $msg);
    }

    /**
     * This method shows the specific product according to the product id.
     */
    public function show(string $id)
    {
        $data = Product::whereProductId($id)->get();
        return response()->json($data->count() == 1 ? $data : [
            ['error' => 'Invalid! Please enter valid product id..!'],
        ]);
    }
    /**
     * This method updates the specified product data into DB.
     */
    public function update(ProductRequest $request, string $id)
    {
        $update = Product::where('id', $id)->update([
            'product_id' => $request->p_id,
            'product_name' => $request->p_name,
            'group_no' => $request->group,
            'sub_group_no' => $request->sub_group,
            'weight' => $request->weight,
            'quantity' => $request->qty,
            'rate' => $request->p_rate,
            'MRP' => $request->p_mrp,
            'discount' => $request->discount,
            'GST' => $request->gst,
            'GSTOn' => $request->gstOn,
        ]);

        $msg = $update ? '<b>Success! </b>Product updated successfully..!' : '<b>Failed! </b>Product cannot updated..!';
        return redirect()->route('product.index')->with('update', $msg);
    }

    /**
     * This method remove the specified product into from DB.
     */
    public function destroy(string $id)
    {
        try {
            $del = Product::destroy($id);
            $exp = $del ? '<b>Success! </b>Product removed successfully..!' : '<b>Failed! </b>Product cannot deleted..!';
        } catch (Exception $e) {
            $exp = '<b>Failed! </b>Bill are generated by this product..!';
        }
        return redirect()->route('product.index')->with('delete', $exp);
    }
}
