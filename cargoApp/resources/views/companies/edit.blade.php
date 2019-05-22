 @extends('layouts.admin')

 @section('content')

 <!-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif -->
 <div class="container con">
     <br>
     <br>
     <h2>Edit Package</h2>
     <form action="{{route('packages.update',['package' => $packages->id])}}" method="POST">
         @csrf
         @method('PUT')
         <div class="form-group">
             <label>Name</label>
             <input name="name" value="{{$packages->name}}" type="text" class="form-control">
         </div>
         <div class="form-group">
             <label>Sessions Number</label>
             <input name="sessionsNumber" class="form-control" value="{{$packages->sessionsNumber}}" />
         </div>


         <div class="form-group">
             <label>Price</label>
             <input name="price" class="form-control" value="{{$packages->price}}" />
         </div>





         <button type="submit" class="btn btn-primary" style="display:inline; float:left;">Submit</button>
     </form>
     <a href="{{route('packages.index')}}" class="btn btn-danger" style="display:inline; float:left; margin-left:10px;">Back</a>

 </div>
 @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif  
 @endsection
