@extends('layouts.app')
<link src="./fonts/MISTV___.TTF" />
<link href="css/generalCssNumbers.css" rel="stylesheet" />

 <link href="css/cards-2-2.css" rel="stylesheet" />
 @section('className',"sub-banner")


@section('slider')

@endsection
<style>
.playBoard{
    height:27em;
  }
</style>
@section('website')


<div class="container" id="gameContainer" >

    <div class="row justify-content-center">
        <div class="col-md-10">
            <cards-2-3></cards-2-3>
            
        </div>
    </div>
</div>

@endsection
