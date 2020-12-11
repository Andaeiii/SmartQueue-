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
               					<th>SAP/RC_Number</th>
               					<th>Email</th>
               					<th>Phone</th>
               					<th>Address</th>
               					<th>Action</th>
               				</tr>
               			</thead>

               			<tbody>
               				<?php $i = 1; ?>
               				@foreach($coys as $coy)
               				{{--pr($coy, true)--}}
               				<tr>
               					<td>{{$i}}</td>
               					<td>{{$coy->fullname}}</td>
               					<td>{{$coy->sap_code}}/{{$coy->rc_number}}</td>
               					<td>{{$coy->email}}</td>
               					<td>{{$coy->phone}}</td>
               					<td>{{$coy->address}}</td>
               					<td><a href="/station/{{$coy->id}}/add" title="Add new Station">[+] Station</a></td>
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