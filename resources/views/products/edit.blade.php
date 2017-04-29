@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Product</div>

                <div class="panel-body">

                @if(count($errors)>0)

                <div class="alert alert-danger" role="alert">

                <p>Validation Error. Please fix this error below:</p>
                <!--papar validation error-->
                <ul>
                @foreach($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
                </ul>

                </div>
                @endif


                <!--tambah form kat sini-->
                
                <!--product-->

                {{ Form::open(['route'=>['products.update',$product->id], 'method'=>'PUT', 'files'=>true])}}

                <div class="form-group {{ $errors->has('brand_id') ? 'has-error' : false }} ">
                {{Form::label('brand_id', 'Brand')}}
                {{Form::select('brand_id', $brands, $product->brand_id,['placeholder' => 'Select Brand...','class'=>'form-control'])}} 
                </div>

                <div class="form-group {{ $errors->has('category_id') ? 'has-error' : false }} ">
                {{Form::label('category_id', 'Category')}}
                {{Form::select('category_id',$categories, $product->subcategory->category_id,['placeholder' => 'Select category...','class'=>'form-control','id'=>'category_id'])}} 
                </div>

                <div class="form-group {{ $errors->has('subcategory_id') ? 'has-error' : false }} ">
                {{Form::label('subcategory_id', 'Subcategory')}}
                {{Form::select('subcategory_id',$subcategories, $product->subcategory_id,['placeholder' => 'Select subcategory...','class'=>'form-control','id'=>'subcategory_id'])}} 
                </div>
                
                <div class="form-group {{ $errors->has('state_id') ? 'has-error' : false }} ">
                {{Form::label('state_id', 'State')}}
                {{Form::select('state_id', $states, $product->area->state_id,['placeholder' => 'Select State...','class'=>'form-control','id'=>'state_id'])}}
                </div>

                <div class="form-group {{ $errors->has('area_id') ? 'has-error' : false }} ">
                {{Form::label('area_id', 'Area')}}
                {{Form::select('area_id', $areas, $product->area_id, ['placeholder' => 'Select area...','class'=>'form-control','id'=>'area_id'])}} 
                </div>

                <div class="form-group {{ $errors->has('product_name') ? 'has-error' : false }} ">
                {{Form::label('product_name', 'Product Name')}}
                {{Form::text('product_name',$product->product_name,['class'=>'form-control'])}}
                </div>

                <div class="form-group {{ $errors->has('product_description') ? 'has-error' : false }} ">
                {{Form::label('product_description', 'Product Description')}}
                {{Form::textarea('product_description',$product->product_description,['class'=>'form-control'])}}
                </div>

                <div class="form-group {{ $errors->has('product_price') ? 'has-error' : false }} ">
                {{Form::label('product_price', 'Product Price')}}
                {{Form::text('product_price',$product->product_price,['class'=>'form-control'])}}
                </div>

                <div class="form-group {{ $errors->has('condition') ? 'has-error' : false }} ">
                {{Form::label('condition', 'Condition')}}
                {{Form::radio('condition','new', false)}} New
                {{Form::radio('condition','used', false)}} Used
                </div>

                <div class="form-group {{ $errors->has('product_image') ? 'has-error' : false }} ">
                    {{ Form:: label('product_image', 'Product Image') }}
                    {{ Form:: file('product_image') }}
                </div>

                <div class="form-group">
                    @if(!empty($product->product_image))
                    <img src="{{ asset('storage/images'.$product->product_image) }}">
                    @endif
                </div>
    
                <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{route('products.index')}}" class="btn btn-default">Cancel</a>
                </div>

                {!! Form::close() !!}
                <!--tutup form kat sini -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script type="text/javascript">

    $( document ).ready(function() {
    //console.log( "Form create product now!!!" );

//bila setiap kali pengguna tukar State, buat function di bawah
    var selected_state_id = '{{ old('state_id') }}';
    console.log(selected_state_id);

//kalau ade selected state id, kite panggil balik function ajax dapatkan area
    if (selected_state_id.length>0){
        console.log('kita akan panggil balik ajax utk dapatkan area');
        getStateAreas(selected_state_id);
    };

//dapatkan selected state selepas validation error
    function getStateAreas(state_id){

        var ajax_url = '/products/areas/' + state_id;
        $.get(ajax_url, function(data){

            console.log(data);

            $('#area_id').empty().append('<option value="">Select Area</option>');
            $.each(data, function(area_id,area_name){
                
                $('#area_id').append('<option value='+area_id+'>'+area_name+'</option>');
            });

            var selected_area_id = '{{ old('area_id') }}';

            if (selected_area_id.length>0){

                $('#area_id').val(selected_area_id);
            };
        });
    }

    $( "#state_id" ).change(function() {

         var state_id = $(this).val();
         getStateAreas(state_id);
    });

    var selected_category_id = '{{ old('category_id')}}';
    console.log(selected_category_id);

    if (selected_category_id.length>0){
        getCategoriesSubcategories(selected_category_id);

        
    };

    function getCategoriesSubcategories(category_id){

        var ajax_url = '/products/subcategories/' + category_id;
        $.get(ajax_url, function(data){

            console.log(data);

            $('#subcategory_id').empty().append('<option value="">Select Subcategory</option>');
            $.each(data, function(subcategory_id,subcategory_name){
                
                $('#subcategory_id').append('<option value='+subcategory_id+'>'+subcategory_name+'</option>');
            });

            var selected_subcategory_id = '{{ old('subcategory_id') }}';

            if (selected_subcategory_id.length>0){

                $('#subcategory_id').val(selected_subcategory_id);
            };
        });
    }

    $( "#category_id" ).change(function() {

        var category_id = $(this).val();
        getCategoriesSubcategories(category_id);
    });

});
</script>

@endsection