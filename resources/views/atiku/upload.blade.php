<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>plupload test</title>
    <!-- Custom CSS -->
    <link href="/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core CSS -->
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/plupload.css" rel="stylesheet">
    <link href="/icomoon/styles.css" rel="stylesheet">
</head>

<body>

    <div id="wrapper">

    @include('partials.nav')


     <div id="page-wrapper">


          @include('atiku.partials.title')

            <!-- /.row -->
            <div class="row">

               <div class="col-md-4">

                    <div class="form-group">
                        <label>Enter Gallery Title</label>
                        <input id="galtp" name="galtp" class="form-control" required="true">
                        <small class="help-block text-muted">enter blog title here...</small>
                    </div>

                    <div class="form-group">
                        <label>Enter Gallery Description</label>
                        <textarea id="galdesc" name="galdesc" class="form-control"></textarea>
                        <small class="help-block text-muted">summarize the content here...</small>
                    </div>

                    <div class="form-group">
                        <small class="help-block text-muted">select image for blog...</small>
                    </div>

                    
               </div>


               <div class="col-md-7">

                    <label>Select/Queue Images to Upload (JPEG, JPG files only)...</label>


                    <div style="height:100px !important;" id="plupload" class="file-uploader">
                    <p>Your browser doesn't have Flash installed.</p>
                    </div>
             
               </div>


            </div>


        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="/js/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>

    <script src="/js/plupload/plupload.full.min.js"></script>
    <script src="/js/plupload/plupload.queue.min.js"></script>

    <script type="text/javascript">
        
        var urlvars;

        $(function(){
              

            // Setup all runtimes
            $("#plupload").pluploadQueue({

                runtimes: 'html5, html4, Flash, Silverlight',

                url: '/photos/upload', 

                /*                

                multipart:true,

                multipart_params:{
                    'title': $('#galtp').val(),
                    'desc' : $('#galdesc').val()
                },

                */

                //chunk_size: '300Kb',
                unique_names: true,

                filters: {
                    max_file_size: '40300Kb',
                    mime_types: [{
                        title: "Image Files upload",
                        extensions:  "jpg,jpeg"//"jpg,png,jpeg"
                    }]
                },

                init:{

                    FilesAdded: function(up, files) {
                        //check if the desciption and title fields are empty...
                        if(String($('#galtp').val()) === ''){
                            alert('Gallery Title and Description cannot be empty.....');
                            $('#galtp').focus();
                        }
                    },

                    BeforeUpload: function(up, file) {

                        $('#galtp').attr('disabled', 'disabled');
                        $('#galdesc').attr('disabled', 'disabled');
                        
                        console.log(up.settings.multipart_params);

                        up.settings.multipart = true;
                        up.settings.multipart_params = {
                            'title': $('#galtp').val(),
                            'desc' : $('#galdesc').val()
                        };

                    },

                    UploadComplete: function(up, files) {
                        alert('queue finished uploading....');
                        //log('[UploadComplete]'); // Called when all files are either uploaded or failed
                        //redirect to all-files page...
                       // window.location = '/photos/add';


                        $('#galtp').removeAttr('disabled');
                        $('#galdesc').removeAttr('disabled');
                    },

                    Destroy: function(up) {
                        //log('[Destroy] '); // Called when uploader is destroyed
                    },

                    Error: function(up, args) {
                        console.log(args);
                        log('[Error] ', args); // Called when error occurs
                    }
                }


            });

            // Write log
            function log() {
                var str = "";

                plupload.each(arguments, function(arg) {
                    var row = "";

                    if (typeof(arg) != "string") {
                        plupload.each(arg, function(value, key) {

                            // Convert items in File objects to human readable form
                            if (arg instanceof plupload.File) {

                                // Convert status to human readable
                                switch (value) {
                                    case plupload.QUEUED:
                                    value = 'QUEUED';
                                    break;

                                    case plupload.UPLOADING:
                                    value = 'UPLOADING';
                                    break;

                                    case plupload.FAILED:
                                    value = 'FAILED';
                                    break;

                                    case plupload.DONE:
                                    value = 'DONE';
                                    break;
                                }
                            }

                            if (typeof(value) != "function") {
                                row += (row ? ', ': '') + key + '=' + value;
                            }
                        });

                        str += row + " ";
                    }
                    else {
                        str += arg + " ";
                    }
                });

                var log = $('#log');
                log.append(str + "<br>");
                log.scrollTop(log[0].scrollHeight);
            }
            
        });

    </script>



</body>

</html>
