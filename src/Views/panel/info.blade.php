@extends('monkyz::layouts.monkyz')

@section('content')
	<div class="row">
		<div class="col-sm-12">
			<p>
				<a href="http://www.1353.it" target="_blank">
					<img src="https://img.shields.io/badge/powered%20by-lab1353-brightgreen.svg">
				</a>
				<img src="https://poser.pugx.org/lab1353/monkyz/downloads">
				<img src="https://poser.pugx.org/lab1353/monkyz/license">
			</p>
			<h4><strong>Monkyz</strong> is a dynamic and autonomous Administration Panel for <em>Laravel</em>.</h4>
			<p>
				It adapts to existing database by creating a full CRUD management for any table existing.<br>
				No configuration required: without writing a single line of code, your control panel is ready for use.
			</p>

			<h3>Links</h3>
			<dl class="dl-horizontal">
				@foreach($links as $name=>$link)
					<dt>{{$name}}</dt>
					<dd><a href="{{$link}}" target="_blank">{{$link}}</a></dd>
				@endforeach
			</dl>

			<h3>Vendors</h3>
			<dl class="dl-horizontal">
				@foreach($vendors as $name=>$link)
					<dt>{{$name}}</dt>
					<dd><a href="{{$link}}" target="_blank">{{$link}}</a></dd>
				@endforeach
			</dl>

			<h3>Tools</h3>
			<dl class="dl-horizontal">
				@foreach($tools as $name=>$link)
					<dt>{{$name}}</dt>
					<dd><a href="{{$link}}" target="_blank">{{$link}}</a></dd>
				@endforeach
			</dl>
		</div>
	</div>
@endsection