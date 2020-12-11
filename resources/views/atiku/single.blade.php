@extends('layouts.index')


@section('page_contents')


        <div id="page-wrapper">


            @include('atiku.partials.title')

            <!-- /.row -->
            <div class="row">

               <div class="col-md-4">

                    <h2 style="font-size:14px !important; font-weight: bold">{{$blog->title}}</h2>

                    @if($blog->image != null)
                      <p style="background-color: #000000; width:100%;" align="center">
                        <img width="200" src="/atiku/uploads/{{$blog->image}}"/>
                    </p>
                    @endif

                    <b> Summary </b>
                    <p style="font-size:12px; color: #333333; text-align: justify;">{{substr($blog->excerpt, 0, 250). '....'}}</p>
                    <br/>

                    <b> Full Content </b>
                    <p style="font-size:12px; color: #333333; text-align: justify;">{{substr($blog->content, 0, 250). '....'}}</p>

               
               </div>

               <div class="col-md-8">


                      
                    <table id="datatable" class="table-responsive">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>comment</th>
                                <th>Date</th>
                                <th>Actions</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $i = 1; ?>
                            @foreach($blog->comments as $c)
                            {{--pr($s, true)--}}
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$c->comment}}</td>
                                <td>{{mkDate($c->created_at)}}</td>
                                <td> 

                                <table>
                                    <tr>                              
                                        <td>
                                            <a href="/comment/{{$c->id}}/approve" 
                                                class="ball ball-{{(!$c->verified) ? 'red' : 'green'}}"
                                                title="Click to {{(!$c->verified) ? 'Approve' : 'Disapprove'}}" 
                                                >
                                                
                                            </a> 
                                        </td>
                                         <td><a href="/comment/{{$c->id}}/delete">del</a></td>
                                    </tr>
                                </table>

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

        <style type="text/css">
            .ball{
                display:inline-block; 
                width:20px; height:20px; 
                border: solid 1px #ffffff;
                margin-top:10px; 
                border-radius:30px;
            }
            .ball-red{
                background-color: #ff0000; 
            }

            .ball-green{
                background-color: #44d444; 
            }

        </style>


        @stop