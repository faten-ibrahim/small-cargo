


<a href="{{route('gyms.index')}}" class="btn btn-primary">Back</a>

<h3>Name : </h3><p>{{$gym->name}}</p>
<h3>city name : </h3><p>{{isset($gym->city)?$gym->city->name:'Not Found'}}</p>
<h3>created at : </h3><p>{{$gym->created_at->format('l js \of F Y h:i:s A')}}</p>








