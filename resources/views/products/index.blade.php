@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">


            <!-- SEARCH HERE     -->


        <div class="panel panel-primary">
            <div class="panel-heading">Search Product</div>

            <div class="panel-body">

                <form action="{{ route('products.index') }}" method="GET">

            <div class="row">
                <div class="col-md-3">
                <div class="form-group">
                {{Form::label('search_brand', 'Brand')}}
                {{Form::select('search_brand', $brands, null,['placeholder' => 'Select Brand...','class'=>'form-control'])}} 
                </div>
                </div>

            <div class="col-md-3">
                <div class="form-group">
                {{Form::label('search_state', 'State')}}
                {{Form::select('search_state', $states, null,['placeholder' => 'Select Brand...','class'=>'form-control'])}} 
                </div>
                </div>  

            <div class="col-md-3">
                <div class="form-group">
                {{Form::label('search_category', 'Category')}}
                {{Form::select('search_category', $categories, null,['placeholder' => 'Select Brand...','class'=>'form-control'])}} 
                </div>
            </div>  

            <div class="col-md-3">
                <div class="form-group">
                {{Form::label('search_anything', 'By Product Name/Desc')}}
                {{Form::text('search_anything',Request::get('search_anything'),['class'=>'form-control'])}} 
                </div>
            </div>  

            <div class="col-md-1">

            <div class="form-group" style="padding-top:27px;">
                <button type="submit" class="btn btn-success">Search</button>
            </div>

            </div>

            </form>
            </div>

        </div>
            
            
            


            <!-- end of search here -->

            <div class="panel panel-success">

                <div class="panel-heading">Manage Products</div>

                
                <a href="{{route('products.create')}}" class="btn btn-warning">Create Product</a>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Product Title</th>
                                <th>Product Description</th>
                                <th>Price</th>
                                <th>Location</th>
                                <th>Condition</th>
                                <th>Subcategory</th>
                                <th>Brand</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{$product->product_name}}</td>
                                <td>{{$product->product_description}}</td>
                                <td>{{$product->product_price}}</td>
                                <td>{{$product->area->area_name}}, {{$product->area->area_description}}</td>
                                <td>{{$product->condition}}</td>
                                <td>{{$product->subcategory->subcategory_name or '' }}</td>
                                <td>{{$product->brand->brand_name}}</td>
                                <td>
                                    <a href="{{ route('products.edit',$product->id) }}" class="btn btn-warning">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>


                    </table>
                    <!--pagination link-->
                    {{ $products->appends(Request::except('page'))->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
