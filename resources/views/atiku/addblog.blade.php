@extends('layouts.index')


@section('page_contents')

        <div id="page-wrapper">


            @include('atiku.partials.title')
            
            @if(Session::has('success'))
                <div class="alert alert-success" role="alert">
                  Success, blog post saved successfully..... 
                </div>
            @elseif(Session::has('failed'))
                <div class="alert alert-danger" role="alert">
                ---Error :: updating message, pls, try again..
                </div>
            @endif

            <!-- /.row -->
            <div class="row">

            	{{Form::open(['route'=>'process_blog', 'files'=>true])}}

               <div class="col-md-4">

					<div class="form-group">
					    <label>Blog Title</label>
					    <input name="blogtitle" class="form-control" required="true">
					    <small class="help-block text-muted">enter blog title here...</small>
					</div>

                    <div class="form-group">
                        <label>Blog Summary(Excerpt)</label>
                        <input name="blogexerpt" class="form-control">
                        <small class="help-block text-muted">summarize the content here...</small>
                    </div>

					<div class="form-group">
					    <label>Choose Blog Image</label>
					    <input type="file" name="blogimg" class="form-control" required="true">
					    <small class="help-block text-muted">select image for blog...</small>
					</div>

                    <input  type="hidden" name="blogparty" value="{{$party}}"/>

                    
               </div>




               <div class="col-md-7">

                    <div class="form-group">
                        <label>Blog Content, full Text...</label>

                        <textarea class="form-control input-block-level" id="scontent" name="blogcontent" rows="7"></textarea>


                        <small class="help-block text-muted">select current state...</small>
                    </div>



                    <button type="submit" class="btn btn-default">Submit Button</button>



               </div>



               {{ Form::close() }}

            </div>


        </div>
        <!-- /#page-wrapper -->


        @stop