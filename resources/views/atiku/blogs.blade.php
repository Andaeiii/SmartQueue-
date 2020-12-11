@extends('layouts.index')


@section('page_contents')

        <div id="page-wrapper">


            @include('atiku.partials.title')

            <!-- /.row -->
            <div class="row">

            
               <div class="col-md-12">


               		<table id="datatable" class="table-responsive">
               			<thead>
               				<tr>
               					<th>id</th>
               					<th>title</th>
               					<th>excerpt</th>
               					<th>comments</th>
               					<th>image</th>
               					<th>Date Created</th>
               					<th>Action</th>
               				</tr>
               			</thead>

               			<tbody>
               				<?php 
                        $i = 1; 
                      ?>
               				@foreach($blogs as $b)
               				{{--pr($s, true)--}}

                      <?php 
                        $v = 0;
                        foreach($b->comments as $c){
                          if($c->verified){
                            $v++;
                          }
                        }
                        $commx = '<span style="color:#44d444">Approved - ' . $v . '</span> / <b>' . count($b->comments) . '</b>';
                      ?>
               				<tr>
               					<td>{{$i}}</td>
               					<td>{{$b->title}}</td>
               					<td>{{trimTxt($b->excerpt)}}</td>
               					<td>{!! $commx !!}</td>
               					<td>{{$b->image}}</td>
               					<td>{{mkDate($b->created_at)}}</td>
               					<td>
                            <a href="/blog/{{$b->id}}/view">view</a>
                            <a href="/blog/{{$b->id}}/del">del</a>
                        </td>
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