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

            	{{Form::open(['route'=>'new_station'])}}

               <div class="col-md-4">

					<div class="form-group">
					    <label>Station Managers Name</label>
					    <input name="fullname" class="form-control" required="true">
					    <small class="help-block text-muted">enter your full business name here.</small>
					</div>

                    <div class="form-group">
                        <label>Station Managers Phone</label>
                        <input type="number" name="st_mgr" class="form-control">
                        <small class="help-block text-muted">station managers phone number</small>
                    </div>

					<div class="form-group">
					    <label>Branch Name</label>
					    <input name="branch_name" class="form-control" required="true">
					    <small class="help-block text-muted">enter branch name here.</small>
					</div>

                    

                    <br/>

                    <button type="submit" class="btn btn-default">Submit Button</button>

               </div>




               <div class="col-md-4">

                    <div class="form-group">
                        <label>State</label>

                        <select name="state" class="form-control" required="true" onchange="buildLgas(this);">
                            <option>--------</option>
                            @foreach($states as $st)
                            <option value="{{$st->id}}">{{$st->state}}</option>
                            @endforeach
                        </select>

                        <small class="help-block text-muted">select current state...</small>
                    </div>


                    <div id="lgadiv" class="form-group">
                        <label>Select LGA</label>

                        <div id="seloptn">
                            <select name="lga" class="form-control" required="true">
                                <option>--------</option>
                            </select>
                        </div>

                        <small class="help-block text-muted">select current state...</small>
                    </div>

                    <div class="form-group">

                       <label>Enter Town / Street name</label>
                       <div class="input-group">
                            <input name="town_name" type="text" class="form-control" placeholder="Town Name"/>
                            <span class="input-group-addon"> / </span>
                            <input name="street_name" type="text" class="form-control" placeholder="Street name"/>
                        </div>
                    </div>


               </div>



               <div class="col-md-4">

               		<input type="hidden" name="r_code" value="{{$r_code}}">


					<div class="form-group">
					    <label>Retail Station Number</label>

					    <input name="retail_num" value="{{$r_code}}" class="form-control" disabled="disabled">

					    <small class="help-block text-muted">unique code given upon registration...</small>
					</div>


                    <div class="form-group">
                        <label>Company Info</label>
                        <input type="hidden" value="{{$company->id}}" name="company_id"/>
                        <input value="{{$company->fullname}}" class="form-control" readonly="readonly" disabled="disabled">

                        <small class="help-block text-muted">unique code given upon registration...</small>
                    </div>


					<div class="form-group">
                        <label>Select Fuel Station Service(s) </label>
                        <br/>
                        <label class="checkbox-inline">
                            <input name="fuels[]" value="petrol" type="checkbox"> Petrol
                        </label>
                        <label class="checkbox-inline">
                            <input name="fuels[]" value="diesel" type="checkbox"> Diesel
                        </label>
                        <label class="checkbox-inline">
                            <input name="fuels[]" value="kerosine" type="checkbox"> Kerosine
                        </label>
                        <br/>
					    <small class="help-block text-muted">select one or more services.</small>
                    </div>



               </div>


               {{ Form::close() }}

            </div>


        </div>
        <!-- /#page-wrapper -->


        @stop