<div class="row">
    <div class="col-lg-7">
        <h1 class="page-header">{{$pg_title}}</h1>
    </div>

    <div class="col-lg-5">
        <div class="btn-group" role="group" aria-label="...">
          <a class="btn btn-default" href="/blog/add">Add Blog</a>
          <a class="btn btn-default" href="/blogs/all">All Blogs</a>
          <a class="btn btn-default" href="/photos/add">Add Photos</a>
          <a class="btn btn-default" href="/photos/all">All Photos</a>
        </div>
    </div>
    <!-- /.col-lg-12 -->
</div>
            
@if(Session::has('success'))
    <div class="alert alert-success" role="alert">
      Success, process carried out successfully..... 
    </div>
@elseif(Session::has('failed'))
    <div class="alert alert-danger" role="alert">
    ---Error :: something unusual happened, pls try again..
    </div>
@endif