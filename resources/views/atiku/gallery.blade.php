@extends('layouts.index')


@section('page_contents')


        <div id="page-wrapper">


            @include('atiku.partials.title')

            <!-- /.row -->
            <div class="row">


               <div class="col-md-12 pixcontainer">


                       @foreach($photos as $g)

                        <div class="pix" title="{{$g->title}}">
                            <a href="/gallery/{{$g->id}}/del"> x </a>
                            <img width="200" src="/atiku/gallery/{{$g->imgfile}}"/>
                        </div>

                       @endforeach

                    <div class="clr"></div>
               </div>


            </div>


        </div>
        <!-- /#page-wrapper -->

        <style type="text/css">
                
                .pixcontainer{min-height:600px;}
                .pix{position:relative; border: solid 1px #cccccc;  float: left; margin:3px 3px 0px 0px;}
                .pix:hover{opacity:0.7;}
                .pix a{position: absolute; top:10px; right:10px; background-color: #ffffff; padding:3px 10px; border: solid 2px #000000;}
                .clr{clear:both;}

        </style>


        @stop