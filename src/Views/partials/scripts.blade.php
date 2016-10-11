<!-- SCRIPTS -->

<!-- jQuery -->
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!-- Custom Theme JavaScript -->
<script src="{{ $monkyz_assets }}js/monkyz.min.js"></script>
@if(!empty($scripts_datatables))
	<!--  Datatables     -->
	{{-- //cdn.datatables.net/v/bs/dt-1.10.12/datatables.min.js --}}
	{{-- //cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js --}}
	<script src="//cdn.datatables.net/v/bs/dt-1.10.12/datatables.min.js"></script>
	<script>
		{!! $scripts_datatables !!}
	</script>
@endif