<center><h1><u>Welcome!</u></h1></center>
<p>Get started with Lean Views</p>
<p> Lean views provide an easy way to create simple management consoles for your service </p>

<p> You also have available properties of the service as well as parameters passed to it </p>
<p> You may also use the blade templating tool provided within laravel. We strongly advice you use a
    frontend framework though.
    
    <br><u>What is available in a lean view</u>   
    @foreach($payload as $key => $value)
    
<p>{{$key}} => <?php var_dump($value) ?></p>

    @endforeach
