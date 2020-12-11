@extends('layouts.index')


@section('page_contents')

<?php

	//prepare data for page...


	$time = [
				['07am','morning'],
				['12pm','afternoon'],
				['05pm','evening']
	];

?>

        <div id="page-wrapper">


            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">{{$pg_title}} for {{ucfirst($mkt->fullname)}}</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>


           {{Form::open(['route'=>'new_log'])}}

            <div class="row">



            	@foreach($time as $t)

            	<div class="col-md-3">
            		<div class="form-group">
      					    <label>Data at {{$t[0]}} ({{ $t[1] }})</label>	
                    <?php
                      $nm = unserialize($fuel);

                    ?>

        					    @foreach($fuels as $fuel)						    			    
        					    <div class="form-group input-group">
                                    <input name="{{$nm[1]}}_{{$t[0]}}" type="Number" class="form-control">
                                    <span class="input-group-addon">{{$}}</span>
                                </div>	
                      @endforeach 

      					</div>	
              </div>

            	@endforeach

            	<input type="hidden" name="mid" value="{{$mkt->id}}">
            </div>

            <div class="row">
            	<div class="col-md-12">
            		<button class=" btn btn-alert" type="submit">Update Todays Info</button>
            	</div>
            </div>

           {{Form::close()}}


            <style type="text/css">
            	
            	.input-group-addon {

				    width: 40% !important;
				    text-align: left !important;

				}
				.pricx *{font-size:10px !important;}
				.pricx span{display:block;}

            </style>


<hr/>
            <!-- /.row -->
            <div class="row">

            
               <div class="col-md-12">


               		<table id="datatable">
               			<thead>
               				<tr>
               					<th>s/no</th>
               					<th>Fullname</th>
               					<th>Day(Date)</th>
               					<th>Morning</th>
               					<th>Afternoon</th>
               					<th>Evening</th>
               					<th>Date Created</th>
               					<th>Points</th>
               				</tr>
               			</thead>

               			<tbody>
               				<?php $i = 1; ?>
               				@foreach($logs as $l)
               				{{-- pr($l, true) --}}

               				<tr>

               					<td>{{$i}}</td>
               					<td>{{$l->station->branch}}</td>
               					<td>{{mkDate($l->created_at)}}</td>
               					
               					<td>{!! strData($l->morning) !!}</td>
               					<td>{!! strData($l->afternoon) !!}</td>
               					<td>{!! strData($l->evening) !!}</td>

               					<td>{{$l->created_at}}</td>
               					<td><a href="/service/{{$l->id}}/logs">...</a></td>
               					
               				</tr>

               				<?php $i++; ?>
               				
               				@endforeach

               			</tbody>

               		</table>
			  </div>


            </div>


        </div>
        <!-- /#page-wrapper -->


        @stop