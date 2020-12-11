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

            	{{Form::open(['route'=>'new_company'])}}

               <div class="col-md-5">

					<div class="form-group">
					    <label>Enter Company Name</label>
					    <input name="fullname" class="form-control" required="true">
					    <small class="help-block text-muted">enter your full business name here.</small>
					</div>

					<div class="form-group">
					    <label>Enter SAP Code</label>
					    <input name="sap_code" class="form-control" required="true">
					    <small class="help-block text-muted">enter SAP Code here.</small>
					</div>

					<div class="form-group">
					    <label>RC/BN Number</label>
					    <input name="rc_num" class="form-control" required="true">
					    <small class="help-block text-muted">enter registered CAC RC/BN Number.</small>
					</div>

                    <button type="submit" class="btn btn-default">Submit Button</button>

               </div>

               <div class="col-md-5">

                    <div class="form-group">
                        <label>Email Address</label>
                        <input name="email" class="form-control" required="true">
                        <small class="help-block text-muted">enter email address...</small>
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input name="phone" class="form-control" required="true">
                        <small class="help-block text-muted">enter phone number...</small>
                    </div>


                    <div class="form-group">
                        <label>Enter Full Address</label>
                        <textarea name="address" class="form-control" required="true"></textarea>
                    </div>


               </div>


               {{ Form::close() }}

            </div>


        </div>
        <!-- /#page-wrapper -->


        @stop