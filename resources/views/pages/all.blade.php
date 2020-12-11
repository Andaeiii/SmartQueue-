@extends('layouts.index')


@section('page_contents')

        <div id="page-wrapper">


            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">{{$pg_title}}</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!-- /.row -->
            <div class="row">

            
               <div class="col-md-12">


               		<table id="datatable" class="table-responsive">
               			<thead>
               				<tr>
               					<th>id</th>
               					<th>Fullname</th>
               					<th>State</th>
               					<th>Branch</th>
               					<th>Services</th>
               					<th>Retail Number</th>
               					<th>Date Created</th>
               					<th>Action</th>
               				</tr>
               			</thead>

               			<tbody>
               				<?php $i = 1; ?>
               				@foreach($stations as $s)
               				{{--pr($s, true)--}}
               				<tr>
               					<td>{{$i}}</td>
               					<td>{{$s->fullname}}</td>
               					<td>{{$s->state->state}}</td>
               					<td>{{$s->branch}}</td>
               					<td>{{-- getServices($s->fuels) --}}</td>
               					<td>{{$s->code->retail_num}}</td>
               					<td>{{$s->created_at}}</td>
               					<td><a href="/service/{{$s->id}}/logs">view</a></td>
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